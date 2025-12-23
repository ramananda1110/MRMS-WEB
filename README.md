# 🖥️ Meeting Room Booking Management System – Backend (Laravel)
📌 Project Overview

**Space Book** is a cross-platform mobile application built with Flutter and powered by a PHP Laravel backend.
The system is designed to efficiently manage meeting room reservations within an organization by allowing users to:  

This project is the **backend service** for the **Meeting Room Booking Management System**, developed using PHP Laravel.
It provides secure **RESTful APIs** for managing users, meeting rooms, bookings, and notifications, and serves as the central data and business logic layer for the Flutter mobile application.

--- 

## 🛠️ Technology Stack

- PHP (Laravel Framework)
- MySQL / PostgreSQL – Relational database
- Laravel Sanctum / Passport – API authentication
- RESTful APIs – Client-server communication
- Firebase Cloud Messaging (FCM) – Push notifications
- Composer – Dependency management

 #### ⚙️ Installation & Setup

 Prerequisites
- PHP >= 8.0
- Composer
- MySQL / PostgreSQL
- Laravel CLI

Setup Steps

```bash
git clone https://github.com/ramananda1110/MRMS-WEB.git
cd meeting-room-backend
composer install
cp .env.example .env
php artisan key:generate
```
Configure database credentials in .env.

## Run Migrations
```bash
php artisan migrate
```
## Start Server
```bash
php artisan serve
```
## API will be available at:
```bash
http://127.0.0.1:8000/api
```

## 📂 Key Features

- User authentication & authorization
- Meeting room management
- Booking creation, update & cancellation
- Conflict-free scheduling logic
- API support for mobile applications
- Secure and scalable architecture


## Author / Contact

Ramananda Sarkar<br/>
Email: rshc4u@gmail.com<br/>
Mobile: +8801738039685
  
