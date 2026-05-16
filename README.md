# 🚚 FleetWise — S-Tier Fleet Management System

![FleetWise Banner](https://raw.githubusercontent.com/placeholder-images/dashboard.png)

FleetWise is a comprehensive, enterprise-grade fleet management platform designed for modern logistics and transport operations. It provides a robust suite of tools for managing vehicles, drivers, trips, maintenance, and finances with a focus on data integrity, high-performance reporting, and premium user experience.

## 🚀 Core Features

-   **🚛 Advanced Fleet Tracking**: Manage vehicle lifecycles, technical specs, and insurance compliance.
-   **👤 Driver Management**: Track licenses, assignments, and availability.
-   **🛣️ Intelligent Trip Scheduling**: Log routes, odometer readings, and real-time trip statuses.
-   **🔧 Proactive Maintenance**: Automated alerts for upcoming services (7-day window) and historical logs.
-   **💰 Financial Intelligence**: Detailed fuel and general expense tracking with efficiency analytics (km/L).
-   **📊 Streamed CSV Exports**: High-performance, filter-aware data exporting for all modules.
-   **📜 Audit Trail & Security**: Role-Based Access Control (RBAC) and a centralized Activity Log for every action.
-   **🖨️ Printable Reports**: Clean, sidebar-free layouts for Trip Summaries and Cost Analysis.

## 🛠️ Technology Stack

-   **Backend**: Laravel 11 (PHP 8.2+)
-   **Frontend**: Tailwind CSS, Alpine.js (Livewire-free for speed)
-   **Charts**: Chart.js with animated transitions
-   **Database**: SQLite / MySQL / PostgreSQL support
-   **Icons**: Lucide & Heroicons

## 📦 Setup Instructions

1.  **Clone & Install**:
    ```bash
    git clone https://github.com/your-username/FleetWise.git
    cd FleetWise
    composer install
    npm install && npm run build
    ```

2.  **Environment Setup**:
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

3.  **Database Initialization**:
    ```bash
    # Create database file if using SQLite
    touch database/database.sqlite
    php artisan migrate --seed
    ```

4.  **Run Development Server**:
    ```bash
    php artisan serve
    ```

## 🔑 Demo Credentials

| Role | Email | Password |
| :--- | :--- | :--- |
| **Administrator** | `admin@fleetwise.test` | `password` |
| **Staff User** | `staff@fleetwise.test` | `password` |

---
*Developed with ❤️ as an S-Tier Portfolio Piece.* .
