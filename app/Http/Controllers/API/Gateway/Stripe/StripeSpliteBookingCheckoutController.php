<?php

namespace App\Http\Controllers\API\Gateway\Stripe;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Course;
use App\Models\CourseEnroll;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Stripe\Exception\ApiErrorException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class StripeSpliteBookingCheckoutController extends Controller
{
    public $redirectFail;
    public $redirectSuccess;

    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $this->redirectFail = env("APP_URL") . "/fail";
        $this->redirectSuccess = env("APP_URL") . "/success";
    }

    public function checkout(Request $request)
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

            $successUrl = route('api.student.course.booking.stripe.success.payment') . '?token={CHECKOUT_SESSION_ID}';
            $cancelUrl = route('api.student.course.booking.stripe.cancel.payment') . '?token={CHECKOUT_SESSION_ID}';

            $booking = Booking::create([
                'user_id' => auth('api')->user()->id,
                'course_id' => $data['course_id'],
                'slug' => $slug,
                'price' => $course_price,
                'currency' => 'USD',
                'gateway' => 'stripe',
                'status' => 'pending'
            ]);

            $enroll = CourseEnroll::create([
                'user_id' => auth('api')->user()->id,
                'course_id' => $data['course_id'],
                'transaction_id' => $slug,
                'amount' => $course_price,
                'status' => 'pending'
            ]);

            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Course Fee',
                        ],
                        'unit_amount' => ($teacher_amount + $admin_fee) * 100,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'metadata' => [
                    'slug' => $slug,
                    'booking_id' => $booking->id,
                    'enroll_id' => $enroll->id
                ],
                'payment_intent_data' => [
                    'application_fee_amount' => $admin_fee * 100,
                    'transfer_data' => [
                        'destination' => $stripe_account_id,
                    ],
                ],
                'success_url' => $successUrl,
                'cancel_url' => $cancelUrl,
            ]);

            $data = [
                'checkout_url' => $session->url
            ];

            return Helper::jsonResponse(true, 'Checkout session created successfully', 200, $data);

        } catch (ModelNotFoundException $e) {

            Log::error($e->getMessage());
            return redirect()->to($this->redirectFail);
        } catch (ApiErrorException $e) {

            Log::error($e->getMessage());
            return redirect()->to($this->redirectFail);
        }
    }

    public function success(Request $request)
    {
        $validatedData = $request->validate([
            'token' => ['required', 'string']
        ]);

        try {

            $session = Session::retrieve($validatedData['token']);
            if ($session->payment_status === 'paid') {

                $booking_id = $session->metadata['booking_id'];
                $booking = Booking::find($booking_id);
                $booking->status = 'success';
                $booking->save();

                $enroll_id = $session->metadata['enroll_id'];
                $enroll = CourseEnroll::find($enroll_id);
                $enroll->status = 'completed';
                $enroll->save();

                return redirect()->to($this->redirectSuccess);
                
            }

            if ($session->payment_status === 'unpaid' || $session->payment_status === 'no_payment_required') {
                return redirect()->to($this->redirectFail);
            }

            return redirect()->to($this->redirectFail);
        } catch (ApiErrorException $e) {

            Log::error($e->getMessage());
            return redirect()->to($this->redirectFail);
        } catch (ModelNotFoundException $e) {

            Log::error($e->getMessage());
            return redirect()->to($this->redirectFail);
        }
    }
    public function failure(Request $request)
    {
        return redirect()->to($this->redirectFail);
    }
}
