<?php
/**
 * Laravel Application Entry Point for Laragon
 * 
 * This file redirects requests to the public directory
 * so you can access the app at http://localhost/insurance
 */

// Check if we're trying to access a public asset directly
$request_uri = $_SERVER['REQUEST_URI'];
$base_path = '/insurance';

// Remove the base path to get the relative URI
if (strpos($request_uri, $base_path) === 0) {
    $relative_uri = substr($request_uri, strlen($base_path));
} else {
    $relative_uri = $request_uri;
}

// If it's an empty request or just a slash, redirect to public
if (empty($relative_uri) || $relative_uri === '/') {
    header('Location: /insurance/public/');
    exit;
}

// Check if the file exists in public directory
$public_file = __DIR__ . '/public' . $relative_uri;
if (file_exists($public_file) && is_file($public_file)) {
    // Serve the file directly
    $mime_type = mime_content_type($public_file);
    header('Content-Type: ' . $mime_type);
    readfile($public_file);
    exit;
}

// For all other requests, redirect to public with the path
header('Location: /insurance/public' . $relative_uri);
exit;
?>