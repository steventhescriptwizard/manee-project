import React from 'react';
import { StatCardProps } from '../types';
import { Icon } from './Icon';

const StatsCard: React.FC<StatCardProps> = ({ 
    title, 
    value, 
    icon, 
    trend, 
    trendLabel, 
    iconColorClass, 
    iconBgClass, 
    trendPositive 
}) => {
    return (
        <div className="bg-white dark:bg-gray-900 p-5 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm flex flex-col gap-3">
            <div className="flex items-center justify-between">
                <p className="text-slate-500 dark:text-slate-400 text-sm font-medium">{title}</p>
                <span className={`material-symbols-outlined p-1.5 rounded-md text-[20px] ${iconColorClass} ${iconBgClass}`}>
                    {icon}
                </span>
            </div>
            <div>
                <h3 className="text-2xl font-bold text-slate-900 dark:text-white">{value}</h3>
                <div className="flex items-center gap-1 mt-1">
                    <Icon 
                        name={trendPositive ? "trending_up" : (trend === 0 ? "remove" : "trending_down")} 
                        className={`text-[16px] ${trendPositive ? "text-green-600" : (trend === 0 ? "text-slate-400" : "text-red-500")}`} 
                    />
                    <p className={`text-xs font-semibold ${trendPositive ? "text-green-600" : (trend === 0 ? "text-slate-500" : "text-red-500")}`}>
                        {trend > 0 ? "+" : ""}{trend}%
                    </p>
                    <p className="text-slate-400 text-xs ml-1">{trendLabel}</p>
                </div>
            </div>
        </div>
    );
};

export default StatsCard;