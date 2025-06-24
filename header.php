<?php
// Include language system
require_once 'languages.php';

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
$username = $_SESSION['username'] ?? '';

// Get current page name
$current_page = basename($_SERVER['PHP_SELF'], '.php');

// Get current language info
$current_lang = getCurrentLanguage();
$available_langs = getAvailableLanguages();
?>

<!-- User Header -->
<?php if ($isLoggedIn): ?>
      <div class="user-header bg-primary text-white py-3 mb-4">
            <div class="container">
                  <div class="row align-items-center justify-content-between">
                        <div class="col-auto">
                              <div class="d-flex align-items-center">
                                    <i class="fas fa-user-circle me-3 fs-3"></i>
                                    <div>
                                          <span class="fw-bold fs-5"><?php echo t('welcome'); ?>, <?php echo htmlspecialchars($username); ?>!</span>
                                          <div class="small opacity-75"><?php echo t('successfully_logged_in'); ?></div>
                                    </div>
                              </div>
                        </div>
                        <div class="col-auto">
                              <div class="d-flex justify-content-end align-items-center">
                                    <!-- Language Switcher -->
                                    <div class="language-switcher me-3">
                                          <div class="language-btn" id="languageBtn">
                                                <span class="flag"><?php echo $current_lang['flag']; ?></span>
                                                <span class="name"><?php echo $current_lang['native_name']; ?></span>
                                                <i class="fas fa-chevron-down ms-1"></i>
                                          </div>
                                          <div class="language-dropdown" id="languageDropdown">
                                                <div class="language-dropdown-header">
                                                      <?php echo t('select_language'); ?>
                                                </div>
                                                <?php foreach ($available_langs as $lang_code => $lang_info): ?>
                                                      <a href="?lang=<?php echo $lang_code; ?>"
                                                            class="language-option <?php echo ($lang_code === $current_language) ? 'active' : ''; ?>">
                                                            <span class="flag"><?php echo $lang_info['flag']; ?></span>
                                                            <span class="name"><?php echo $lang_info['name']; ?></span>
                                                            <span class="native-name"><?php echo $lang_info['native_name']; ?></span>
                                                      </a>
                                                <?php endforeach; ?>
                                          </div>
                                    </div>

                                    <!-- Hamburger Menu for Mobile -->
                                    <div class="hamburger-menu me-3" id="hamburgerMenu">
                                          <div class="hamburger-line"></div>
                                          <div class="hamburger-line"></div>
                                          <div class="hamburger-line"></div>
                                    </div>
                                    <a href="login.php?logout=1" class="btn btn-outline-light btn-sm btn-logout">
                                          <i class="fas fa-sign-out-alt me-1"></i><?php echo t('logout'); ?>
                                    </a>
                              </div>
                        </div>
                  </div>
            </div>
      </div>

      <!-- Mobile Navigation Menu -->
      <div class="mobile-nav" id="mobileNav">
            <div class="mobile-close" id="mobileClose"></div>
            <a href="index.php" class="btn <?php echo ($current_page === 'index') ? 'active' : 'btn-outline-primary'; ?>">
                  <i class="fas fa-file-alt me-2"></i><?php echo t('view_sr1'); ?>
            </a>
            <a href="cover-letter.php" class="btn <?php echo ($current_page === 'cover-letter') ? 'active' : 'btn-outline-primary'; ?>">
                  <i class="fas fa-envelope me-2"></i><?php echo t('view_sr2'); ?>
            </a>
            <a href="certificates.php" class="btn <?php echo ($current_page === 'certificates') ? 'active' : 'btn-outline-success'; ?>">
                  <i class="fas fa-certificate me-2"></i><?php echo t('view_certificates'); ?>
            </a>
            <a href="generate_pdf.php?type=cv" class="btn btn-outline-success">
                  <i class="fas fa-download me-2"></i><?php echo t('download_pdf'); ?>
            </a>
            <?php if ($username === 'chamrern'): ?>
                  <a href="admin.php" class="btn <?php echo ($current_page === 'admin') ? 'active' : 'btn-outline-primary'; ?>">
                        <i class="fas fa-cog me-2"></i><?php echo t('admin_panel'); ?>
                  </a>
            <?php else: ?>
                  <a href="user_dashboard.php" class="btn <?php echo ($current_page === 'user_dashboard') ? 'active' : 'btn-outline-primary'; ?>">
                        <i class="fas fa-user me-2"></i><?php echo t('dashboard'); ?>
                  </a>
            <?php endif; ?>
            <a href="login.php?logout=1" class="btn btn-outline-light btn-sm">
                  <i class="fas fa-sign-out-alt me-1"></i><?php echo t('logout'); ?>
            </a>
      </div>

      <!-- Desktop Navigation for logged in users -->
      <div class="container mb-4">
            <div class="nav-buttons text-center">
                  <a href="index.php" class="btn <?php echo ($current_page === 'index') ? 'active' : 'btn-outline-primary'; ?>">
                        <i class="fas fa-file-alt me-2"></i><?php echo t('view_sr1'); ?>
                  </a>
                  <a href="cover-letter.php" class="btn <?php echo ($current_page === 'cover-letter') ? 'active' : 'btn-outline-primary'; ?>">
                        <i class="fas fa-envelope me-2"></i><?php echo t('view_sr2'); ?>
                  </a>
                  <a href="certificates.php" class="btn <?php echo ($current_page === 'certificates') ? 'active' : 'btn-outline-success'; ?>">
                        <i class="fas fa-certificate me-2"></i><?php echo t('view_certificates'); ?>
                  </a>
                  <a href="generate_pdf.php?type=cv" class="btn btn-outline-success">
                        <i class="fas fa-download me-2"></i><?php echo t('download_pdf'); ?>
                  </a>
                  <?php if ($username === 'chamrern'): ?>
                        <a href="admin.php" class="btn <?php echo ($current_page === 'admin') ? 'active' : 'btn-outline-primary'; ?>">
                              <i class="fas fa-cog me-2"></i><?php echo t('admin_panel'); ?>
                        </a>
                  <?php else: ?>
                        <a href="user_dashboard.php" class="btn <?php echo ($current_page === 'user_dashboard') ? 'active' : 'btn-outline-primary'; ?>">
                              <i class="fas fa-user me-2"></i><?php echo t('dashboard'); ?>
                        </a>
                  <?php endif; ?>
            </div>
      </div>
<?php else: ?>
      <!-- Header for non-logged in users -->
      <div class="user-header bg-primary text-white py-3 mb-4">
            <div class="container">
                  <div class="row align-items-center justify-content-between">
                        <div class="col-auto">
                              <div class="d-flex align-items-center">
                                    <i class="fas fa-user-circle me-3 fs-3"></i>
                                    <div>
                                          <span class="fw-bold fs-5"><?php echo t('welcome_guest'); ?></span>
                                          <div class="small opacity-75"><?php echo t('login_to_access'); ?></div>
                                    </div>
                              </div>
                        </div>
                        <div class="col-auto">
                              <div class="d-flex justify-content-end align-items-center">
                                    <!-- Language Switcher -->
                                    <div class="language-switcher me-3">
                                          <div class="language-btn" id="languageBtn">
                                                <span class="flag"><?php echo $current_lang['flag']; ?></span>
                                                <span class="name"><?php echo $current_lang['native_name']; ?></span>
                                                <i class="fas fa-chevron-down ms-1"></i>
                                          </div>
                                          <div class="language-dropdown" id="languageDropdown">
                                                <div class="language-dropdown-header">
                                                      <?php echo t('select_language'); ?>
                                                </div>
                                                <?php foreach ($available_langs as $lang_code => $lang_info): ?>
                                                      <a href="?lang=<?php echo $lang_code; ?>"
                                                            class="language-option <?php echo ($lang_code === $current_language) ? 'active' : ''; ?>">
                                                            <span class="flag"><?php echo $lang_info['flag']; ?></span>
                                                            <span class="name"><?php echo $lang_info['name']; ?></span>
                                                            <span class="native-name"><?php echo $lang_info['native_name']; ?></span>
                                                      </a>
                                                <?php endforeach; ?>
                                          </div>
                                    </div>

                                    <!-- Hamburger Menu for Mobile -->
                                    <div class="hamburger-menu me-3" id="hamburgerMenu">
                                          <div class="hamburger-line"></div>
                                          <div class="hamburger-line"></div>
                                          <div class="hamburger-line"></div>
                                    </div>
                                    <a href="login.php" class="btn btn-outline-light btn-sm btn-login">
                                          <i class="fas fa-sign-in-alt me-1"></i><?php echo t('login'); ?>
                                    </a>
                              </div>
                        </div>
                  </div>
            </div>
      </div>

      <!-- Mobile Navigation Menu for non-logged in users -->
      <div class="mobile-nav" id="mobileNav">
            <div class="mobile-close" id="mobileClose"></div>
            <a href="index.php" class="btn <?php echo ($current_page === 'index') ? 'active' : 'btn-outline-primary'; ?>">
                  <i class="fas fa-file-alt me-2"></i><?php echo t('view_cv'); ?>
            </a>
            <a href="login.php" class="btn <?php echo ($current_page === 'login') ? 'active' : 'btn-outline-primary'; ?>">
                  <i class="fas fa-sign-in-alt me-2"></i><?php echo t('login'); ?>
            </a>
            <a href="register.php" class="btn <?php echo ($current_page === 'register') ? 'active' : 'btn-outline-primary'; ?>">
                  <i class="fas fa-user-plus me-2"></i><?php echo t('register'); ?>
            </a>
      </div>

      <!-- Desktop Navigation for non-logged in users -->
      <!-- <div class="container mb-4">
            <div class="nav-buttons text-center">
                  <a href="login.php" class="btn <?php echo ($current_page === 'login') ? 'active' : 'btn-primary'; ?>">
                        <i class="fas fa-sign-in-alt me-2"></i><?php echo t('login'); ?>
                  </a>
                  <a href="register.php" class="btn <?php echo ($current_page === 'register') ? 'active' : 'btn-outline-primary'; ?>">
                        <i class="fas fa-user-plus me-2"></i><?php echo t('register'); ?>
                  </a>
            </div>
      </div> -->
<?php endif; ?>

<script>
      document.addEventListener('DOMContentLoaded', function() {
            const hamburgerMenu = document.getElementById('hamburgerMenu');
            const mobileNav = document.getElementById('mobileNav');
            const mobileClose = document.getElementById('mobileClose');
            const languageBtn = document.getElementById('languageBtn');
            const languageDropdown = document.getElementById('languageDropdown');

            // Language switcher functionality
            if (languageBtn && languageDropdown) {
                  languageBtn.addEventListener('click', function(e) {
                        e.stopPropagation();
                        languageDropdown.classList.toggle('show');
                  });

                  // Close language dropdown when clicking outside
                  document.addEventListener('click', function(e) {
                        if (!languageBtn.contains(e.target) && !languageDropdown.contains(e.target)) {
                              languageDropdown.classList.remove('show');
                        }
                  });

                  // Close language dropdown when pressing Escape
                  document.addEventListener('keydown', function(e) {
                        if (e.key === 'Escape') {
                              languageDropdown.classList.remove('show');
                        }
                  });
            }

            // Check if hamburger menu exists (for both logged-in and non-logged-in users)
            if (hamburgerMenu && mobileNav && mobileClose) {
                  // Open mobile menu
                  hamburgerMenu.addEventListener('click', function() {
                        hamburgerMenu.classList.add('active');
                        mobileNav.classList.add('active');
                        document.body.style.overflow = 'hidden'; // Prevent background scrolling
                  });

                  // Close mobile menu
                  function closeMobileMenu() {
                        hamburgerMenu.classList.remove('active');
                        mobileNav.classList.remove('active');
                        document.body.style.overflow = ''; // Restore scrolling
                  }

                  mobileClose.addEventListener('click', closeMobileMenu);

                  // Close menu when clicking on a link
                  const mobileNavLinks = mobileNav.querySelectorAll('a');
                  mobileNavLinks.forEach(link => {
                        link.addEventListener('click', closeMobileMenu);
                  });

                  // Close menu when clicking outside
                  mobileNav.addEventListener('click', function(e) {
                        if (e.target === mobileNav) {
                              closeMobileMenu();
                        }
                  });

                  // Close menu on escape key
                  document.addEventListener('keydown', function(e) {
                        if (e.key === 'Escape' && mobileNav.classList.contains('active')) {
                              closeMobileMenu();
                        }
                  });
            }
      });
</script>