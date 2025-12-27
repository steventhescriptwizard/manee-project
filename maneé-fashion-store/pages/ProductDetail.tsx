import React, { useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';

const ProductDetail: React.FC = () => {
  const navigate = useNavigate();
  const [selectedSize, setSelectedSize] = useState('M');
  const [selectedColor, setSelectedColor] = useState('Sage Green');

  const addToCart = () => {
    navigate('/cart');
  };

  return (
    <div className="bg-white pt-6">
      <main className="mx-auto max-w-[1280px] px-6 py-6 lg:px-10">
        <nav className="mb-8 flex flex-wrap items-center gap-2 text-sm text-textMuted">
          <Link to="/" className="hover:text-textMain">Home</Link>
          <span className="material-symbols-outlined text-sm">chevron_right</span>
          <Link to="/product" className="hover:text-textMain">Shop</Link>
          <span className="material-symbols-outlined text-sm">chevron_right</span>
          <span className="font-medium text-textMain">The Classic Linen Shirt</span>
        </nav>

        <div className="grid grid-cols-1 lg:grid-cols-12 gap-10 xl:gap-16">
          {/* Gallery */}
          <div className="lg:col-span-7">
            <div className="flex flex-col-reverse lg:flex-row gap-4">
              <div className="flex lg:flex-col gap-3 overflow-x-auto lg:overflow-y-auto lg:w-24 lg:h-[600px] hide-scrollbar">
                {[
                  'https://lh3.googleusercontent.com/aida-public/AB6AXuDhlZwnI19XMPjD5L70T2DeYMnlyT_5F_BhII1IoU4Bwu4zUex_luuaD7r2KJzRy5SAnf44NIsWrVcCP2Batu_WeHywM8g93bXeLs6h8pcb5YBPwCeeNdfwWrVBSnmlenuqrt2zDSss7s-MfIdK1A5mYPOpF1aCP4PfDbdnPRtATBvKPLv4rnrA672R-JFST_XR8gf2n7xC0bV5WdLQBJrZU-M1bhFPUolEssRuU0GKpoXIWXYzmKXIXJM6-LE-QubX0xMmYdlTOmE',
                  'https://lh3.googleusercontent.com/aida-public/AB6AXuA3ynT1qhA7n-Y1HV1cN8zux5i3-xeRCxuqg14Y9iMaW8Jcbkyi4QBq4B29Rjnp5qCeA5KJ9BFlhOo0IwHZj1P5-YlUjrHz7EhgWZ0BuPDcdegmgeQTrjxX5BZ91t4VkebGlDnmg9422PeLV1Ouhtw1p1cb_vuLUzReyhioRpl6f7DxlkLkdb1klKxRlGN0sMSRCoAMKihdkaBvnoFX6KEr-hTdS58bqn3ykrYJbukgRyWmzyXtZ2T7MLPBRAMOqfTpoyixgBMkRNw',
                  'https://lh3.googleusercontent.com/aida-public/AB6AXuCPi40eXpi7M39RS7k8DuNm0dM_3e2OMTCIfwkG3agOHL3FzGveIVs0KkUhoT29BBkjseMOD1SecMiYT4vuoLFn4xXPcRON4V32y7biBXFH3SXCUorLaBAjSHWXLCout1gylIzyNmWG_jUTuiLXET8ayuvp9NvgD67-jjSQIc5yL9vDQRbsdkU9g9dRxwI2chySVLEwz_RFKDwAEZdZPDcXzZcbg5ywJd7902uJuvm2I3A6rxKqQ_sLnL0H948D0ms3lCJt5w-9_q4',
                  'https://lh3.googleusercontent.com/aida-public/AB6AXuAwWFXLjWAydLT8LcrbmNSspjrmVLqe1WOqbuLdYFpZRDujLAIXeH9yzTzi0kBeyykuwIYAqRV3lQp0CCVOsl6hoq_poN_uVIhJhZAcKBGud8d1mse2Jz_sOXGKL9pGgu9vRV4R-AxBs_JFquA_vpIxiGuzLLQUBKi6Xb9XNb8q5zeJeikNp9egQmrPvr7YcAcowV3c67Qd2QlEmkq_txTD6HqqaZuaB4BPAqzkfQgY1V112Rr6VPN0maV7YLwb_XRwdqiF6KPtk6U'
                ].map((src, i) => (
                  <button key={i} className={`relative aspect-[3/4] w-20 min-w-[80px] lg:w-full overflow-hidden rounded-lg border-2 ${i === 0 ? 'border-brandBlue' : 'border-transparent hover:border-gray-300'}`}>
                    <img src={src} alt="Thumbnail" className="h-full w-full object-cover" />
                  </button>
                ))}
              </div>
              <div className="flex-1">
                <div className="relative aspect-[3/4] w-full overflow-hidden rounded-xl bg-gray-100">
                  <img 
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuBDsfBrrcYhytQNMK3LXS8jkAwTw66Hb6MiegDLeRdqntG71wgRdAcD7muX-bp_FQw03ONr1N_sj6rwaQ4-vbq1XW2YxONCj9PfXT-KChWT3CSh1mYT-VIzJTFemA4m6ISzBP8R1fA61Y2edwRkUuX4QfeSiknKpKkEY__jcCMxaMyMaZQuVzTt8QKze2_5urj1eiuKV2R5iiii16Rz2HbNS8b86IS3SDue_T7UHrDO48eVIvjgH_rTdNOlw8LqLF6cr3W0EdIQhI4" 
                    alt="Main product" 
                    className="h-full w-full object-cover" 
                  />
                  <button className="absolute bottom-4 right-4 rounded-full bg-white p-2 text-gray-900 shadow-md hover:bg-gray-50">
                    <span className="material-symbols-outlined">zoom_in</span>
                  </button>
                </div>
              </div>
            </div>
          </div>

          {/* Details */}
          <div className="lg:col-span-5 flex flex-col pt-2 lg:pt-0">
            <div className="border-b border-gray-100 pb-6">
              <h1 className="font-serif text-3xl lg:text-4xl font-bold leading-tight text-textMain">The Classic Linen Shirt</h1>
              <div className="mt-2 flex items-center justify-between">
                <p className="text-2xl font-medium text-textMain">Rp 349.000</p>
                <div className="flex items-center gap-1 text-amber-400">
                  {[1,2,3,4].map(i => <span key={i} className="material-symbols-outlined text-[18px] fill-current">star</span>)}
                  <span className="material-symbols-outlined text-[18px] fill-current opacity-50">star_half</span>
                  <span className="ml-1 text-xs text-textMuted text-gray-500">(128 Reviews)</span>
                </div>
              </div>
            </div>

            <div className="py-6">
              <p className="text-base leading-relaxed text-textMuted">
                A timeless staple for your wardrobe. Crafted from 100% breathable linen, this shirt offers a relaxed fit that's perfect for the modern woman on the go. Effortlessly chic and endlessly versatile.
              </p>
            </div>

            {/* Color */}
            <div className="mb-6">
              <span className="mb-3 block text-sm font-medium text-textMain">Color: <span className="text-textMuted font-normal">{selectedColor}</span></span>
              <div className="flex gap-3">
                <button 
                  onClick={() => setSelectedColor('Sage Green')}
                  className={`group relative h-10 w-10 rounded-full border bg-[#E0E8E1] focus:outline-none focus:ring-2 focus:ring-brandBlue focus:ring-offset-2 ${selectedColor === 'Sage Green' ? 'border-gray-400 ring-2 ring-brandBlue ring-offset-2' : 'border-gray-200'}`}
                >
                  {selectedColor === 'Sage Green' && <span className="absolute inset-0 flex items-center justify-center"><span className="material-symbols-outlined text-sm text-gray-600">check</span></span>}
                </button>
                <button 
                  onClick={() => setSelectedColor('White')}
                  className={`h-10 w-10 rounded-full border bg-[#F5F5F5] hover:scale-105 focus:outline-none focus:ring-2 focus:ring-brandBlue focus:ring-offset-2 ${selectedColor === 'White' ? 'border-gray-400 ring-2 ring-brandBlue ring-offset-2' : 'border-gray-200'}`}
                >
                   {selectedColor === 'White' && <span className="absolute inset-0 flex items-center justify-center"><span className="material-symbols-outlined text-sm text-gray-600">check</span></span>}
                </button>
                <button 
                  onClick={() => setSelectedColor('Navy')}
                  className={`h-10 w-10 rounded-full border bg-[#1A202C] hover:scale-105 focus:outline-none focus:ring-2 focus:ring-brandBlue focus:ring-offset-2 ${selectedColor === 'Navy' ? 'border-gray-400 ring-2 ring-brandBlue ring-offset-2' : 'border-gray-200'}`}
                >
                   {selectedColor === 'Navy' && <span className="absolute inset-0 flex items-center justify-center"><span className="material-symbols-outlined text-sm text-white">check</span></span>}
                </button>
              </div>
            </div>

            {/* Size */}
            <div className="mb-8">
              <div className="mb-3 flex items-center justify-between">
                <span className="text-sm font-medium text-textMain">Size</span>
                <button className="text-xs font-medium text-textMuted hover:text-textMain underline">Size Guide</button>
              </div>
              <div className="grid grid-cols-4 gap-3">
                {['S', 'M', 'L', 'XL'].map((size) => (
                  <button 
                    key={size}
                    onClick={() => setSelectedSize(size)}
                    disabled={size === 'XL'}
                    className={`flex h-12 items-center justify-center rounded-lg border text-sm font-medium transition-all 
                      ${selectedSize === size 
                        ? 'border-2 border-brandBlue bg-brandBlue/10 text-gray-900 font-bold' 
                        : 'border-gray-200 hover:border-gray-400 text-textMain'}
                      ${size === 'XL' ? 'opacity-50 cursor-not-allowed' : ''}
                    `}
                  >
                    {size}
                  </button>
                ))}
              </div>
            </div>

            {/* Actions */}
            <div className="flex gap-4 pb-8 border-b border-gray-100">
              <button onClick={addToCart} className="flex-1 h-14 rounded-lg bg-brandBlue font-sans text-[16px] font-bold tracking-wide text-[#111318] transition-transform active:scale-[0.98] hover:bg-brandBlueHover flex items-center justify-center gap-2">
                Add to Cart
              </button>
              <button className="h-14 w-14 rounded-lg border border-gray-200 flex items-center justify-center text-textMain hover:bg-gray-50 transition-colors">
                <span className="material-symbols-outlined">favorite</span>
              </button>
            </div>

            {/* Accordions */}
            <div className="mt-6 flex flex-col gap-1">
              <details className="group py-4 border-b border-gray-100">
                <summary className="flex cursor-pointer items-center justify-between text-sm font-medium text-textMain">
                  <span>Details & Care</span>
                  <span className="material-symbols-outlined transition-transform group-open:rotate-180">expand_more</span>
                </summary>
                <div className="pt-3 text-sm text-textMuted">
                  <ul className="list-disc pl-4 space-y-1">
                    <li>100% Premium Linen</li>
                    <li>Machine wash cold, gentle cycle</li>
                    <li>Do not bleach</li>
                    <li>Hang to dry</li>
                  </ul>
                </div>
              </details>
              <details className="group py-4 border-b border-gray-100">
                <summary className="flex cursor-pointer items-center justify-between text-sm font-medium text-textMain">
                  <span>Shipping & Returns</span>
                  <span className="material-symbols-outlined transition-transform group-open:rotate-180">expand_more</span>
                </summary>
                <div className="pt-3 text-sm text-textMuted">
                  <p>Free shipping on all domestic orders over Rp 500.000. Returns accepted within 14 days of delivery.</p>
                </div>
              </details>
            </div>
          </div>
        </div>

        {/* Reviews Section */}
        <div className="mt-20 lg:mt-24 border-t border-[#f0f2f4] pt-16">
          <div className="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16">
            <div className="lg:col-span-4">
              <h2 className="font-serif text-2xl lg:text-3xl font-bold text-textMain mb-6">Customer Reviews</h2>
              <div className="mb-10 flex items-center gap-4">
                <div className="flex items-center gap-2">
                  <span className="text-5xl font-serif font-bold text-textMain">4.8</span>
                  <div className="flex flex-col">
                    <div className="flex text-amber-400 text-sm">
                      {[1,2,3,4].map(i => <span key={i} className="material-symbols-outlined text-[20px] fill-current">star</span>)}
                      <span className="material-symbols-outlined text-[20px] fill-current opacity-50">star_half</span>
                    </div>
                    <span className="text-xs text-textMuted mt-1">Based on 128 reviews</span>
                  </div>
                </div>
              </div>
              <div className="rounded-lg border border-gray-100 bg-gray-50 p-6">
                <h3 className="font-serif text-lg font-bold text-textMain mb-4">Write a Review</h3>
                <form className="space-y-4" onSubmit={(e) => e.preventDefault()}>
                  <div>
                    <label className="block text-xs font-medium text-textMuted mb-1">Rating</label>
                    <div className="flex gap-1 text-gray-300">
                      {[1,2,3,4,5].map(i => (
                        <button key={i} type="button" className="hover:text-amber-400">
                          <span className="material-symbols-outlined fill-current">star</span>
                        </button>
                      ))}
                    </div>
                  </div>
                  <div>
                    <label className="block text-xs font-medium text-textMuted mb-1" htmlFor="name">Name</label>
                    <input className="w-full rounded border-gray-200 bg-white px-3 py-2 text-sm focus:border-brandBlue focus:ring-brandBlue" id="name" placeholder="Your name" type="text" />
                  </div>
                  <div>
                    <label className="block text-xs font-medium text-textMuted mb-1" htmlFor="review">Review</label>
                    <textarea className="w-full rounded border-gray-200 bg-white px-3 py-2 text-sm focus:border-brandBlue focus:ring-brandBlue" id="review" placeholder="How was the product?" rows={3}></textarea>
                  </div>
                  <button className="w-full rounded bg-brandBlue px-4 py-2.5 text-sm font-bold text-[#111318] hover:bg-brandBlueHover transition-colors" type="button">Submit Review</button>
                </form>
              </div>
            </div>
            
            <div className="lg:col-span-8 pt-2 lg:pt-14">
              <div className="space-y-8">
                {/* Review 1 */}
                <div className="border-b border-gray-100 pb-8">
                  <div className="flex items-center justify-between mb-2">
                    <div className="flex items-center gap-3">
                      <div className="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold text-sm">SJ</div>
                      <div>
                        <h4 className="text-sm font-bold text-textMain">Sarah Jenkins</h4>
                        <div className="flex items-center gap-2 text-xs text-textMuted">
                          <span>2 days ago</span><span>•</span><span>Ordered Size M</span>
                        </div>
                      </div>
                    </div>
                    <div className="flex text-amber-400">
                      {[1,2,3,4,5].map(i => <span key={i} className="material-symbols-outlined text-[16px] fill-current">star</span>)}
                    </div>
                  </div>
                  <p className="text-sm leading-relaxed text-textMuted mt-3">Absolutely love this shirt! The linen quality is fantastic, very soft and breathable. It fits perfectly, slightly oversized as described. The sage green color is exactly like the photos.</p>
                </div>
                 {/* Review 2 */}
                <div className="border-b border-gray-100 pb-8">
                  <div className="flex items-center justify-between mb-2">
                    <div className="flex items-center gap-3">
                      <div className="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold text-sm">MA</div>
                      <div>
                        <h4 className="text-sm font-bold text-textMain">Michelle A.</h4>
                        <div className="flex items-center gap-2 text-xs text-textMuted">
                          <span>1 week ago</span><span>•</span><span>Ordered Size S</span>
                        </div>
                      </div>
                    </div>
                    <div className="flex text-amber-400">
                      {[1,2,3,4].map(i => <span key={i} className="material-symbols-outlined text-[16px] fill-current">star</span>)}
                      <span className="material-symbols-outlined text-[16px] fill-current text-gray-300">star</span>
                    </div>
                  </div>
                  <p className="text-sm leading-relaxed text-textMuted mt-3">Great shirt overall. The fabric feels premium. I deducted one star because the sleeves are a bit longer than I expected for a size S.</p>
                </div>
              </div>
              <div className="mt-10 text-center">
                <button className="inline-flex items-center gap-2 text-sm font-medium text-textMain hover:text-brandBlue transition-colors">
                  <span>View all 128 reviews</span>
                  <span className="material-symbols-outlined text-lg">arrow_forward</span>
                </button>
              </div>
            </div>
          </div>
        </div>

        {/* Recommendations */}
        <div className="mt-20 lg:mt-32">
          <h2 className="mb-8 font-serif text-2xl lg:text-3xl font-bold text-textMain">You May Also Like</h2>
          <div className="grid grid-cols-2 md:grid-cols-4 gap-4 lg:gap-8">
            {[
              { name: 'The Oversized Blouse', price: 'Rp 299.000', img: 'https://lh3.googleusercontent.com/aida-public/AB6AXuBjj0VuqOitMQivgaQH961_WZ91Fp9AlbcmkRvfSd4meneMnVPpA69qex8Qy2LboYjKsExpbUBtLP6d_OtgjqoxH8aD2rcdqdw7zCbjaeph204CAwZrHjQInV_O4AUSQXYNoOTInoAMfM4EA2jckcEf1NHUK-aX1McyN9mQRCsfrCOvFjucun2ou15iTMlcjfSRmU8VVUJjbANptQDiJyvn8lR2CUXUbWOpYnnpCxdCqfijQnxxfJ7YE7QT0JtgqM0JaJE92UjXiqo' },
              { name: 'Summer Linen Dress', price: 'Rp 459.000', img: 'https://lh3.googleusercontent.com/aida-public/AB6AXuDVfPBq7g6CPlpvAu9-b8-E4betRc_bOiGjMR0sH34XCkBi0eHXRwd3TFJCmJXIOlEmJv6qhqva0YgrxeSEc6EHvei6NSrhPBcTekyFkSb_xVGvcJ_sO0DoGPiCaians1sbvdK3WNAhhqNyqJQ9ns1_1I5CThZnkmkWHOMIS6-SymPR5bKvpNUMg8pWPYo0xs-V1Gq1mMUubfPG9jTfKJaO7XYdTw6R32ysw85vUXS8otvJLrZn7u3BcgtIRlFyglC5femDkgUTAmg' },
              { name: 'Structure Blazer', price: 'Rp 529.000', img: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCvlTE2H87rgwHIphOl1f5AyWm0A0L3XzJ2b8RITg7KzVcJDf71ddyrxguSvSG2BSBb_kbXulOS_Pw8neKPhg4c746JsjQtzqgC3Bw2gvZB7lg7i4lReUcOswKuaEG8cEI5H0X7J5W7A6CbrhYwc9V8yUop29Nn16NCK5TrzxXX2nP81zzFUh_5pkcajhi0TIhuXdG4As0skYIsgRg8ZOYcD4m81liA5cNu2dDc9rEqeqAw2tFJPkhp5YY7eJtA9qML1uX3PtIhvcI' },
              { name: 'Pleated Trousers', price: 'Rp 389.000', img: 'https://lh3.googleusercontent.com/aida-public/AB6AXuDknYUMny3xcUd9klry8PbE94FuxJKw6VWIlBFjME1WJuDkkzjsS57r5FL7weN-cbZAn7c7A-__2kLKllr-IBg8KDk3cQQVQANYQ1yFjAgs0C92XYmaOYfUnNxfr9lon0lw8z0JxS2uJ02Lk_XjUv8igh-7jmwY2NwIgBrZFilkQbxv2Nyk03CH_Mf8yCJ0wmTfd3-rq5Yaj1WlJyuZjA9q5ZOnVkKobvY-SrdNbFzMm0t_bbpWeLbxqLYS25vFs7zMQI_NIRlNV5A' }
            ].map((item, idx) => (
              <div key={idx} className="group flex flex-col gap-3 cursor-pointer">
                <div className="relative w-full overflow-hidden rounded-lg aspect-[3/4]">
                  <img src={item.img} alt={item.name} className="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" />
                  <button className="absolute bottom-3 right-3 flex h-8 w-8 translate-y-2 items-center justify-center rounded-full bg-white text-gray-900 opacity-0 shadow-sm transition-all group-hover:translate-y-0 group-hover:opacity-100">
                    <span className="material-symbols-outlined text-[18px]">shopping_bag</span>
                  </button>
                </div>
                <div>
                  <h3 className="text-base font-medium text-textMain">{item.name}</h3>
                  <p className="text-sm text-textMuted">{item.price}</p>
                </div>
              </div>
            ))}
          </div>
        </div>
      </main>
    </div>
  );
};

export default ProductDetail;