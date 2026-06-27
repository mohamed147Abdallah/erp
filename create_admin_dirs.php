<?php

$views = [
    'admin/users/index.blade.php' => 'Users',
    'admin/users/create.blade.php' => 'Create User',
    'admin/users/edit.blade.php' => 'Edit User',
    'admin/roles/index.blade.php' => 'Roles',
    'admin/roles/create.blade.php' => 'Create Role',
    'admin/roles/edit.blade.php' => 'Edit Role',
    'admin/permissions/index.blade.php' => 'Permissions',
    'settings/index.blade.php' => 'Settings',
];

$baseDir = __DIR__ . '/resources/views/';

foreach ($views as $path => $title) {
    $fullPath = $baseDir . $path;
    $dir = dirname($fullPath);
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
}
echo "Directories created.\n";
