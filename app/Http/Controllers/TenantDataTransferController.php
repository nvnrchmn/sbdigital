<?php

namespace App\Http\Controllers;

use App\Models\Rumah;
use App\Models\Warga;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TenantDataTransferController extends Controller
{
    public function template(string $module): StreamedResponse
    {
        return $this->csv($module . '-template.csv', function ($out) use ($module) {
            fputcsv($out, $module === 'rumah'
                ? ['nomor_blok', 'keterangan']
                : ['nik', 'nama_lengkap', 'nomor_blok', 'no_hp', 'status_warga']);
        });
    }

    public function export(string $module): StreamedResponse
    {
        abort_unless(auth()->user()->hasRole('Tenant Owner'), 403);

        return $this->csv($module . '-export.csv', function ($out) use ($module) {
            if ($module === 'rumah') {
                fputcsv($out, ['nomor_blok', 'keterangan']);
                Rumah::orderBy('nomor_blok')->cursor()->each(fn ($rumah) => fputcsv($out, [$rumah->nomor_blok, $rumah->keterangan]));
                return;
            }

            fputcsv($out, ['nik', 'nama_lengkap', 'nomor_blok', 'no_hp', 'status_warga']);
            Warga::with('rumah')->orderBy('nama_lengkap')->cursor()->each(fn ($warga) => fputcsv($out, [
                $warga->nik,
                $warga->nama_lengkap,
                $warga->rumah?->nomor_blok,
                $warga->no_hp,
                $warga->status_warga,
            ]));
        });
    }

    public function import(Request $request, string $module)
    {
        abort_unless(auth()->user()->hasRole('Tenant Owner'), 403);

        $request->validate(['file' => ['required', 'file', 'mimes:csv,txt', 'max:2048']]);
        $handle = fopen($request->file('file')->getRealPath(), 'r');
        $header = array_map('trim', fgetcsv($handle) ?: []);
        $imported = 0;

        while (($row = fgetcsv($handle)) !== false) {
            $data = array_combine($header, array_pad($row, count($header), null));
            if ($module === 'rumah') {
                if (blank($data['nomor_blok'] ?? null)) continue;
                Rumah::updateOrCreate(['nomor_blok' => trim($data['nomor_blok'])], ['keterangan' => $data['keterangan'] ?? null]);
            } else {
                if (blank($data['nik'] ?? null) || blank($data['nama_lengkap'] ?? null) || blank($data['nomor_blok'] ?? null)) continue;
                $rumah = Rumah::firstOrCreate(['nomor_blok' => trim($data['nomor_blok'])]);
                Warga::updateOrCreate(['nik' => trim($data['nik'])], [
                    'nama_lengkap' => $data['nama_lengkap'],
                    'id_rumah' => $rumah->id,
                    'no_hp' => $data['no_hp'] ?? null,
                    'status_warga' => in_array(($data['status_warga'] ?? 'Tetap'), ['Tetap', 'Kontrak'], true) ? $data['status_warga'] : 'Tetap',
                ]);
            }
            $imported++;
        }
        fclose($handle);

        return back()->with('success', "Berhasil import {$imported} data {$module}.");
    }

    private function csv(string $filename, callable $callback): StreamedResponse
    {
        return response()->streamDownload(fn () => $callback(fopen('php://output', 'w')), $filename, ['Content-Type' => 'text/csv']);
    }
}
