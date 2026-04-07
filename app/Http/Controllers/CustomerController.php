<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\BookingRequest;
use App\Models\QuickBookingRequest;

class CustomerController extends Controller
{
    public function dashboard()
    {
        $customer = Auth::guard('customer')->user();
        
        // Get both regular and quick bookings
        $regularBookings = BookingRequest::where('email', $customer->email)
            ->select('*', \DB::raw("'regular' as booking_type"))
            ->get();
        
        $quickBookings = QuickBookingRequest::where('email', $customer->email)
            ->select('*', \DB::raw("'quick' as booking_type"))
            ->get();
        
        // Merge and sort by date
        $bookings = collect()
            ->merge($regularBookings)
            ->merge($quickBookings)
            ->sortByDesc('request_date')
            ->values()
            ->take(5);
        
        $bookingCount = $regularBookings->count() + $quickBookings->count();
        
        return view('customer.dashboard', compact('customer', 'bookings', 'bookingCount'));
    }

    public function profile()
    {
        $customer = Auth::guard('customer')->user();
        return view('customer.profile', compact('customer'));
    }

    public function updateProfile(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
        ]);

        $customer->update($validated);

        return redirect()->route('customer.profile')
            ->with('success', 'تم تحديث ملفك الشخصي بنجاح!');
    }

    public function changePassword()
    {
        $customer = Auth::guard('customer')->user();
        return view('customer.change-password', compact('customer'));
    }

    public function updatePassword(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($validated['current_password'], $customer->password)) {
            return back()->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة.']);
        }

        $customer->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('customer.profile')
            ->with('success', 'تم تحديث كلمة المرور بنجاح!');
    }

    public function bookings()
    {
        $customer = Auth::guard('customer')->user();
        
        // Get both regular and quick bookings
        $regularBookings = BookingRequest::where('email', $customer->email)
            ->select('*', \DB::raw("'regular' as booking_type"))
            ->get();
        
        $quickBookings = QuickBookingRequest::where('email', $customer->email)
            ->select('*', \DB::raw("'quick' as booking_type"))
            ->get();
        
        // Merge and sort
        $bookings = collect()
            ->merge($regularBookings)
            ->merge($quickBookings)
            ->sortByDesc('request_date')
            ->values(); // Re-index array
        
        // Manual pagination
        $perPage = 10;
        $page = request()->get('page', 1);
        $items = $bookings->slice(($page - 1) * $perPage, $perPage)->values();
        
        // Create paginator instance
        $bookings = new \Illuminate\Pagination\Paginator(
            $items,
            $perPage,
            $page,
            [
                'path' => route('customer.bookings'),
                'query' => request()->query(),
            ]
        );
        
        return view('customer.bookings', compact('bookings'));
    }

    public function bookingDetail($id)
    {
        $customer = Auth::guard('customer')->user();
        $type = request()->query('type', 'regular');

        if ($type === 'quick') {
            $booking = QuickBookingRequest::findOrFail($id);
            $booking->booking_type = 'quick';
        } else {
            $booking = BookingRequest::findOrFail($id);
            $booking->booking_type = 'regular';
        }

        // التحقق من ملكية الحجز
        if ($booking->email !== $customer->email) {
            abort(403);
        }

        return view('customer.booking-detail', compact('booking'));
    }
}
