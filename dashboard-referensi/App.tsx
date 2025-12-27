import React, { useState } from 'react';
import Sidebar from './components/Sidebar';
import Header from './components/Header';
import StatsCard from './components/StatsCard';
import RevenueChart from './components/RevenueChart';
import TopProducts from './components/TopProducts';
import RecentOrders from './components/RecentOrders';
import { STATS_DATA } from './constants';

const App: React.FC = () => {
    const [isSidebarOpen, setIsSidebarOpen] = useState(false);

    return (
        <div className="flex h-screen w-full font-display">
            {/* Desktop Sidebar */}
            <Sidebar className="hidden md:flex" />

            {/* Mobile Sidebar Overlay */}
            {isSidebarOpen && (
                <div 
                    className="fixed inset-0 z-40 bg-gray-900/50 backdrop-blur-sm md:hidden"
                    onClick={() => setIsSidebarOpen(false)}
                >
                    <div 
                        className="fixed inset-y-0 left-0 w-64 bg-white dark:bg-gray-900 shadow-xl"
                        onClick={e => e.stopPropagation()}
                    >
                        <Sidebar onClose={() => setIsSidebarOpen(false)} className="h-full border-r-0" />
                    </div>
                </div>
            )}

            {/* Main Content */}
            <main className="flex-1 flex flex-col h-full overflow-hidden bg-background-light dark:bg-background-dark relative">
                <Header onMenuClick={() => setIsSidebarOpen(true)} />

                <div className="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8 scroll-smooth">
                    <div className="max-w-[1400px] mx-auto flex flex-col gap-6">
                        {/* Stats Section */}
                        <section className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            {STATS_DATA.map((stat, index) => (
                                <StatsCard key={index} {...stat} />
                            ))}
                        </section>

                        {/* Charts & Best Sellers */}
                        <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <RevenueChart />
                            <TopProducts />
                        </div>

                        {/* Recent Orders Table */}
                        <RecentOrders />
                    </div>
                </div>
            </main>
        </div>
    );
};

export default App;