<?php

/**
 * SEO Helper Functions
 * Provides functions to manage and display SEO metadata
 */

require_once 'config.php';

class SEOHelper
{
      private $pdo;

      public function __construct($pdo)
      {
            $this->pdo = $pdo;
      }

      /**
       * Get SEO metadata for a specific page
       * @param string $page_url The page URL identifier
       * @return array|false SEO metadata array or false if not found
       */
      public function getPageSEO($page_url)
      {
            try {
                  $stmt = $this->pdo->prepare("
                SELECT * FROM seo_metadata 
                WHERE page_url = ? AND is_active = 1
            ");
                  $stmt->execute([$page_url]);
                  return $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                  error_log("SEO Error: " . $e->getMessage());
                  return false;
            }
      }

      /**
       * Get default SEO settings
       * @return array Default SEO settings
       */
      public function getDefaultSettings()
      {
            try {
                  $stmt = $this->pdo->prepare("
                SELECT setting_key, setting_value 
                FROM seo_settings 
                WHERE is_active = 1
            ");
                  $stmt->execute();
                  $settings = [];
                  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $settings[$row['setting_key']] = $row['setting_value'];
                  }
                  return $settings;
            } catch (PDOException $e) {
                  error_log("SEO Settings Error: " . $e->getMessage());
                  return [];
            }
      }

      /**
       * Generate HTML meta tags for a page
       * @param string $page_url The page URL identifier
       * @return string HTML meta tags
       */
      public function generateMetaTags($page_url)
      {
            $seo = $this->getPageSEO($page_url);
            $settings = $this->getDefaultSettings();

            if (!$seo) {
                  // Use default settings if no specific SEO data found
                  $seo = [
                        'page_title' => $settings['site_name'] ?? 'Portfolio System',
                        'meta_description' => $settings['site_description'] ?? 'Professional CV and Portfolio Management System',
                        'meta_keywords' => $settings['site_keywords'] ?? 'CV, portfolio, resume, professional',
                        'meta_author' => 'Chamrern S.',
                        'robots' => 'index, follow',
                        'language' => 'en',
                        'theme_color' => '#007bff'
                  ];
            }

            $html = '';

            // Basic meta tags
            $html .= '<title>' . htmlspecialchars($seo['page_title']) . '</title>' . "\n";
            $html .= '<meta name="description" content="' . htmlspecialchars($seo['meta_description']) . '">' . "\n";
            $html .= '<meta name="keywords" content="' . htmlspecialchars($seo['meta_keywords']) . '">' . "\n";
            $html .= '<meta name="author" content="' . htmlspecialchars($seo['meta_author']) . '">' . "\n";
            $html .= '<meta name="robots" content="' . htmlspecialchars($seo['robots']) . '">' . "\n";
            $html .= '<meta name="language" content="' . htmlspecialchars($seo['language']) . '">' . "\n";

            // Open Graph tags
            if (isset($seo['og_title'])) {
                  $html .= '<meta property="og:title" content="' . htmlspecialchars($seo['og_title']) . '">' . "\n";
            }
            if (isset($seo['og_description'])) {
                  $html .= '<meta property="og:description" content="' . htmlspecialchars($seo['og_description']) . '">' . "\n";
            }
            if (isset($seo['og_image'])) {
                  $html .= '<meta property="og:image" content="' . htmlspecialchars($seo['og_image']) . '">' . "\n";
            }
            if (isset($seo['og_type'])) {
                  $html .= '<meta property="og:type" content="' . htmlspecialchars($seo['og_type']) . '">' . "\n";
            }
            if (isset($seo['og_site_name'])) {
                  $html .= '<meta property="og:site_name" content="' . htmlspecialchars($seo['og_site_name']) . '">' . "\n";
            }
            if (isset($seo['og_locale'])) {
                  $html .= '<meta property="og:locale" content="' . htmlspecialchars($seo['og_locale']) . '">' . "\n";
            }

            // Twitter Card tags
            if (isset($seo['twitter_card'])) {
                  $html .= '<meta name="twitter:card" content="' . htmlspecialchars($seo['twitter_card']) . '">' . "\n";
            }
            if (isset($seo['twitter_title'])) {
                  $html .= '<meta name="twitter:title" content="' . htmlspecialchars($seo['twitter_title']) . '">' . "\n";
            }
            if (isset($seo['twitter_description'])) {
                  $html .= '<meta name="twitter:description" content="' . htmlspecialchars($seo['twitter_description']) . '">' . "\n";
            }
            if (isset($seo['twitter_image'])) {
                  $html .= '<meta name="twitter:image" content="' . htmlspecialchars($seo['twitter_image']) . '">' . "\n";
            }
            if (isset($seo['twitter_site'])) {
                  $html .= '<meta name="twitter:site" content="' . htmlspecialchars($seo['twitter_site']) . '">' . "\n";
            }

            // Canonical URL
            if (isset($seo['canonical_url'])) {
                  $html .= '<link rel="canonical" href="' . htmlspecialchars($seo['canonical_url']) . '">' . "\n";
            }

            // Theme color
            if (isset($seo['theme_color'])) {
                  $html .= '<meta name="theme-color" content="' . htmlspecialchars($seo['theme_color']) . '">' . "\n";
            }

            return $html;
      }

      /**
       * Track page view for analytics
       * @param string $page_url The page URL
       * @param string $referrer The referring URL
       */
      public function trackPageView($page_url, $referrer = '')
      {
            try {
                  $date = date('Y-m-d');

                  // Check if analytics record exists for today
                  $stmt = $this->pdo->prepare("
                SELECT id, page_views, unique_visitors 
                FROM seo_analytics 
                WHERE page_url = ? AND date = ?
            ");
                  $stmt->execute([$page_url, $date]);
                  $existing = $stmt->fetch(PDO::FETCH_ASSOC);

                  if ($existing) {
                        // Update existing record
                        $stmt = $this->pdo->prepare("
                    UPDATE seo_analytics 
                    SET page_views = page_views + 1,
                        updated_at = NOW()
                    WHERE id = ?
                ");
                        $stmt->execute([$existing['id']]);
                  } else {
                        // Create new record
                        $stmt = $this->pdo->prepare("
                    INSERT INTO seo_analytics 
                    (page_url, page_views, unique_visitors, date, referring_domains, created_at, updated_at)
                    VALUES (?, 1, 1, ?, ?, NOW(), NOW())
                ");
                        $stmt->execute([$page_url, $date, $referrer]);
                  }
            } catch (PDOException $e) {
                  error_log("Analytics Error: " . $e->getMessage());
            }
      }

      /**
       * Get analytics data for a page
       * @param string $page_url The page URL
       * @param int $days Number of days to look back
       * @return array Analytics data
       */
      public function getAnalytics($page_url, $days = 30)
      {
            try {
                  $stmt = $this->pdo->prepare("
                SELECT * FROM seo_analytics 
                WHERE page_url = ? AND date >= DATE_SUB(CURDATE(), INTERVAL ? DAY)
                ORDER BY date DESC
            ");
                  $stmt->execute([$page_url, $days]);
                  return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                  error_log("Analytics Error: " . $e->getMessage());
                  return [];
            }
      }
}

// Usage example:
// $seoHelper = new SEOHelper($pdo);
// echo $seoHelper->generateMetaTags('login');
// $seoHelper->trackPageView('login', $_SERVER['HTTP_REFERER'] ?? '');
