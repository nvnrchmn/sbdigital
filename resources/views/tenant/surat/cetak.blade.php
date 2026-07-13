<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Pengantar RT/RW - {{ $surat->warga->nama_lengkap ?? 'Anonim' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @page {
            size: A4;
            margin: 2cm;
        }
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .no-print {
                display: none !important;
            }
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.5;
            color: #000;
        }
    </style>
</head>
<body class="bg-slate-100 print:bg-white text-black">
    <div class="no-print p-4 bg-slate-800 text-white flex justify-between items-center sticky top-0 z-50">
        <div>
            <h1 class="font-bold">Pratinjau Cetak Surat Pengantar</h1>
            <p class="text-xs text-slate-300">Gunakan kertas A4 untuk hasil terbaik.</p>
        </div>
        <div class="flex gap-2">
            <button onclick="window.close()" class="px-4 py-2 bg-slate-700 hover:bg-slate-600 rounded-lg text-sm font-medium">Tutup</button>
            <button onclick="window.print()" class="px-4 py-2 bg-blue-600 hover:bg-blue-500 rounded-lg text-sm font-medium flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9V2h12v7"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><path d="M6 14h12v8H6z"/></svg>
                Cetak Dokumen
            </button>
        </div>
    </div>

    <!-- Kertas A4 -->
    <div class="w-[210mm] min-h-[297mm] mx-auto bg-white shadow-xl print:shadow-none p-[2cm] relative box-border mt-8 mb-8 print:my-0">
        <!-- KOP Surat (Sederhana) -->
        <div class="text-center border-b-[3px] border-black pb-4 mb-6">
            <h1 class="font-bold text-2xl uppercase tracking-wider">Rukun Tetangga (RT) {{ tenant('id') }}</h1>
            <h2 class="font-bold text-xl uppercase tracking-wider">Rukun Warga (RW) XX</h2>
            <p class="text-sm">Perumahan SB Digital, Kelurahan/Desa Contoh, Kecamatan Contoh</p>
            <p class="text-sm">Kabupaten/Kota Contoh, Provinsi Contoh, Kode Pos 12345</p>
        </div>

        <!-- Judul Surat -->
        <div class="text-center mb-8">
            <h3 class="font-bold text-xl uppercase underline tracking-wide">Surat Pengantar</h3>
            <p class="mt-1">Nomor: {{ $surat->nomor_surat ?? '......./RT/RW/.......' }}</p>
        </div>

        <!-- Isi Surat -->
        <div class="text-justify mb-8 space-y-4">
            <p>Yang bertanda tangan di bawah ini, Ketua RT {{ tenant('id') }} Perumahan SB Digital, menerangkan dengan sesungguhnya bahwa:</p>
            
            <table class="w-full ml-8 mb-4">
                <tr>
                    <td class="w-48 py-1">Nama Lengkap</td>
                    <td class="w-4 py-1">:</td>
                    <td class="font-bold">{{ $surat->warga->nama_lengkap ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="py-1">Nomor KTP / NIK</td>
                    <td class="py-1">:</td>
                    <td>{{ $surat->warga->nik ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="py-1">Tempat, Tanggal Lahir</td>
                    <td class="py-1">:</td>
                    <td>{{ $surat->warga->tempat_lahir ?? '-' }}, {{ $surat->warga->tanggal_lahir ? $surat->warga->tanggal_lahir->format('d F Y') : '-' }}</td>
                </tr>
                <tr>
                    <td class="py-1">Jenis Kelamin</td>
                    <td class="py-1">:</td>
                    <td>{{ $surat->warga->jenis_kelamin ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="py-1">Agama</td>
                    <td class="py-1">:</td>
                    <td>{{ $surat->warga->agama ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="py-1">Alamat</td>
                    <td class="py-1">:</td>
                    <td>{{ $surat->warga->rumah->blok ?? '' }} No. {{ $surat->warga->rumah->nomor ?? '' }}, Perumahan SB Digital RT {{ tenant('id') }}</td>
                </tr>
            </table>

            <p>Orang tersebut di atas adalah benar-benar warga RT {{ tenant('id') }} Perumahan SB Digital yang berdomisili di alamat tersebut.</p>
            
            <p>Surat pengantar ini diberikan untuk keperluan: <br>
                <strong class="uppercase underline">{{ $surat->keperluan }}</strong>
            </p>

            <p>Demikian surat pengantar ini dibuat dengan sebenarnya, untuk dapat dipergunakan sebagaimana mestinya oleh pihak yang berkepentingan.</p>
        </div>

        <!-- Tanda Tangan -->
        <div class="flex justify-end mt-16 text-center">
            <div class="w-64">
                <p>Dikeluarkan di: Perumahan SB Digital</p>
                <p>Pada tanggal: {{ $surat->tanggal_disetujui ? $surat->tanggal_disetujui->format('d F Y') : now()->format('d F Y') }}</p>
                <p class="mt-4 mb-20">Ketua RT {{ tenant('id') }}</p>
                
                <p class="font-bold underline uppercase">( ............................................ )</p>
            </div>
        </div>
    </div>
</body>
</html>
