# 🏪 Sari-Sari Store Web Inventory Management System

A simple, efficient, and user-friendly web application designed to help Filipino Sari-Sari store owners manage their inventory, track categories, and monitor stock levels in real-time.

![Laravel](https://img.shields.io/badge/Laravel-10.x%2B-red) ![Tailwind](https://img.shields.io/badge/Bootstrap-5-purple) ![License](https://img.shields.io/badge/License-MIT-blue)

## 📖 About The Project

Running a Sari-Sari store often involves manual listing in notebooks, leading to errors and stockouts. This project digitizes that process, providing a centralized dashboard to track products and categories.

### 🌟 Key Features

* **📦 Product Management:** Add, edit, and delete products with details like price, stock quantity, and description.
* **📂 Categorization:** Organize items (e.g., Canned Goods, Beverages, Toiletries) for easier filtering.
* **📉 Low Stock Indicators:** Visual cues when product stock runs low (optional).
* **🔍 Search & Filter:** Quickly find items in the inventory.
* **📱 Responsive Design:** optimized for desktops, tablets, and mobile phones.

## 🛠️ Technology Stack

* **Backend:** PHP, Laravel Framework
* **Frontend:** Blade Templates, Bootstrap 5 / Tailwind CSS
* **Database:** MySQL
* **Scripting:** JavaScript

## 🚀 Getting Started

Follow these steps to set up the project locally on your machine.

### Prerequisites

* [PHP](https://www.php.net/) (Version 8.1 or higher)
* [Composer](https://getcomposer.org/)
* [Node.js & NPM](https://nodejs.org/)
* [MySQL](https://www.mysql.com/) (or XAMPP/WAMP)

### Installation Guide

1.  **Clone the Repository**
    ```bash
    git clone [https://github.com/Xrid-driX/sari-sari-inventory.git](https://github.com/Xrid-driX/sari-sari-inventory.git)
    cd sari-sari-inventory
    ```

2.  **Install PHP Dependencies**
    ```bash
    composer install
    ```

3.  **Install Frontend Dependencies**
    ```bash
    npm install
    npm run build
    ```

4.  **Environment Configuration**
    * Duplicate the example environment file:
        * **Windows:** `copy .env.example .env`
        * **Mac/Linux:** `cp .env.example .env`
    * Open `.env` and configure your database settings:
        ```env
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=sari_sari_db
        DB_USERNAME=root
        DB_PASSWORD=
        ```

5.  **Generate App Key**
    ```bash
    php artisan key:generate
    ```

6.  **Run Migrations & Seeders** (Set up the database)
    ```bash
    php artisan migrate --seed
    ```

7.  **Run the Application**
    * Start the local server:
        ```bash
        php artisan serve
        ```

8.  **Access the App**
    Open your browser and visit: `http://127.0.0.1:8000`

## 📂 Project Structure
