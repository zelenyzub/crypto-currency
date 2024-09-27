# Cryptocurrency Technical Task

# Requiremqnts
  - PHP 8.2.0
  - Composer 2.5.1
  - Symfony CLI (optional but recommended)
  - MySQL or any other database supported by Doctrine

## Geting started

# Clone Repositoriy
  - git clone https://github.com/zelenyzub/crypto-currency.git
  - cd crypto-currency
  - composer install
  - cp.env .env.local
# Update database URL in .env
  - DATABASE_URL="mysql://root@127.0.0.1:3306/cryptocurrencies?serverVersion=8.0.32&charset=utf8mb4"
  - make sure you have made a database named cryptocurrencies
# Run migrations
  - php bin/console doctrine:migrations:migrate
# Run command for fetching data from public API
  - php bin/console app:fetch-crypto-currencies
# API Endpoints
  - `/api/crypto-currency/{symbol}`: Retrieve cryptocurrency by symbol.
  - `/api/crypto-currency?min=1000`: Retrieve cryptocurrencies by minimum price.
  - `/api/crypto-currency?max=1000`: Retrieve cryptocurrencies by maximum price.
  - `/api/find-currency-by-id/{id}`: Retrieve cryptocurrency by ID.
# Running API Endpoints In Command Line (default examples)
  - http://localhost:8000/api/crypto-currency/btc
  - http://localhost:8000/api/crypto-currency?min=1000
  - http://localhost:8000/api/crypto-currency?max=1000
  - http://localhost:8000/api/find-currency-by-id/2

  
