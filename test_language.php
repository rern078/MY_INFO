<?php
require_once 'languages.php';
?>
<!DOCTYPE html>
<html lang="<?php echo $current_language; ?>" dir="<?php echo getLanguageDirection(); ?>">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title><?php echo t('language_test'); ?> - Portfolio</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-light">
      <?php include 'header.php'; ?>

      <div class="container py-5">
            <div class="row justify-content-center">
                  <div class="col-md-8">
                        <div class="card shadow">
                              <div class="card-header bg-primary text-white">
                                    <h3 class="mb-0">
                                          <i class="fas fa-language me-2"></i>
                                          <?php echo t('language_test'); ?>
                                    </h3>
                              </div>
                              <div class="card-body">
                                    <div class="row">
                                          <div class="col-md-6">
                                                <h5><?php echo t('current_language'); ?></h5>
                                                <p class="mb-3">
                                                      <strong><?php echo t('language'); ?>:</strong>
                                                      <?php echo $current_lang['name']; ?> (<?php echo $current_lang['native_name']; ?>)
                                                </p>
                                                <p class="mb-3">
                                                      <strong><?php echo t('language_code'); ?>:</strong>
                                                      <?php echo $current_lang['code']; ?>
                                                </p>
                                                <p class="mb-3">
                                                      <strong><?php echo t('direction'); ?>:</strong>
                                                      <?php echo getLanguageDirection(); ?>
                                                </p>
                                          </div>
                                          <div class="col-md-6">
                                                <h5><?php echo t('available_languages'); ?></h5>
                                                <ul class="list-group">
                                                      <?php foreach ($available_langs as $lang_code => $lang_info): ?>
                                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                  <span>
                                                                        <?php echo $lang_info['flag']; ?>
                                                                        <?php echo $lang_info['name']; ?>
                                                                        (<?php echo $lang_info['native_name']; ?>)
                                                                  </span>
                                                                  <?php if ($lang_code === $current_language): ?>
                                                                        <span class="badge bg-success"><?php echo t('current'); ?></span>
                                                                  <?php else: ?>
                                                                        <a href="?lang=<?php echo $lang_code; ?>" class="btn btn-sm btn-outline-primary">
                                                                              <?php echo t('switch_to'); ?>
                                                                        </a>
                                                                  <?php endif; ?>
                                                            </li>
                                                      <?php endforeach; ?>
                                                </ul>
                                          </div>
                                    </div>

                                    <hr class="my-4">

                                    <h5><?php echo t('translation_examples'); ?></h5>
                                    <div class="row">
                                          <div class="col-md-4">
                                                <div class="card">
                                                      <div class="card-header">
                                                            <h6 class="mb-0"><?php echo t('common_phrases'); ?></h6>
                                                      </div>
                                                      <div class="card-body">
                                                            <p><strong><?php echo t('welcome'); ?>:</strong> <?php echo t('welcome'); ?></p>
                                                            <p><strong><?php echo t('login'); ?>:</strong> <?php echo t('login'); ?></p>
                                                            <p><strong><?php echo t('register'); ?>:</strong> <?php echo t('register'); ?></p>
                                                            <p><strong><?php echo t('logout'); ?>:</strong> <?php echo t('logout'); ?></p>
                                                      </div>
                                                </div>
                                          </div>
                                          <div class="col-md-4">
                                                <div class="card">
                                                      <div class="card-header">
                                                            <h6 class="mb-0"><?php echo t('form_labels'); ?></h6>
                                                      </div>
                                                      <div class="card-body">
                                                            <p><strong><?php echo t('username'); ?>:</strong> <?php echo t('username'); ?></p>
                                                            <p><strong><?php echo t('password'); ?>:</strong> <?php echo t('password'); ?></p>
                                                            <p><strong><?php echo t('email'); ?>:</strong> <?php echo t('email'); ?></p>
                                                            <p><strong><?php echo t('confirm_password'); ?>:</strong> <?php echo t('confirm_password'); ?></p>
                                                      </div>
                                                </div>
                                          </div>
                                          <div class="col-md-4">
                                                <div class="card">
                                                      <div class="card-header">
                                                            <h6 class="mb-0"><?php echo t('cv_sections'); ?></h6>
                                                      </div>
                                                      <div class="card-body">
                                                            <p><strong><?php echo t('personal_info'); ?>:</strong> <?php echo t('personal_info'); ?></p>
                                                            <p><strong><?php echo t('education'); ?>:</strong> <?php echo t('education'); ?></p>
                                                            <p><strong><?php echo t('experience'); ?>:</strong> <?php echo t('experience'); ?></p>
                                                            <p><strong><?php echo t('skills'); ?>:</strong> <?php echo t('skills'); ?></p>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>

                                    <div class="row">
                                          <div class="col-md-6">
                                                <div class="card">
                                                      <div class="card-header">
                                                            <h5><i class="fas fa-font me-2"></i><?php echo t('font_test'); ?></h5>
                                                      </div>
                                                      <div class="card-body">
                                                            <p><strong><?php echo t('current_font'); ?>:</strong>
                                                                  <span id="currentFont"><?php echo $current_lang['name']; ?></span>
                                                            </p>
                                                            <p><strong><?php echo t('font_family'); ?>:</strong>
                                                                  <span id="fontFamily"><?php echo $current_lang['code'] === 'km' ? 'Kh Fasthand (Fasthand)' : 'Guavine'; ?></span>
                                                            </p>

                                                            <div class="mt-3">
                                                                  <h6><?php echo t('sample_text'); ?>:</h6>
                                                                  <div class="p-3 bg-light rounded">
                                                                        <?php if ($current_lang['code'] === 'km'): ?>
                                                                              <p class="mb-2">សួស្តី! នេះគឺជាអត្ថបទគំរូជាភាសាខ្មែរ។</p>
                                                                              <p class="mb-2">ខ្ញុំឈ្មោះ ចាមរ៉េន និងខ្ញុំជាអ្នកអភិវឌ្ឍន៍។</p>
                                                                              <p class="mb-0">អត្ថបទនេះត្រូវបានបង្ហាញជាមួយពុម្ពអក្សរ Kh Fasthand។</p>
                                                                        <?php else: ?>
                                                                              <p class="mb-2">Hello! This is sample text in <?php echo $current_lang['name']; ?>.</p>
                                                                              <p class="mb-2">My name is Chamrern and I am a developer.</p>
                                                                              <p class="mb-0">This text is displayed with the <?php echo $current_lang['code'] === 'km' ? 'Kh Fasthand' : 'Guavine'; ?> font.</p>
                                                                        <?php endif; ?>
                                                                  </div>
                                                            </div>

                                                            <div class="mt-3">
                                                                  <h6><?php echo t('font_features'); ?>:</h6>
                                                                  <ul class="list-unstyled">
                                                                        <?php if ($current_lang['code'] === 'km'): ?>
                                                                              <li><i class="fas fa-check text-success me-2"></i><?php echo t('khmer_support'); ?></li>
                                                                              <li><i class="fas fa-check text-success me-2"></i><?php echo t('responsive_design'); ?></li>
                                                                              <li><i class="fas fa-check text-success me-2"></i><?php echo t('google_fonts'); ?></li>
                                                                              <li><i class="fas fa-check text-success me-2"></i><?php echo t('fallback_fonts'); ?></li>
                                                                        <?php else: ?>
                                                                              <li><i class="fas fa-check text-success me-2"></i><?php echo t('custom_font'); ?></li>
                                                                              <li><i class="fas fa-check text-success me-2"></i><?php echo t('elegant_design'); ?></li>
                                                                              <li><i class="fas fa-check text-success me-2"></i><?php echo t('web_safe'); ?></li>
                                                                              <li><i class="fas fa-check text-success me-2"></i><?php echo t('fast_loading'); ?></li>
                                                                        <?php endif; ?>
                                                                  </ul>
                                                            </div>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>

                                    <div class="text-center mt-4">
                                          <a href="index.php" class="btn btn-primary">
                                                <i class="fas fa-arrow-left me-2"></i>
                                                <?php echo t('back_to_cv'); ?>
                                          </a>
                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
      </div>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
      <script>
            // Update font information when language changes
            function updateFontInfo() {
                  const currentLang = '<?php echo $current_language; ?>';
                  const currentFontElement = document.getElementById('currentFont');
                  const fontFamilyElement = document.getElementById('fontFamily');

                  if (currentLang === 'km') {
                        currentFontElement.textContent = 'Khmer';
                        fontFamilyElement.textContent = 'Kh Fasthand (Fasthand)';
                  } else if (currentLang === 'zh') {
                        currentFontElement.textContent = 'Chinese';
                        fontFamilyElement.textContent = 'Guavine';
                  } else {
                        currentFontElement.textContent = 'English';
                        fontFamilyElement.textContent = 'Guavine';
                  }
            }

            // Call on page load
            document.addEventListener('DOMContentLoaded', function() {
                  updateFontInfo();
            });

            // Update when language is changed via URL parameter
            if (window.location.search.includes('lang=')) {
                  updateFontInfo();
            }
      </script>
</body>

</html>