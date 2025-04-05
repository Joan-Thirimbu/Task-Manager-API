# 📝 Task Management API

A simple Laravel-based REST API for managing user tasks with authentication, authorization, and soft deletes.

## Features
- User Registration & Login (via Laravel Sanctum)
- Task CRUD (Create, Read, Update, Delete)
- Soft Deletes and Restore
- Permanent Delete
- Filter tasks by status
- Pagination support
- Role-based access (admin vs regular users)

## 🚀 Setup Instructions

### Prerequisites
- PHP >= 8.1
- Composer
- MySQL or compatible database
- Laravel 10+

### Installation
```bash
git clone <repo-url>
cd task-manager-api
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
```

Update your `.env` with the correct database credentials.

### Run the server
```bash
php artisan serve
```

## 🔐 Authentication
This API uses Laravel Sanctum for authentication.

### Register
`POST /api/register`
```json
{
  "name": "Joan Thirimbu",
  "email": "joan@example.com",
  "password": "password",
  "password_confirmation": "password"
}
```

### Login
`POST /api/login`
```json
{
  "email": "joan@example.com",
  "password": "password"
}
```
Returns a bearer token to be used in all authenticated requests.

### Logout
`POST /api/logout`

## 📋 Tasks Endpoints

All task routes require authentication.

### List Tasks
`GET /api/tasks`
Optional query params: `status=pending|completed`

### View Single Task
`GET /api/tasks/{id}`

### Create Task
`POST /api/tasks`
```json
{
  "title": "Finish API",
  "description": "Build out Laravel API",
  "status": "pending"
}
```

### Update Task
`PUT /api/tasks/{id}`
```json
{
  "title": "Update Project",
  "status": "completed"
}
```

### Soft Delete Task
`DELETE /api/tasks/{id}`

### View Trashed Tasks
`GET /api/tasks/trashed`

### Restore Task
`PUT /api/tasks/{id}/restore`

### Permanently Delete Task
`DELETE /api/tasks/{id}/force`

## 🧪 Role-Based Access
- Regular users can only manage their own tasks.
- Admins can view and manage all tasks and users.

### Seeder Users
Seeder includes sample regular and admin users:

- Admin:
  - email: `joan@example.com`
  - password: `password`

- User:
  - email: `user@example.com`
  - password: `password`

## 📬 API Testing with Postman
A Postman collection is included in the project under `postman/Task Manager API.postman_collection.json`.

## 🧑‍💻 Author
Built by Joan Thirimbu

