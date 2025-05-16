# Smash Up Randomizer

[![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?style=flat-square&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=flat-square&logo=mysql&logoColor=white)](https://www.mysql.com)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.x-7952B3?style=flat-square&logo=bootstrap&logoColor=white)](https://getbootstrap.com)
[![Vite](https://img.shields.io/badge/Vite-4.x-646CFF?style=flat-square&logo=vite&logoColor=white)](https://vitejs.dev)
[![License](https://img.shields.io/badge/License-MIT-blue.svg?style=flat-square)](LICENSE)
[![GitHub last commit](https://img.shields.io/github/last-commit/kadsuno/smash-up-randomizer?style=flat-square)](https://github.com/kadsuno/smash-up-randomizer/commits)
[![GitHub issues](https://img.shields.io/github/issues/kadsuno/smash-up-randomizer?style=flat-square)](https://github.com/kadsuno/smash-up-randomizer/issues)
[![Conventional Commits](https://img.shields.io/badge/Conventional%20Commits-1.0.0-yellow.svg?style=flat-square)](https://conventionalcommits.org)
[![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg?style=flat-square)](http://makeapullrequest.com)
[![GitHub Workflow Status](https://img.shields.io/github/actions/workflow/status/kadsuno/smash-up-randomizer/laravel.yml?style=flat-square&logo=github-actions&logoColor=white&label=CI)](https://github.com/kadsuno/smash-up-randomizer/actions)

A web application to help Smash Up players randomly assign factions and manage their game setup.

## About the Project

Smash Up Randomizer is a tool designed for players of the popular card game "Smash Up". This web application helps you:

-   Randomly assign factions to players
-   Filter factions by expansions you own
-   Share game setups with friends
-   Keep track of your favorite faction combinations

Built with Laravel, Bootstrap, and modern JavaScript, the app provides a smooth, responsive experience across devices.

## Features

-   **Random Faction Selection**: Automatically assign random factions to each player
-   **Custom Filters**: Filter by expansions or specific factions to customize your gameplay experience
-   **Share Results**: Easily share your faction assignments with friends through various social platforms
-   **Dark Theme**: Enjoy a comfortable dark mode for late-night gaming sessions
-   **Responsive Design**: Works on desktop, tablets, and mobile devices
-   **User Accounts**: Register and save your favorite faction combinations
-   **Faction Database**: Browse detailed information about all Smash Up factions

## Getting Started

### Prerequisites

-   PHP 8.0 or higher
-   Composer
-   Node.js and npm
-   MySQL or compatible database

### DDEV Setup

This project uses DDEV for local development to ensure a consistent environment across all development machines.

1. Install [DDEV](https://ddev.readthedocs.io/en/stable/)

2. Clone the repository

    ```
    git clone https://github.com/yourusername/smash-up-randomizer.git
    cd smash-up-randomizer
    ```

3. Start DDEV

    ```
    ddev start
    ```

4. Install dependencies

    ```
    ddev composer install
    ddev npm install
    ```

5. Copy environment file and generate application key

    ```
    ddev exec cp .env.example .env
    ddev exec php artisan key:generate
    ```

6. Run migrations

    ```
    ddev exec php artisan migrate
    ```

7. Compile assets

    ```
    ddev npm run dev
    ```

8. Access the site at https://smash-up-randomizer.ddev.site

### Standard Installation

If you're not using DDEV, follow these steps:

1. Clone the repository

    ```
    git clone https://github.com/yourusername/smash-up-randomizer.git
    ```

2. Install PHP dependencies

    ```
    composer install
    ```

3. Install JavaScript dependencies

    ```
    npm install
    ```

4. Copy the environment file and update it with your database credentials

    ```
    cp .env.example .env
    ```

5. Generate an application key

    ```
    php artisan key:generate
    ```

6. Run database migrations

    ```
    php artisan migrate
    ```

7. Compile assets

    ```
    npm run dev
    ```

8. Start the development server
    ```
    php artisan serve
    ```

## Database Structure

The application uses MySQL with the following tables:

### User Management

-   **users**: Admin users for the backend

    -   Standard Laravel user fields (id, name, email, password, etc.)
    -   Created through Laravel authentication scaffolding

-   **frontend_users**: Regular users who use the randomizer
    -   Extends standard user functionality for frontend application users

### Faction Data

-   **decks**: Stores faction details (primary content)
    -   name: Name of the faction
    -   image: Path to faction image
    -   expansion: Which set the faction belongs to
    -   description: Full description of the faction
    -   mechanics, playstyle, effects: Gameplay characteristics
    -   Various other faction-specific metadata fields

### User Interaction

-   **contacts**: Stores contact form submissions
    -   Contains name, email, phone, subject, and message fields
    -   Used for customer support and feedback

### System Tables

-   **jobs**: Background processing queue
-   **failed_jobs**: Failed background jobs
-   **password_resets**: Password reset tokens
-   **personal_access_tokens**: API token management
-   **oauth\_\*** tables: Laravel Passport authentication

## Application Architecture

### Models

The application uses Eloquent ORM with these models:

-   **User**: Admin user accounts (`app/Models/User.php`)
-   **FrontendUser**: Regular user accounts (`app/Models/FrontendUser.php`)
-   **Deck**: Core model for Smash Up factions (`app/Models/Deck.php`)
-   **Contact**: Form submissions (`app/Models/Contact.php`)

### Controllers

The application follows Laravel's MVC pattern with these controllers:

-   **DeckController**: Core functionality for faction management, display, and shuffling
-   **ContactController**: Handles contact form processing
-   **HomeController**: Manages general page routing
-   **Auth Controllers**: Handle authentication for both admin and frontend users

### Views

Views use Laravel Blade templates organized as follows:

-   **auth/**: Authentication views
-   **components/**: Reusable UI components
-   **decks/**: Faction display templates
-   **emails/**: Email templates
-   **errors/**: Error pages
-   **frontend/**: Front-facing user interfaces
-   **backend/**: Admin interfaces
-   **start/**: Landing pages
-   **shuffle/**: Randomizer interface
-   **legal/**: Imprint, privacy policy, and terms of service

### Routes

The application has the following primary routes:

-   `/`: Homepage with main application features
-   `/shuffle`: Faction randomizer form
-   `/shuffle/result`: Generated faction assignments
-   `/factions`: Browse all available factions
-   `/factions/{name}`: Detailed view of a specific faction
-   `/contact-us`: Contact form
-   `/about`: Information about the project
-   `/login`, `/register`: Frontend user authentication
-   `/account`: User account management
-   `/admin/*`: Backend administration area (protected)

### Services

-   **SendgridMailService**: Handles email delivery using Sendgrid

### Mailing

Email functionality is implemented using Laravel's Mail facade with Sendgrid integration:

-   **ContactMail**: Sends notification emails for contact form submissions
-   **ContactConfirmationMail**: Confirmation emails to users who submit contact forms

Configuration is stored in `.env` with mail-related settings (MAIL\_\* variables).

## Frontend Architecture

### JavaScript

-   Uses Laravel Vite for asset compilation
-   Core functionality in resources/js directory
-   Bootstrap and custom components for UI interactions

### Styling

-   SASS/SCSS preprocessing
-   Bootstrap 5 framework with custom overrides
-   Dark/light theme support with localStorage persistence

## Development

### Built With

-   [Laravel](https://laravel.com/) - PHP framework
-   [Bootstrap 5](https://getbootstrap.com/) - Frontend framework
-   [Vite](https://vitejs.dev/) - Frontend tooling
-   [MySQL](https://www.mysql.com/) - Database
-   [Sendgrid](https://sendgrid.com/) - Email delivery

### Compiling Assets

-   Development: `npm run dev`
-   Production: `npm run build`

### Version Control Strategy

We follow a simplified Git Flow approach:

#### Branches

-   **main**: Production-ready code
-   **dev**: Integration branch for feature development
-   **feature/\***: Individual feature branches
-   **bugfix/\***: Bug fixes
-   **release/\***: Release preparation

#### Commit Conventions

We use conventional commits to maintain a clean history:

```
feat: add new faction filter component
fix: correct dark mode contrast issues
docs: update installation instructions
style: format code according to PSR-12
refactor: improve randomization algorithm
test: add tests for faction selection
```

## Style Guide

### PHP Coding Standards

-   PSR-12 compliant code formatting
-   DocBlocks for all classes and methods
-   Type hints for method parameters and return types
-   Laravel best practices for controllers, models, and services

### JavaScript Standards

-   ES6+ syntax
-   Consistent naming conventions
-   Component-based organization

### SASS/CSS Conventions

-   Component-based styling
-   Consistent naming using kebab-case
-   Responsive design principles
-   Dark/light theme compatibility

## License

This project is licensed under the MIT License.
