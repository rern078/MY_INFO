document.addEventListener('DOMContentLoaded', function () {
      const hamburgerMenu = document.getElementById('hamburgerMenu');
      const mobileNav = document.getElementById('mobileNav');
      const mobileClose = document.getElementById('mobileClose');
      const languageBtn = document.getElementById('languageBtn');
      const languageDropdown = document.getElementById('languageDropdown');

      // Portfolio dropdown functionality
      const portfolioBtn = document.getElementById('portfolioBtn');
      const portfolioDropdown = document.getElementById('portfolioDropdown');
      const mobilePortfolioBtn = document.getElementById('mobilePortfolioBtn');
      const mobilePortfolioDropdown = document.getElementById('mobilePortfolioDropdown');

      // Header scroll functionality
      const userHeader = document.querySelector('.user-header');
      let lastScrollTop = 0;
      let scrollThreshold = 50; // Reduced threshold for earlier fixed positioning
      let isHeaderFixed = false;
      let scrollTimeout;

      function handleScroll() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            const scrollDelta = scrollTop - lastScrollTop;

            // Add fixed class when scrolling past threshold
            if (scrollTop > scrollThreshold && !isHeaderFixed) {
                  userHeader.classList.add('fixed');
                  document.body.classList.add('header-fixed');
                  isHeaderFixed = true;
            } else if (scrollTop <= scrollThreshold && isHeaderFixed) {
                  userHeader.classList.remove('fixed');
                  document.body.classList.remove('header-fixed');
                  isHeaderFixed = false;
                  userHeader.classList.remove('header-hidden'); // Ensure header is visible when returning to top
            }

            // Show header when scrolling (more responsive)
            if (isHeaderFixed) {
                  // Clear any existing timeout
                  clearTimeout(scrollTimeout);

                  // Always show header when scrolling
                  userHeader.classList.remove('header-hidden');

                  // Only hide header after user stops scrolling for 1 second
                  scrollTimeout = setTimeout(() => {
                        if (scrollTop > 100) {
                              userHeader.classList.add('header-hidden');
                        }
                  }, 1000);
            }

            lastScrollTop = scrollTop;
      }

      // Throttle scroll events for better performance
      let ticking = false;

      function requestTick() {
            if (!ticking) {
                  requestAnimationFrame(function () {
                        handleScroll();
                        ticking = false;
                  });
                  ticking = true;
            }
      }

      // Add scroll event listener
      window.addEventListener('scroll', requestTick, {
            passive: true
      });

      // Desktop portfolio dropdown
      if (portfolioBtn && portfolioDropdown) {
            portfolioBtn.addEventListener('click', function (e) {
                  e.stopPropagation();
                  portfolioDropdown.parentElement.classList.toggle('active');
            });

            // Close portfolio dropdown when clicking outside
            document.addEventListener('click', function (e) {
                  if (!portfolioBtn.contains(e.target) && !portfolioDropdown.contains(e.target)) {
                        portfolioDropdown.parentElement.classList.remove('active');
                  }
            });
      }

      // Mobile portfolio dropdown
      if (mobilePortfolioBtn && mobilePortfolioDropdown) {
            mobilePortfolioBtn.addEventListener('click', function (e) {
                  e.stopPropagation();
                  mobilePortfolioDropdown.parentElement.classList.toggle('active');
            });

            // Close mobile portfolio dropdown when clicking outside
            document.addEventListener('click', function (e) {
                  if (!mobilePortfolioBtn.contains(e.target) && !mobilePortfolioDropdown.contains(e.target)) {
                        mobilePortfolioDropdown.parentElement.classList.remove('active');
                  }
            });
      }

      // Language switcher functionality
      if (languageBtn && languageDropdown) {
            languageBtn.addEventListener('click', function (e) {
                  e.stopPropagation();
                  languageDropdown.classList.toggle('show');
            });

            // Close language dropdown when clicking outside
            document.addEventListener('click', function (e) {
                  if (!languageBtn.contains(e.target) && !languageDropdown.contains(e.target)) {
                        languageDropdown.classList.remove('show');
                  }
            });

            // Close language dropdown when pressing Escape
            document.addEventListener('keydown', function (e) {
                  if (e.key === 'Escape') {
                        languageDropdown.classList.remove('show');
                  }
            });
      }

      // Check if hamburger menu exists (for both logged-in and non-logged-in users)
      if (hamburgerMenu && mobileNav && mobileClose) {
            // Open mobile menu
            hamburgerMenu.addEventListener('click', function () {
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
            mobileNav.addEventListener('click', function (e) {
                  if (e.target === mobileNav || e.target.classList.contains('mobile-close')) {
                        closeMobileMenu();
                  }
            });

            // Close menu on escape key
            document.addEventListener('keydown', function (e) {
                  if (e.key === 'Escape' && mobileNav.classList.contains('active')) {
                        closeMobileMenu();
                  }
            });
      }

      // Add this new script for the dropdown functionality
      const dropdown = document.querySelector('.portfolio-dropdown');
      const btn = document.querySelector('.portfolio-btn');

      if (dropdown && btn) {
            btn.addEventListener('click', function (e) {
                  e.stopPropagation();
                  dropdown.classList.toggle('active');
            });

            // Hide dropdown when clicking outside
            document.addEventListener('click', function (e) {
                  if (!dropdown.contains(e.target)) {
                        dropdown.classList.remove('active');
                  }
            });
      }

      // Profile image change functionality
      function changeProfileImage() {
            // Show loading state
            const button = event.target.closest('button');
            const originalIcon = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            button.disabled = true;

      }
});
// Portfolio Dropdown Functionality
document.addEventListener('DOMContentLoaded', function () {
      const portfolioBtn = document.getElementById('portfolioBtn');
      const portfolioDropdown = document.getElementById('portfolioDropdown');
      const mobilePortfolioBtn = document.getElementById('mobilePortfolioBtn');
      const mobilePortfolioDropdown = document.getElementById('mobilePortfolioDropdown');
      const portfolioOptions = document.querySelectorAll('.portfolio-option');

      // Toggle desktop dropdown
      if (portfolioBtn && portfolioDropdown) {
            portfolioBtn.addEventListener('click', function (e) {
                  e.stopPropagation();
                  const dropdown = this.closest('.portfolio-dropdown');
                  dropdown.classList.toggle('active');
            });
      }

      // Toggle mobile dropdown
      if (mobilePortfolioBtn && mobilePortfolioDropdown) {
            mobilePortfolioBtn.addEventListener('click', function (e) {
                  e.stopPropagation();
                  const dropdown = this.closest('.portfolio-dropdown');
                  dropdown.classList.toggle('active');
            });
      }

      // Close dropdowns when clicking outside
      document.addEventListener('click', function (e) {
            if (!e.target.closest('.portfolio-dropdown')) {
                  document.querySelectorAll('.portfolio-dropdown').forEach(dropdown => {
                        dropdown.classList.remove('active');
                  });
            }
      });

      // Handle portfolio section navigation
      portfolioOptions.forEach(option => {
            option.addEventListener('click', function (e) {
                  e.preventDefault();

                  // Close all dropdowns
                  document.querySelectorAll('.portfolio-dropdown').forEach(dropdown => {
                        dropdown.classList.remove('active');
                  });

                  // Close mobile navigation if open
                  const mobileNav = document.getElementById('mobileNav');
                  if (mobileNav && mobileNav.classList.contains('active')) {
                        mobileNav.classList.remove('active');
                        const hamburgerMenu = document.getElementById('hamburgerMenu');
                        if (hamburgerMenu) {
                              hamburgerMenu.classList.remove('active');
                        }
                  }

                  const targetSection = this.getAttribute('data-section');
                  const targetElement = document.getElementById(targetSection);

                  if (targetElement) {
                        // Smooth scroll to section
                        targetElement.scrollIntoView({
                              behavior: 'smooth',
                              block: 'start'
                        });

                        // Update active state
                        portfolioOptions.forEach(opt => opt.classList.remove('active'));
                        this.classList.add('active');

                        // Remove active class after animation
                        setTimeout(() => {
                              this.classList.remove('active');
                        }, 2000);
                  }
            });
      });

      // Intersection Observer for section highlighting
      const sectionObserver = new IntersectionObserver(function (entries) {
            entries.forEach(entry => {
                  if (entry.isIntersecting) {
                        const sectionId = entry.target.id;
                        const correspondingOption = document.querySelector(`[data-section="${sectionId}"]`);

                        if (correspondingOption) {
                              portfolioOptions.forEach(opt => opt.classList.remove('active'));
                              correspondingOption.classList.add('active');
                        }
                  }
            });
      }, {
            threshold: 0.3,
            rootMargin: '-20% 0px -20% 0px'
      });

      // Observe all portfolio sections
      const sections = ['personal-info', 'skills', 'experience', 'education', 'courses', 'languages', 'interests', 'connect'];
      sections.forEach(sectionId => {
            const section = document.getElementById(sectionId);
            if (section) {
                  sectionObserver.observe(section);
            }
      });
});

// Add animation classes to elements as they come into view
document.addEventListener('DOMContentLoaded', function () {
      const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
      };

      const observer = new IntersectionObserver(function (entries) {
            entries.forEach(entry => {
                  if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                  }
            });
      }, observerOptions);

      // Observe all timeline items and info cards
      document.querySelectorAll('.timeline-item, .info-card, .skill-category').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
      });
});