# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

**MONEV RELAWAN** (RelawanCare) is a volunteer monitoring system with two main components:
- **Web Dashboard**: Laravel-based admin interface for monitoring volunteer activities
- **Mobile App**: Android application for volunteers to input field data (photos, GPS, beneficiary data)

The application tracks volunteer activities in distributing aid to beneficiaries across Indonesian administrative regions (kabupaten/kecamatan/desa).

## Architecture

### Backend (Laravel 11)
- **Authentication**: Dual authentication system
  - Web users: Standard Laravel authentication
  - Mobile volunteers: Phone number + 5-digit PIN authentication
- **Database**: MySQL with normalized structure for administrative regions, volunteers, beneficiaries, aid types, and volunteer activities
- **Key Models**: User, Volunteer, Beneficiary, AdministrativeRegion, AidType, AidSession, VolunteerActivity

### Frontend
- **Web**: Laravel with Vite + Vue.js integration
- **Mobile**: Android application (separate codebase)

### Database Design
The database follows proper normalization with key entities:
- Administrative regions stored hierarchically in single table
- Volunteers linked to specific administrative regions  
- Beneficiaries with complete demographic data (KK, NIK, address)
- Flexible aid system supporting various aid types including cash with nominal amounts
- Activity tracking with GPS coordinates and multiple photo support
- Session-based aid distribution system

## Common Commands

### Initial Project Setup
```bash
# Install Laravel project (when initializing)
composer create-project laravel/laravel . "^11.0"

# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate
php artisan db:seed
```

### Development
```bash
# Start development servers
php artisan serve                # Backend API server
npm run dev                      # Frontend development with Vite

# Database operations
php artisan migrate              # Run migrations
php artisan migrate:fresh --seed # Fresh migration with seeding
php artisan make:migration       # Create new migration
php artisan make:model          # Create new model
php artisan make:controller      # Create new controller
```

### Testing & Quality
```bash
# Run tests
php artisan test                 # Run PHPUnit tests
npm run test                     # Run frontend tests (when configured)

# Code quality
composer run lint                # PHP linting (when configured)
npm run lint                     # JavaScript/Vue linting
```

### Build & Deployment
```bash
# Production build
npm run build                    # Build frontend assets
php artisan config:cache         # Cache configuration
php artisan route:cache          # Cache routes
php artisan view:cache           # Cache views
```

## Key Features to Implement

### Authentication System
- Web admin authentication using Laravel's built-in auth
- Mobile volunteer authentication via phone number + 5-digit PIN
- Role-based access control between web users and volunteers

### Core Functionality
- **Administrative Regions Management**: Hierarchical kabupaten > kecamatan > desa structure
- **Volunteer Management**: Registration, assignment to regions, mobile authentication
- **Beneficiary Management**: Complete demographic data with family card (KK) and national ID (NIK)
- **Aid Distribution**: Session-based aid distribution with multiple aid types
- **Activity Tracking**: GPS-enabled activity logging with photo uploads
- **Reporting Dashboard**: Web-based monitoring and reporting interface

### Mobile Integration
- API endpoints for mobile app data synchronization
- Image upload handling for field photos
- GPS coordinate storage and validation
- Offline capability considerations for mobile data collection

## Database Schema
- Reference `database_structure.sql` for complete schema
- All foreign keys properly configured with cascade deletes where appropriate
- Indexed fields for performance optimization
- Sample data included for testing

## File Structure Conventions
- Follow Laravel 11 directory structure
- Vue components in `resources/js/components/`
- API controllers in `app/Http/Controllers/Api/`
- Models with proper relationships in `app/Models/`
- Database migrations with descriptive timestamps
- Factory and seeder files for test data generation