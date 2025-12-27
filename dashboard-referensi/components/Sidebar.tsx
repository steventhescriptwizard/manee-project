import React from 'react';
import { Icon } from './Icon';

interface SidebarProps {
    className?: string;
    onClose?: () => void;
}

const Sidebar: React.FC<SidebarProps> = ({ className = "", onClose }) => {
    const navItems = [
        { icon: 'dashboard', label: 'Dashboard', active: true },
        { icon: 'shopping_bag', label: 'Orders', active: false },
        { icon: 'checkroom', label: 'Products', active: false },
        { icon: 'group', label: 'Customers', active: false },
        { icon: 'inventory_2', label: 'Inventory', active: false },
        { icon: 'campaign', label: 'Marketing', active: false },
        { icon: 'settings', label: 'Settings', active: false },
    ];

    return (
        <aside className={`w-64 bg-white dark:bg-gray-900 border-r border-slate-200 dark:border-gray-800 flex flex-col flex-shrink-0 z-20 transition-all duration-300 ${className}`}>
            <div className="p-6 border-b border-slate-100 dark:border-gray-800 flex items-center justify-between gap-3">
                <div className="flex items-center gap-3">
                    <div 
                        className="bg-center bg-no-repeat bg-cover rounded-full size-10 shadow-sm"
                        style={{ backgroundImage: 'url("https://lh3.googleusercontent.com/aida-public/AB6AXuBAQcBMqo23YoDYtJJDBxr9-_w9wgv-CrmlyJA9pRfFlwvSKvNE8ce424fWz2umL7byiYjmLvctF-xa1c1o-aXmu76WMZHdR5gr3FI2-gz1c2F-hJrHT_UXNLIV0LnqDnHg6F74xWFBxuqWkwr8qd-Qi781OlBdx2V1SGMq5AK7xMPZzbXWK6MvEHtzJNUwT-u-m9T-BPwmTiPqIHJ99hKKADiWDhnAtmTOg1dQUgOmya34wVeI1YguGM0sZTtfEUpS3p3A_xW9qHw")' }}
                    ></div>
                    <div className="flex flex-col">
                        <h1 className="text-slate-900 dark:text-white text-lg font-bold leading-none tracking-tight">Maneé Admin</h1>
                        <p className="text-slate-500 dark:text-slate-400 text-xs font-normal mt-1">Store Manager</p>
                    </div>
                </div>
                {onClose && (
                    <button onClick={onClose} className="md:hidden text-slate-400 hover:text-slate-600">
                        <Icon name="close" />
                    </button>
                )}
            </div>

            <nav className="flex-1 overflow-y-auto py-4 px-3 space-y-1">
                {navItems.map((item) => (
                    <a
                        key={item.label}
                        href="#"
                        className={`flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors group ${
                            item.active 
                            ? 'bg-primary/10 text-primary' 
                            : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-gray-800 hover:text-slate-900 dark:hover:text-white'
                        }`}
                    >
                        <Icon 
                            name={item.icon} 
                            className={`text-[22px] ${!item.active && 'group-hover:text-primary transition-colors'}`} 
                            filled={item.active} 
                        />
                        <span className={`text-sm ${item.active ? 'font-semibold' : 'font-medium'}`}>
                            {item.label}
                        </span>
                    </a>
                ))}
            </nav>

            <div className="p-4 border-t border-slate-200 dark:border-gray-800">
                <div className="bg-primary/5 rounded-lg p-4 flex flex-col gap-2">
                    <div className="flex items-center justify-between">
                        <span className="text-xs font-semibold text-primary uppercase">Pro Plan</span>
                        <Icon name="verified" className="text-primary text-sm" />
                    </div>
                    <div className="w-full bg-slate-200 dark:bg-gray-700 h-1.5 rounded-full overflow-hidden">
                        <div className="bg-primary w-3/4 h-full rounded-full"></div>
                    </div>
                    <p className="text-[10px] text-slate-500 dark:text-slate-400">850/1000 orders this month</p>
                </div>
            </div>
        </aside>
    );
};

export default Sidebar;