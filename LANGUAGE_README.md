# Multi-Language Support for Portfolio Website

This portfolio website now supports three languages: English, Khmer (Cambodia), and Chinese.

## Features

### 🌍 Language Support
- **English (en)** - 🇺🇸 Default language
- **Khmer (km)** - 🇰🇭 Cambodian language
- **Chinese (zh)** - 🇨🇳 Simplified Chinese

### 🔄 Language Switcher
- Beautiful dropdown language switcher in the header
- Shows flag, language name, and native name
- Remembers user's language preference in session
- Works on both desktop and mobile devices

### 📱 Responsive Design
- Mobile-friendly language switcher
- Responsive navigation with translated content
- Consistent styling across all devices

## Files Modified/Created

### Core Language System
- `languages.php` - Main language system with translations
- `header.php` - Updated with language switcher
- `login.php` - Translated login form
- `register.php` - Translated registration form
- `index.php` - Updated with language support
- `test_language.php` - Language testing page

### Translation Structure

The language system uses a simple key-value translation approach:

```php
$translations = [
    'en' => [
        'welcome' => 'Welcome',
        'login' => 'Login',
        // ... more translations
    ],
    'km' => [
        'welcome' => 'សូមស្វាគមន៍',
        'login' => 'ចូលគណនី',
        // ... more translations
    ],
    'zh' => [
        'welcome' => '欢迎',
        'login' => '登录',
        // ... more translations
    ]
];
```

## Usage

### Basic Translation
```php
<?php echo t('welcome'); ?>
```

### Language Information
```php
$current_lang = getCurrentLanguage();
$available_langs = getAvailableLanguages();
```

### Language Direction
```php
$direction = getLanguageDirection(); // 'ltr' or 'rtl'
```

## Implementation Details

### 1. Language Detection
- URL parameter: `?lang=en`
- Session storage for persistence
- Default fallback to English

### 2. Translation Function
```php
function t($key, $lang = null) {
    // Returns translated text or falls back to English
    // If no translation found, returns the key
}
```

### 3. HTML Language Attributes
```html
<html lang="<?php echo $current_language; ?>" dir="<?php echo getLanguageDirection(); ?>">
```

### 4. Language Switcher Features
- Dropdown with flags and native names
- Active language highlighting
- Click outside to close
- Escape key support
- Mobile responsive

## Adding New Languages

To add a new language:

1. **Add language configuration** in `languages.php`:
```php
'fr' => [
    'code' => 'fr',
    'name' => 'French',
    'native_name' => 'Français',
    'flag' => '🇫🇷'
]
```

2. **Add translations** in the `$translations` array:
```php
'fr' => [
    'welcome' => 'Bienvenue',
    'login' => 'Connexion',
    // ... add all required translations
]
```

3. **Update RTL support** if needed in `isRTL()` function

## Translation Categories

The translations are organized into categories:

- **Header** - Navigation and welcome messages
- **Navigation** - Menu items and buttons
- **Language Switcher** - Language selection interface
- **Common** - General UI elements
- **Forms** - Form labels and validation
- **Messages** - Success/error messages
- **CV Sections** - Resume content sections
- **Admin** - Administrative interface

## Testing

Visit `test_language.php` to:
- See current language settings
- Test language switching
- View translation examples
- Verify responsive design

## Browser Support

- Modern browsers with emoji support
- Fallback for older browsers
- Progressive enhancement approach

## Performance

- Lightweight translation system
- No external dependencies
- Fast language switching
- Minimal overhead

## Future Enhancements

Potential improvements:
- Database-driven translations
- Automatic language detection
- Translation management interface
- More languages support
- RTL language support (Arabic, Hebrew)
- Translation memory/caching

## Notes

- All user-facing text should use the `t()` function
- Maintain consistent translation keys across languages
- Test thoroughly in all supported languages
- Consider cultural differences in translations
- Keep translations concise and clear 