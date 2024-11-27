## POC: Import Products with Laravel Excel

This Proof of Concept (POC) demonstrates importing products into a Laravel 11 application using the Laravel Excel package. The project includes setting up a Laravel environment, configuring necessary packages, and handling large data imports efficiently. Key features include:

- Laravel 11 setup with Sail and MySQL
- Admin and user panels using Filament
- Product and Brand models with migrations
- Category management using Rinvex
- Excel file import functionality
- Queued import capability for large datasets

The goal is to test the import process with a large dataset (10,000 products) and address any memory overload issues.


For  the status details, check [POC.md](POC.md).


To run the project, you need to ensure the following steps are completed:

To run the project, you need to ensure the following steps are completed:

1. **Install Dependencies:**
   Make sure you have all the necessary dependencies installed via Composer and npm.

   ```bash
   composer install
   npm install
   ```

2. **Environment Configuration:**
   Copy the `.env.example` file to `.env` and configure your environment variables, such as database credentials.

   ```bash
   cp .env.example .env
   ```

3. **Generate Application Key:**
   Generate the application key for your Laravel application.

   ```bash
   ./vendor/bin/sail artisan key:generate
   ```

4. **Run Migrations:**
   Run the database migrations to set up your database schema.

   ```bash
   ./vendor/bin/sail artisan migrate
   ```

5. **Start Sail:**
   Start the Laravel Sail environment.

   ```bash
   ./vendor/bin/sail up
   ```

6. **Build Frontend Assets:**
   Compile the frontend assets using npm.

   ```bash
   npm run dev
   ```
   
7. Add user with Filament
    ```
    php artisan make:filament-user
    ```
   
8. Login at `localhost/admin`

These steps should help you set up and run the project successfully.
