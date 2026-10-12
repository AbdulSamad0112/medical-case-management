# Jajal Medical — Case Management System

A Laravel 10 application for tracking surgical implant cases (hip, knee, spine,
shoulder, trauma, etc.). It ships with a server-rendered Blade UI **and** a
Sanctum-protected REST API, with role-based access control (Admin / Viewer).

## Features

- **Authentication** — session based login for the web UI, Sanctum personal
  access tokens for the API.
- **Role based authorization** via policies: `admin` can create/update/delete,
  `viewer` has read-only access.
- **Case registry** — paginated list with search by case number / surgeon name
  and filters for status and priority (filters are preserved across pages).
- **Dashboard** — live counts per status plus the five most recent cases.
- **REST API** — full CRUD for cases with a consistent JSON envelope
  (`success`, `data`, `message`, and `meta` for paginated lists).

## Requirements

- PHP ^8.1 (tested on 8.2)
- Composer
- MySQL (default) — SQLite works for tests
- Node 16+ & npm (for the Vite/Tailwind front-end assets)

## Installation

```bash
composer install
npm install
cp .env.example .env   # then set DB_* and APP_KEY
php artisan key:generate
php artisan migrate --seed
npm run dev            # or: npm run build
php artisan serve
```

### Demo accounts (created by `UserSeeder`)

| Role   | Email                     | Password       |
| ------ | ------------------------- | -------------- |
| Admin  | admin@jajalmedical.com    | Admin@123456   |
| Viewer | viewer@jajalmedical.com   | Viewer@123456  |

### Sample data

`MedicalCaseSeeder` creates 22 demo cases (`CASE-1001` … `CASE-1022`).

## Web routes

| Method | URI              | Action                               | Access        |
| ------ | ---------------- | ------------------------------------ | ------------- |
| GET    | `/`              | Redirect to dashboard or login       | Public        |
| GET    | `/login`         | Login form                           | Guest         |
| POST   | `/login`         | Authenticate                         | Guest         |
| POST   | `/logout`        | Log out                              | Authenticated |
| GET    | `/dashboard`     | Metrics + recent cases               | Authenticated |
| —      | `/cases`         | Resource CRUD (index/create/store…)  | Authenticated |

## API endpoints

All API responses use the envelope `{ "success": bool, "data": mixed, "message": string }`.

| Method       | URI                    | Description                       | Access        |
| ------------ | ---------------------- | --------------------------------- | ------------- |
| POST         | `/api/login`           | Issue a Sanctum token             | Public        |
| POST         | `/api/logout`          | Revoke the current token          | Authenticated |
| GET          | `/api/user`            | Current authenticated user        | Authenticated |
| GET          | `/api/cases`           | Paginated / filtered list         | Authenticated |
| GET          | `/api/cases/options`   | Valid status & priority values    | Authenticated |
| POST         | `/api/cases`           | Create a case                     | Admin         |
| GET          | `/api/cases/{id}`      | Show a single case                | Authenticated |
| PUT/PATCH    | `/api/cases/{id}`      | Update a case                     | Admin         |
| DELETE       | `/api/cases/{id}`      | Delete a case                     | Admin         |

`GET /api/cases` accepts `case_number`, `surgeon_name`, `status`, `priority`,
`page` and `per_page` (1–50, default 10) query parameters.

## Testing

The suite covers authentication, case CRUD, filtering, validation and
role-based authorization for both the web and API surfaces.

```bash
php artisan test
```

`phpunit.xml` is configured for a MySQL test database on port 3307. To run the
suite without MySQL, point it at in-memory SQLite:

```powershell
$env:DB_CONNECTION='sqlite'; $env:DB_DATABASE=':memory:'; php artisan test
```

## License

Released under the [MIT license](https://opensource.org/licenses/MIT).
