<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    
    public function approveVendor($id)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor->update(['status' => 'approved']);
        
        // Sync user status
        if ($vendor->user) {
            $vendor->user->update(['status' => 'approved']);
        }
        
        return redirect()->back()->with('success', 'Vendor approved.');
    }

    public function rejectVendor($id)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor->update(['status' => 'rejected']);
        
        // Sync user status
        if ($vendor->user) {
            $vendor->user->update(['status' => 'rejected']);
        }
        
        return redirect()->back()->with('success', 'Vendor rejected.');
    }

    public function deleteVendor($id)
    {
        $vendor = Vendor::findOrFail($id);
        
        // Delete all services associated with this vendor
        $vendor->services()->delete();
        
        // Delete the vendor record
        $vendor->delete();
        
        return redirect()->back()->with('success', 'Vendor and all their services deleted successfully.');
    }

    
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deletion of admin users
        if ($user->role == 'admin') {
            return redirect()->back()->with('error', 'Cannot delete admin users.');
        }
        
        // Delete related vendor record if exists
        if ($user->vendor) {
            $user->vendor->delete();
        }
        
        // Delete user's bookings
        $user->bookings()->delete();
        
        // Delete user
        $user->delete();
        
        return redirect()->back()->with('success', 'User deleted successfully.');
    }

    public function deleteService($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();
        return redirect()->back()->with('success', 'Service deleted successfully.');
    }

    public function deleteBooking($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();
        return redirect()->back()->with('success', 'Booking deleted successfully.');
    }
}