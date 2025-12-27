import React, { useState, useEffect } from 'react';
import { Link, useLocation } from 'react-router-dom';

const Navbar: React.FC = () => {
  const location = useLocation();
  const isHome = location.pathname === '/';
  const [isScrolled, setIsScrolled] = useState(false);
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);

  useEffect(() => {
    const handleScroll = () => {
      setIsScrolled(window.scrollY > 50);
    };
    window.addEventListener('scroll', handleScroll);
    return () => window.removeEventListener('scroll', handleScroll);
  }, []);

  // Determine navbar styling based on page and scroll state
  const navClasses = `fixed top-0 w-full z-50 transition-all duration-300 ${
    isHome && !isScrolled
      ? 'bg-transparent text-white border-transparent'
      : 'bg-white/95 backdrop-blur-md text-textMain border-b border-gray-100 shadow-sm'
  }`;

  const linkClasses = `text-sm font-medium transition-colors hover:text-brandBlue ${
    isHome && !isScrolled ? 'text-white hover:text-gray-200' : 'text-textMain'
  }`;

  const logoClasses = `font-serif text-3xl font-bold tracking-tight ${
    isHome && !isScrolled ? 'text-white' : 'text-textMain'
  }`;

  const iconClasses = `material-symbols-outlined text-[24px] cursor-pointer ${
     isHome && !isScrolled ? 'text-white' : 'text-textMain'
  }`;

  return (
    <header className={navClasses}>
      <div className={`absolute inset-0 bg-gradient-to-b from-black/50 to-transparent pointer-events-none transition-opacity duration-300 ${isHome && !isScrolled ? 'opacity-100' : 'opacity-0'}`}></div>
      
      <div className="container mx-auto px-6 py-4 flex justify-between items-center relative z-10 h-16 md:h-20">
        <div className="flex items-center gap-4">
          <button className="lg:hidden" onClick={() => setMobileMenuOpen(!mobileMenuOpen)}>
            <span className={iconClasses}>menu</span>
          </button>
          <Link to="/" className="flex items-center gap-2 group">
            <h1 className={logoClasses}>Maneé</h1>
          </Link>
          
          <nav className="hidden lg:flex items-center gap-8 ml-8">
            <Link to="/product" className={linkClasses}>Shop</Link>
            <Link to="/product" className={linkClasses}>New Arrivals</Link>
            <Link to="/product" className={`${linkClasses} ${isHome && !isScrolled ? 'text-white' : 'text-red-600 hover:text-red-700'}`}>Sale</Link>
            <Link to="/" className={linkClasses}>About Maneé</Link>
          </nav>
        </div>

        <div className="flex items-center gap-4 md:gap-6">
          <div className={`hidden md:flex items-center rounded-full px-4 py-1.5 transition-all ${isHome && !isScrolled ? 'bg-white/20 border border-white/30' : 'bg-gray-100'}`}>
            <span className={`material-symbols-outlined text-[20px] ${isHome && !isScrolled ? 'text-white/80' : 'text-gray-500'}`}>search</span>
            <input 
              type="text" 
              placeholder="Find products..." 
              className={`bg-transparent border-none outline-none text-sm w-32 ml-2 focus:ring-0 p-0 placeholder-current ${isHome && !isScrolled ? 'text-white placeholder-white/70' : 'text-textMain placeholder-gray-400'}`}
            />
          </div>

          <button className="hidden md:block">
            <span className={iconClasses}>search</span>
          </button>
          
          <Link to="/" className="hidden md:block hover:opacity-80">
            <span className={linkClasses}>Login</span>
          </Link>

          <Link to="/cart" className="relative flex items-center justify-center hover:opacity-80">
            <span className={iconClasses}>shopping_bag</span>
            <span className={`absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full text-[10px] font-bold ${isHome && !isScrolled ? 'bg-white text-black' : 'bg-brandBlue text-black'}`}>2</span>
          </Link>
        </div>
      </div>

      {/* Mobile Menu */}
      {mobileMenuOpen && (
        <div className="lg:hidden absolute top-full left-0 w-full bg-white border-b border-gray-100 shadow-lg py-4 px-6 flex flex-col gap-4 text-textMain z-50">
           <Link to="/product" onClick={() => setMobileMenuOpen(false)}>Shop</Link>
           <Link to="/product" onClick={() => setMobileMenuOpen(false)}>New Arrivals</Link>
           <Link to="/product" onClick={() => setMobileMenuOpen(false)} className="text-red-600">Sale</Link>
           <Link to="/" onClick={() => setMobileMenuOpen(false)}>About Maneé</Link>
        </div>
      )}
    </header>
  );
};

export default Navbar;