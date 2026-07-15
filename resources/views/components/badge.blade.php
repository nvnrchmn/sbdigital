@props(['status' => 'default'])
@php
$statusLower = strtolower($status);
$map = [
    'lunas'   => 'bg-success-100 text-emerald-800',
    'sukses'  => 'bg-success-100 text-emerald-800',
    'aktif'   => 'bg-success-100 text-emerald-800',
    'tetap'   => 'bg-success-100 text-emerald-800',
    'pending' => 'bg-warning-100 text-amber-800',
    'proses'  => 'bg-warning-100 text-amber-800',
    'kontrak' => 'bg-warning-100 text-amber-800',
    'telat'   => 'bg-danger-100 text-red-800',
    'gagal'   => 'bg-danger-100 text-red-800',
    'batal'   => 'bg-danger-100 text-red-800',
    'ditolak' => 'bg-danger-100 text-red-800',
    'draft'   => 'bg-slate-100 text-slate-700',
    'selesai' => 'bg-brand-cyan-100 text-brand-cyan-800',
];
$colorClass = $map[$statusLower] ?? 'bg-slate-100 text-slate-700 border border-slate-200';
@endphp
<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-full px-2.5 py-0.5 text-caption font-medium {$colorClass}"]) }}>
    {{ $slot }}
</span>
