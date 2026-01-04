@extends('layouts.admin')

@section('title', 'Import Data Produk - Maneé Admin')

@section('content')
<div class="max-w-[1400px] mx-auto flex flex-col gap-6" x-data="importPage()">
    <!-- Breadcrumbs -->
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 dark:text-slate-400 dark:hover:text-white transition-colors">
                    <span class="material-symbols-outlined text-[18px] mr-2">home</span>
                    Dashboard
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <span class="material-symbols-outlined text-slate-400 text-[18px]">chevron_right</span>
                    <a href="{{ route('admin.products.index') }}" class="ml-1 text-sm font-medium text-slate-500 hover:text-blue-600 dark:text-slate-400 dark:hover:text-white md:ml-2 transition-colors">Produk</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <span class="material-symbols-outlined text-slate-400 text-[18px]">chevron_right</span>
                    <span class="ml-1 text-sm font-medium text-slate-900 dark:text-white md:ml-2">Import Data</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Page Heading & Instructions -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div class="flex flex-col gap-1">
            <h1 class="text-slate-900 dark:text-white tracking-tight text-3xl font-bold">Import Data Produk</h1>
            <p class="text-slate-500 dark:text-slate-400 text-base font-normal max-w-2xl">
                Unggah file data produk untuk memperbarui inventaris secara massal. Pastikan format file Anda sesuai dengan template standar kami.
            </p>
        </div>
        <div>
            <a href="{{ route('admin.products.template') }}" class="flex items-center justify-center rounded-lg h-10 px-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 gap-2 text-sm font-semibold transition-colors shadow-sm whitespace-nowrap">
                <span class="material-symbols-outlined text-[20px]">download</span>
                <span>Unduh Template Excel</span>
            </a>
        </div>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            <span class="font-medium">Success!</span> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
            <span class="font-medium">Error!</span> {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
            <span class="font-medium">Validation Error!</span>
            <ul class="mt-1.5 ml-4 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Main Upload Form -->
    <form action="{{ route('admin.products.import') }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-slate-200 dark:border-gray-800 overflow-hidden">
        @csrf
        <div class="p-8 flex flex-col gap-8">
            
            <!-- Drag and Drop Area -->
            <div class="w-full">
                <label 
                    for="dropzone-file" 
                    class="flex flex-col items-center justify-center w-full h-64 border-2 border-dashed rounded-xl cursor-pointer transition-all group relative"
                    :class="isDragging ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/10' : 'bg-slate-50 dark:bg-slate-900/50 border-slate-300 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 hover:border-blue-500 dark:hover:border-blue-500'"
                    @dragover.prevent="isDragging = true"
                    @dragleave.prevent="isDragging = false"
                    @drop.prevent="handleDrop($event)"
                >
                    <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center">
                        <template x-if="fileName">
                            <div class="flex flex-col items-center animate-pulse">
                                <div class="mb-4 rounded-full bg-green-50 dark:bg-green-900/20 p-4">
                                    <span class="material-symbols-outlined text-4xl text-green-500">check_circle</span>
                                </div>
                                <p class="mb-2 text-lg font-semibold text-slate-700 dark:text-slate-200">File Terpilih</p>
                                <p class="text-sm text-slate-500 dark:text-slate-400 font-medium" x-text="fileName"></p>
                                <p class="mt-4 text-xs text-blue-600 hover:underline">Klik untuk mengganti file</p>
                            </div>
                        </template>
                        <template x-if="!fileName">
                            <div class="flex flex-col items-center">
                                <div class="mb-4 rounded-full bg-blue-50 dark:bg-blue-900/20 p-4 transition-transform group-hover:scale-110" :class="isDragging ? 'scale-110' : ''">
                                    <span class="material-symbols-outlined text-4xl text-blue-600">cloud_upload</span>
                                </div>
                                <p class="mb-2 text-lg font-semibold text-slate-700 dark:text-slate-200">
                                    <span x-text="isDragging ? 'Lepaskan file di sini' : 'Klik untuk upload atau drag & drop'"></span>
                                </p>
                                <p class="text-sm text-slate-500 dark:text-slate-400">CSV, XLS, atau XLSX (Maks. 10MB)</p>
                            </div>
                        </template>
                    </div>
                    <input id="dropzone-file" type="file" name="file" class="hidden" accept=".csv, .xlsx, .xls" @change="handleFileSelect($event)" />
                </label>
            </div>

            <!-- Import Options -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-slate-100 dark:border-slate-800">
                <div class="flex flex-col gap-3">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Mode Import</h3>
                    <div class="flex flex-col gap-3">
                        <label class="flex items-start p-3 border rounded-lg cursor-pointer transition-colors relative"
                            :class="importMode === 'new' ? 'border-blue-500 bg-blue-50/50 dark:bg-blue-900/10' : 'border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 hover:border-blue-500 dark:hover:border-blue-500'">
                            <input type="radio" name="import_mode" value="new" x-model="importMode" class="mt-1 h-4 w-4 border-slate-300 text-blue-600 focus:ring-blue-500">
                            <div class="ml-3 flex flex-col">
                                <span class="block text-sm font-medium text-slate-900 dark:text-white">Tambah Produk Baru</span>
                                <span class="block text-xs text-slate-500 dark:text-slate-400 mt-1">Lewati baris jika SKU sudah ada di database.</span>
                            </div>
                        </label>

                        <label class="flex items-start p-3 border rounded-lg cursor-pointer transition-colors relative"
                            :class="importMode === 'update' ? 'border-blue-500 bg-blue-50/50 dark:bg-blue-900/10' : 'border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 hover:border-blue-500 dark:hover:border-blue-500'">
                            <input type="radio" name="import_mode" value="update" x-model="importMode" class="mt-1 h-4 w-4 border-slate-300 text-blue-600 focus:ring-blue-500">
                            <div class="ml-3 flex flex-col">
                                <span class="block text-sm font-medium text-slate-900 dark:text-white">Perbarui Produk yang Ada</span>
                                <span class="block text-xs text-slate-500 dark:text-slate-400 mt-1">Timpa data produk jika SKU ditemukan.</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="flex flex-col gap-3">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Notifikasi</h3>
                    <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg flex gap-3">
                        <span class="material-symbols-outlined text-blue-600 shrink-0">info</span>
                        <div class="text-sm text-slate-700 dark:text-slate-300">
                            <p class="font-medium mb-1">Sebelum memulai:</p>
                            <ul class="list-disc ml-4 space-y-1 text-slate-600 dark:text-slate-400 text-xs">
                                <li>Pastikan header kolom sesuai template.</li>
                                <li>Periksa format tanggal (DD/MM/YYYY).</li>
                                <li>Maksimal 5000 baris per file.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row justify-end items-center gap-4 pt-4">
                <a href="{{ route('admin.products.index') }}" class="w-full sm:w-auto px-6 py-2.5 text-center rounded-lg text-slate-600 dark:text-slate-300 font-medium hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                    Batal
                </a>
                <button type="submit" class="w-full sm:w-auto flex items-center justify-center gap-2 px-6 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-bold shadow-lg shadow-blue-500/30 transition-all hover:scale-[1.02]">
                    <span class="material-symbols-outlined">publish</span>
                    Mulai Import Data
                </button>
            </div>
        </div>
    </form>

    <!-- Recent Imports Table (Mockup) -->
    <div class="flex flex-col gap-4">
        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Riwayat Import Terakhir</h3>
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-slate-200 dark:border-gray-800 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-500 dark:text-slate-400">
                    <thead class="text-xs text-slate-700 uppercase bg-slate-50 dark:bg-gray-800 dark:text-slate-400 border-b border-slate-200 dark:border-slate-700">
                        <tr>
                            <th scope="col" class="px-6 py-4">Nama File</th>
                            <th scope="col" class="px-6 py-4">Tanggal</th>
                            <th scope="col" class="px-6 py-4">Status</th>
                            <th scope="col" class="px-6 py-4">Total Data</th>
                            <th scope="col" class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse($histories as $history)
                        <tr class="bg-white dark:bg-gray-900 hover:bg-slate-50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-900 dark:text-white flex items-center gap-2">
                                <span class="material-symbols-outlined text-xl {{ $history->file_name ? 'text-blue-500' : 'text-slate-400' }}">description</span>
                                {{ $history->file_name ?? 'Unknown' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $history->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                @if($history->status === 'completed')
                                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900/30 dark:text-green-300 border border-green-200 dark:border-green-800">
                                        Selesai
                                    </span>
                                @elseif($history->status === 'failed')
                                    <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-red-900/30 dark:text-red-300 border border-red-200 dark:border-red-800">
                                        Gagal
                                    </span>
                                @else
                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900/30 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                                        Proses
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($history->status === 'completed')
                                    {{ $history->successful_rows }} / {{ $history->total_rows }} Item
                                @else
                                    {{ $history->total_rows }} Item
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <!-- Future: Link to detailed report -->
                                <span class="text-xs text-slate-400">
                                    {{ $history->failed_rows > 0 ? $history->failed_rows . ' Gagal' : '-' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-500 dark:text-slate-400">
                                Belum ada riwayat import data.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function importPage() {
        return {
            isDragging: false,
            importMode: 'new', // 'new' or 'update'
            fileName: null,
            
            handleFileSelect(event) {
                const file = event.target.files[0];
                if (file) {
                    this.validateAndSetFile(file);
                }
            },
            
            handleDrop(event) {
                this.isDragging = false;
                const file = event.dataTransfer.files[0];
                if (file) {
                    this.validateAndSetFile(file);
                }
            },
            
            validateAndSetFile(file) {
                const validTypes = ['.csv', '.xls', '.xlsx'];
                const extension = '.' + file.name.split('.').pop().toLowerCase();
                
                if (validTypes.includes(extension)) {
                    this.fileName = file.name;
                    
                    // Update the actual file input
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    document.getElementById('dropzone-file').files = dataTransfer.files;
                } else {
                    alert('Tipe file tidak valid. Harap unggah file CSV, XLS, atau XLSX.');
                    this.fileName = null;
                    document.getElementById('dropzone-file').value = ''; // Clear input
                }
            }
        }
    }
</script>
@endsection
