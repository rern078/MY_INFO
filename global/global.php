<?php
// Handle random profile image functionality
function getRandomProfileImage()
{
      $randomImagesDir = 'images/random/';
      $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

      // Check if directory exists
      if (!is_dir($randomImagesDir)) {
            return null;
      }

      // Get all image files from the random directory
      $imageFiles = [];
      $files = scandir($randomImagesDir);

      foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                  $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                  if (in_array($extension, $allowedExtensions)) {
                        $imageFiles[] = $file;
                  }
            }
      }

      // If no images found, return null
      if (empty($imageFiles)) {
            return null;
      }

      // If user doesn't have a profile image assigned in session, assign one randomly
      if (!isset($_SESSION['profile_image'])) {
            $_SESSION['profile_image'] = $imageFiles[array_rand($imageFiles)];
      }

      return $randomImagesDir . $_SESSION['profile_image'];
}
