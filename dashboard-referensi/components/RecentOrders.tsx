import React from 'react';
import { RECENT_ORDERS } from '../constants';
import { Icon } from './Icon';

const StatusBadge: React.FC<{ status: string }> = ({ status }) => {
    let colorClass = "";
    let dotClass = "";
    
    switch(status) {
        case 'Completed':
            colorClass = "bg-green-50 text-green-700 dark:bg-green-900/30 dark:text-green-400";
            dotClass = "bg-green-500";
            break;
        case 'Pending':
            colorClass = "bg-yellow-50 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400";
            dotClass = "bg-yellow-500";
            break;
        case 'Shipped':
            colorClass = "bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400";
            dotClass = "bg-blue-500";
            break;
        default:
            colorClass = "bg-slate-50 text-slate-700 dark:bg-slate-800 dark:text-slate-400";
            dotClass = "bg-slate-500";
    }

    return (
        <span className={`inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium ${colorClass}`}>
            <span className={`size-1.5 rounded-full ${dotClass}`}></span>
            {status}
        </span>
    );
};

const RecentOrders: React.FC = () => {
    return (
        <div className="bg-white dark:bg-gray-900 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm overflow-hidden">
            <div className="p-5 border-b border-slate-100 dark:border-gray-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <h3 className="text-slate-900 dark:text-white text-lg font-bold">Recent Orders</h3>
                <div className="flex gap-2">
                    <button className="flex items-center gap-2 px-3 py-2 bg-slate-50 dark:bg-gray-800 text-slate-600 dark:text-slate-300 rounded-lg text-sm font-medium hover:bg-slate-100 dark:hover:bg-gray-700 transition-colors">
                        <Icon name="filter_list" className="text-[18px]" />
                        Filter
                    </button>
                    <button className="flex items-center gap-2 px-3 py-2 bg-slate-50 dark:bg-gray-800 text-slate-600 dark:text-slate-300 rounded-lg text-sm font-medium hover:bg-slate-100 dark:hover:bg-gray-700 transition-colors">
                        <Icon name="download" className="text-[18px]" />
                        Export
                    </button>
                </div>
            </div>
            <div className="overflow-x-auto">
                <table className="w-full text-left border-collapse">
                    <thead>
                        <tr className="bg-slate-50/50 dark:bg-gray-800/50 border-b border-slate-200 dark:border-gray-800 text-xs uppercase text-slate-500 font-semibold tracking-wider">
                            <th className="px-6 py-4">Order ID</th>
                            <th className="px-6 py-4">Customer</th>
                            <th className="px-6 py-4">Product</th>
                            <th className="px-6 py-4">Date</th>
                            <th className="px-6 py-4">Amount</th>
                            <th className="px-6 py-4">Status</th>
                            <th className="px-6 py-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody className="divide-y divide-slate-100 dark:divide-gray-800">
                        {RECENT_ORDERS.map((order) => (
                            <tr key={order.id} className="hover:bg-slate-50 dark:hover:bg-gray-800/50 transition-colors">
                                <td className="px-6 py-4 text-sm font-medium text-primary cursor-pointer hover:underline">{order.id}</td>
                                <td className="px-6 py-4 text-sm text-slate-700 dark:text-slate-300">
                                    <div className="flex items-center gap-3">
                                        <div 
                                            className="size-8 rounded-full bg-slate-200 bg-cover" 
                                            style={{ backgroundImage: `url("${order.customer.avatar}")` }}
                                        ></div>
                                        <span>{order.customer.name}</span>
                                    </div>
                                </td>
                                <td className="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">{order.productName}</td>
                                <td className="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">{order.date}</td>
                                <td className="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">${order.amount.toFixed(2)}</td>
                                <td className="px-6 py-4">
                                    <StatusBadge status={order.status} />
                                </td>
                                <td className="px-6 py-4 text-right">
                                    <button className="text-slate-400 hover:text-slate-600 dark:hover:text-white">
                                        <Icon name="more_vert" className="text-[20px]" />
                                    </button>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </div>
    );
};

export default RecentOrders;