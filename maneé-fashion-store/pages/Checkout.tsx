import React from 'react';
import { Link, useNavigate } from 'react-router-dom';

const Checkout: React.FC = () => {
  const navigate = useNavigate();

  const handlePlaceOrder = () => {
    navigate('/success');
  };

  return (
    <div className="bg-white min-h-screen">
      <main className="mx-auto max-w-[1280px] px-6 py-10 lg:px-10">
        <div className="mb-8 flex flex-wrap items-center gap-2 text-sm text-textMuted">
          <Link to="/" className="hover:text-textMain">Home</Link>
          <span className="material-symbols-outlined text-sm">chevron_right</span>
          <Link to="/cart" className="hover:text-textMain">Cart</Link>
          <span className="material-symbols-outlined text-sm">chevron_right</span>
          <span className="font-medium text-textMain">Checkout</span>
        </div>
        <h1 className="mb-10 font-serif text-3xl font-bold text-textMain lg:text-4xl">Checkout</h1>
        
        <div className="grid grid-cols-1 lg:grid-cols-12 gap-10 xl:gap-16">
          <div className="lg:col-span-7 space-y-10">
            {/* Step 1: Shipping */}
            <section>
              <h2 className="mb-6 flex items-center gap-3 font-serif text-2xl font-semibold text-textMain">
                <span className="flex h-8 w-8 items-center justify-center rounded-full bg-brandBlue/20 text-sm font-bold text-textMain">1</span>
                Shipping Information
              </h2>
              <form className="space-y-6">
                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div className="space-y-2">
                    <label className="text-sm font-medium text-textMain">First Name</label>
                    <input className="w-full rounded-md border-gray-200 bg-white px-4 py-3 text-sm placeholder:text-gray-400 focus:border-brandBlue focus:ring-brandBlue" placeholder="Enter first name" type="text" />
                  </div>
                  <div className="space-y-2">
                    <label className="text-sm font-medium text-textMain">Last Name</label>
                    <input className="w-full rounded-md border-gray-200 bg-white px-4 py-3 text-sm placeholder:text-gray-400 focus:border-brandBlue focus:ring-brandBlue" placeholder="Enter last name" type="text" />
                  </div>
                </div>
                <div className="space-y-2">
                  <label className="text-sm font-medium text-textMain">Email Address</label>
                  <input className="w-full rounded-md border-gray-200 bg-white px-4 py-3 text-sm placeholder:text-gray-400 focus:border-brandBlue focus:ring-brandBlue" placeholder="name@example.com" type="email" />
                </div>
                <div className="space-y-2">
                  <label className="text-sm font-medium text-textMain">Phone Number</label>
                  <input className="w-full rounded-md border-gray-200 bg-white px-4 py-3 text-sm placeholder:text-gray-400 focus:border-brandBlue focus:ring-brandBlue" placeholder="+62 812 3456 7890" type="tel" />
                </div>
                <div className="space-y-2">
                  <label className="text-sm font-medium text-textMain">Address</label>
                  <input className="w-full rounded-md border-gray-200 bg-white px-4 py-3 text-sm placeholder:text-gray-400 focus:border-brandBlue focus:ring-brandBlue" placeholder="Street address, apartment, suite, unit" type="text" />
                </div>
                <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                  <div className="space-y-2">
                    <label className="text-sm font-medium text-textMain">City</label>
                    <input className="w-full rounded-md border-gray-200 bg-white px-4 py-3 text-sm placeholder:text-gray-400 focus:border-brandBlue focus:ring-brandBlue" placeholder="Jakarta Selatan" type="text" />
                  </div>
                  <div className="space-y-2">
                    <label className="text-sm font-medium text-textMain">Province</label>
                    <select className="w-full rounded-md border-gray-200 bg-white px-4 py-3 text-sm focus:border-brandBlue focus:ring-brandBlue">
                      <option>DKI Jakarta</option>
                      <option>Jawa Barat</option>
                      <option>Banten</option>
                    </select>
                  </div>
                  <div className="space-y-2">
                    <label className="text-sm font-medium text-textMain">Postal Code</label>
                    <input className="w-full rounded-md border-gray-200 bg-white px-4 py-3 text-sm placeholder:text-gray-400 focus:border-brandBlue focus:ring-brandBlue" placeholder="12345" type="text" />
                  </div>
                </div>
              </form>
              <div className="mt-8">
                <h3 className="mb-4 text-sm font-medium text-textMain">Shipping Method</h3>
                <div className="space-y-3">
                  <label className="flex cursor-pointer items-center justify-between rounded-lg border border-brandBlue bg-brandBlue/5 p-4 transition-colors hover:bg-brandBlue/10">
                    <div className="flex items-center gap-3">
                      <input type="radio" name="shipping" className="h-4 w-4 border-gray-300 text-brandBlue focus:ring-brandBlue" defaultChecked />
                      <div>
                        <p className="font-medium text-textMain">Standard Delivery</p>
                        <p className="text-xs text-textMuted">3-5 business days</p>
                      </div>
                    </div>
                    <span className="font-medium text-textMain">Free</span>
                  </label>
                  <label className="flex cursor-pointer items-center justify-between rounded-lg border border-gray-200 p-4 transition-colors hover:border-brandBlue hover:bg-gray-50">
                    <div className="flex items-center gap-3">
                      <input type="radio" name="shipping" className="h-4 w-4 border-gray-300 text-brandBlue focus:ring-brandBlue" />
                      <div>
                        <p className="font-medium text-textMain">Express Delivery</p>
                        <p className="text-xs text-textMuted">1-2 business days</p>
                      </div>
                    </div>
                    <span className="font-medium text-textMain">Rp 50.000</span>
                  </label>
                </div>
              </div>
            </section>

            {/* Step 2: Payment */}
            <section className="border-t border-[#f0f2f4] pt-10">
              <h2 className="mb-6 flex items-center gap-3 font-serif text-2xl font-semibold text-textMain">
                <span className="flex h-8 w-8 items-center justify-center rounded-full bg-brandBlue/20 text-sm font-bold text-textMain">2</span>
                Payment Method
              </h2>
              <div className="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                {[
                  { icon: 'credit_card', label: 'Credit Card' },
                  { icon: 'account_balance', label: 'Bank Transfer' },
                  { icon: 'wallet', label: 'E-Wallet' },
                ].map((method, idx) => (
                  <label key={idx} className="cursor-pointer">
                    <input type="radio" name="payment-type" className="peer sr-only" defaultChecked={idx === 0} />
                    <div className="flex h-full flex-col items-center justify-center rounded-lg border border-gray-200 bg-white p-4 text-center transition-all peer-checked:border-brandBlue peer-checked:bg-brandBlue/5 hover:border-gray-300">
                      <span className="material-symbols-outlined mb-2 text-2xl text-textMain">{method.icon}</span>
                      <span className="text-sm font-medium text-textMain">{method.label}</span>
                    </div>
                  </label>
                ))}
              </div>
              <div className="rounded-lg bg-gray-50 p-6">
                 {/* Card Form */}
                 <div className="space-y-4">
                    <div className="space-y-2">
                       <label className="text-sm font-medium text-textMain">Card Number</label>
                       <div className="relative">
                          <input type="text" placeholder="0000 0000 0000 0000" className="w-full rounded-md border-gray-200 bg-white px-4 py-3 pl-12 text-sm placeholder:text-gray-400 focus:border-brandBlue focus:ring-brandBlue" />
                          <span className="material-symbols-outlined absolute left-4 top-3 text-gray-400">credit_card</span>
                       </div>
                    </div>
                    <div className="grid grid-cols-2 gap-6">
                      <div className="space-y-2">
                         <label className="text-sm font-medium text-textMain">Expiry Date</label>
                         <input type="text" placeholder="MM/YY" className="w-full rounded-md border-gray-200 bg-white px-4 py-3 text-sm placeholder:text-gray-400 focus:border-brandBlue focus:ring-brandBlue" />
                      </div>
                      <div className="space-y-2">
                         <label className="text-sm font-medium text-textMain">CVV</label>
                         <div className="relative">
                            <input type="text" placeholder="123" className="w-full rounded-md border-gray-200 bg-white px-4 py-3 text-sm placeholder:text-gray-400 focus:border-brandBlue focus:ring-brandBlue" />
                            <span className="material-symbols-outlined absolute right-4 top-3 cursor-help text-gray-400 text-[20px]">help</span>
                         </div>
                      </div>
                    </div>
                    <div className="space-y-2">
                       <label className="text-sm font-medium text-textMain">Name on Card</label>
                       <input type="text" placeholder="Full name as displayed on card" className="w-full rounded-md border-gray-200 bg-white px-4 py-3 text-sm placeholder:text-gray-400 focus:border-brandBlue focus:ring-brandBlue" />
                    </div>
                 </div>
              </div>
            </section>
          </div>

          <div className="lg:col-span-5">
            <div className="sticky top-24 rounded-xl border border-gray-100 bg-gray-50 p-6 shadow-sm lg:p-8">
              <h2 className="mb-6 font-serif text-2xl font-semibold text-textMain">Order Summary</h2>
              <div className="mb-6 flex flex-col gap-6">
                {/* Item 1 */}
                <div className="flex gap-4">
                  <div className="h-20 w-16 flex-shrink-0 overflow-hidden rounded-md border border-gray-200 bg-white">
                    <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuDhlZwnI19XMPjD5L70T2DeYMnlyT_5F_BhII1IoU4Bwu4zUex_luuaD7r2KJzRy5SAnf44NIsWrVcCP2Batu_WeHywM8g93bXeLs6h8pcb5YBPwCeeNdfwWrVBSnmlenuqrt2zDSss7s-MfIdK1A5mYPOpF1aCP4PfDbdnPRtATBvKPLv4rnrA672R-JFST_XR8gf2n7xC0bV5WdLQBJrZU-M1bhFPUolEssRuU0GKpoXIWXYzmKXIXJM6-LE-QubX0xMmYdlTOmE" alt="Linen Shirt" className="h-full w-full object-cover" />
                  </div>
                  <div className="flex flex-1 flex-col justify-between">
                    <div className="flex justify-between gap-2">
                      <div>
                        <h3 className="font-medium text-textMain">The Classic Linen Shirt</h3>
                        <p className="text-xs text-textMuted mt-1">Sage Green / M</p>
                      </div>
                      <p className="font-medium text-textMain">Rp 349.000</p>
                    </div>
                    <p className="text-xs text-textMuted">Qty: 1</p>
                  </div>
                </div>
                 {/* Item 2 */}
                <div className="flex gap-4">
                  <div className="h-20 w-16 flex-shrink-0 overflow-hidden rounded-md border border-gray-200 bg-white">
                    <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuDknYUMny3xcUd9klry8PbE94FuxJKw6VWIlBFjME1WJuDkkzjsS57r5FL7weN-cbZAn7c7A-__2kLKllr-IBg8KDk3cQQVQANYQ1yFjAgs0C92XYmaOYfUnNxfr9lon0lw8z0JxS2uJ02Lk_XjUv8igh-7jmwY2NwIgBrZFilkQbxv2Nyk03CH_Mf8yCJ0wmTfd3-rq5Yaj1WlJyuZjA9q5ZOnVkKobvY-SrdNbFzMm0t_bbpWeLbxqLYS25vFs7zMQI_NIRlNV5A" alt="Trousers" className="h-full w-full object-cover" />
                  </div>
                  <div className="flex flex-1 flex-col justify-between">
                    <div className="flex justify-between gap-2">
                      <div>
                        <h3 className="font-medium text-textMain">Pleated Trousers</h3>
                        <p className="text-xs text-textMuted mt-1">Beige / S</p>
                      </div>
                      <p className="font-medium text-textMain">Rp 389.000</p>
                    </div>
                    <p className="text-xs text-textMuted">Qty: 1</p>
                  </div>
                </div>
              </div>
              
              <div className="mb-6 border-t border-gray-200 py-6">
                 <form className="flex gap-2">
                    <input type="text" placeholder="Promo code" className="flex-1 rounded-md border-gray-200 bg-white px-4 py-2.5 text-sm placeholder:text-gray-400 focus:border-brandBlue focus:ring-brandBlue" />
                    <button type="button" className="rounded-md border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-textMain hover:bg-gray-50">Apply</button>
                 </form>
              </div>

              <div className="space-y-3 text-sm">
                 <div className="flex justify-between text-textMuted"><span>Subtotal</span><span>Rp 738.000</span></div>
                 <div className="flex justify-between text-textMuted"><span>Shipping</span><span className="text-green-600">Free</span></div>
                 <div className="flex justify-between text-textMuted"><span>Tax (11%)</span><span>Rp 81.180</span></div>
                 <div className="mt-4 flex justify-between border-t border-gray-200 pt-4 font-serif text-lg font-bold text-textMain">
                    <span>Total</span><span>Rp 819.180</span>
                 </div>
              </div>
              <button onClick={handlePlaceOrder} className="mt-8 w-full rounded-lg bg-brandBlue py-4 font-sans text-[16px] font-bold tracking-wide text-[#111318] transition-transform active:scale-[0.98] hover:bg-brandBlueHover">Place Order</button>
              <div className="mt-4 flex items-center justify-center gap-2 text-xs text-textMuted">
                 <span className="material-symbols-outlined text-sm">lock</span> Secure checkout powered by Stripe
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  );
};

export default Checkout;