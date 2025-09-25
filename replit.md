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