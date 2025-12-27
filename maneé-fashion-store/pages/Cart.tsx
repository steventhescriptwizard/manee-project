import React from 'react';
import { Link, useNavigate } from 'react-router-dom';

const Cart: React.FC = () => {
  const navigate = useNavigate();

  return (
    <div className="bg-brandCream min-h-screen">
       <main className="flex-grow w-full max-w-7xl mx-auto px-4 md:px-10 py-8 md:py-12">
        {/* Page Heading */}
        <div className="mb-8 md:mb-12">
          <h2 className="font-serif text-4xl md:text-5xl font-bold text-[#111318] mb-2">Keranjang Belanja</h2>
          <p className="text-[#616f89] text-base font-light">Anda memiliki 2 item di keranjang belanja.</p>
        </div>

        <div className="flex flex-col lg:flex-row gap-8 xl:gap-12 items-start">
          {/* Items List */}
          <div className="w-full lg:flex-1">
            <div className="hidden md:grid grid-cols-12 gap-4 border-b border-[#dbdfe6] pb-3 mb-4 text-sm font-medium text-[#616f89] uppercase tracking-wider">
              <div className="col-span-6">Produk</div>
              <div className="col-span-2 text-center">Harga</div>
              <div className="col-span-2 text-center">Kuantitas</div>
              <div className="col-span-2 text-right">Total</div>
            </div>

            {/* Cart Item 1 */}
            <div className="group relative flex flex-col md:grid md:grid-cols-12 gap-4 py-6 border-b border-[#dbdfe6] items-center">
              <div className="col-span-6 flex gap-4 w-full">
                <div className="relative w-24 h-32 md:w-28 md:h-36 flex-shrink-0 overflow-hidden rounded-lg bg-gray-100">
                  <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuD9WD5L-06GMlWbzMFwmawuRP5VcqNUcV7orB9WKOwSJZ9ZRPle98xt47NB3jt5nmpIVK-DH5m7a9Q4XozkBKdTQ-PGWkwLuAeLFgVwJEl6wIJ90Aky8yIoSuGbieQAUMVFc9tsdSzByC_DOIfpG3zTxZ8hdD5nfE2t08Ht3rkBajYIIVhUEumCGGd81FOg1KD4JTG9GLT9-_-91TwyxrrzRFHbugywEi3__xjE6xzpbTKUyEI7Hi03kuB4tzlo_OtykzfOVvjsZ_E" alt="Linen Shirt" className="w-full h-full object-cover" />
                </div>
                <div className="flex flex-col justify-center">
                  <h3 className="font-serif text-xl font-semibold text-[#111318] mb-1">Maneé Classic Linen Shirt</h3>
                  <p className="text-sm text-[#616f89] mb-1">Warna: Putih Alami</p>
                  <p className="text-sm text-[#616f89]">Ukuran: M</p>
                  <div className="md:hidden mt-2 flex items-center justify-between w-full gap-4">
                    <span className="font-medium text-[#111318]">Rp 299.000</span>
                  </div>
                </div>
              </div>
              <div className="hidden md:block col-span-2 text-center text-[#111318] font-normal">Rp 299.000</div>
              <div className="col-span-12 md:col-span-2 flex justify-start md:justify-center w-full md:w-auto mt-4 md:mt-0">
                <div className="flex items-center border border-[#dbdfe6] rounded-lg h-9 bg-white">
                  <button className="w-8 h-full flex items-center justify-center text-[#616f89] hover:bg-surface hover:text-[#111318] rounded-l-lg transition-colors"><span className="material-symbols-outlined text-[16px]">remove</span></button>
                  <input type="text" value="1" readOnly className="w-10 h-full text-center border-none focus:ring-0 text-sm font-medium text-[#111318] p-0" />
                  <button className="w-8 h-full flex items-center justify-center text-[#616f89] hover:bg-surface hover:text-[#111318] rounded-r-lg transition-colors"><span className="material-symbols-outlined text-[16px]">add</span></button>
                </div>
              </div>
              <div className="hidden md:flex col-span-2 justify-end text-[#111318] font-bold">Rp 299.000</div>
              <button className="hidden md:block absolute top-1/2 -translate-y-1/2 -right-8 xl:-right-10 text-[#9ca3af] hover:text-red-500 transition-colors p-2"><span className="material-symbols-outlined">delete</span></button>
            </div>

            {/* Cart Item 2 */}
            <div className="group relative flex flex-col md:grid md:grid-cols-12 gap-4 py-6 border-b border-[#dbdfe6] items-center">
              <div className="col-span-6 flex gap-4 w-full">
                <div className="relative w-24 h-32 md:w-28 md:h-36 flex-shrink-0 overflow-hidden rounded-lg bg-gray-100">
                  <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuCBdqwjIjQuWcCEX2ULDtBXsCeWbrBUmgkpHwz4vx3rSchzDR05gWN-QjMSdd1FeSE2s7mRFDemBCBeWcQMzTKUn0m-qff4s0dgMJD4KoJCmLaLGPWBiXLHrujIoao8B4E2sI0R8HAtjZSVdwIsm7sQDYGNWZeaOxBYafeLfiyVq2f2RzZWNBvJeM04hO6sazY1EB2zjSIEX3jQUYaQDnnBsMwfbDcChJWwSxy2vJFaXzQU-rDn8wegiN_MCfRDjR1AJfk509uWzrY" alt="Silk Skirt" className="w-full h-full object-cover" />
                </div>
                <div className="flex flex-col justify-center">
                  <h3 className="font-serif text-xl font-semibold text-[#111318] mb-1">Silk Midi Skirt</h3>
                  <p className="text-sm text-[#616f89] mb-1">Warna: Champagne</p>
                  <p className="text-sm text-[#616f89]">Ukuran: S</p>
                  <div className="md:hidden mt-2 flex items-center justify-between w-full gap-4">
                    <span className="font-medium text-[#111318]">Rp 349.000</span>
                  </div>
                </div>
              </div>
              <div className="hidden md:block col-span-2 text-center text-[#111318] font-normal">Rp 349.000</div>
              <div className="col-span-12 md:col-span-2 flex justify-start md:justify-center w-full md:w-auto mt-4 md:mt-0">
                <div className="flex items-center border border-[#dbdfe6] rounded-lg h-9 bg-white">
                  <button className="w-8 h-full flex items-center justify-center text-[#616f89] hover:bg-surface hover:text-[#111318] rounded-l-lg transition-colors"><span className="material-symbols-outlined text-[16px]">remove</span></button>
                  <input type="text" value="1" readOnly className="w-10 h-full text-center border-none focus:ring-0 text-sm font-medium text-[#111318] p-0" />
                  <button className="w-8 h-full flex items-center justify-center text-[#616f89] hover:bg-surface hover:text-[#111318] rounded-r-lg transition-colors"><span className="material-symbols-outlined text-[16px]">add</span></button>
                </div>
              </div>
              <div className="hidden md:flex col-span-2 justify-end text-[#111318] font-bold">Rp 349.000</div>
              <button className="hidden md:block absolute top-1/2 -translate-y-1/2 -right-8 xl:-right-10 text-[#9ca3af] hover:text-red-500 transition-colors p-2"><span className="material-symbols-outlined">delete</span></button>
            </div>
            
            <div className="mt-8">
              <Link to="/product" className="inline-flex items-center gap-2 text-sm font-medium text-[#111318] hover:text-brandBlue transition-colors border-b border-transparent hover:border-brandBlue pb-0.5">
                <span className="material-symbols-outlined text-[18px]">arrow_back</span> Lanjut Belanja
              </Link>
            </div>
          </div>

          {/* Order Summary */}
          <div className="w-full lg:w-[380px] xl:w-[420px] flex-shrink-0">
            <div className="lg:sticky lg:top-28 bg-[#f8f9fc] rounded-xl p-6 md:p-8 border border-[#dbdfe6]/50">
              <h3 className="font-serif text-2xl font-bold text-[#111318] mb-6">Ringkasan Pesanan</h3>
              <div className="space-y-4 mb-6 border-b border-[#dbdfe6] pb-6">
                <div className="flex justify-between items-center text-[#616f89]">
                  <span className="text-sm">Subtotal</span>
                  <span className="font-medium text-[#111318]">Rp 648.000</span>
                </div>
                <div className="flex justify-between items-center text-[#616f89]">
                  <span className="text-sm">Biaya Pengiriman</span>
                  <span className="text-sm text-[#616f89] italic">Hitung di Checkout</span>
                </div>
                <div className="flex justify-between items-center text-[#616f89]">
                  <span className="text-sm">Diskon</span>
                  <span className="font-medium text-[#111318]">-</span>
                </div>
              </div>
              <div className="mb-6">
                <label className="block text-xs font-medium text-[#616f89] mb-2 uppercase tracking-wide">Kode Promo</label>
                <div className="flex gap-2">
                  <input type="text" placeholder="Masukkan kode" className="flex-1 rounded-lg border-[#dbdfe6] bg-white text-sm focus:border-brandBlue focus:ring-brandBlue" />
                  <button className="px-4 py-2 bg-white border border-[#dbdfe6] rounded-lg text-sm font-medium text-[#111318] hover:bg-gray-50 transition-colors">Pakai</button>
                </div>
              </div>
              <div className="flex justify-between items-center mb-8">
                <span className="font-serif text-xl font-bold text-[#111318]">Total</span>
                <div className="flex flex-col items-end">
                  <span className="font-serif text-2xl font-bold text-[#111318]">Rp 648.000</span>
                  <span className="text-xs text-[#616f89]">Termasuk PPN</span>
                </div>
              </div>
              <button 
                onClick={() => navigate('/checkout')}
                className="w-full bg-brandBlue hover:bg-brandBlueHover text-[#111318] rounded-lg py-3.5 px-4 font-bold text-base tracking-wide transition-all shadow-sm hover:shadow flex items-center justify-center gap-2 group"
              >
                <span className="material-symbols-outlined text-[20px] group-hover:translate-x-0.5 transition-transform">lock</span> Lanjut ke Pembayaran
              </button>
              <div className="mt-6 grid grid-cols-3 gap-2 text-center">
                 {/* Trust signals */}
                <div className="flex flex-col items-center gap-1">
                  <span className="material-symbols-outlined text-[#616f89] text-[20px]">verified_user</span>
                  <span className="text-[10px] text-[#616f89] leading-tight">Pembayaran Aman</span>
                </div>
                <div className="flex flex-col items-center gap-1">
                  <span className="material-symbols-outlined text-[#616f89] text-[20px]">local_shipping</span>
                  <span className="text-[10px] text-[#616f89] leading-tight">Pengiriman Cepat</span>
                </div>
                <div className="flex flex-col items-center gap-1">
                  <span className="material-symbols-outlined text-[#616f89] text-[20px]">sync_alt</span>
                  <span className="text-[10px] text-[#616f89] leading-tight">Garansi Retur</span>
                </div>
              </div>
            </div>
          </div>
        </div>
       </main>
    </div>
  );
};

export default Cart;