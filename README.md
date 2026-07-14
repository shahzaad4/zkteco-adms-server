# ZKTeco ADMS Server

A Laravel-based Attendance Device Management System (ADMS) for managing ZKTeco biometric devices over the iClock protocol.

The application provides centralized device communication, attendance synchronization, employee management, reporting, and administrative tools for organizations operating multiple biometric devices.

---

## Overview

This project acts as an ADMS server between ZKTeco biometric devices and a centralized database.

It supports both real-time attendance synchronization and on-demand data retrieval through device commands while providing a web interface for administrators to monitor devices, manage employee data, and generate attendance reports.

---

## Core Features

- Real-time attendance synchronization
- Attendance log import through device commands
- Employee (device user) synchronization
- Device status monitoring
- Attendance reporting
- Check-In / Check-Out visualization
- Employee name mapping
- Excel export
- Device log viewer
- Fingerprint log management
- Multi-device support
- Search and filtering

---

## Screenshots

### Dashboard

![Dashboard](screenshots/dashboard.png)

### Devices

![Devices](screenshots/devices.png)

### Attendance

![Attendance](screenshots/attendance.png)

### Attendance Report

![Attendance Report](screenshots/attendance-report.png)

### Device Users

![Device Users](screenshots/device-users.png)

### Device Logs

![Device Logs](screenshots/device-logs.png)

---

## Technology Stack

| Component | Technology |
|-----------|------------|
| Framework | Laravel |
| Language | PHP 8 |
| Database | MySQL / MariaDB |
| Frontend | Blade, Bootstrap 5 |
| Export | Laravel Excel |
| Device Protocol | ZKTeco iClock |

---

## Installation

Clone the repository.

```bash
git clone https://github.com/shahzaad4/zkteco-adms-server.git
```

Install dependencies.

```bash
composer install
```

Create the environment file.

```bash
cp .env.example .env
```

Generate the application key.

```bash
php artisan key:generate
```

Configure your database inside `.env`.

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=adms
DB_USERNAME=root
DB_PASSWORD=
```

Run the migrations.

```bash
php artisan migrate
```

Start the development server.

```bash
php artisan serve
```

---

## Project Structure

```
app/
bootstrap/
config/
database/
public/
resources/
routes/
storage/
```

---

## Screens Included

- Dashboard
- Device Management
- Attendance Logs
- Attendance Report
- Device Users
- Device Logs

---

## Future Improvements

- Role-based authentication
- Department management
- Shift scheduling
- Overtime calculation
- REST API
- Mobile dashboard
- Docker deployment
- Odoo integration

---

## License

This project is licensed under the MIT License.
