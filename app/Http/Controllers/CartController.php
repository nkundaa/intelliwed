<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('booking_cart', []);
        $total = collect($cart)->sum('price');
        
        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        $cart = session()->get('booking_cart', []);

        if (isset($cart[$id])) {
            return redirect()->back()->with('error', 'Service already added to your booking cart.');
        }

        $cart[$id] = [
            "id" => $service->id,
            "title" => $service->title,
            "price" => $service->price,
            "image" => $service->main_image,
            "category" => $service->category,
            "vendor" => $service->vendor->business_name ?? 'Vendor'
        ];

        session()->put('booking_cart', $cart);
        return redirect()->back()->with('success', 'Service added to your booking cart!');
    }

    public function remove($id)
    {
        $cart = session()->get('booking_cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('booking_cart', $cart);
        }

        return redirect()->back()->with('success', 'Service removed from booking cart.');
    }

    public function clear()
    {
        session()->forget('booking_cart');
        return redirect()->route('services.index')->with('success', 'Booking cart cleared.');
    }
}
