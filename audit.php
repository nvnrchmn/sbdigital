<?php

$dirs = [
    'app/Livewire/Tenant',
    'app/Livewire/Central',
    'app/Livewire/Layout'
];

$results = [];

function checkFile($path) {
    $content = file_get_contents($path);
    $methods = ['mount', 'save', 'delete', 'approve', 'update'];
    
    $missing = [];
    foreach ($methods as $method) {
        if (preg_match('/public function ' . $method . '\s*\(/', $content)) {
            // Check if method body has authorization
            $methodPattern = '/public function ' . $method . '\s*\([^)]*\)\s*\{([^}]*)\}/s';
            if (preg_match($methodPattern, $content, $matches)) {
                $body = $matches[1];
                if (!preg_match('/(abort_unless|abort_if|can\(|authorize\(|hasAnyRole|hasRole)/', $body)) {
                    $missing[] = $method;
                }
            } else {
                // If regex fails to capture full body properly, just check globally near the method
                $missing[] = $method . ' (regex fail)';
            }
        }
    }
    
    if (!empty($missing)) {
        return $missing;
    }
    return null;
}

foreach ($dirs as $dir) {
    if (!is_dir($dir)) continue;
    
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($files as $file) {
        if ($file->getExtension() === 'php') {
            $res = checkFile($file->getPathname());
            if ($res) {
                echo $file->getPathname() . " -> missing auth in: " . implode(', ', $res) . "\n";
            }
        }
    }
}
