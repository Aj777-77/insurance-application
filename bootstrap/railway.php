<?php

try {
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
        base_path('bootstrap/cache'),
    ];

    foreach ($directories as $directory) {
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
            echo "Created directory: $directory\n";
        }
    }

    // Create symbolic link for storage
    $storageLink = public_path('storage');
    $storagePath = storage_path('app/public');
    
    if (!file_exists($storageLink) && file_exists($storagePath)) {
        if (is_link($storageLink)) {
            unlink($storageLink);
        }
        symlink($storagePath, $storageLink);
        echo "Created storage symlink\n";
    }

    echo "Railway setup completed successfully.\n";
    
} catch (Exception $e) {
    echo "Railway setup error: " . $e->getMessage() . "\n";
    // Don't fail completely, just log the error
}