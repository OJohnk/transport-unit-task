# Transport Unit Manager

A simple Laravel + Vue.js application for creating and searching transport units (trucks and trailers).

## Requirements

- PHP 8.x
- Composer
- Node.js
- MySQL

## Installation

1. Clone the repository
2. `composer install`
3. `npm install`
4. `cp .env.example .env`
5. `php artisan key:generate`
6. Create a MySQL database called transport_units and update `.env`
7. `php artisan migrate`
8. `npm run dev`
9. `php artisan serve`

## Seeding (optional)

To seed 100,000 transport units:
```bash
php artisan db:seed --class=TransportUnitSeeder