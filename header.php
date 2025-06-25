<?php
// Include language system
require_once 'languages.php';
require_once 'global/global.php';

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
$username = $_SESSION['username'] ?? '';

// Get current page name
$current_page = basename($_SERVER['PHP_SELF'], '.php');

// Get current language info
$current_lang = getCurrentLanguage();
$available_langs = getAvailableLanguages();
$current_language = $_SESSION['language'] ?? 'en';

// Check if we're on the index page
$isIndexPage = ($current_page === 'index');

// Get the profile image for current user
$profileImage = getRandomProfileImage();
?>

<!-- User Header -->
<?php if ($isLoggedIn): ?>
      <div class="user-header bg-primary text-white py-3 mb-4">
            <div class="container">
                  <div class="row align-items-center justify-content-between">
                        <div class="col-auto">
                              <div class="d-flex align-items-center">
                                    <?php if ($profileImage): ?>
                                          <div class="profile-image-container me-3">
                                                <img src="<?php echo htmlspecialchars($profileImage); ?>"
                                                      alt="Profile"
                                                      class="profile-image"
                                                      style="width: 48px; height: 48px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(255,255,255,0.3);">
                                                <button type="button"
                                                      class="profile-image-change-btn"
                                                      onclick="changeProfileImage()"
                                                      title="Change Profile Image">
                                                      <i class="fas fa-sync-alt"></i>
                                                </button>
                                          </div>
                                    <?php else: ?>
                                          <i class="fas fa-user-circle me-3 fs-3"></i>
                                    <?php endif; ?>
                                    <div>
                                          <span class="fw-bold fs-5"><?php echo t('welcome'); ?>, <?php echo htmlspecialchars($username); ?>!</span>
                                          <div class="small opacity-75"><?php echo t('successfully_logged_in'); ?></div>
                                    </div>
                              </div>
                        </div>
                        <div class="col-auto">
                              <div class="d-flex justify-content-end align-items-center">
                                    <!-- Portfolio Sections Dropdown - Only show on index page -->
                                    <?php if ($isIndexPage): ?>
                                          <div class="portfolio-dropdown me-3">
                                                <div class="portfolio-btn" id="portfolioBtn">
                                                      <i class="fas fa-bars me-2"></i>
                                                      <span><?php echo t('portfolio_sections'); ?></span>
                                                      <i class="fas fa-chevron-down ms-1"></i>
                                                </div>
                                                <div class="portfolio-dropdown-menu" id="portfolioDropdown">
                                                      <a href="#personal-info" class="portfolio-option" data-section="personal-info">
                                                            <i class="fas fa-user me-2"></i>
                                                            <span><?php echo t('personal_information'); ?></span>
                                                      </a>
                                                      <a href="#skills" class="portfolio-option" data-section="skills">
                                                            <i class="fas fa-tools me-2"></i>
                                                            <span><?php echo t('skills_expertise'); ?></span>
                                                      </a>
                                                      <a href="#experience" class="portfolio-option" data-section="experience">
                                                            <i class="fas fa-briefcase me-2"></i>
                                                            <span><?php echo t('professional_experience'); ?></span>
                                                      </a>
                                                      <a href="#education" class="portfolio-option" data-section="education">
                                                            <i class="fas fa-graduation-cap me-2"></i>
                                                            <span><?php echo t('education'); ?></span>
                                                      </a>
                                                      <a href="#courses" class="portfolio-option" data-section="courses">
                                                            <i class="fas fa-book me-2"></i>
                                                            <span><?php echo t('courses'); ?></span>
                                                      </a>
                                                      <a href="#interests" class="portfolio-option" data-section="interests">
                                                            <i class="fas fa-heart me-2"></i>
                                                            <span><?php echo t('interests_hobbies'); ?></span>
                                                      </a>
                                                      <a href="#connect" class="portfolio-option" data-section="connect">
                                                            <i class="fas fa-link me-2"></i>
                                                            <span><?php echo t('connect_with_me'); ?></span>
                                                      </a>
                                                </div>
                                          </div>
                                    <?php endif; ?>

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

            <!-- Portfolio Sections Dropdown for Mobile - Only show on index page -->
            <?php if ($isIndexPage): ?>
                  <div class="portfolio-dropdown">
                        <div class="portfolio-btn" id="mobilePortfolioBtn">
                              <i class="fas fa-bars me-2"></i>
                              <span><?php echo t('portfolio_sections'); ?></span>
                              <i class="fas fa-chevron-down ms-1"></i>
                        </div>
                        <div class="portfolio-dropdown-menu" id="mobilePortfolioDropdown">
                              <a href="#personal-info" class="portfolio-option" data-section="personal-info">
                                    <i class="fas fa-user me-2"></i>
                                    <span><?php echo t('personal_information'); ?></span>
                              </a>
                              <a href="#skills" class="portfolio-option" data-section="skills">
                                    <i class="fas fa-tools me-2"></i>
                                    <span><?php echo t('skills_expertise'); ?></span>
                              </a>
                              <a href="#experience" class="portfolio-option" data-section="experience">
                                    <i class="fas fa-briefcase me-2"></i>
                                    <span><?php echo t('professional_experience'); ?></span>
                              </a>
                              <a href="#education" class="portfolio-option" data-section="education">
                                    <i class="fas fa-graduation-cap me-2"></i>
                                    <span><?php echo t('education'); ?></span>
                              </a>
                              <a href="#courses" class="portfolio-option" data-section="courses">
                                    <i class="fas fa-book me-2"></i>
                                    <span><?php echo t('courses'); ?></span>
                              </a>
                              <a href="#interests" class="portfolio-option" data-section="interests">
                                    <i class="fas fa-heart me-2"></i>
                                    <span><?php echo t('interests_hobbies'); ?></span>
                              </a>
                              <a href="#connect" class="portfolio-option" data-section="connect">
                                    <i class="fas fa-link me-2"></i>
                                    <span><?php echo t('connect_with_me'); ?></span>
                              </a>
                        </div>
                  </div>
            <?php endif; ?>

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
                                    <?php if ($profileImage): ?>
                                          <div class="profile-image-container me-3">
                                                <img src="<?php echo htmlspecialchars($profileImage); ?>"
                                                      alt="Profile"
                                                      class="profile-image"
                                                      style="width: 48px; height: 48px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(255,255,255,0.3);">
                                                <button type="button"
                                                      class="profile-image-change-btn"
                                                      onclick="changeProfileImage()"
                                                      title="Change Profile Image">
                                                      <i class="fas fa-sync-alt"></i>
                                                </button>
                                          </div>
                                    <?php else: ?>
                                          <i class="fas fa-user-circle me-3 fs-3"></i>
                                    <?php endif; ?>
                                    <div>
                                          <span class="fw-bold fs-5"><?php echo t('welcome_guest'); ?></span>
                                          <div class="small opacity-75"><?php echo t('login_to_access'); ?></div>
                                    </div>
                              </div>
                        </div>
                        <div class="col-auto">
                              <div class="d-flex justify-content-end align-items-center">
                                    <!-- Portfolio Sections Dropdown - Only show on index page -->
                                    <?php if ($isIndexPage): ?>
                                          <div class="portfolio-dropdown me-3">
                                                <div class="portfolio-btn" id="portfolioBtn">
                                                      <i class="fas fa-bars me-2"></i>
                                                      <span><?php echo t('portfolio_sections'); ?></span>
                                                      <i class="fas fa-chevron-down ms-1"></i>
                                                </div>
                                                <div class="portfolio-dropdown-menu" id="portfolioDropdown">
                                                      <a href="#personal-info" class="portfolio-option" data-section="personal-info">
                                                            <i class="fas fa-user me-2"></i>
                                                            <span><?php echo t('personal_information'); ?></span>
                                                      </a>
                                                      <a href="#skills" class="portfolio-option" data-section="skills">
                                                            <i class="fas fa-tools me-2"></i>
                                                            <span><?php echo t('skills_expertise'); ?></span>
                                                      </a>
                                                      <a href="#experience" class="portfolio-option" data-section="experience">
                                                            <i class="fas fa-briefcase me-2"></i>
                                                            <span><?php echo t('professional_experience'); ?></span>
                                                      </a>
                                                      <a href="#education" class="portfolio-option" data-section="education">
                                                            <i class="fas fa-graduation-cap me-2"></i>
                                                            <span><?php echo t('education'); ?></span>
                                                      </a>
                                                      <a href="#courses" class="portfolio-option" data-section="courses">
                                                            <i class="fas fa-book me-2"></i>
                                                            <span><?php echo t('courses'); ?></span>
                                                      </a>
                                                      <a href="#interests" class="portfolio-option" data-section="interests">
                                                            <i class="fas fa-heart me-2"></i>
                                                            <span><?php echo t('interests_hobbies'); ?></span>
                                                      </a>
                                                      <a href="#connect" class="portfolio-option" data-section="connect">
                                                            <i class="fas fa-link me-2"></i>
                                                            <span><?php echo t('connect_with_me'); ?></span>
                                                      </a>
                                                </div>
                                          </div>
                                    <?php endif; ?>

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

            <!-- Portfolio Sections Dropdown for Mobile - Only show on index page -->
            <?php if ($isIndexPage): ?>
                  <div class="portfolio-dropdown">
                        <div class="portfolio-btn" id="mobilePortfolioBtn">
                              <i class="fas fa-bars me-2"></i>
                              <span><?php echo t('portfolio_sections'); ?></span>
                              <i class="fas fa-chevron-down ms-1"></i>
                        </div>
                        <div class="portfolio-dropdown-menu" id="mobilePortfolioDropdown">
                              <a href="#personal-info" class="portfolio-option" data-section="personal-info">
                                    <i class="fas fa-user me-2"></i>
                                    <span><?php echo t('personal_information'); ?></span>
                              </a>
                              <a href="#skills" class="portfolio-option" data-section="skills">
                                    <i class="fas fa-tools me-2"></i>
                                    <span><?php echo t('skills_expertise'); ?></span>
                              </a>
                              <a href="#experience" class="portfolio-option" data-section="experience">
                                    <i class="fas fa-briefcase me-2"></i>
                                    <span><?php echo t('professional_experience'); ?></span>
                              </a>
                              <a href="#education" class="portfolio-option" data-section="education">
                                    <i class="fas fa-graduation-cap me-2"></i>
                                    <span><?php echo t('education'); ?></span>
                              </a>
                              <a href="#courses" class="portfolio-option" data-section="courses">
                                    <i class="fas fa-book me-2"></i>
                                    <span><?php echo t('courses'); ?></span>
                              </a>
                              <a href="#interests" class="portfolio-option" data-section="interests">
                                    <i class="fas fa-heart me-2"></i>
                                    <span><?php echo t('interests_hobbies'); ?></span>
                              </a>
                              <a href="#connect" class="portfolio-option" data-section="connect">
                                    <i class="fas fa-link me-2"></i>
                                    <span><?php echo t('connect_with_me'); ?></span>
                              </a>
                        </div>
                  </div>
            <?php endif; ?>

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
<?php endif; ?>