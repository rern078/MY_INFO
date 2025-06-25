<?php

/**
 * Example: How to integrate SEO metadata into your pages
 * This shows how to use the SEO helper in your login and register pages
 */

require_once 'config.php';
require_once 'seo_helper.php';

// Initialize SEO helper
$seoHelper = new SEOHelper($pdo);

// Example for login.php
function loginPageWithSEO()
{
      global $seoHelper;

      // Track page view
      $seoHelper->trackPageView('login', $_SERVER['HTTP_REFERER'] ?? '');

      // Generate meta tags
      $metaTags = $seoHelper->generateMetaTags('login');

      // Your HTML head section
?>
      <!DOCTYPE html>
      <html lang="en">

      <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <?php echo $metaTags; ?>

            <!-- Your CSS and other head elements -->
            <link rel="stylesheet" href="styles/style.css">
      </head>

      <body>
            <!-- Your login page content -->
            <div class="login-container">
                  <h1>Login to Portfolio System</h1>
                  <!-- Login form content -->
            </div>
      </body>

      </html>
<?php
}

// Example for register.php
function registerPageWithSEO()
{
      global $seoHelper;

      // Track page view
      $seoHelper->trackPageView('register', $_SERVER['HTTP_REFERER'] ?? '');

      // Generate meta tags
      $metaTags = $seoHelper->generateMetaTags('register');

      // Your HTML head section
?>
      <!DOCTYPE html>
      <html lang="en">

      <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <?php echo $metaTags; ?>

            <!-- Your CSS and other head elements -->
            <link rel="stylesheet" href="styles/style.css">
      </head>

      <body>
            <!-- Your register page content -->
            <div class="register-container">
                  <h1>Create Your Portfolio Account</h1>
                  <!-- Registration form content -->
            </div>
      </body>

      </html>
<?php
}

// Example: How to modify your existing header.php
function headerWithSEO($page_url)
{
      global $seoHelper;

      // Track page view
      $seoHelper->trackPageView($page_url, $_SERVER['HTTP_REFERER'] ?? '');

      // Generate meta tags
      $metaTags = $seoHelper->generateMetaTags($page_url);

?>
      <!DOCTYPE html>
      <html lang="en">

      <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <?php echo $metaTags; ?>

            <!-- Your existing CSS and JS includes -->
            <link rel="stylesheet" href="styles/style.css">
            <link rel="stylesheet" href="styles/custom.css">
            <script src="https://kit.fontawesome.com/your-kit-code.js"></script>
      </head>

      <body>
            <!-- Your existing header content -->
      <?php
}

// Example: How to get analytics data in admin panel
function displaySEOAnalytics()
{
      global $seoHelper;

      // Get analytics for login page (last 30 days)
      $loginAnalytics = $seoHelper->getAnalytics('login', 30);

      // Get analytics for register page (last 30 days)
      $registerAnalytics = $seoHelper->getAnalytics('register', 30);

      ?>
            <div class="analytics-dashboard">
                  <h2>SEO Analytics</h2>

                  <div class="analytics-section">
                        <h3>Login Page Analytics (Last 30 Days)</h3>
                        <?php if (!empty($loginAnalytics)): ?>
                              <table class="analytics-table">
                                    <thead>
                                          <tr>
                                                <th>Date</th>
                                                <th>Page Views</th>
                                                <th>Unique Visitors</th>
                                                <th>Bounce Rate</th>
                                                <th>Avg Time (seconds)</th>
                                          </tr>
                                    </thead>
                                    <tbody>
                                          <?php foreach ($loginAnalytics as $data): ?>
                                                <tr>
                                                      <td><?php echo htmlspecialchars($data['date']); ?></td>
                                                      <td><?php echo htmlspecialchars($data['page_views']); ?></td>
                                                      <td><?php echo htmlspecialchars($data['unique_visitors']); ?></td>
                                                      <td><?php echo htmlspecialchars($data['bounce_rate']); ?>%</td>
                                                      <td><?php echo htmlspecialchars($data['avg_time_on_page']); ?></td>
                                                </tr>
                                          <?php endforeach; ?>
                                    </tbody>
                              </table>
                        <?php else: ?>
                              <p>No analytics data available for login page.</p>
                        <?php endif; ?>
                  </div>

                  <div class="analytics-section">
                        <h3>Register Page Analytics (Last 30 Days)</h3>
                        <?php if (!empty($registerAnalytics)): ?>
                              <table class="analytics-table">
                                    <thead>
                                          <tr>
                                                <th>Date</th>
                                                <th>Page Views</th>
                                                <th>Unique Visitors</th>
                                                <th>Bounce Rate</th>
                                                <th>Avg Time (seconds)</th>
                                          </tr>
                                    </thead>
                                    <tbody>
                                          <?php foreach ($registerAnalytics as $data): ?>
                                                <tr>
                                                      <td><?php echo htmlspecialchars($data['date']); ?></td>
                                                      <td><?php echo htmlspecialchars($data['page_views']); ?></td>
                                                      <td><?php echo htmlspecialchars($data['unique_visitors']); ?></td>
                                                      <td><?php echo htmlspecialchars($data['bounce_rate']); ?>%</td>
                                                      <td><?php echo htmlspecialchars($data['avg_time_on_page']); ?></td>
                                                </tr>
                                          <?php endforeach; ?>
                                    </tbody>
                              </table>
                        <?php else: ?>
                              <p>No analytics data available for register page.</p>
                        <?php endif; ?>
                  </div>
            </div>
      <?php
}

// Example: How to update your existing login.php
/*
// In your login.php file, replace the head section with:

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
    <link rel="stylesheet" href="styles/custom.css">
</head>
<body>
    <!-- Your existing login page content -->
*/

// Example: How to update your existing register.php
/*
// In your register.php file, replace the head section with:

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
    <link rel="stylesheet" href="styles/custom.css">
</head>
<body>
    <!-- Your existing register page content -->
*/
      ?>