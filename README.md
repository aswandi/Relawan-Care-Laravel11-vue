# RelawanCare

A web application for managing volunteers and aid distribution. Built with Laravel and Vue.js.

## About The Project

RelawanCare is a platform designed to streamline the process of organizing volunteer activities and distributing aid to beneficiaries. It provides features for managing volunteers, tracking aid sessions, and reporting on distribution activities.

## Built With

* [Laravel](https://laravel.com/)
* [Vue.js](https://vuejs.org/)
* [Tailwind CSS](https://tailwindcss.com/)

## Getting Started

To get a local copy up and running follow these simple steps.

### Prerequisites

* PHP >= 8.1
* Composer
* Node.js & NPM
* A web server (e.g., Nginx, Apache) or Laravel Valet/Laragon

### Installation

1. Clone the repo
   ```sh
   git clone https://github.com/aswandi/Relawan-Care-Laravel11-vue.git
   ```
2. Install PHP dependencies
   ```sh
   composer install
   ```
3. Install NPM packages
   ```sh
   npm install
   ```
4. Copy `.env.example` to `.env` and configure your database and other settings.
   ```sh
   cp .env.example .env
   ```
5. Generate an application key
   ```sh
   php artisan key:generate
   ```
6. Run the database migrations
   ```sh
   php artisan migrate
   ```
7. (Optional) Seed the database with sample data
    ```sh
    php artisan db:seed
    ```
8. Compile assets
   ```sh
   npm run dev
   ```
9. Start the development server
   ```sh
   php artisan serve
   ```

## License

Distributed under the MIT License. See `LICENSE` for more information.