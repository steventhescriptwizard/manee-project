import React from 'react';
import { Link } from 'react-router-dom';

const OrderSuccess: React.FC = () => {
  return (
    <main className="flex-grow container mx-auto px-6 py-12 lg:py-20 min-h-screen">
      <div className="max-w-4xl mx-auto bg-white p-8 md:p-12 shadow-sm border border-gray-50 rounded-sm">
        <div className="text-center mb-14">
          <div className="w-16 h-16 bg-brandBlue/30 rounded-full flex items-center justify-center mx-auto mb-6 animate-pulse">
            <span className="material-symbols-outlined text-3xl text-textMain">check</span>
          </div>
          <h1 className="text-4xl md:text-5xl font-serif italic font-medium text-textMain mb-4 leading-tight">
            Pesanan Anda Berhasil Ditempatkan!
          </h1>
          <p className="text-gray-500 font-light text-lg max-w-lg mx-auto">
            Terima kasih telah berbelanja di Maneé. Konfirmasi pesanan dan resi pengiriman telah dikirim ke email Anda.
          </p>
        </div>

        <div className="bg-[#F9F5F0] p-6 rounded-sm mb-12 flex flex-wrap justify-between items-end gap-6 border-l-4 border-brandBlue">
          <div className="grid grid-cols-2 md:grid-cols-4 gap-8 w-full md:w-auto">
            <div>
              <p className="text-[10px] text-gray-500 uppercase tracking-widest mb-1 font-medium">No. Pesanan</p>
              <p className="font-sans font-medium text-lg">#MN-8823</p>
            </div>
            <div>
              <p className="text-[10px] text-gray-500 uppercase tracking-widest mb-1 font-medium">Tanggal</p>
              <p className="font-sans font-medium text-lg">24 Okt 2023</p>
            </div>
            <div className="col-span-2 md:col-span-2">
              <p className="text-[10px] text-gray-500 uppercase tracking-widest mb-1 font-medium">Total Pembayaran</p>
              <p className="font-sans font-medium text-lg text-brandRed">Rp 899.000</p>
            </div>
          </div>
          <a href="#" className="text-sm border-b border-black pb-0.5 hover:text-gray-600 transition-colors whitespace-nowrap hidden md:block">
            Cetak Invoice
          </a>
        </div>

        <div className="grid grid-cols-1 lg:grid-cols-3 gap-12">
          <div className="lg:col-span-2 space-y-8">
            <h3 className="font-serif italic text-2xl border-b border-gray-100 pb-2 text-textMain">Ringkasan Item</h3>
            <div className="flex gap-5 items-start">
              <div className="w-20 h-24 bg-gray-100 flex-shrink-0 overflow-hidden rounded-sm">
                <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuCoiDlm_pHQFnDjFgWtlN2U84WZqfXqpExXAyv1AQGg9aUol-rX8pqe7XwrlG3KdTgH95lLUKJL8CkNoWlEo_QeRaXFyElIz0bbIVXNGs_zCmBZTtEiNVilWQbDZ5qBfVyWyMkWinv1LbQMDK28y6-vYvrP8eKBsrdUZPGsA7ztvnia8YXQyz4O-gYvCPzIzqjxceWrASG3T3bb1ZkDiCsPrO6GQ8jXAT75SHQEa-_rnEfmmC6HHKqIETyYu9srXMJyAkUOPT2tI7Q" alt="Sweater" className="w-full h-full object-cover" />
              </div>
              <div className="flex-grow pt-1">
                <h4 className="font-sans font-medium text-textMain text-base">Grey Mock Neck Sweater</h4>
                <p className="text-sm text-gray-500 mt-1 font-light">Size: M | Color: Grey</p>
                <p className="text-sm text-gray-500 font-light">Qty: 1</p>
              </div>
              <div className="text-right pt-1">
                <p className="font-medium text-textMain">Rp 450.000</p>
              </div>
            </div>
            <div className="flex gap-5 items-start">
              <div className="w-20 h-24 bg-gray-100 flex-shrink-0 overflow-hidden rounded-sm">
                <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuA1IDsUt5sfwleYPxZC0tG_ROX7G61rI375s2ZaAV6sojanXZmmMoDb7r1ladVxCFjBr2NIV4bLio_V3sYPipS5uksm115D0pHDytc1sYrWVBHQL5lBPHI27LI8Ho79JeizbKaLt2Mv8Rc89vHLYRaySaefw6ypLeEdmsxe_V_LakgCRfjbzHzF_49JR4WAZJ4Ghqc4S1vYPJqT0jf0R-GJ1tFY0IC7At4n2d7Fw5cocXfa1qcYERU_mQgWaIYf1sRJXLDRz4W2Ezs" alt="Cardigan" className="w-full h-full object-cover" />
              </div>
              <div className="flex-grow pt-1">
                <h4 className="font-sans font-medium text-textMain text-base">Cream Cardigan</h4>
                <p className="text-sm text-gray-500 mt-1 font-light">Size: S | Color: Cream</p>
                <p className="text-sm text-gray-500 font-light">Qty: 1</p>
              </div>
              <div className="text-right pt-1">
                <p className="font-medium text-textMain">Rp 429.000</p>
              </div>
            </div>
            <div className="border-t border-gray-100 pt-6 space-y-3 text-sm">
              <div className="flex justify-between text-gray-600 font-light"><span>Subtotal</span><span>Rp 879.000</span></div>
              <div className="flex justify-between text-gray-600 font-light"><span>Pengiriman (Regular)</span><span>Rp 20.000</span></div>
              <div className="flex justify-between text-lg font-medium text-textMain pt-4 border-t border-gray-50 mt-2">
                <span>Total</span><span>Rp 899.000</span>
              </div>
            </div>
          </div>
          
          <div className="space-y-10">
            <div>
              <h3 className="font-serif italic text-2xl border-b border-gray-100 pb-2 mb-4 text-textMain">Dikirim Ke</h3>
              <address className="not-italic text-sm text-gray-600 leading-relaxed font-light">
                <span className="font-medium text-textMain block mb-2 text-base">Anindya Putri</span>
                Jl. Prawirotaman No. 45<br/>
                Mergangsan, Yogyakarta<br/>
                DI Yogyakarta, 55153<br/>
                Indonesia<br/>
                <span className="block mt-2 text-gray-500">(+62) 812-3456-7890</span>
              </address>
            </div>
            <div>
              <h3 className="font-serif italic text-2xl border-b border-gray-100 pb-2 mb-4 text-textMain">Metode Pembayaran</h3>
              <div className="flex items-center gap-3 bg-gray-50 p-3 rounded-sm">
                <span className="material-symbols-outlined text-gray-600">account_balance</span>
                <div className="text-sm">
                  <p className="font-medium text-textMain">Bank Transfer BCA</p>
                  <p className="text-gray-500 text-xs font-light">a.n Maneé Official</p>
                </div>
              </div>
            </div>
            <div className="pt-4 flex flex-col gap-3">
              <button className="block w-full text-center bg-black text-white py-3.5 px-6 text-sm tracking-widest uppercase hover:bg-gray-800 transition-colors rounded-sm">Lacak Pesanan</button>
              <Link to="/" className="block w-full text-center border border-black text-black py-3.5 px-6 text-sm tracking-widest uppercase hover:bg-gray-50 transition-colors rounded-sm">Kembali ke Beranda</Link>
            </div>
          </div>
        </div>
      </div>
    </main>
  );
};

export default OrderSuccess;