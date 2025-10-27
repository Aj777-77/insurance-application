<?php

// Create storage directories if they don't exist
$directories = [
    storage_path('app'),
    storage_path('app/public'),
    storage_path('framework'),
    storage_path('framework/cache'),
    storage_path('framework/cache/data'),
    storage_path('framework/sessions'),
    storage_path('framework/views'),
    storage_path('logs'),
];

foreach ($directories as $directory) {
    if (!file_exists($directory)) {
        mkdir($directory, 0755, true);
    }
}

// Create symbolic link for storage
if (!file_exists(public_path('storage'))) {
    symlink(storage_path('app/public'), public_path('storage'));
}

echo "Storage directories and symlink created successfully.\n";