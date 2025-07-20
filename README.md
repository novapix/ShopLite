# ShopLite

ShopLite is an e-commerce platform designed to simplify online shopping and store management. Built with Laravel, it provides robust features for managing products, customers, and orders.

## Features

- User authentication and roles management
- Product categories and brand management
- Customer profiles with avatars
- Seamless database migrations and seeders

[//]: # (- RESTful API support)

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/novapix/ShopLite.git
   ```

2. Navigate to the project directory:
   ```bash
   cd ShopLite
   ```

3. Install dependencies:
   ```bash
   composer install
   npm install
   ```

4. Set up the environment file:
   ```bash
   cp .env.example .env
   ```
   Update the `.env` file with your database and other configurations.

5. Run migrations:
   ```bash
   php artisan migrate
   ```

6. Seed the database:
   ```bash
   php artisan db:seed
   ```

7. Start the development server:
   ```bash
   php artisan serve
   ```

## Contributing

Contributions are welcome! Please fork the repository and submit a pull request.

## License

This project is licensed under the [MIT License](LICENSE).
