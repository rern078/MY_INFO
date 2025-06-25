# SEO Metadata System for Portfolio

This document explains how to use the SEO metadata system for your portfolio website, specifically for login and register pages.

## Files Created/Modified

1. **`db/cv_portfolio.sql`** - Updated with SEO metadata for login and register pages
2. **`db/add_login_register_seo.sql`** - Standalone SQL script to add SEO data
3. **`seo_helper.php`** - PHP helper class for managing SEO metadata
4. **`example_seo_integration.php`** - Examples of how to integrate SEO into your pages

## Database Structure

### SEO Metadata Table
The `seo_metadata` table contains SEO information for each page:

- **page_url**: Page identifier (e.g., 'login', 'register')
- **page_title**: Page title for browser tab
- **meta_description**: Description for search engines
- **meta_keywords**: Keywords for SEO
- **og_title/og_description**: Open Graph tags for social media
- **twitter_title/twitter_description**: Twitter Card tags
- **robots**: Search engine crawling instructions
- **canonical_url**: Canonical URL for the page

### SEO Analytics Table
The `seo_analytics` table tracks page performance:

- **page_views**: Number of page views
- **unique_visitors**: Number of unique visitors
- **bounce_rate**: Percentage of visitors who leave immediately
- **avg_time_on_page**: Average time spent on page
- **search_keywords**: Keywords that brought visitors
- **referring_domains**: Where visitors came from

## Installation Steps

### 1. Update Database
Run the SQL script to add SEO metadata:

```sql
-- Option 1: Run the standalone script
mysql -u your_username -p your_database < db/add_login_register_seo.sql

-- Option 2: Import the updated cv_portfolio.sql file
mysql -u your_username -p your_database < db/cv_portfolio.sql
```

### 2. Add SEO Helper to Your Project
Copy `seo_helper.php` to your project root directory.

### 3. Update Your Pages

#### For Login Page (`login.php`):
```php
<?php
require_once 'config.php';
require_once 'seo_helper.php';

$seoHelper = new SEOHelper($pdo);
$seoHelper->trackPageView('login', $_SERVER['HTTP_REFERER'] ?? '');
$metaTags = $seoHelper->generateMetaTags('login');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo $metaTags; ?>
    
    <!-- Your existing CSS and JS includes -->
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <!-- Your existing login page content -->
</body>
</html>
```

#### For Register Page (`register.php`):
```php
<?php
require_once 'config.php';
require_once 'seo_helper.php';

$seoHelper = new SEOHelper($pdo);
$seoHelper->trackPageView('register', $_SERVER['HTTP_REFERER'] ?? '');
$metaTags = $seoHelper->generateMetaTags('register');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo $metaTags; ?>
    
    <!-- Your existing CSS and JS includes -->
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <!-- Your existing register page content -->
</body>
</html>
```

## SEO Metadata Added

### Login Page SEO:
- **Title**: "Login - Portfolio System"
- **Description**: "Secure login page for accessing your personal portfolio dashboard. Manage your CV, certificates, and professional information."
- **Keywords**: "login, sign in, portfolio system, user authentication, secure access, dashboard login"
- **Robots**: "noindex, nofollow" (prevents search engine indexing for security)

### Register Page SEO:
- **Title**: "Register - Create Portfolio Account"
- **Description**: "Create a new account to build and manage your professional portfolio. Start showcasing your skills, experience, and achievements."
- **Keywords**: "register, sign up, create account, portfolio system, new user, professional portfolio"
- **Robots**: "noindex, nofollow" (prevents search engine indexing for security)

## Features

### 1. Automatic Meta Tag Generation
The SEO helper automatically generates all necessary meta tags:
- Basic SEO tags (title, description, keywords)
- Open Graph tags for social media
- Twitter Card tags
- Canonical URLs
- Theme colors

### 2. Page Analytics Tracking
Automatically tracks:
- Page views
- Unique visitors
- Bounce rates
- Time on page
- Referring domains

### 3. Fallback System
If no specific SEO data is found for a page, the system uses default settings from `seo_settings` table.

## Usage Examples

### Get SEO Data for a Page:
```php
$seoHelper = new SEOHelper($pdo);
$seoData = $seoHelper->getPageSEO('login');
if ($seoData) {
    echo "Page Title: " . $seoData['page_title'];
}
```

### Generate Meta Tags:
```php
$metaTags = $seoHelper->generateMetaTags('login');
echo $metaTags; // Outputs all HTML meta tags
```

### Track Page View:
```php
$seoHelper->trackPageView('login', $_SERVER['HTTP_REFERER'] ?? '');
```

### Get Analytics:
```php
$analytics = $seoHelper->getAnalytics('login', 30); // Last 30 days
foreach ($analytics as $data) {
    echo "Date: " . $data['date'] . ", Views: " . $data['page_views'];
}
```

## Security Considerations

1. **Login/Register pages use `noindex, nofollow`** to prevent search engines from indexing sensitive pages
2. **Analytics tracking is lightweight** and doesn't collect personal information
3. **SQL injection protection** through prepared statements
4. **Error logging** for debugging without exposing sensitive data

## Customization

### Adding SEO for New Pages:
1. Add a new record to `seo_metadata` table
2. Use the page URL as the `page_url` identifier
3. Set appropriate meta tags and descriptions
4. Choose appropriate `robots` directive

### Modifying Existing SEO:
```sql
UPDATE seo_metadata 
SET page_title = 'New Title',
    meta_description = 'New description'
WHERE page_url = 'login';
```

### Adding Analytics to Admin Panel:
Use the `displaySEOAnalytics()` function from `example_seo_integration.php` to show analytics in your admin panel.

## Troubleshooting

### Common Issues:

1. **Meta tags not showing**: Check if `seo_helper.php` is included and `$pdo` connection is working
2. **Analytics not tracking**: Verify database permissions and table structure
3. **SEO data not found**: Check if the `page_url` matches exactly in the database

### Debug Mode:
Add error logging to see what's happening:
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

## Performance Notes

- SEO helper uses prepared statements for security
- Analytics tracking is asynchronous and lightweight
- Meta tag generation is cached in memory during page load
- Database queries are optimized with proper indexing

## Support

For issues or questions:
1. Check the error logs
2. Verify database connectivity
3. Ensure all required files are included
4. Test with the example integration code 