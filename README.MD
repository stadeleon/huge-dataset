# Huge Dataset Project Setup Guide

This document describes how to set up and run the project locally using Docker Compose. It includes database setup, caching with Redis, and generating test data using Faker.

## Prerequisites

- Docker
- Docker Compose
- Git

---

## Installation

### 1. Clone the repository

```bash
git clone git@github.com:stadeleon/huge-dataset.git
cd huge-dataset
```

### 2. Build and launch Docker containers

Run the following command to build and start containers:

```bash
docker compose up --build -d
```

### 3. Install Composer dependencies

Run Composer within the Docker container:

```bash
docker compose exec php composer install
```

### 4. Set up environment variables

Copy and configure your environment variables:

```bash
cp app/.env app/.env.local
```

Make sure the following lines exist in your `.env.local` file:

```env
DATABASE_URL="postgresql://symfony:secret@postgres:5432/symfony?serverVersion=15&charset=utf8"
REDIS_URL=redis://redis:6379
```

### 5. Database setup

Run database migrations:

```bash
docker compose exec php bin/console doctrine:migrations:migrate
```

### 6. Populate database with test data (Faker)

Generate fake data using the provided Symfony command:

```bash
docker compose exec php bin/console app:seed-big-data
```

### 7. Clear and warm up Symfony cache

```bash
docker compose exec php bin/console cache:clear
```

## Verify the application

- Visit your app at:
```
http://localhost
```

- Verify the API documentation:
```
http://localhost/api/doc
```

- Check the dataset endpoint:
```
http://localhost/api/process-huge-dataset
```

---

##  Useful commands

Clear cache:
```bash
docker compose exec php bin/console cache:clear
```

Update Composer autoload:
```bash
docker compose exec php composer dump-autoload
```

Rebuild Docker containers:
```bash
docker compose up --build -d
```

---

## Your application is now ready!


