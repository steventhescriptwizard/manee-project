import React from 'react';
import { TOP_PRODUCTS } from '../constants';

const TopProducts: React.FC = () => {
    return (
        <div className="lg:col-span-1 bg-white dark:bg-gray-900 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm flex flex-col">
            <div className="p-5 border-b border-slate-100 dark:border-gray-800 flex justify-between items-center">
                <h3 className="text-slate-900 dark:text-white text-base font-bold">Top Selling Products</h3>
                <button className="text-primary text-sm font-medium hover:underline">View All</button>
            </div>
            <div className="flex flex-col p-4 gap-4 flex-1 overflow-y-auto max-h-[400px]">
                {TOP_PRODUCTS.map((product) => (
                    <div key={product.id} className="flex items-center gap-4 group cursor-pointer hover:bg-slate-50 dark:hover:bg-gray-800 p-2 rounded-lg transition-colors">
                        <div 
                            className="size-12 rounded-lg bg-cover bg-center flex-shrink-0 border border-slate-100 dark:border-slate-700" 
                            style={{ backgroundImage: `url("${product.image}")` }}
                        ></div>
                        <div className="flex flex-col flex-1 min-w-0">
                            <h4 className="text-sm font-semibold text-slate-900 dark:text-white truncate">{product.name}</h4>
                            <p className="text-xs text-slate-500 truncate">{product.sales} sales</p>
                        </div>
                        <p className="text-sm font-bold text-slate-900 dark:text-white">${product.price}</p>
                    </div>
                ))}
            </div>
        </div>
    );
};

export default TopProducts;