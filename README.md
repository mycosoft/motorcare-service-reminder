# Motorcare Service Reminder System

A Laravel-based vehicle service management system designed for automotive service centers in Uganda. Track customers, vehicles, service schedules, and send automated reminder notifications.

## Features

### Dashboard
- Welcome greeting with current date
- Overview cards: Total Customers, Registered Vehicles, Upcoming Services, Overdue Services
- Quick action buttons for common tasks
- Overdue services alert section
- Monthly service trends chart
- Service types distribution pie chart
- Recently added customers list

### Customer Management
- Full CRUD operations for customers
- Search by name, email, phone, address
- Filter by status (active/inactive)
- View customer details with associated vehicles

### Vehicle Management
- Full CRUD operations for vehicles
- Search by make, model, registration number, VIN
- Filter by customer
- Track last service date and next service date
- View complete service history per vehicle

### Service Records
- Log completed services with cost tracking
- Search by vehicle, service type
- Filter by status and date range
- Track service history per vehicle

### Service Scheduling
- Schedule upcoming services for vehicles
- Track expected mileage at service
- Status tracking: Pending, Notified, Confirmed, Completed, Cancelled
- Overdue services detection and view
- Send reminder notifications to customers

### Service Types
- Define service types with base pricing
- Set estimated hours for each service
- Activate/deactivate service types

### Roles & Permissions
- Role-based access control (Admin, Staff, etc.)
- Granular permission system
- Assign permissions to roles
- Assign roles to users

### Settings
- Database-backed settings storage
- General settings management
- System configuration options

### Reminder Notifications
- Send SMS/Email reminders for upcoming services
- Track notification attempts
- Last notification timestamp per schedule

## Modules

| Module | Description |
|--------|-------------|
| Customers | Manage customer accounts and contact information |
| Vehicles | Track vehicles with make, model, year, registration, VIN |
| Services | Record completed services with cost and date |
| Service Schedules | Schedule future services and track overdue items |
| Service Types | Define service categories with pricing |
| Roles | Role definitions with associated permissions |
| Permissions | Permission definitions for access control |
| Settings | System-wide configuration storage |

## Tech Stack

- **Framework:** Laravel 10.x
- **Frontend:** AdminLTE 3.x, Bootstrap 4.x, Chart.js
- **Database:** MySQL/MariaDB
- **Authentication:** Laravel Breeze

## Installation

1. Clone the repository:
```bash
git clone https://github.com/mycosoft/motorcare-service-reminder.git
cd motorcare-service-reminder
```

2. Install dependencies:
```bash
composer install
npm install
```

3. Copy environment file:
```bash
cp .env.example .env
```

4. Generate application key:
```bash
php artisan key:generate
```

5. Configure database in `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=motorcare_service_reminder
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

6. Run migrations and seeders:
```bash
php artisan migrate:fresh --seed
```

7. Create admin user:
```bash
php artisan make:user-admin
```

8. Start the development server:
```bash
php artisan serve
```

## Default Credentials

After running seeders and creating admin user:
- **Email:** admin@motorcare.com
- **Password:** password

## Usage

### Dashboard
Access the dashboard at `/dashboard` after login to see:
- Service overview statistics
- Overdue services alerts
- Upcoming service reminders
- Monthly service trends

### Managing Customers
1. Navigate to Customers from sidebar
2. Click "Add Customer" for new entries
3. Use search and filters to find customers
4. Click customer name to view details

### Scheduling Services
1. Go to Service Schedules
2. Click "Schedule New Service"
3. Select vehicle and service type
4. Set scheduled date and expected mileage
5. Save to create schedule

### Sending Reminders
1. Go to Service Schedules
2. Find a schedule without recent notification
3. Click the bell icon to send reminder
4. Or use "Send Reminders" quick action from dashboard

## Data Seeding

The system seeds with:
- **Permissions:** 33 system permissions
- **Roles:** Admin and Staff with appropriate permissions
- **Sample Customers:** Ugandan names (John Muwonge, Sarah Nansubuga)
- **Sample Vehicles:** Various Ugandan vehicle registrations
- **Service Types:** Oil Change, Tire Rotation, Full Service, etc.
- **Service Records:** Historical service data

## License

This project is open-sourced software.