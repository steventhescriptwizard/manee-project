<?php

namespace App\Http\Controllers\Web\Customer;

use App\Http\Controllers\Controller;
use App\Models\CustomerAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $customer = $user->customer;
        
        if (!$customer) {
            // Create customer profile if it doesn't exist (fail-safe)
            $customer = $user->customer()->create(['tier' => 'regular']);
        }
        
        $addresses = $customer->addresses()->latest()->get();
        
        return view('web.customer.address', compact('user', 'addresses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'recipient_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'address_line' => 'required|string',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postal_code' => 'required|string|max:255',
            'is_primary' => 'boolean',
        ]);

        $customer = Auth::user()->customer;

        if ($request->is_primary) {
            $customer->addresses()->update(['is_primary' => false]);
        }

        $customer->addresses()->create($request->all());

        return back()->with('success', 'Alamat berhasil ditambahkan.');
    }

    public function update(Request $request, CustomerAddress $address)
    {
        $this->authorizeAccess($address);

        $request->validate([
            'label' => 'required|string|max:255',
            'recipient_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'address_line' => 'required|string',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postal_code' => 'required|string|max:255',
            'is_primary' => 'boolean',
        ]);

        $customer = Auth::user()->customer;

        if ($request->is_primary && !$address->is_primary) {
            $customer->addresses()->update(['is_primary' => false]);
        }

        $address->update($request->all());

        return back()->with('success', 'Alamat berhasil diperbarui.');
    }

    public function destroy(CustomerAddress $address)
    {
        $this->authorizeAccess($address);
        
        $address->delete();

        return back()->with('success', 'Alamat berhasil dihapus.');
    }

    public function setPrimary(CustomerAddress $address)
    {
        $this->authorizeAccess($address);
        
        $customer = Auth::user()->customer;
        $customer->addresses()->update(['is_primary' => false]);
        
        $address->update(['is_primary' => true]);

        return back()->with('success', 'Alamat utama berhasil diubah.');
    }

    private function authorizeAccess(CustomerAddress $address)
    {
        if ($address->customer_id !== Auth::user()->customer->id) {
            abort(403);
        }
    }
}
