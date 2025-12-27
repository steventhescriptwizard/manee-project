import React from 'react';
import { Link } from 'react-router-dom';

const Home: React.FC = () => {
  return (
    <div className="w-full">
      {/* Hero Section */}
      <section className="relative h-screen w-full overflow-hidden">
        <div className="absolute inset-0">
          <img 
            src="https://lh3.googleusercontent.com/aida-public/AB6AXuCbsxAlEW3MhJQg1YK49Nau0qc_Nn0EOHwwnyuDNJeNpWbulFCuGIGT-XPkaHJueFIpL70tMgiEJtseI3IOqa6rrUUdw7cpQtFI0RzfWzWPApM6IQWWgEZ7h6z8eFxmCoh_kmmJMLhFWUDc4h8BXML1zj__No8A0FQGp0o1Wf9DV-uEAUTsaoDrLQLuEdRE5lm5635Hl0Iz_gOTPr2kcVEmSXAY6sCkj7qH3D1pmfP8hCVOdRVcH-H1bY8zkfos0wM_KtxsH60lAEs" 
            alt="Fashion model" 
            className="w-full h-full object-cover object-top"
          />
          <div className="absolute inset-0 bg-gradient-to-r from-black/60 via-black/20 to-transparent"></div>
          {/* Decorative blur */}
          <div className="absolute top-0 right-0 w-[80vh] h-[80vh] rounded-full bg-[#791F1F] mix-blend-multiply opacity-80 blur-3xl transform translate-x-1/4 -translate-y-1/4 pointer-events-none hidden lg:block"></div>
        </div>
        
        <div className="relative container mx-auto px-6 h-full flex flex-col justify-center text-white z-10">
          <div className="max-w-xl mt-16 md:mt-0 md:ml-12">
            <h1 className="text-5xl md:text-6xl lg:text-7xl font-serif italic font-light leading-tight mb-6">
              Headline Here and<br/>Can Go Over Two Lines
            </h1>
            <p className="text-lg md:text-xl font-sans font-light mb-10 max-w-md opacity-90">
              Subheadline goes here and can<br/>go over two lines
            </p>
            <Link to="/product" className="inline-block border border-white px-8 py-3 text-sm tracking-widest uppercase hover:bg-white hover:text-black transition-colors duration-300">
              CTA Here
            </Link>
          </div>
        </div>

        {/* Hero Controls */}
        <button className="absolute left-4 top-1/2 -translate-y-1/2 text-white/70 hover:text-white transition-colors p-2 z-20">
          <span className="material-icons-outlined text-4xl">arrow_back_ios</span>
        </button>
        <button className="absolute right-4 top-1/2 -translate-y-1/2 text-white/70 hover:text-white transition-colors p-2 z-20">
          <span className="material-icons-outlined text-4xl">arrow_forward_ios</span>
        </button>
        <div className="absolute bottom-10 left-1/2 -translate-x-1/2 flex gap-3 z-20">
          <button className="w-3 h-3 rounded-full bg-white"></button>
          <button className="w-3 h-3 rounded-full border border-white hover:bg-white/50"></button>
          <button className="w-3 h-3 rounded-full border border-white hover:bg-white/50"></button>
        </div>
      </section>

      {/* Categories */}
      <section className="py-20 bg-brandCream">
        <div className="container mx-auto px-6">
          <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
            {[
              { title: 'Knitwear', img: 'https://lh3.googleusercontent.com/aida-public/AB6AXuAVRfgLlzrP9fqQnHE63e7vNZtFNvAE96nYSvPhfNND4DoLCKlgRqRcHJDPCsh-q42shU3a9vlc0zSa2VXwjHrfFRb6gRbkBB4oZADjPf6NOUhqOxpPZesx1PtvXjuQim5IubGfqmjr5FIWllzARiesbLf-cJ9NKMW9Bgdzpu1r23XktS7nr7r0AspxdfTrXw_v_ZQvNXkLc8RG_M-oIllmDUE9wlYGed31nBLQEDK0iPzvmnSiM0NrRxM_y5yiXXeSyd07T1egSt8' },
              { title: 'Tops', img: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCpfADCJ5zg2A3a7ant5mpWgdBathPlkV_hlcpJsvuvG82THvxdHA9zd5KXqAbvNOxtU20gVVtlk4nHNxnIer8ehcG4PbdFbW9uyoU5W2iV8cRXqgGrgTntccmB7FIk4qnekkJqqRHDtDLliGc0-Sc1waYNTkNzjAV2xe5HzG48CCvFqH14Ncy9yyGMavwLaEykkZhDLEMVhfIXN5FH5715A2VZdU5TP4UnbFYewKZudZ0Ib1WfQOBTDK-HwSd_8po5EasJuympVwI' },
              { title: 'Bottoms', img: 'https://lh3.googleusercontent.com/aida-public/AB6AXuA4bT9Hve-EzPaklYD_KgUHdNeqsgmLYh1BWwdFg18IAxH6jwKtfSzNA8RPJslKQ--Kn7EutwfhXOjiOqhgo75EUo9sl8TmC1pM-gVo6dgsFSOudstO6eyXZwDNzvMzQOH9ahZ_mBVogK3P5LoUWAv-YbEyzZMu0Afgi5CFk-pV1odIcdTbRDIQmuYuq8Ux7v0QT6UfytUHr_N7snKsygJQsz1-xsh6O5_SunrZLhBhx3ZveBZ9PaV04CCWBHeQY70WgyL-AXAYwus' }
            ].map((cat, idx) => (
              <Link to="/product" key={idx} className="group relative h-[250px] overflow-hidden rounded-lg block">
                <img src={cat.img} alt={cat.title} className="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
                <div className="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-80"></div>
                <div className="absolute bottom-10 left-0 w-full text-center">
                  <span className="text-white text-2xl font-sans font-light border-b border-white/50 pb-1">{cat.title}</span>
                </div>
              </Link>
            ))}
          </div>
        </div>
      </section>

      {/* Product Slider Section */}
      <section className="py-16 bg-[#FDFBF7]">
        <div className="container mx-auto px-6">
          <div className="flex flex-col md:flex-row justify-between items-end mb-10">
            <h2 className="text-3xl md:text-4xl font-sans font-medium text-textMain">Shop Categories</h2>
            <div className="flex gap-8 mt-6 md:mt-0">
              <button className="text-textMain font-sans text-lg border-b border-current pb-1">Best Sellers</button>
              <button className="text-gray-500 font-sans text-lg hover:text-textMain border-b border-transparent hover:border-current pb-1 transition-all">New Arrivals</button>
              <button className="text-gray-500 font-sans text-lg hover:text-textMain border-b border-transparent hover:border-current pb-1 transition-all">Sale</button>
            </div>
          </div>
          
          <div className="relative group">
            <div className="flex gap-6 overflow-x-auto hide-scrollbar pb-8 scroll-smooth" id="product-slider">
              {[
                 { title: 'Grey Mock Neck', price: 'Rp. 450.000', img: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCoiDlm_pHQFnDjFgWtlN2U84WZqfXqpExXAyv1AQGg9aUol-rX8pqe7XwrlG3KdTgH95lLUKJL8CkNoWlEo_QeRaXFyElIz0bbIVXNGs_zCmBZTtEiNVilWQbDZ5qBfVyWyMkWinv1LbQMDK28y6-vYvrP8eKBsrdUZPGsA7ztvnia8YXQyz4O-gYvCPzIzqjxceWrASG3T3bb1ZkDiCsPrO6GQ8jXAT75SHQEa-_rnEfmmC6HHKqIETyYu9srXMJyAkUOPT2tI7Q' },
                 { title: 'Cream Cardigan', price: 'Rp. 429.000', img: 'https://lh3.googleusercontent.com/aida-public/AB6AXuA1IDsUt5sfwleYPxZC0tG_ROX7G61rI375s2ZaAV6sojanXZmmMoDb7r1ladVxCFjBr2NIV4bLio_V3sYPipS5uksm115D0pHDytc1sYrWVBHQL5lBPHI27LI8Ho79JeizbKaLt2Mv8Rc89vHLYRaySaefw6ypLeEdmsxe_V_LakgCRfjbzHzF_49JR4WAZJ4Ghqc4S1vYPJqT0jf0R-GJ1tFY0IC7At4n2d7Fw5cocXfa1qcYERU_mQgWaIYf1sRJXLDRz4W2Ezs' },
                 { title: 'Blue Sweater', price: 'Rp. 399.000', img: 'https://lh3.googleusercontent.com/aida-public/AB6AXuARQ-VQNpDEHKIWyhAvZ3xyQVv-1ggv9urICK4OptOQP1Qgrn6VbhmSVzbgSNKmGjM9Lmo5DVHwXQkQhqUoio7gPg8g-gQOi8VhKlCqYeVreD6BE2p5BJxNg75JkGlvQHUW9qsmPBNscCgRelWRqMFOpCjZbXlY2N9bhLGthGn0KH8M1Tt92wr-DNN2PR2uCoaXX1GYFVwFnpVeIW-9vx6w0aS384HoC2dlCdYkYA-6Ic5wtSsvclZWjGXjacD8zgSdp7SOHdb6K0U' },
                 { title: 'Long Skirt', price: 'Rp. 349.000', img: 'https://lh3.googleusercontent.com/aida-public/AB6AXuBdJo1m8zYnhcp9Rx_VkC2TjgvRFBATk__NhY3jYNitl37Y9tTpRKyFJMmbdo8B3uYAojImNzqKkpnA9Ntm6rUy0f_G5EZjOMgS2VZINkiwetkmc3rYE4Leo_pyZwQ-4capHoQdblvaqmTz278Ooxk_MVg06-WJepti6FWBpy45PnybjzRtMew7fOj3vyGm1fygvuhbbCENtMS70PIrTMBD6zC7GRbK8FXrSjuA2EociXvrt3DBMvcHYpZ1Rmf2z_qfjfPZrKoGY50' },
                 { title: 'Linen Shirt', price: 'Rp. 349.000', img: 'https://lh3.googleusercontent.com/aida-public/AB6AXuDhlZwnI19XMPjD5L70T2DeYMnlyT_5F_BhII1IoU4Bwu4zUex_luuaD7r2KJzRy5SAnf44NIsWrVcCP2Batu_WeHywM8g93bXeLs6h8pcb5YBPwCeeNdfwWrVBSnmlenuqrt2zDSss7s-MfIdK1A5mYPOpF1aCP4PfDbdnPRtATBvKPLv4rnrA672R-JFST_XR8gf2n7xC0bV5WdLQBJrZU-M1bhFPUolEssRuU0GKpoXIWXYzmKXIXJM6-LE-QubX0xMmYdlTOmE' },
              ].map((prod, idx) => (
                <Link to="/product" key={idx} className="min-w-[160px] md:min-w-[200px] bg-white rounded-lg overflow-hidden border border-gray-100 group/card">
                  <div className="relative aspect-[3/4] overflow-hidden bg-gray-100">
                    <img src={prod.img} alt={prod.title} className="w-full h-full object-cover group-hover/card:scale-105 transition-transform duration-500" />
                    <button className="absolute top-3 right-3 text-gray-800 hover:text-brandRed transition-colors">
                      <span className="material-icons-outlined">bookmark_border</span>
                    </button>
                  </div>
                  <div className="p-3 md:p-4">
                    <h3 className="font-sans font-medium text-textMain mb-1">{prod.title}</h3>
                    <p className="font-sans text-sm text-gray-500">{prod.price}</p>
                  </div>
                </Link>
              ))}
            </div>
            
            {/* Scroll Buttons */}
            <button 
              className="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-1/2 bg-white shadow-lg rounded-full p-3 hidden md:block hover:bg-gray-50 transition-colors z-10"
              onClick={() => document.getElementById('product-slider')?.scrollBy({left: -220, behavior: 'smooth'})}
            >
              <span className="material-icons-outlined text-gray-800">chevron_left</span>
            </button>
            <button 
              className="absolute right-0 top-1/2 -translate-y-1/2 translate-x-1/2 bg-white shadow-lg rounded-full p-3 hidden md:block hover:bg-gray-50 transition-colors z-10"
              onClick={() => document.getElementById('product-slider')?.scrollBy({left: 220, behavior: 'smooth'})}
            >
              <span className="material-icons-outlined text-gray-800">chevron_right</span>
            </button>
          </div>
        </div>
      </section>

      {/* Promo Section */}
      <section className="relative h-[500px] w-full bg-gray-900 overflow-hidden">
        <img 
          src="https://lh3.googleusercontent.com/aida-public/AB6AXuCHQpNjp7DhmlQfL0YlVDdpRkuAFvfN2JprEFlYTJydhYdz_jcR3gcw03Wfr4i3l5PabQeZ8fEV0jVUdrbXOTDN48vChJyl5FdArV8O9wQ6oY0UCNDHV-IziY1flPZaYscK4KQEU6bO5CgcvA7S_Wj4FsCq4yQ9wyxYFTkqwRu09gYUdG5W1tF97hm3-asFGKjExVxPTqH2pcfS0IadWFBrkkHHDTfG2SsJ4jswIogKBQAQ_aAnWkZxbLdu2AiJZmO1dmrdYE371nQ" 
          alt="Leather bag detail" 
          className="w-full h-full object-cover"
        />
        <div className="absolute inset-0 bg-black/40"></div>
        <div className="absolute inset-0 flex items-center">
          <div className="container mx-auto px-6">
            <div className="max-w-lg text-white md:ml-12">
              <h2 className="text-5xl font-serif italic font-light mb-4">Receive 10% Off</h2>
              <p className="text-lg font-sans font-light mb-8 text-white/90">
                Enjoy 10% off your first purchase,<br/>
                and other promotional offers<br/>
                by becoming our members.
              </p>
              <button className="inline-block border border-white px-8 py-3 text-sm tracking-widest uppercase hover:bg-white hover:text-black transition-colors duration-300 rounded">
                Register Now
              </button>
            </div>
          </div>
        </div>
      </section>
    </div>
  );
};

export default Home;