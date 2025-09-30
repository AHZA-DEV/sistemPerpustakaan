<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

# Overview

This is a **Perpustakaan Digital** (Digital Library) application built with Laravel 12. The application is designed to manage library operations including user management, book catalog, and book lending/borrowing functionality. It features separate interfaces for administrators and regular users, with authentication-based access control.

# User Preferences

Preferred communication style: Simple, everyday language.

# System Architecture

## Frontend Architecture
- **Technology Stack**: Laravel Blade templating with TailwindCSS 4.0 for styling
- **Build System**: Vite for asset compilation and hot module replacement during development
- **UI Framework**: Mix of TailwindCSS for modern responsive design and Bootstrap 5 for admin dashboard components
- **Static Assets**: Template HTML files stored in `public/template/` for prototyping and reference

## Backend Architecture
- **Framework**: Laravel 12 (latest version) with PHP 8.2+ requirement
- **MVC Pattern**: Standard Laravel architecture with Models, Views, and Controllers
- **Authentication**: Laravel's built-in authentication system for user login/registration
- **Database ORM**: Eloquent ORM for database interactions
- **Namespace Structure**: PSR-4 autoloading with `App\` namespace for application code

## Data Storage Solutions
- **Primary Database**: SQLite (default setup with auto-creation during installation)
- **Migration System**: Laravel's schema builder for database version control
- **Seeding**: Database factories and seeders for test data generation using Faker library

## Authentication and Authorization
- **User Authentication**: Laravel's built-in authentication system
- **Role-based Access**: Separate interfaces for Admin and User roles
- **Session Management**: Laravel session handling for maintaining user state
- **CSRF Protection**: Built-in Laravel CSRF token protection

## Key Application Features
- **Admin Dashboard**: Complete CRUD operations for users, books, categories, and loan management
- **User Interface**: Book browsing, search functionality, and personal loan history
- **Book Management**: Catalog management with categories and availability tracking
- **Loan System**: Book borrowing and return functionality with due date tracking
- **Reporting**: Administrative reports and analytics dashboard

## Development Environment
- **Asset Pipeline**: Vite with Laravel plugin for modern frontend tooling
- **Hot Reload**: Development server with HMR for faster iteration
- **Code Quality**: Laravel Pint for code formatting and PHPUnit for testing
- **Development Tools**: Laravel Tinker for interactive debugging, Laravel Sail for Docker environment

# External Dependencies

## Core Framework Dependencies
- **Laravel Framework 12**: Web application framework providing MVC architecture, routing, and core services
- **Laravel Tinker**: Interactive REPL for debugging and testing Laravel applications

## Frontend Build Tools
- **Vite 7.0+**: Modern build tool for asset compilation and development server
- **Laravel Vite Plugin**: Laravel-specific Vite integration for seamless asset handling
- **TailwindCSS 4.0**: Utility-first CSS framework for responsive design
- **Axios**: HTTP client library for making API requests from frontend

## Development and Testing
- **FakerPHP**: Library for generating fake data for database seeding and testing
- **PHPUnit**: Unit testing framework for PHP applications
- **Laravel Pail**: Log viewer for development debugging
- **Laravel Pint**: Code style fixer following Laravel conventions
- **Mockery**: Mocking library for unit tests
- **Collision**: Error handler for better development experience

## Utility Libraries
- **Guzzle HTTP**: HTTP client library for external API communications
- **Carbon**: Date manipulation library (via Laravel)
- **Doctrine Inflector**: String manipulation for pluralization/singularization
- **Symfony Components**: Various utility components used by Laravel core

## UI/UX Dependencies (Template References)
- **Bootstrap 5**: CSS framework used in admin dashboard templates
- **Bootstrap Icons**: Icon library for admin interface
- **Font Awesome 6**: Icon library for user interface
- **Chart.js**: JavaScript charting library for reports and analytics
- **DataTables**: jQuery plugin for enhanced table functionality in admin panels

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
