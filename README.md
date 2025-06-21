# CV Portfolio System

A comprehensive CV and cover letter management system with certificate management capabilities.

## Features

- **CV Management**: Create and manage professional CVs
- **Cover Letter Management**: Generate and customize cover letters
- **Certificate Management**: Upload and manage professional certificates
- **PDF Generation**: Export CV and cover letters as PDF
- **User Management**: Admin and regular user roles
- **Clean URLs**: Modern URL structure without .php extensions

## URL Structure

The system uses clean URLs for better user experience:

- `/` - Home/CV page
- `/cover-letter` - Cover letter page
- `/certificates` - Certificates management page
- `/admin` - Admin panel (admin users only)
- `/dashboard` - User dashboard
- `/login` - Login page
- `/register` - Registration page
- `/generate-pdf` - PDF generation

## Requirements

- PHP 7.4 or higher
- MySQL/MariaDB
- Apache web server with mod_rewrite enabled
- Composer (for TCPDF dependency)

## Installation

1. Clone or download the project files
2. Configure your database settings in `config.php`
3. Import the database schema from `sample_data.sql`
4. Install dependencies: `composer install`
5. Ensure Apache mod_rewrite is enabled
6. Set proper permissions on the `uploads/` directory

## Configuration

The `.htaccess` file handles URL rewriting to remove `.php` extensions. Make sure your Apache server has `mod_rewrite` enabled.

## Usage

1. Register a new account or use the default admin account (username: `chamrern`)
2. Log in to access the system
3. Use the admin panel to set up personal information, company details, and cover letter content
4. Upload certificates through the certificates page
5. View your CV and cover letter
6. Generate PDF versions for download

## Security Features

- Session-based authentication
- Input sanitization
- File upload restrictions
- Admin-only access to management functions
- Protected configuration files

## File Structure

```
CV/
├── .htaccess              # URL rewriting rules
├── config.php             # Database configuration
├── index.php              # CV display page
├── cover-letter.php       # Cover letter page
├── certificates.php       # Certificate management
├── admin.php              # Admin panel
├── user_dashboard.php     # User dashboard
├── login.php              # Login page
├── register.php           # Registration page
├── generate_pdf.php       # PDF generation
├── styles/
│   └── style.css          # Custom styles
├── uploads/
│   └── certificates/      # Certificate uploads
└── vendor/                # Composer dependencies
```
