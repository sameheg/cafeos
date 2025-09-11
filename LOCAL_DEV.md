# Local Development Setup

## Overview
- This section outlines the primary goals and scope of Local Dev.

## Prerequisites
- Familiarity with basic Local Dev concepts and system requirements is recommended.

## Setup
- Follow these steps to configure and enable Local Dev in your environment.

## Usage
- Instructions and examples for applying Local Dev in day-to-day operations.

## References
- Additional resources and documentation about Local Dev for further learning.


## Prerequisites
- PHP 8.4
- Composer
- Node.js 20+
- Docker & Docker Compose
- MySQL/Redis

## Steps
1. Clone repo
2. Copy .env.example → .env
3. Run docker-compose up -d
4. Run composer install && npm install
5. Run php artisan migrate --seed
6. Open http://localhost:8000
