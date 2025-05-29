<?php

namespace App\Http\Controllers\Api\Gateway\Stripe;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Course;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Webhook;
use Stripe\Exception\ApiErrorException;
use Stripe\Exception\SignatureVerificationException;
use Stripe\PaymentIntent;
use UnexpectedValueException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class StripeSpliteBookingWebHookController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }
    public function intent(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|exists:courses,id',
        ]);

        if ($validator->fails()) {
            return Helper::jsonResponse(false, 'Validation failed', 422, $validator->errors());
        }

        try {

            DB::beginTransaction();

            $data = $validator->validated();

            $stripe_account_id = auth('api')->user()->stripe_account_id;

            $course = Course::find($data['course_id']);
            $course_price = $course->price;
            $admin_fee = $course_price * (10 / 100);
            $teacher_amount = $course_price - $admin_fee;

            $slug = Str::uuid();

            $booking = Booking::create([
                'user_id' => auth('api')->user()->id,
                'course_id' => $data['course_id'],
                'slug' => $slug,
                'price' => $course_price,
                'currency' => 'USD',
                'gateway' => 'stripe',
                'status' => 'pending'
            ]);

            $paymentIntent = PaymentIntent::create([
                'amount'   => $teacher_amount * 100,
                'currency' => 'usd',
                'metadata' => [
                    'slug' => $slug,
                    'booking_id' => $booking->id
                ],
                'transfer_data' => [
                    'destination' => $stripe_account_id
                ],
                'application_fee_amount' => $admin_fee * 100
            ]);

            $data = [
                'client_secret' => $paymentIntent->client_secret
            ];

            DB::commit();

            return Helper::jsonResponse(true, 'Payment intent created successfully', 200, $data);
        } catch (ApiErrorException $e) {

            DB::rollBack();
            return Helper::jsonResponse(false, $e->getMessage(), 500, []);
        } catch (Exception $e) {

            DB::rollBack();
            return Helper::jsonResponse(false, $e->getMessage(), 500, []);
        }
    }

    public function webhook(Request $request): JsonResponse
    {

        $payload        = $request->getContent();
        $sigHeader      = $request->header('Stripe-Signature');
        $endpointSecret = config('services.stripe.webhook_secret');

        try {

            $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);

            switch ($event->type) {
                case 'payment_intent.succeeded':
                    $this->success($event->data->object);
                    return Helper::jsonResponse(true, 'Payment successful', 200, []);
                case 'payment_intent.payment_failed':
                    $this->failure($event->data->object);
                    return Helper::jsonResponse(true, 'Payment failed', 200, []);
                default:
                    return Helper::jsonResponse(true, 'Unhandled event type', 200, []);
            }

        } catch (Exception $e) {

            return Helper::jsonResponse(false, $e->getMessage(), 500, []);
            
        }
    }

    protected function success($paymentIntent): void
    {
        //$admin      = User::role('admin', 'web')->first();
        $booking_id   = $paymentIntent->metadata->booking_id;
        $booking = Booking::find($booking_id);
        $booking->status = 'success';
        $booking->save();
    }

    protected function failure($paymentIntent): void
    {
        //$admin      = User::role('admin', 'web')->first();
        $booking_id   = $paymentIntent->metadata->booking_id;
        $booking = Booking::find($booking_id);
        $booking->status = 'failed';
        $booking->save();
    }
}
