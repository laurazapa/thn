# THN Project

This is a Laravel project following Domain-Driven Design (DDD) principles. The project is built with Laravel 12 and includes Behat for behavior-driven development testing.

## Requirements

- PHP 8.4 or higher (^8.4)
- Laravel 12.0
- Composer
- SQLite

## Installation

1. Clone the repository:
```bash
git clone https://github.com/laurazapa/thn.git
```

2. Install PHP dependencies:
```bash
composer install
```

3. Create environment files:
```bash
cp .env.example .env
cp .env.behat.example .env.behat
```

4. Generate application key:
```bash
php artisan key:generate
```

5. Create SQLite database:
```bash
touch database/database.sqlite
```

6. Run migrations:
```bash
php artisan migrate
```

7. Create SQLite database for Behat:
```bash
touch database/database_behat.sqlite
```

8. Run migrations for Behat tests:
```bash
php artisan migrate --env=behat
```

## Development

To start the development server:

```bash
php artisan serve
```

## Testing

### Running Behat Tests

To run all Behat tests:

```bash
APP_ENV=behat ./vendor/bin/behat
```

### Running PHPUnit Tests

To run PHPUnit tests:

```bash
./vendor/bin/phpunit
```

### Testing the Application

The application will be available at `http://localhost:8000`

You can test the API endpoints using tools like Postman. Here are some example endpoints:

```bash
# Get the basic information of a hotel
curl http://localhost:8000/api/hotels/{hotelUuid}

# Get how many users have booked rooms per hotel
curl http://localhost:8000/api/api/hotels/user-count-list
```

## Project Structure

The project follows a DDD structure with the following main directories:

- `apps/` - Contains different bounded contexts
- `src/` - Shared domain code
- `tests/` - Test suites including Behat and PHPUnit tests
- `config/` - Application configuration
- `database/` - Database migrations and seeders
