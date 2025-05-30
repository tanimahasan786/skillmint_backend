<?php

namespace App\Http\Controllers\Web\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use Exception;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;


class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = Booking::with('user', 'course')->orderBy('created_at', 'desc')->get();
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('user', function ($data) {
                        return $data->user->name;
                    })
                    ->addColumn('course', function ($data) {
                        return $data->course->name;
                    })
                    ->rawColumns(['user', 'course'])
                    ->make(true);
            }
            return view('backend.layout.booking.index');
        } catch (Exception $e) {
            return redirect()->back()->with('t-error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Booking::with(['category', 'subcategory', 'user'])->where('id', $id)->first();
        return view('backend.layouts.post.show', compact('post'));
    }
}
