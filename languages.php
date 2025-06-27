<?php
// Language system for the portfolio website
// Supports: English (en), Khmer (km), Chinese (zh)

session_start();

// Available languages
$available_languages = [
      'en' => [
            'code' => 'en',
            'name' => 'English',
            'native_name' => 'English',
            'flag' => '🇺🇸'
      ],
      'km' => [
            'code' => 'km',
            'name' => 'Khmer',
            'native_name' => 'ខ្មែរ',
            'flag' => '🇰🇭'
      ],
      'zh' => [
            'code' => 'zh',
            'name' => 'Chinese',
            'native_name' => '中文',
            'flag' => '🇨🇳'
      ],
];

// Default language
$default_language = 'en';

// Get current language from session or URL parameter
if (isset($_GET['lang']) && array_key_exists($_GET['lang'], $available_languages)) {
      $_SESSION['language'] = $_GET['lang'];
} elseif (!isset($_SESSION['language'])) {
      $_SESSION['language'] = $default_language;
}

$current_language = $_SESSION['language'];

// Translation arrays
$translations = [
      'en' => [
            // Header
            'welcome' => 'Welcome',
            'welcome_guest' => 'Welcome Guest!',
            'login_to_access' => 'Please login to access your Curriculum Vitae',
            'successfully_logged_in' => 'You are successfully logged in',
            'logout' => 'Logout',
            'login' => 'Login',
            'register' => 'Register',

            // Navigation
            'view_cv' => 'View Curriculum Vitae',
            'view_sr1' => 'View Curriculum Vitae',
            'view_sr2' => 'View Cover Letter',
            'view_certificates' => 'View Certificates',
            'download_pdf' => 'Download PDF',
            'admin_panel' => 'Admin Panel',
            'dashboard' => 'Dashboard',

            // Portfolio Dropdown
            'portfolio_sections' => 'Portfolio Sections',
            'personal_information' => 'Personal Information',
            'skills_expertise' => 'Skills & Expertise',
            'professional_experience' => 'Professional Experience',
            'education' => 'Education',
            'courses' => 'Courses',
            'languages' => 'Languages',
            'interests_hobbies' => 'Interests & Hobbies',
            'connect_with_me' => 'Connect With Me',

            // Language switcher
            'select_language' => 'Select Language',
            'language' => 'Language',

            // Common
            'yes' => 'Yes',
            'no' => 'No',
            'save' => 'Save',
            'cancel' => 'Cancel',
            'delete' => 'Delete',
            'edit' => 'Edit',
            'add' => 'Add',
            'update' => 'Update',
            'search' => 'Search',
            'loading' => 'Loading...',
            'error' => 'Error',
            'success' => 'Success',
            'warning' => 'Warning',
            'info' => 'Information',

            // Forms
            'username' => 'Username',
            'password' => 'Password',
            'email' => 'Email',
            'confirm_password' => 'Confirm Password',
            'submit' => 'Submit',
            'reset' => 'Reset',

            // Messages
            'login_successful' => 'Login successful!',
            'login_failed' => 'Login failed. Please check your credentials.',
            'logout_successful' => 'Logout successful!',
            'registration_successful' => 'Registration successful!',
            'registration_failed' => 'Registration failed. Please try again.',
            'password_mismatch' => 'Passwords do not match.',
            'user_exists' => 'Username already exists.',
            'invalid_credentials' => 'Invalid username or password.',
            'username_required' => 'Username is required.',
            'password_required' => 'Password is required.',
            'remember_me' => 'Remember Me',
            'show_saved_credentials' => 'Show saved credentials',
            'dont_have_account' => "Don't have an account?",
            'register_here' => 'Register here',
            'already_have_account' => 'Already have an account?',
            'login_here' => 'Login here',
            'email_required' => 'Email is required.',
            'confirm_password_required' => 'Confirm password is required.',
            'username_min_length' => 'Username must be at least 3 characters long.',
            'username_max_length' => 'Username must not exceed 50 characters.',
            'username_alphabets_only' => 'Username must contain only alphabets (letters).',
            'invalid_email_format' => 'Invalid email format.',
            'password_min_length' => 'Password must be at least 6 characters long.',
            'password_alphanumeric_only' => 'Password must contain only letters and numbers.',
            'username_or_email_exists' => 'Username or email already exists.',
            'database_error' => 'Database error occurred. Please try again.',
            'registration_failed' => 'Registration failed. Please try again.',
            'username_help_text' => 'Only alphabets (a-z, A-Z) allowed, 3-50 characters',
            'email_help_text' => 'Enter a valid email address',
            'password_help_text' => 'Only letters and numbers (a-z, A-Z, 0-9) allowed, minimum 6 characters',
            'confirm_password_help_text' => 'Re-enter your password to confirm',
            'cv' => 'TienG ChamrerN - Curriculum Vitae',
            'user' => 'User',
            'no_cv_data_available' => 'No Curriculum Vitae data available. Please contact the administrator to set up your Curriculum Vitae.',
            'language_test' => 'Language Test',
            'current_language' => 'Current Language',
            'language_code' => 'Language Code',
            'direction' => 'Direction',
            'available_languages' => 'Available Languages',
            'current' => 'Current',
            'switch_to' => 'Switch to',
            'translation_examples' => 'Translation Examples',
            'common_phrases' => 'Common Phrases',
            'form_labels' => 'Form Labels',
            'cv_sections' => 'Curriculum Vitae Sections',
            'back_to_cv' => 'Back to Curriculum Vitae',

            // CV Sections
            'personal_info' => 'Personal Information',
            'contact_info' => 'Contact Information',
            'education' => 'Education',
            'experience' => 'Experience',
            'skills' => 'Skills',
            'languages' => 'Languages',
            'certificates' => 'Certificates',
            'projects' => 'Projects',
            'references' => 'References',

            // Admin
            'admin_dashboard' => 'Admin Dashboard',
            'manage_users' => 'Manage Users',
            'manage_content' => 'Manage Content',
            'system_settings' => 'System Settings',
            'backup_database' => 'Backup Database',
            'view_logs' => 'View Logs',

            // Test Language Page
            'test_language' => 'Test Language System',
            'font_test' => 'Font Test',
            'current_font' => 'Current Font',
            'font_family' => 'Font Family',
            'sample_text' => 'Sample Text',
            'font_features' => 'Font Features',
            'khmer_support' => 'Khmer Language Support',
            'responsive_design' => 'Responsive Design',
            'google_fonts' => 'Google Fonts Integration',
            'fallback_fonts' => 'Fallback Fonts',
            'custom_font' => 'Custom Font (Guavine)',
            'elegant_design' => 'Elegant Design',
            'web_safe' => 'Web Safe',
            'fast_loading' => 'Fast Loading'
      ],

      'km' => [
            // Header
            'welcome' => 'សូមស្វាគមន៍',
            'welcome_guest' => 'សូមស្វាគមន៍Guest!',
            'login_to_access' => 'សូមចូលគណនីដើម្បីចូលមើលប្រវត្តិរូបសង្ខេប',
            'successfully_logged_in' => 'អ្នកបានចូលគណនីដោយជោគជ័យ',
            'logout' => 'ចាកចេញ',
            'login' => 'ចូលគណនី',
            'register' => 'ចុះឈ្មោះ',

            // Navigation
            'view_cv' => 'មើលប្រវត្តិរូបសង្ខេប',
            'view_sr1' => 'មើលប្រវត្តិរូបសង្ខេប',
            'view_sr2' => 'មើលលិខិតគម្រប',
            'view_certificates' => 'មើលវិញ្ញាបនបត្រ',
            'download_pdf' => 'ទាញយក PDF',
            'admin_panel' => 'ផ្ទាំងគ្រប់គ្រង',
            'dashboard' => 'ផ្ទាំងគ្រប់គ្រង',

            // Portfolio Dropdown
            'portfolio_sections' => 'ផ្នែកប្រវត្តិរូបសង្ខេប',
            'personal_information' => 'ព័ត៌មានផ្ទាល់ខ្លួន',
            'skills_expertise' => 'ជំនាញ & ប្រសិទ្ធិ',
            'professional_experience' => 'បទពិសោធន៍បច្ចុប្បន្ន',
            'education' => 'ការអប់រំ',
            'courses' => 'កម្រិត',
            'languages' => 'ភាសា',
            'interests_hobbies' => 'ចំណង់ចំណូលចិត្ត',
            'connect_with_me' => 'ជួបជាមួយខ្ញុំ',

            // Language switcher
            'select_language' => 'ជ្រើសរើសភាសា',
            'language' => 'ភាសា',

            // Common
            'yes' => 'បាទ/ចាស',
            'no' => 'ទេ',
            'save' => 'រក្សាទុក',
            'cancel' => 'បោះបង់',
            'delete' => 'លុប',
            'edit' => 'កែប្រែ',
            'add' => 'បន្ថែម',
            'update' => 'ធ្វើបច្ចុប្បន្នភាព',
            'search' => 'ស្វែងរក',
            'loading' => 'កំពុងផ្ទុក...',
            'error' => 'កំហុស',
            'success' => 'ជោគជ័យ',
            'warning' => 'ការព្រមាន',
            'info' => 'ព័ត៌មាន',

            // Forms
            'username' => 'ឈ្មោះអ្នកប្រើប្រាស់',
            'password' => 'ពាក្យសម្ងាត់',
            'email' => 'អ៊ីមែល',
            'confirm_password' => 'បញ្ជាក់ពាក្យសម្ងាត់',
            'submit' => 'ដាក់ស្នើ',
            'reset' => 'កំណត់ឡើងវិញ',

            // Messages
            'login_successful' => 'ចូលគណនីដោយជោគជ័យ!',
            'login_failed' => 'ចូលគណនីបរាជ័យ។ សូមពិនិត្យព័ត៌មានផ្ទៀងផ្ទាត់របស់អ្នក។',
            'logout_successful' => 'ចាកចេញដោយជោគជ័យ!',
            'registration_successful' => 'ចុះឈ្មោះដោយជោគជ័យ!',
            'registration_failed' => 'ចុះឈ្មោះបរាជ័យ។ សូមព្យាយាមម្តងទៀត។',
            'password_mismatch' => 'ពាក្យសម្ងាត់មិនត្រូវគ្នា។',
            'user_exists' => 'ឈ្មោះអ្នកប្រើប្រាស់មានរួចហើយ។',
            'invalid_credentials' => 'ឈ្មោះអ្នកប្រើប្រាស់ ឬពាក្យសម្ងាត់មិនត្រឹមត្រូវ។',
            'username_required' => 'ឈ្មោះគណនីមិនអាចទទេ!',
            'password_required' => 'លេខសម្ងាត់មិនអាចទទេ!',
            'remember_me' => 'ចងចាំខ្ញុំ',
            'show_saved_credentials' => 'បង្ហាញព័ត៌មានផ្ទៀងផ្ទាត់ដែលបានរក្សាទុក',
            'dont_have_account' => "មិនមានគណនីមែនទេ?",
            'register_here' => 'ចុះឈ្មោះទីនេះ',
            'already_have_account' => 'មានគណនីមែនទេ?',
            'login_here' => 'ចូលគណនីទីនេះ',
            'email_required' => 'អ៊ីម៉ែលមិនអាចទទេ!',
            'confirm_password_required' => 'បញ្ជាក់ពាក្យសម្ងាត់ត្រូវការ។',
            'username_min_length' => 'ឈ្មោះអ្នកប្រើប្រាស់ត្រូវតែមានយ៉ាងតិច ៣ តួអក្សរ។',
            'username_max_length' => 'ឈ្មោះអ្នកប្រើប្រាស់មិនត្រូវលើស ៥០ តួអក្សរ។',
            'username_alphabets_only' => 'ឈ្មោះអ្នកប្រើប្រាស់ត្រូវតែមានតែអក្សរ (a-z, A-Z)។',
            'invalid_email_format' => 'ទម្រង់អ៊ីមែលមិនត្រឹមត្រូវ។',
            'password_min_length' => 'ពាក្យសម្ងាត់ត្រូវតែមានយ៉ាងតិច ៦ តួអក្សរ។',
            'password_alphanumeric_only' => 'ពាក្យសម្ងាត់ត្រូវតែមានតែអក្សរ និងលេខ (a-z, A-Z, 0-9)។',
            'username_or_email_exists' => 'ឈ្មោះអ្នកប្រើប្រាស់ ឬអ៊ីមែលមានរួចហើយ។',
            'database_error' => 'មានកំហុសមូលដ្ឋានទិន្នន័យ។ សូមព្យាយាមម្តងទៀត។',
            'registration_failed' => 'ចុះឈ្មោះបរាជ័យ។ សូមព្យាយាមម្តងទៀត។',
            'username_help_text' => 'តែអក្សរ (a-z, A-Z) ត្រូវបានអនុញ្ញាត, ៣-៥០ តួអក្សរ',
            'email_help_text' => 'បញ្ចូលអាសយដ្ឋានអ៊ីមែលត្រឹមត្រូវ',
            'password_help_text' => 'តែអក្សរ និងលេខ (a-z, A-Z, 0-9) ត្រូវបានអនុញ្ញាត, អប្បបរមា ៦ តួអក្សរ',
            'confirm_password_help_text' => 'បញ្ចូលពាក្យសម្ងាត់របស់អ្នកម្តងទៀតដើម្បីបញ្ជាក់',
            'cv' => 'ទៀង ចំរើន - ប្រវត្តិរូបសង្ខេប',
            'user' => 'អ្នកប្រើប្រាស់',
            'no_cv_data_available' => 'គ្មានទិន្នន័យ ប្រវត្តិរូបសង្ខេប ទេ។ សូមទាក់ទងអ្នកគ្រប់គ្រងដើម្បីរៀបចំ ប្រវត្តិរូបសង្ខេប របស់អ្នក។',
            'language_test' => 'ការធ្វើតេស្តភាសា',
            'current_language' => 'ភាសាបច្ចុប្បន្ន',
            'language_code' => 'កូដភាសា',
            'direction' => 'ទិសដៅ',
            'available_languages' => 'ភាសាដែលមាន',
            'current' => 'បច្ចុប្បន្ន',
            'switch_to' => 'ប្តូរទៅ',
            'translation_examples' => 'ឧទាហរណ៍ការបកប្រែ',
            'common_phrases' => 'ឃ្លាទូទៅ',
            'form_labels' => 'ស្លាកទម្រង់',
            'cv_sections' => 'ផ្នែកប្រវត្តិរូបសង្ខេប',
            'back_to_cv' => 'ត្រឡប់ទៅប្រវត្តិរូបសង្ខេប',

            // CV Sections
            'personal_info' => 'ព័ត៌មានផ្ទាល់ខ្លួន',
            'contact_info' => 'ព័ត៌មានទំនាក់ទំនង',
            'education' => 'ការអប់រំ',
            'experience' => 'បទពិសោធន៍',
            'skills' => 'ជំនាញ',
            'languages' => 'ភាសា',
            'certificates' => 'វិញ្ញាបនបត្រ',
            'projects' => 'គម្រោង',
            'references' => 'ឯកសារយោបល់',

            // Admin
            'admin_dashboard' => 'ផ្ទាំងគ្រប់គ្រងអ្នកគ្រប់គ្រង',
            'manage_users' => 'គ្រប់គ្រងអ្នកប្រើប្រាស់',
            'manage_content' => 'គ្រប់គ្រងមាតិកា',
            'system_settings' => 'ការកំណត់ប្រព័ន្ធ',
            'backup_database' => 'បម្រុងទុកមូលដ្ឋានទិន្នន័យ',
            'view_logs' => 'មើលកំណត់ត្រា',

            // Test Language Page
            'test_language' => 'ធ្វើតេស្តប្រព័ន្ធភាសា',
            'font_test' => 'ធ្វើតេស្តពុម្ពអក្សរ',
            'current_font' => 'ពុម្ពអក្សរបច្ចុប្បន្ន',
            'font_family' => 'គ្រួសារពុម្ពអក្សរ',
            'sample_text' => 'អត្ថបទគំរូ',
            'font_features' => 'លក្ខណៈពិសេសពុម្ពអក្សរ',
            'khmer_support' => 'ការគាំទ្រភាសាខ្មែរ',
            'responsive_design' => 'ការរចនាឆ្លើយតប',
            'google_fonts' => 'ការរួមបញ្ចូលពុម្ពអក្សរ Google',
            'fallback_fonts' => 'ពុម្ពអក្សរជំនួស',
            'custom_font' => 'ពុម្ពអក្សរផ្ទាល់ខ្លួន (Guavine)',
            'elegant_design' => 'ការរចនាស្អាត',
            'web_safe' => 'សុវត្ថិភាពវែប',
            'fast_loading' => 'ការផ្ទុកលឿន'
      ],

      'zh' => [
            // Header
            'welcome' => '欢迎',
            'welcome_guest' => '欢迎访客！',
            'login_to_access' => '请登录以访问您的简历',
            'successfully_logged_in' => '您已成功登录',
            'logout' => '退出登录',
            'login' => '登录',
            'register' => '注册',

            // Navigation
            'view_cv' => '查看个人简历',
            'view_sr1' => '查看个人简历 ',
            'view_sr2' => '查看求职信',
            'view_certificates' => '查看证书',
            'download_pdf' => '下载PDF',
            'admin_panel' => '管理面板',
            'dashboard' => '仪表板',

            // Portfolio Dropdown
            'portfolio_sections' => '简历部分',
            'personal_information' => '个人信息',
            'skills_expertise' => '技能',
            'professional_experience' => '工作经验',
            'education' => '教育背景',
            'courses' => '课程',
            'languages' => '语言',
            'interests_hobbies' => '兴趣爱好',
            'connect_with_me' => '联系我',

            // Language switcher
            'select_language' => '选择语言',
            'language' => '语言',

            // Common
            'yes' => '是',
            'no' => '否',
            'save' => '保存',
            'cancel' => '取消',
            'delete' => '删除',
            'edit' => '编辑',
            'add' => '添加',
            'update' => '更新',
            'search' => '搜索',
            'loading' => '加载中...',
            'error' => '错误',
            'success' => '成功',
            'warning' => '警告',
            'info' => '信息',

            // Forms
            'username' => '用户名',
            'password' => '密码',
            'email' => '电子邮件',
            'confirm_password' => '确认密码',
            'submit' => '提交',
            'reset' => '重置',

            // Messages
            'login_successful' => '登录成功！',
            'login_failed' => '登录失败。请检查您的凭据。',
            'logout_successful' => '退出登录成功！',
            'registration_successful' => '注册成功！',
            'registration_failed' => '注册失败。请重试。',
            'password_mismatch' => '密码不匹配。',
            'user_exists' => '用户名已存在。',
            'invalid_credentials' => '用户名或密码无效。',
            'username_required' => '用户名是必需的。',
            'password_required' => '密码是必需的。',
            'remember_me' => '记住我',
            'show_saved_credentials' => '显示保存的凭据',
            'dont_have_account' => "没有账户？",
            'register_here' => '在这里注册',
            'already_have_account' => '已有账户？',
            'login_here' => '在这里登录',
            'email_required' => '电子邮件是必需的。',
            'confirm_password_required' => '确认密码是必需的。',
            'username_min_length' => '用户名必须至少包含3个字符。',
            'username_max_length' => '用户名不能超过50个字符。',
            'username_alphabets_only' => '用户名只能包含字母（a-z, A-Z）。',
            'invalid_email_format' => '电子邮件格式无效。',
            'password_min_length' => '密码必须至少包含6个字符。',
            'password_alphanumeric_only' => '密码只能包含字母和数字。',
            'username_or_email_exists' => '用户名或电子邮件已存在。',
            'database_error' => '数据库错误。请重试。',
            'registration_failed' => '注册失败。请重试。',
            'username_help_text' => '只允许字母（a-z, A-Z），3-50个字符',
            'email_help_text' => '输入有效的电子邮件地址',
            'password_help_text' => '只允许字母和数字（a-z, A-Z, 0-9），最少6个字符',
            'confirm_password_help_text' => '重新输入密码以确认',
            'cv' => '田格 占伦 - 个人简历',
            'user' => '用户',
            'no_cv_data_available' => '没有简历数据。请联系管理员设置您的简历。',
            'language_test' => '语言测试',
            'current_language' => '当前语言',
            'language_code' => '语言代码',
            'direction' => '方向',
            'available_languages' => '可用语言',
            'current' => '当前',
            'switch_to' => '切换到',
            'translation_examples' => '翻译示例',
            'common_phrases' => '常用短语',
            'form_labels' => '表单标签',
            'cv_sections' => '简历部分',
            'back_to_cv' => '返回简历',

            // CV Sections
            'personal_info' => '个人信息',
            'contact_info' => '联系信息',
            'education' => '教育背景',
            'experience' => '工作经验',
            'skills' => '技能',
            'languages' => '语言',
            'certificates' => '证书',
            'projects' => '项目',
            'references' => '推荐人',

            // Admin
            'admin_dashboard' => '管理仪表板',
            'manage_users' => '管理用户',
            'manage_content' => '管理内容',
            'system_settings' => '系统设置',
            'backup_database' => '备份数据库',
            'view_logs' => '查看日志',

            // Test Language Page
            'test_language' => '测试语言系统',
            'font_test' => '字体测试',
            'current_font' => '当前字体',
            'font_family' => '字体系列',
            'sample_text' => '示例文本',
            'font_features' => '字体特性',
            'khmer_support' => '高棉语支持',
            'responsive_design' => '响应式设计',
            'google_fonts' => 'Google字体集成',
            'fallback_fonts' => '备用字体',
            'custom_font' => '自定义字体 (Guavine)',
            'elegant_design' => '优雅设计',
            'web_safe' => '网页安全',
            'fast_loading' => '快速加载'
      ]
];

/**
 * Get translation for a key
 * @param string $key Translation key
 * @param string $lang Language code (optional, uses current language if not provided)
 * @return string Translated text
 */
function t($key, $lang = null, $wrap = true)
{
      global $translations, $current_language;

      $lang = $lang ?: $current_language;

      if (isset($translations[$lang][$key])) {
            return $translations[$lang][$key];
      }

      // Fallback to English if translation not found
      if ($lang !== 'en' && isset($translations['en'][$key])) {
            // Wrap fallback text in a span with a special class
            return $wrap
                  ? '<span class="fallback-en">' . $translations['en'][$key] . '</span>'
                  : $translations['en'][$key];
      }

      // Return key if no translation found
      return $key;
}

/**
 * Get current language info
 * @return array Language information
 */
function getCurrentLanguage()
{
      global $available_languages, $current_language;
      return $available_languages[$current_language];
}

/**
 * Get all available languages
 * @return array All available languages
 */
function getAvailableLanguages()
{
      global $available_languages;
      return $available_languages;
}

/**
 * Check if current language is RTL
 * @return bool True if RTL language
 */
function isRTL()
{
      global $current_language;
      // Currently no RTL languages supported, but can be extended
      return false;
}

/**
 * Get language direction
 * @return string 'ltr' or 'rtl'
 */
function getLanguageDirection()
{
      return isRTL() ? 'rtl' : 'ltr';
}
