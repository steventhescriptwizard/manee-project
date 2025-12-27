import React from 'react';
import { ResponsiveContainer, AreaChart, Area, Tooltip, XAxis } from 'recharts';
import { CHART_DATA } from '../constants';

const RevenueChart: React.FC = () => {
    return (
        <div className="lg:col-span-2 bg-white dark:bg-gray-900 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm p-6">
            <div className="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
                <div>
                    <h3 className="text-slate-900 dark:text-white text-base font-bold">Revenue Analytics</h3>
                    <p className="text-slate-500 dark:text-slate-400 text-sm">Overview of revenue for the last 30 days</p>
                </div>
                <select className="form-select bg-slate-50 dark:bg-gray-800 border-none text-slate-700 dark:text-slate-300 text-sm rounded-lg focus:ring-0 cursor-pointer py-2 pr-8 pl-3 font-medium w-full sm:w-auto outline-none">
                    <option>Last 30 Days</option>
                    <option>Last 7 Days</option>
                    <option>This Year</option>
                </select>
            </div>
            
            <div className="flex items-end gap-2 mb-4">
                <p className="text-slate-900 dark:text-white text-3xl font-bold leading-none">$45,230</p>
                <span className="text-green-600 text-sm font-semibold bg-green-50 dark:bg-green-900/20 px-2 py-0.5 rounded mb-1">+8.5%</span>
            </div>

            <div className="w-full h-[240px] mt-4">
                <ResponsiveContainer width="100%" height="100%">
                    <AreaChart data={CHART_DATA}>
                        <defs>
                            <linearGradient id="chartGradient" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="5%" stopColor="#1660e9" stopOpacity={0.15}/>
                                <stop offset="95%" stopColor="#1660e9" stopOpacity={0}/>
                            </linearGradient>
                        </defs>
                        {/* Hiding Axes for cleaner look matching the design, showing only simple ticks if needed */}
                         <XAxis 
                            dataKey="name" 
                            axisLine={false} 
                            tickLine={false} 
                            tick={{ fill: '#94a3b8', fontSize: 12 }} 
                            interval="preserveStartEnd"
                            ticks={['Week 1', 'Week 2', 'Week 3', 'Week 4']}
                        />
                        <Tooltip 
                            contentStyle={{ 
                                backgroundColor: '#fff', 
                                border: '1px solid #e2e8f0', 
                                borderRadius: '8px',
                                boxShadow: '0 4px 6px -1px rgb(0 0 0 / 0.1)' 
                            }}
                            itemStyle={{ color: '#1660e9', fontWeight: 600 }}
                            cursor={{ stroke: '#94a3b8', strokeWidth: 1, strokeDasharray: '4 4' }}
                        />
                        <Area 
                            type="monotone" 
                            dataKey="value" 
                            stroke="#1660e9" 
                            strokeWidth={3} 
                            fillOpacity={1} 
                            fill="url(#chartGradient)" 
                        />
                    </AreaChart>
                </ResponsiveContainer>
            </div>
        </div>
    );
};

export default RevenueChart;