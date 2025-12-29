<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Customer;
use App\Models\CustomerAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::with(['customer'])
            ->withCount('orders')
            ->where('role', 'customer')
            ->latest()
            ->paginate(10);
        return view('admin.customers.index', compact('customers'));
    }

    public function create()
    {
        $tiers = ['regular', 'silver', 'gold', 'platinum'];
        return view('admin.customers.create', compact('tiers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            // Customer specific
            'phone' => ['nullable', 'string', 'max:20'],
            'gender' => ['nullable', 'in:male,female,other'],
            'date_of_birth' => ['nullable', 'date'],
            'tier' => ['required', 'in:regular,silver,gold,platinum'],
            // Address specific
            'address_line' => ['nullable', 'string'],
            'city' => ['nullable', 'string', 'max:255'],
            'province' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:10'],
        ]);

        DB::transaction(function () use ($request) {
            $avatarPath = null;
            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'customer',
                'avatar' => $avatarPath,
            ]);

            $customer = Customer::create([
                'user_id' => $user->id,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'tier' => $request->tier,
            ]);

            if ($request->address_line) {
                CustomerAddress::create([
                    'customer_id' => $customer->id,
                    'label' => 'Alamat Utama',
                    'recipient_name' => $user->name,
                    'phone_number' => $request->phone ?? '-',
                    'address_line' => $request->address_line,
                    'city' => $request->city,
                    'province' => $request->province,
                    'postal_code' => $request->postal_code,
                    'is_primary' => true,
                ]);
            }
        });

        return redirect()->route('admin.customers.index')->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    public function show(User $customer)
    {
        // Safety check for role
        if ($customer->role !== 'customer') {
            abort(404);
        }

        $customer->load(['customer.addresses', 'orders' => function($query) {
            $query->latest()->take(5);
        }]);

        // Calculate stats
        $totalSpend = $customer->orders()->where('payment_status', 'paid')->sum('total_price');
        $totalOrders = $customer->orders()->count();

        // Pass as $user for compatibility with the view slicing
        $user = $customer;

        return view('admin.customers.show', compact('user', 'totalSpend', 'totalOrders'));
    }

    public function edit(User $customer)
    {
        if ($customer->role !== 'customer') {
            abort(404);
        }

        $customer->load(['customer.addresses' => function($q) {
            $q->where('is_primary', true);
        }]);
        $tiers = ['regular', 'silver', 'gold', 'platinum'];

        return view('admin.customers.edit', compact('customer', 'tiers'));
    }

    public function update(Request $request, User $customer)
    {
        if ($customer->role !== 'customer') {
            abort(404);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$customer->id],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            // Customer specific
            'phone' => ['nullable', 'string', 'max:20'],
            'gender' => ['nullable', 'in:male,female,other'],
            'date_of_birth' => ['nullable', 'date'],
            'tier' => ['required', 'in:regular,silver,gold,platinum'],
            // Address specific
            'address_line' => ['nullable', 'string'],
            'city' => ['nullable', 'string', 'max:255'],
            'province' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:10'],
        ]);

        DB::transaction(function () use ($request, $customer) {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
            ];

            if ($request->hasFile('avatar')) {
                if ($customer->avatar) {
                    \Storage::disk('public')->delete($customer->avatar);
                }
                $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
            }

            $customer->update($data);

            if ($request->filled('password')) {
                $request->validate([
                    'password' => ['confirmed', Rules\Password::defaults()],
                ]);
                $customer->update(['password' => Hash::make($request->password)]);
            }

            // Update or Create Customer Profile
            $customerProfile = $customer->customer()->updateOrCreate(
                ['user_id' => $customer->id],
                [
                    'phone' => $request->phone,
                    'gender' => $request->gender,
                    'date_of_birth' => $request->date_of_birth,
                    'tier' => $request->tier,
                ]
            );

            // Update or Create Primary Address
            if ($request->address_line) {
                $customerProfile->addresses()->updateOrCreate(
                    ['is_primary' => true],
                    [
                        'label' => 'Alamat Utama',
                        'recipient_name' => $customer->name,
                        'phone_number' => $request->phone ?? '-',
                        'address_line' => $request->address_line,
                        'city' => $request->city,
                        'province' => $request->province,
                        'postal_code' => $request->postal_code,
                    ]
                );
            }
        });

        return redirect()->route('admin.customers.index')->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    public function destroy(User $customer)
    {
        if ($customer->role !== 'customer') {
            abort(404);
        }

        if ($customer->avatar) {
            \Storage::disk('public')->delete($customer->avatar);
        }
        
        $customer->delete();
        return redirect()->route('admin.customers.index')->with('success', 'Data pelanggan berhasil dihapus.');
    }
}
