<div class="bg-white dark:bg-gray-900 p-6 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm flex flex-col h-full">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Top Selling Products</h3>
        <a href="#" class="text-sm font-semibold text-blue-600 hover:text-blue-700">View All</a>
    </div>

    <div class="flex flex-col gap-4 overflow-y-auto pr-2">
        @php
            $products = [
                [
                    'name' => 'Silk Summer Dress',
                    'sales' => 124,
                    'price' => 120,
                    'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBPQviqAjm7rHpvhXf2pwJF2hRPwYBQxiwD8l5l-pl3JiMQytU_GpwyOFRG7m5ZlXDnrXOhD_975gtHh2kbZNMIFSfwomWfl7xUWwOfDHi45xpLfZ1THR8V_yTeUMhjj8J1kPAFXbv5MJ5IzOc-UZ-ydUBtbJrQhVlPSg6VZB23Z7-73QEDY8cOknfAmDWVlYrBG0Em0u-5qZpTZ9OliscvovVQsCCR7gbiW68Wy2i_NuRovn_2KeSdPxf0iru-gTVomobipsIz8Fc'
                ],
                [
                    'name' => 'Classic Denim Jacket',
                    'sales' => 89,
                    'price' => 85,
                    'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAuXShKxMoCsX1-lYzC5_brpfV1AoeyJMtF4K_xQjAForu8Gck0BZ86liOH09YEppjgPvl5WpoiMHSnXmAWaUPSp6qf30qccF5sT1vFWPXNbXwktV1OKkjOqIDZqn8JEBmLqCvrzmQPeZaMnNnqUb4yqbqUIJSZ17OqUHcvh1xHy6HDeZLMnn6T4Xt9agsnfwz9FlQXQDSknnGu4mFQULWi9JijASscMag5r65dGd86il9V_tp2WZw1ke8_WDexW0Rgz9cceCcY6_I'
                ],
                [
                    'name' => 'White Cotton Blouse',
                    'sales' => 65,
                    'price' => 55,
                    'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCRaRw1oGlIR8LgWCf6t0H2dHUhfVgxr6Ij1Nawtja2RsVtF3hnM2K0LmFQMO1tBhvW0dyhO7Ivm7o-AjNYgPCADNE6k6ny0bbAusZ1Ypiq165EQUlKIUvRl0F_lIMDxqCk33IN-CW-Q8yD98nhhj1oLq-4eS-Sj66xAYQRBOLCDN1QpSHrlIWKr6T5YcAIcXDHN3v64wPkl-OFKm2n33gAINER9RyPdzcEeMSLqOrutAOY99PdMz0poU5RvvctfOFLVDYliKu9mUg'
                ],
                [
                    'name' => 'High Waist Trousers',
                    'sales' => 42,
                    'price' => 90,
                    'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuArEKmC5T1c6xw5fWHELwh4hFTIysUQKjckgqSjNHzgEQepkYZMa6winh6gEdOrgYiCiUeHVg-biJmIfNR4tzIoygRPDECmSnhXBghvJDTnY10su5oy3DKFh_Fzmi3kaVmb3sNzTncfj3pEZ3v7Tdx2JIOgoJRFP8QaeEvDTRcUTw-4SiR8C95n0L_Kgy80Lr1h2Dig_mvq-OCd6EGt0ZEza3iRDpGVQMlJC6LjONduJL15ZFtCat9Scee0n_JHZQZ94DufWt7yzrU'
                ]
            ];
        @endphp

        @foreach($products as $product)
        <div class="flex items-center gap-4 group cursor-pointer">
            <div 
                class="bg-center bg-no-repeat bg-cover rounded-lg h-12 w-12 border border-slate-100 dark:border-gray-800"
                style="background-image: url('{{ $product['image'] }}')"
            ></div>
            <div class="flex-1">
                <h4 class="text-sm font-semibold text-slate-900 dark:text-white group-hover:text-blue-600 transition-colors line-clamp-1">{{ $product['name'] }}</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400">{{ $product['sales'] }} sales</p>
            </div>
            <span class="text-sm font-bold text-slate-900 dark:text-white">${{ $product['price'] }}</span>
        </div>
        @endforeach
    </div>
</div>
