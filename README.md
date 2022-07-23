# Laravel Referrals

> #### A Laravel + React project that implements a referrals system, heavily inspired by [Dropbox](https://www.dropbox.com/referrals).

## Features

- Users can send out referral links to multiple email addresses
- Recipients will receive an email containing a registration link with a referral code
- When recipients register using the link, the referrer will earn 1 referral point
- Referrers can earn a maximum of 10 points
- Users can view a list of their referrals and see how many users already registered using their links
- An admin user can view a dashboard page with all the referrals in the system

## Getting Started

### Requirements

- PHP 7.4
- Laravel 8.4

### Installation

Clone the repository.
```
git clone https://github.com/alfonzm/laravel-referrals.git
```

Switch to the project folder.
```
cd laravel-referrals
```

Install dependencies and setup Laravel project.
```
composer install
npm run install --legacy-peer-deps
php artisan key:generate
```

Create an `.env` file and make necessary changes for your environment.
```
cp .env.example .env
```

Run migrations with seeder. This will seed admin roles and a super-admin user.
```
php artisan migrate --seed
```

Serve the app. You may also use [Laravel Sail](https://laravel.com/docs/8.x/sail), [Valet](https://laravel.com/docs/8.x/valet), etc.

```
php artisan serve
npm run watch
```

## Running Tests

When running tests, it is recommended to use a separate database and `.env.testing` file.

```
cp .env.example .env.testing
```

Then configure your DB config in the `.env.testing` file.

Or, you can also use a sqlite database:

```
touch database/database.sqlite
```

Then in the `.env.testing` file, remove all DB related variables except for:
```
DB_CONNECTION=sqlite
```

To run the tests:

```
php artisan test
```


## Dependencies

- [BenSampo/laravel-enum](https://github.com/BenSampo/laravel-enum)
- [spatie/laravel-cors](https://github.com/spatie/laravel-cors)
- [spatie/laravel-permission](https://github.com/spatie/laravel-permission)

## Authors

- [Alfonz Montelibano](https://github.com/alfonzm)

## License

The MIT License (MIT). Please see License File for more information.
