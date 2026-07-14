<?php

$patches = [
    'app/Livewire/Tenant/Iuran/Form.php' => [
        'save' => "        abort_unless(auth()->user()->hasAnyRole(['Tenant Owner', 'Ketua RT', 'Bendahara']), 403, 'Akses ditolak.');\n"
    ],
    'app/Livewire/Tenant/Keluhan/Form.php' => [
        'save' => "        abort_unless(auth()->user()->can('create keluhan') || auth()->user()->can('edit keluhan'), 403, 'Akses ditolak.');\n"
    ],
    'app/Livewire/Tenant/Langganan/Index.php' => [
        'mount' => "        abort_unless(auth()->user()->hasRole('Tenant Owner'), 403, 'Akses ditolak.');\n"
    ],
    'app/Livewire/Tenant/Lapak/Form.php' => [
        'save' => "        abort_unless(auth()->user()->can('create lapak') || auth()->user()->can('edit lapak'), 403, 'Akses ditolak.');\n"
    ],
    'app/Livewire/Tenant/Laporan/Form.php' => [
        'mount' => "        abort_unless(auth()->user()->can('create laporan') || auth()->user()->can('edit laporan'), 403, 'Akses ditolak.');\n",
        'save' => "        abort_unless(auth()->user()->can('create laporan') || auth()->user()->can('edit laporan'), 403, 'Akses ditolak.');\n"
    ],
    'app/Livewire/Tenant/Pengumuman/Index.php' => [
        'delete' => "        abort_unless(auth()->user()->can('delete pengumuman'), 403, 'Akses ditolak.');\n"
    ],
    'app/Livewire/Tenant/Polling/Show.php' => [
        'mount' => "        abort_unless(auth()->user()->can('view polling'), 403, 'Akses ditolak.');\n"
    ],
    'app/Livewire/Tenant/Rumah/Index.php' => [
        'delete' => "        abort_unless(auth()->user()->can('delete rumah'), 403, 'Akses ditolak.');\n"
    ],
    'app/Livewire/Tenant/Surat/Form.php' => [
        'save' => "        abort_unless(auth()->user()->can('create surat') || auth()->user()->can('edit surat'), 403, 'Akses ditolak.');\n"
    ],
    'app/Livewire/Central/Announcement/Form.php' => [
        'mount' => "        abort_unless(auth()->user()->hasRole('Super Admin'), 403, 'Akses ditolak.');\n",
        'save' => "        abort_unless(auth()->user()->hasRole('Super Admin'), 403, 'Akses ditolak.');\n"
    ],
    'app/Livewire/Central/Plan/Form.php' => [
        'mount' => "        abort_unless(auth()->user()->hasRole('Super Admin'), 403, 'Akses ditolak.');\n",
        'save' => "        abort_unless(auth()->user()->hasRole('Super Admin'), 403, 'Akses ditolak.');\n"
    ],
    'app/Livewire/Central/Settings/Index.php' => [
        'mount' => "        abort_unless(auth()->user()->hasRole('Super Admin'), 403, 'Akses ditolak.');\n"
    ],
    'app/Livewire/Central/Tenant/Form.php' => [
        'mount' => "        abort_unless(auth()->user()->hasRole('Super Admin'), 403, 'Akses ditolak.');\n",
        'save' => "        abort_unless(auth()->user()->hasRole('Super Admin'), 403, 'Akses ditolak.');\n"
    ],
    'app/Livewire/Central/VerifyTenant.php' => [
        'mount' => "        // Public endpoint, maybe? Or needs auth? If Central component is public, we skip. But Verify is usually public or uses token.\n"
    ]
];

foreach ($patches as $file => $methods) {
    if (!file_exists($file)) continue;
    
    $content = file_get_contents($file);
    
    foreach ($methods as $method => $injection) {
        if (strpos($injection, '//') === 0) continue; // Skip comment
        
        $pattern = '/(public function ' . $method . '\s*\([^)]*\)\s*\{)(?!\s*abort_unless)/';
        $replacement = "$1\n$injection";
        $content = preg_replace($pattern, $replacement, $content, 1);
    }
    
    file_put_contents($file, $content);
    echo "Patched: $file\n";
}
