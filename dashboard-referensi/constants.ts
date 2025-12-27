import { Order, Product, StatCardProps } from './types';

export const TOP_PRODUCTS: Product[] = [
    {
        id: '1',
        name: 'Silk Summer Dress',
        sales: 124,
        price: 120,
        image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuBPQviqAjm7rHpvhXf2pwJF2hRPwYBQxiwD8l5l-pl3JiMQytU_GpwyOFRG7m5ZlXDnrXOhD_975gtHh2kbZNMIFSfwomWfl7xUWwOfDHi45xpLfZ1THR8V_yTeUMhjj8J1kPAFXbv5MJ5IzOc-UZ-ydUBtbJrQhVlPSg6VZB23Z7-73QEDY8cOknfAmDWVlYrBG0Em0u-5qZpTZ9OliscvovVQsCCR7gbiW68Wy2i_NuRovn_2KeSdPxf0iru-gTVomobipsIz8Fc'
    },
    {
        id: '2',
        name: 'Classic Denim Jacket',
        sales: 89,
        price: 85,
        image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuAuXShKxMoCsX1-lYzC5_brpfV1AoeyJMtF4K_xQjAForu8Gck0BZ86liOH09YEppjgPvl5WpoiMHSnXmAWaUPSp6qf30qccF5sT1vFWPXNbXwktV1OKkjOqIDZqn8JEBmLqCvrzmQPeZaMnNnqUb4yqbqUIJSZ17OqUHcvh1xHy6HDeZLMnn6T4Xt9agsnfwz9FlQXQDSknnGu4mFQULWi9JijASscMag5r65dGd86il9V_tp2WZw1ke8_WDexW0Rgz9cceCcY6_I'
    },
    {
        id: '3',
        name: 'White Cotton Blouse',
        sales: 65,
        price: 55,
        image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCRaRw1oGlIR8LgWCf6t0H2dHUhfVgxr6Ij1Nawtja2RsVtF3hnM2K0LmFQMO1tBhvW0dyhO7Ivm7o-AjNYgPCADNE6k6ny0bbAusZ1Ypiq165EQUlKIUvRl0F_lIMDxqCk33IN-CW-Q8yD98nhhj1oLq-4eS-Sj66xAYQRBOLCDN1QpSHrlIWKr6T5YcAIcXDHN3v64wPkl-OFKm2n33gAINER9RyPdzcEeMSLqOrutAOY99PdMz0poU5RvvctfOFLVDYliKu9mUg'
    },
    {
        id: '4',
        name: 'High Waist Trousers',
        sales: 42,
        price: 90,
        image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuArEKmC5T1c6xw5fWHELwh4hFTIysUQKjckgqSjNHzgEQepkYZMa6winh6gEdOrgYiCiUeHVg-biJmIfNR4tzIoygRPDECmSnhXBghvJDTnY10su5oy3DKFh_Fzmi3kaVmb3sNzTncfj3pEZ3v7Tdx2JIOgoJRFP8QaeEvDTRcUTw-4SiR8C95n0L_Kgy80Lr1h2Dig_mvq-OCd6EGt0ZEza3iRDpGVQMlJC6LjONduJL15ZFtCat9Scee0n_JHZQZ94DufWt7yzrU'
    }
];

export const RECENT_ORDERS: Order[] = [
    {
        id: '#1023',
        customer: {
            name: 'Sarah Johnson',
            avatar: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCPMjk1g28RySO4tJTdKPui-GBQgiEHLQwv_YuZhFSKSOCj94N5qjq4j6Hpt67aMXk2g0OUojhNTRIk1JLJ0wO_8PSOxoxzi7GVYKIM7PnR2CF43YeSKLrvrw4IabnmISm83eh4DTG9AfUCFBBO9IjjkzHu57_ToUjG0JWcPFu-3v7T52DhOCRUJQgrZPjmiaOxuTczwbMJJRwvs2c7cn3Ej1QUy0Vo6KS2Grf5dMtDUkNOlaXoNqzkEDc2fFFX8oJt1Hgrf4EyAuA'
        },
        productName: 'Silk Summer Dress',
        date: 'Oct 24, 2023',
        amount: 120.00,
        status: 'Completed'
    },
    {
        id: '#1024',
        customer: {
            name: 'Mike Thompson',
            avatar: 'https://lh3.googleusercontent.com/aida-public/AB6AXuABItL87A5iE5QlPZacpThkGl2nw-nL73ezIY7GMMnLJqbu2qfOh2ivvdsLiguLrVVrj-0XxWsnVo72Z_8VpkvoIGs4f01WpdEsVNvYZWYCgewQpt4DwMiP55Nz356Gi_3wt0e5Dl1r3KwWM2WwCC_w5PUgHDOiJFePeUJKZrp-1DjHYNNDxnok-qOu8JxJjf0auhmFeGE1VtEXfypEpCsMKD_gbIFjlkPEzqIKuHWCsDAVFIkRiagJKsBFx7uqJsz3EmCNLh-otd8'
        },
        productName: 'Denim Jacket',
        date: 'Oct 24, 2023',
        amount: 85.00,
        status: 'Pending'
    },
    {
        id: '#1025',
        customer: {
            name: 'Emily Chen',
            avatar: 'https://lh3.googleusercontent.com/aida-public/AB6AXuC3B4apRlWfwQMQhjf-pfkLSPg9BSmbPrjdNyfCsKRoBHPwJUzsqztmIUKzODDWZg1YRusYPYO27cqGRH7Q4vP5EKejLZOwK_8dUsUzKRkaCmesgMirogxYbhjecw0j3hUlJm0gHXHGlgke7Cp0iIm-1Maktl3BRNve33mWnS-EBlhKQSJNQ8ZxuHr1RwNy58WqXDBvLtZeG9iK-l0Y1YY0SrOE7gX4egpR3AeWSjfOJFSc54MRAk06oudrTHoO_VjSFzaTeEvh_mg'
        },
        productName: 'High Waist Trousers',
        date: 'Oct 23, 2023',
        amount: 90.00,
        status: 'Shipped'
    },
    {
        id: '#1026',
        customer: {
            name: 'Jessica Davis',
            avatar: 'https://lh3.googleusercontent.com/aida-public/AB6AXuA6oiz6Kdl_r1q1b8G2xWjTjVfn8DU0yJnDn5gKWbvVU_7l1-2pPOmAlqb1mTp_wugzE7UhV1ATIZxjIv6vGmGAeu8pBhxcAoINVYCw0DWQGbYwP_bCM5ioelD3NY1WL6SOw6lG0JNg9bxbN1sGN6WkgIFhFZI220NPo2oT8VA3n_NJpKHn3dOMCxZfSnzSIGINXDW1jMx5lz2e15AETweWHeYmaVAw1y7Zffi0_dIsrFkR_KqNKhM4r9mjyekjk_E7TE3XNy2T3iI'
        },
        productName: 'White Cotton Blouse',
        date: 'Oct 23, 2023',
        amount: 55.00,
        status: 'Completed'
    }
];

export const STATS_DATA: StatCardProps[] = [
    {
        title: 'Total Revenue',
        value: '$12,450',
        icon: 'payments',
        trend: 12,
        trendLabel: 'vs last week',
        iconColorClass: 'text-primary',
        iconBgClass: 'bg-primary/10',
        trendPositive: true
    },
    {
        title: 'New Orders',
        value: '45',
        icon: 'shopping_cart',
        trend: 5,
        trendLabel: 'vs last week',
        iconColorClass: 'text-purple-600',
        iconBgClass: 'bg-purple-100 dark:bg-purple-900/30',
        trendPositive: true
    },
    {
        title: 'Pending Shipments',
        value: '12',
        icon: 'local_shipping',
        trend: 2,
        trendLabel: 'vs last week',
        iconColorClass: 'text-orange-600',
        iconBgClass: 'bg-orange-100 dark:bg-orange-900/30',
        trendPositive: false
    },
    {
        title: 'Low Stock Items',
        value: '5',
        icon: 'warning',
        trend: 0,
        trendLabel: 'vs last week',
        iconColorClass: 'text-red-600',
        iconBgClass: 'bg-red-100 dark:bg-red-900/30',
        trendPositive: false // Interpreting 0 as neutral/negative context for stocks
    }
];

// Recharts data to mimic the wave
export const CHART_DATA = [
  { name: 'Week 1', value: 30 },
  { name: '1.2', value: 50 },
  { name: '1.4', value: 45 },
  { name: '1.6', value: 42 },
  { name: 'Week 2', value: 60 },
  { name: '2.2', value: 35 },
  { name: '2.4', value: 48 },
  { name: '2.6', value: 52 },
  { name: 'Week 3', value: 25 },
  { name: '3.2', value: 20 },
  { name: '3.4', value: 70 },
  { name: '3.6', value: 45 },
  { name: 'Week 4', value: 80 },
];
