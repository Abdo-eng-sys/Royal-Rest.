<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $reservations = $request->user()->reservations()
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->get();
        return response()->json($reservations);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:20',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'guests' => 'required|integer|min:1|max:20',
            'special_requests' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $reservation = $request->user()->reservations()->create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'date' => $request->date,
            'time' => $request->time,
            'guests' => $request->guests,
            'special_requests' => $request->special_requests,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Reservation created successfully',
            'reservation' => $reservation
        ], 201);
    }

    public function show(Request $request, $id)
    {
        $reservation = $request->user()->reservations()->findOrFail($id);
        return response()->json($reservation);
    }

    public function update(Request $request, $id)
    {
        $reservation = $request->user()->reservations()->findOrFail($id);

        if ($reservation->status !== 'pending') {
            return response()->json([
                'message' => 'Cannot update confirmed or completed reservations'
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'date' => 'sometimes|date|after_or_equal:today',
            'time' => 'sometimes',
            'guests' => 'sometimes|integer|min:1|max:20',
            'special_requests' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $reservation->update($request->only(['date', 'time', 'guests', 'special_requests']));

        return response()->json([
            'message' => 'Reservation updated successfully',
            'reservation' => $reservation
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $reservation = $request->user()->reservations()->findOrFail($id);

        if ($reservation->status === 'completed') {
            return response()->json([
                'message' => 'Cannot delete completed reservations'
            ], 400);
        }

        $reservation->delete();

        return response()->json([
            'message' => 'Reservation cancelled successfully'
        ]);
    }
}
