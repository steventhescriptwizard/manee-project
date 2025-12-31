# Maneé - Premium Fashion E-Commerce

Maneé is a modern, high-end e-commerce platform built with Laravel, designed for premium fashion brands. It features a sleek, minimalist aesthetic combined with powerful administrative tools and a seamless customer experience.

## ✨ Key Features

### 🛍️ Customer Experience
- **Immersive Product Gallery**: High-performance image slider with auto-advance, smooth transitions, and synchronized thumbnail navigation.
- **Dynamic Variant Switching**: Real-time image and data updates when selecting different product colors/sizes.
- **Advanced Shop Filtering**: Instant product filtering by category, price range, and dynamic colors pulled directly from inventory.
- **Premium Mobile UI**: Full-screen responsive side-drawer menu with backdrop blur and optimized mobile interactions.
- **Custom Authentication**: Secure and uniquely routed login and registration pages.

### 🛡️ Admin Dashboard
- **Insights & Analytics**: Real-time sales stats, revenue charts, and inventory tracking.
- **Comprehensive Product Management**: Effortless management of products, gallery images, and complex variants.
- **Safety Mechanics**: "Unsaved Changes" protection to prevent accidental data loss during record editing.
- **Optimized Navigation**: Dynamic breadcrumb system for lightning-fast movement across the dashboard.

## 🚀 Tech Stack
- **Framework**: [Laravel 11](https://laravel.com)
- **Frontend Interactivity**: [Alpine.js](https://alpinejs.dev)
- **Styling**: [Tailwind CSS](https://tailwindcss.com)
- **Icons**: [Material Symbols](https://fonts.google.com/icons)
- **Notifications**: [SweetAlert2](https://sweetalert2.github.io)

## 🛠️ Installation & Setup

1. **Clone the repository**
   ```bash
   git clone [repository-url]
   cd manee-project
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Configure Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database & Storage**
   ```bash
   php artisan migrate --seed
   php artisan storage:link
   ```

5. **Run the application**
   ```bash
   # Terminal 1
   php artisan serve
   
   # Terminal 2
   npm run dev
   ```

---

## 👨‍💻 Author
**Steven Morison**  
- ✉️ [stevencodelab@gmail.com](mailto:stevencodelab@gmail.com)  
- ✉️ [steventhescriptwizard@gmail.com](mailto:steventhescriptwizard@gmail.com)

---
*Created with passion for Advanced Agentic Coding.*
