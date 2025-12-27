<div class="bg-white dark:bg-gray-900 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-200 dark:border-gray-800 flex items-center justify-between">
        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Recent Orders</h3>
        <a href="#" class="text-sm font-semibold text-blue-600 hover:text-blue-700">View All</a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-50 dark:bg-gray-800 text-slate-500 dark:text-slate-400 uppercase text-xs font-semibold">
                <tr>
                    <th class="px-6 py-4">Order ID</th>
                    <th class="px-6 py-4">Product</th>
                    <th class="px-6 py-4">Date</th>
                    <th class="px-6 py-4">Amount</th>
                    <th class="px-6 py-4">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 dark:divide-gray-800">
                @php
                    $orders = [
                        [
                            'id' => '#1023',
                            'customer' => 'Sarah Johnson',
                            'avatar' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCPMjk1g28RySO4tJTdKPui-GBQgiEHLQwv_YuZhFSKSOCj94N5qjq4j6Hpt67aMXk2g0OUojhNTRIk1JLJ0wO_8PSOxoxzi7GVYKIM7PnR2CF43YeSKLrvrw4IabnmISm83eh4DTG9AfUCFBBO9IjjkzHu57_ToUjG0JWcPFu-3v7T52DhOCRUJQgrZPjmiaOxuTczwbMJJRwvs2c7cn3Ej1QUy0Vo6KS2Grf5dMtDUkNOlaXoNqzkEDc2fFFX8oJt1Hgrf4EyAuA',
                            'product' => 'Silk Summer Dress',
                            'date' => 'Oct 24, 2023',
                            'amount' => '120.00',
                            'status' => 'Completed'
                        ],
                        [
                            'id' => '#1024',
                            'customer' => 'Mike Thompson',
                            'avatar' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuABItL87A5iE5QlPZacpThkGl2nw-nL73ezIY7GMMnLJqbu2qfOh2ivvdsLiguLrVVrj-0XxWsnVo72Z_8VpkvoIGs4f01WpdEsVNvYZWYCgewQpt4DwMiP55Nz356Gi_3wt0e5Dl1r3KwWM2WwCC_w5PUgHDOiJFePeUJKZrp-1DjHYNNDxnok-qOu8JxJjf0auhmFeGE1VtEXfypEpCsMKD_gbIFjlkPEzqIKuHWCsDAVFIkRiagJKsBFx7uqJsz3EmCNLh-otd8',
                            'product' => 'Denim Jacket',
                            'date' => 'Oct 24, 2023',
                            'amount' => '85.00',
                            'status' => 'Pending'
                        ],
                        [
                            'id' => '#1025',
                            'customer' => 'Emily Chen',
                            'avatar' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuC3B4apRlWfwQMQhjf-pfkLSPg9BSmbPrjdNyfCsKRoBHPwJUzsqztmIUKzODDWZg1YRusYPYO27cqGRH7Q4vP5EKejLZOwK_8dUsUzKRkaCmesgMirogxYbhjecw0j3hUlJm0gHXHGlgke7Cp0iIm-1Maktl3BRNve33mWnS-EBlhKQSJNQ8ZxuHr1RwNy58WqXDBvLtZeG9iK-l0Y1YY0SrOE7gX4egpR3AeWSjfOJFSc54MRAk06oudrTHoO_VjSFzaTeEvh_mg',
                            'product' => 'High Waist Trousers',
                            'date' => 'Oct 23, 2023',
                            'amount' => '90.00',
                            'status' => 'Shipped'
                        ],
                        [
                            'id' => '#1026',
                            'customer' => 'Jessica Davis',
                            'avatar' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuA6oiz6Kdl_r1q1b8G2xWjTjVfn8DU0yJnDn5gKWbvVU_7l1-2pPOmAlqb1mTp_wugzE7UhV1ATIZxjIv6vGmGAeu8pBhxcAoINVYCw0DWQGbYwP_bCM5ioelD3NY1WL6SOw6lG0JNg9bxbN1sGN6WkgIFhFZI220NPo2oT8VA3n_NJpKHn3dOMCxZfSnzSIGINXDW1jMx5lz2e15AETweWHeYmaVAw1y7Zffi0_dIsrFkR_KqNKhM4r9mjyekjk_E7TE3XNy2T3iI',
                            'product' => 'White Cotton Blouse',
                            'date' => 'Oct 23, 2023',
                            'amount' => '55.00',
                            'status' => 'Completed'
                        ]
                    ];
                @endphp

                @foreach($orders as $order)
                <tr class="hover:bg-slate-50 dark:hover:bg-gray-800 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <span class="font-bold text-slate-700 dark:text-slate-200">{{ $order['id'] }}</span>
                            <div class="flex items-center gap-2">
                                <img src="{{ $order['avatar'] }}" class="w-6 h-6 rounded-full object-cover">
                                <span class="text-slate-600 dark:text-slate-400">{{ $order['customer'] }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">{{ $order['product'] }}</td>
                    <td class="px-6 py-4 text-slate-500 dark:text-slate-400">{{ $order['date'] }}</td>
                    <td class="px-6 py-4 font-semibold text-slate-900 dark:text-white">${{ $order['amount'] }}</td>
                    <td class="px-6 py-4">
                        @php
                            $statusClass = match($order['status']) {
                                'Completed' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                'Pending' => 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400',
                                'Shipped' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                default => 'bg-gray-100 text-gray-700'
                            };
                        @endphp
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">
                            {{ $order['status'] }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
