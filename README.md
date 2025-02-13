<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Laravel Application: Book Management System

## Overview

This application is a Laravel-based Book Management System that allows users to:

- Log in and see profile.
- Create, read, and delete authors.
- Add, delete, and manage books associated of authors.

The application is built with Laravel and follows a basic MVC structure. User can authenticate themselves with middleware and manage authors and books in a user-friendly interface.

## Installation

### Prerequisites

- **PHP**: >=8.1
- **Composer**: Dependency manager for PHP
- **Laravel**: Version 10.x
- **MySQL** or any other database system you prefer (configure your `.env` accordingly).
- **Git**: To clone the repository.

### Steps

1. **Clone the repository**:

    ```bash
    git clone https://your-repository-url.git
    cd your-project-directory
    ```

2. **Install dependencies**:

    ```bash
    composer install
    ```

3. **Install additional packages**:

    Run the following command to install the additional required packages if not installed:

    ```bash
    composer require guzzlehttp/guzzle:^7.9 zircote/swagger-php:^5.0
    ```

4. **Create and configure the `.env` file**:

    ```bash
    cp .env.example .env
    ```

    Open `.env` and configure the following:

    - `SWAGGER_URL=`
    - `SWAGGER_EMAIL=`
    - `SWAGGER_PASSWORD=`

5. **Generate the application key**:

    ```bash
    php artisan key:generate
    ```

6. **Run migrations** to set up the database tables:

    ```bash
    php artisan migrate
    ```

7. **Start the development server**:

    ```bash
    php artisan serve
    ```

    Visit the app in your browser at `http://127.0.0.1:8000`.

---

## Routes Overview

### Authentication

- `GET /login` - Show the login form.
- `POST /login` - Authenticate the user.
- `GET /` - Redirects to login page.
- `GET /profile` - Display the user profile after a successful login.
- `POST /logout` - Log out the user and redirect to the login page.

### Author Management (requires login)

- `GET /authors` - List all authors.
- `GET /authors/create` - Show form to create a new author.
- `POST /create` - Store the new author.
- `GET /authors/{author_id}` - View author details.
- `DELETE /authors/{author_id}` - Delete an author.

### Book Management (requires login)

- `GET /book/create/{author_id}` - Show form to create a book for a specific author.
- `POST /book` - Store the book.
- `DELETE /book/{book_id}` - Delete a book.

---

## Console Command: `create:author`

In addition to managing authors through the web interface, you can also create authors via a custom Artisan command.

### How to use:

Run the following command from the terminal:

```bash
php artisan create:author


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
