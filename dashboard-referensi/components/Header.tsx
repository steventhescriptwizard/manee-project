import React from 'react';
import { Icon } from './Icon';

interface HeaderProps {
    onMenuClick: () => void;
}

const Header: React.FC<HeaderProps> = ({ onMenuClick }) => {
    return (
        <header className="h-16 bg-white dark:bg-gray-900 border-b border-slate-200 dark:border-gray-800 flex items-center justify-between px-6 z-10 flex-shrink-0">
            <div className="flex items-center gap-4">
                <button 
                    onClick={onMenuClick}
                    className="md:hidden text-slate-500 hover:text-slate-900 dark:hover:text-white"
                >
                    <Icon name="menu" />
                </button>
                <h2 className="text-slate-900 dark:text-white text-lg font-bold leading-tight hidden sm:block">
                    Overview
                </h2>
            </div>
            
            <div className="flex items-center gap-6">
                <div className="hidden md:flex relative w-64 lg:w-80 h-10">
                    <div className="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                        <Icon name="search" className="text-[20px]" />
                    </div>
                    <input 
                        type="text" 
                        className="bg-slate-100 dark:bg-gray-800 border-none text-slate-900 dark:text-white text-sm rounded-lg focus:ring-2 focus:ring-primary focus:bg-white dark:focus:bg-gray-800 block w-full pl-10 p-2.5 placeholder-slate-400 transition-all" 
                        placeholder="Search orders, products..." 
                    />
                </div>
                
                <div className="flex items-center gap-3">
                    <button className="relative p-2 text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-white transition-colors rounded-full hover:bg-slate-100 dark:hover:bg-gray-800">
                        <Icon name="notifications" className="text-[24px]" />
                        <span className="absolute top-2 right-2 size-2 bg-red-500 rounded-full border-2 border-white dark:border-gray-900"></span>
                    </button>
                    
                    <div className="h-8 w-px bg-slate-200 dark:bg-gray-800 mx-1"></div>
                    
                    <button className="flex items-center gap-3 hover:bg-slate-50 dark:hover:bg-gray-800 p-1.5 rounded-full pr-3 transition-colors">
                        <div 
                            className="bg-center bg-no-repeat bg-cover rounded-full size-8 border border-slate-200 dark:border-gray-700" 
                            style={{ backgroundImage: 'url("https://lh3.googleusercontent.com/aida-public/AB6AXuCXx32y85RxitxStW7xnkQsK6r0HyaCF-KW7X809r-CWp02i5ZyJcoWT0IlmoSv8lguJtzNNv8JrCaaFChB-x5FRmZJbHuDtK_UPcG0aWM6o9GLbW_K5Gv2yblkwXxP3RqFJv2CXxCzjTGe3ku7nZtYPYzHl9ULyipNJeBaCCma0L31Y-LFxYXpu1OvUil51ctsvstZzN8tLAlwyf8wugne2ZMzSSbyDmDWMDvrYDs6T8gBBGap2Dry-YLlFwpKIg8Il5dXV6dv-ws")' }}
                        ></div>
                        <span className="text-sm font-medium text-slate-700 dark:text-slate-200 hidden sm:block">Admin</span>
                        <Icon name="expand_more" className="text-slate-400 text-[20px] hidden sm:block" />
                    </button>
                </div>
            </div>
        </header>
    );
};

export default Header;