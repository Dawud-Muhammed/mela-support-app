# Mela Support App

Mela Support App is a Laravel-based campus facility support platform for reporting, assigning, tracking, and resolving maintenance issues. It supports role-based workflows for citizens (requesters), technicians, and administrators, with both in-app and optional Telegram notifications.

## Key Features

- **Ticket lifecycle management**: create, assign, track, resolve, verify, and close support tickets.
- **Smart technician dispatch**: automatic assignment based on technician specialty and building coverage.
- **Role-based access**: separate flows for users, technicians, and admins.
- **Evidence handling**: upload issue evidence and resolution evidence.
- **Conversation threads**: ticket-level messaging between involved users.
- **Admin analytics**: operational KPIs, SLA risk visibility, and technician performance snapshots.
- **Account moderation**: admin user suspension/reactivation controls.
- **Notifications**: Laravel database notifications, email alerts, and optional Telegram alerts.

## Tech Stack

- **Backend**: PHP 8.2+, Laravel 12
- **Frontend tooling**: Vite, Tailwind CSS, Alpine.js
- **Database**: SQLite (default), compatible with other Laravel-supported databases
- **Queue/Notifications**: Laravel queue + notification system

## Prerequisites

Before running the project, ensure you have:

- PHP 8.2+
- Composer
- Node.js 18+ and npm
- SQLite (or your preferred relational database)

## Getting Started

### 1) Clone and enter the project

```bash
git clone https://github.com/Dawud-Muhammed/mela-support-app.git
cd mela-support-app
```

### 2) Install dependencies and bootstrap

Use the built-in setup script:

```bash
composer run setup
```

This command installs PHP and JS dependencies, creates `.env` if needed, generates an app key, runs migrations, and builds frontend assets.

### 3) Seed initial data

```bash
php artisan db:seed
```

### 4) Run the development environment

```bash
composer run dev
```

This starts the Laravel server, queue listener, log watcher, and Vite dev server concurrently.

## Default Seeded Admin (Development)

After seeding, a default admin account is available:

- **Email**: `admin@bit.edu.et`
- **Password**: `password`

> For security, change or remove default credentials outside local development.

## Environment Configuration

Update `.env` as needed for your environment.

### Optional Telegram integration

Set the Telegram bot token to enable Telegram notifications:

```env
TELEGRAM_BOT_TOKEN=your_bot_token_here
```

Users/technicians must also have a `telegram_chat_id` saved in their profile record to receive Telegram messages.

## Common Commands

```bash
# Run test suite
composer test

# Run code style checks/fixes
./vendor/bin/pint

# Build frontend assets for production
npm run build
```

## Core Roles

- **User (Citizen)**: submits maintenance tickets and verifies resolutions.
- **Technician**: receives assignments and updates ticket status.
- **Admin**: manages users/agents and monitors analytics.

## Project Structure

- `/app/Http/Controllers` — web controllers (tickets, admin, profile, notifications)
- `/app/Services` — business services (dispatching, uploads, notifications, Telegram)
- `/app/Models` — domain models (`Ticket`, `User`, `Category`, `TicketMessage`)
- `/database/migrations` — schema definitions
- `/database/seeders` — initial seed data
- `/resources/views` — Blade templates

## Contributing

1. Fork the repository.
2. Create a feature branch.
3. Make focused, tested changes.
4. Open a pull request with a clear description.

## License

This project is open-sourced under the [MIT license](https://opensource.org/licenses/MIT).
