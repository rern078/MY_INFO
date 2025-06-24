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

<!-- Additional SEO Meta Tags -->
<meta name="theme-color" content="#007bff">
<meta name="msapplication-TileColor" content="#007bff">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<meta name="apple-mobile-web-app-title" content="Portfolio System">

<!-- Canonical URL -->
<link rel="canonical" href="<?php echo isset($page_url) ? $page_url : (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">

<!-- Favicon -->
<link rel="icon" type="image/x-icon" href="/favicon.ico">
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">

<!-- Stylesheets -->
<link rel="stylesheet" href="styles/style.css?v=<?php echo time(); ?>">
<link rel="stylesheet" href="styles/custom.css?v=<?php echo time(); ?>">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>