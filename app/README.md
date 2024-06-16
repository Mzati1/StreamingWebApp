# Movies App

Welcome to Movies App! This project is a [brief description of your project].

## Getting Started

To get this project up and running, follow these steps:

### Prerequisites

Before you start, make sure you have the following installed:

-   [Node.js](https://nodejs.org/) (version >= X.X.X)
-   [Composer](https://getcomposer.org/)
-   [PHP](https://www.php.net/) (version >= X.X)
-   [MySQL](https://www.mysql.com/) or another database system

## Installation

1. Clone the repository:

    ```bash
    git clone https://github.com/your-username/movies-app.git
    cd movies-app
    ```

#### Install php dependencies

```bash
   composer install
```

#### Install php dependencies

```bash
npm install
```

#### Set up environment variables

- first create env file ( if does not exist already)

```bash
touch .env
```

- you can change depending on how you want

```bash
APP_NAME=Movies
APP_ENV=local
APP_KEY=base64:Kr2Q61IXL4ToxBcJYsM8LZ5/lb7oI/FUVEah2b7zjuw=
APP_DEBUG=true
APP_TIMEZONE=UTC
APP_URL=https://localhost

# Set your database connection details (uncomment and fill in accordingly)
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=your_database_name
# DB_USERNAME=your_database_username
# DB_PASSWORD=your_database_password

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

# Add other necessary environment variables (e.g., API keys, AWS credentials)

TMDB_BASE_URL=https://api.themoviedb.org/3
TMDB_IMAGE_BASE_URL=https://image.tmdb.org/t/p/w500/
TMDB_TOKEN=your_tmdb_token

```

## Configuration

-   #### Start the PHP development server (or use Laravel's artisan commands if applicable):

```bash
php artisan serve
```

-   #### compile assets and run development server for live reloading

```bash
npm run build && npm run dev
```
