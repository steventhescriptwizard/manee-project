export interface Product {
    id: string;
    name: string;
    sales: number;
    price: number;
    image: string;
}

export interface Order {
    id: string;
    customer: {
        name: string;
        avatar: string;
    };
    productName: string;
    date: string;
    amount: number;
    status: 'Completed' | 'Pending' | 'Shipped' | 'Processing';
}

export interface StatCardProps {
    title: string;
    value: string;
    icon: string;
    trend: number;
    trendLabel: string;
    iconColorClass: string;
    iconBgClass: string;
    trendPositive: boolean;
}