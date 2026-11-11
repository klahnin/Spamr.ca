<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\NumberRental;
use Illuminate\Http\Request;

class NumberMarketplaceController extends Controller
{
    public function index()
    {
        $pageTitle = 'Number Marketplace';
        $listings  = Device::availableForRent()->with('user')->paginate(getPaginate());
        $myRentals = NumberRental::where('rented_by_user_id', auth()->id())->with('device')->latest()->get();
        $myListings = Device::belongsToUser()->where('is_for_rent', true)->get();

        return view('Template::user.marketplace.index', compact('pageTitle', 'listings', 'myRentals', 'myListings'));
    }

    public function rent(Request $request)
    {
        $request->validate(['device_id' => 'required|integer']);
        $device = Device::availableForRent()->findOrFail($request->device_id);
        NumberRental::create([
            'device_id'          => $device->id,
            'rented_by_user_id'  => auth()->id(),
            'owned_by_user_id'   => $device->user_id,
            'price_cents'        => $device->rental_price_cents,
            'status'             => 'active',
            'started_at'         => now(),
        ]);
        $device->rented_by_user_id = auth()->id();
        $device->save();
        return back()->withNotify([['success', "Number {$device->sim[0]['number']} rented successfully"]]);
    }

    public function list(Request $request)
    {
        $request->validate([
            'device_id'        => 'required|integer',
            'rental_price_cents' => 'required|integer|min:50|max:5000',
        ]);
        $device = Device::belongsToUser()->findOrFail($request->device_id);
        $device->is_for_rent        = true;
        $device->rental_price_cents = $request->rental_price_cents;
        $device->save();
        return back()->withNotify([['success', 'Number listed for rent']]);
    }

    public function unlist(Request $request)
    {
        $device = Device::belongsToUser()->findOrFail($request->device_id);
        $device->is_for_rent = false;
        $device->save();
        return back()->withNotify([['success', 'Number unlisted']]);
    }
}