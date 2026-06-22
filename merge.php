<?php
$homeContent = file_get_contents('C:\xampp\htdocs\celestia-bibliotheca\app\Views\user\home.php');
$dashContent = file_get_contents('C:\xampp\htdocs\celestia-bibliotheca\app\Views\user\dashboard.php');

// Extract styles from home
preg_match('/<style>(.*?)<\/style>/s', $homeContent, $homeStylesMatch);
$homeStyles = $homeStylesMatch[1] ?? '';

// Extract styles from dashboard
preg_match('/<style>(.*?)<\/style>/s', $dashContent, $dashStylesMatch);
$dashStyles = $dashStylesMatch[1] ?? '';

// Remove the old hero and categories styles from dashboard styles
$dashStyles = preg_replace('/\/\* Hero \*\/.*?\/\* Section \*\//s', '/* Section */', $dashStyles);
$dashStyles = preg_replace('/\/\* Categories \*\/.*?\/\* Services quick links \*\//s', '/* Services quick links */', $dashStyles);

// We need to keep the Search Block styles! Wait, the Search block styles were under /* Hero */ in dashboard.php.
// Let's just manually define the new CSS in the script below to be safe and clean.
