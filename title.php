<?php
// Fetch SEO metadata for the current page
if (!isset($page_title) || !isset($page_description) || !isset($page_keywords) || !isset($page_author) || !isset($page_url) || !isset($page_image)) {
      // Determine the current page URL for matching
      $request_uri = $_SERVER['REQUEST_URI'];
      $script_name = $_SERVER['SCRIPT_NAME'];
      $page_url = $request_uri;

      // Normalize homepage to '/'
      if ($script_name === '/index.php' || $request_uri === '/index.php' || $request_uri === '/') {
            $page_url = '/';
      } elseif (strpos($request_uri, '?') !== false) {
            $page_url = strtok($request_uri, '?');
      }

      // Remove leading slash and .php extension for database matching
      $db_page_url = ltrim($page_url, '/');
      $db_page_url = str_replace('.php', '', $db_page_url);

      // Try to fetch SEO metadata for this page (with error handling)
      try {
            if (isset($conn) && $conn) {
                  $stmt = mysqli_prepare($conn, "SELECT * FROM seo_metadata WHERE page_url = ? AND is_active = 1 LIMIT 1");
                  if ($stmt) {
                        mysqli_stmt_bind_param($stmt, 's', $db_page_url);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        if ($row = mysqli_fetch_assoc($result)) {
                              if (!isset($page_title)) $page_title = $row['page_title'];
                              if (!isset($page_description)) $page_description = $row['meta_description'];
                              if (!isset($page_keywords)) $page_keywords = $row['meta_keywords'];
                              if (!isset($page_author)) $page_author = $row['meta_author'];
                              if (!isset($page_url)) $page_url = $row['canonical_url'] ?: $row['page_url'];
                              if (!isset($page_image)) $page_image = $row['og_image'];
                              if (!isset($og_title)) $og_title = $row['og_title'];
                              if (!isset($og_description)) $og_description = $row['og_description'];
                              if (!isset($og_type)) $og_type = $row['og_type'];
                              if (!isset($og_site_name)) $og_site_name = $row['og_site_name'];
                              if (!isset($og_locale)) $og_locale = $row['og_locale'];
                              if (!isset($twitter_card)) $twitter_card = $row['twitter_card'];
                              if (!isset($twitter_title)) $twitter_title = $row['twitter_title'];
                              if (!isset($twitter_description)) $twitter_description = $row['twitter_description'];
                              if (!isset($twitter_image)) $twitter_image = $row['twitter_image'];
                              if (!isset($twitter_site)) $twitter_site = $row['twitter_site'];
                              if (!isset($robots)) $robots = $row['robots'];
                              if (!isset($language)) $language = $row['language'];
                              if (!isset($theme_color)) $theme_color = $row['theme_color'];
                        }
                        mysqli_stmt_close($stmt);
                  }
            }
      } catch (Exception $e) {
            // Silently handle database errors for SEO metadata
            error_log("SEO metadata error: " . $e->getMessage());
      }
}
?>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo isset($page_title) ? $page_title : t('cv'); ?></title>

<!-- SEO Meta Tags -->
<meta name="description" content="<?php echo isset($page_description) ? $page_description : 'Professional CV and Portfolio Management System'; ?>">
<meta name="keywords" content="<?php echo isset($page_keywords) ? $page_keywords : 'CV, portfolio, resume, professional, career, skills, experience'; ?>">
<meta name="author" content="<?php echo isset($page_author) ? $page_author : 'Portfolio System'; ?>">
<meta name="robots" content="index, follow">
<meta name="language" content="English">
<meta name="revisit-after" content="7 days">
<meta name="distribution" content="global">
<meta name="rating" content="general">

<!-- Open Graph Meta Tags -->
<meta property="og:title" content="<?php echo isset($page_title) ? $page_title : t('cv'); ?>">
<meta property="og:description" content="<?php echo isset($page_description) ? $page_description : 'Professional CV and Portfolio Management System'; ?>">
<meta property="og:type" content="website">
<meta property="og:url" content="<?php echo isset($page_url) ? $page_url : (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
<meta property="og:image" content="<?php echo isset($page_image) ? $page_image : (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/images/og-image.jpg'; ?>">
<meta property="og:site_name" content="Portfolio System">
<meta property="og:locale" content="en_US">

<!-- Twitter Card Meta Tags -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo isset($page_title) ? $page_title : t('cv'); ?>">
<meta name="twitter:description" content="<?php echo isset($page_description) ? $page_description : 'Professional CV and Portfolio Management System'; ?>">
<meta name="twitter:image" content="<?php echo isset($page_image) ? $page_image : (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/images/twitter-image.jpg'; ?>">
<meta name="twitter:site" content="@portfoliosystem">

<!-- Canonical URL -->
<link rel="canonical" href="<?php echo isset($page_url) ? $page_url : (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">

<!-- Favicon -->
<link rel="icon" type="image/x-icon" href="/images/chamrern.ico">
<link rel="apple-touch-icon" sizes="180x180" href="/images/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/images/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/images/favicon-16x16.png">

<!-- Stylesheets -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="styles/style.css?v=<?php echo time(); ?>">
<link rel="stylesheet" href="styles/custom.css?v=<?php echo time(); ?>">
<script src="styles/js/custom.js?v=<?php echo time(); ?>"></script>

<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>