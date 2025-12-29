@extends('layouts.admin')

@section('title', 'Manajemen Admin - Maneé Admin')

@section('content')
<div class="flex flex-col gap-6">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight">Manajemen Admin</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Kelola akun administrator untuk mengelola sistem Maneé.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.users.create') }}" class="flex items-center gap-2 bg-slate-900 dark:bg-blue-600 text-white px-6 py-3 rounded-xl font-bold text-sm hover:opacity-90 transition-all shadow-lg shadow-slate-200 dark:shadow-none">
                <span class="material-symbols-outlined text-[20px]">person_add</span>
                <span>Tambah Admin</span>
            </a>
        </div>
    </div>

    {{-- Stats Grid (Optional but good for premium feel) --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl border border-slate-200 dark:border-gray-800 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="size-12 rounded-xl bg-blue-50 dark:bg-blue-900/20 text-blue-600 flex items-center justify-center">
                    <span class="material-symbols-outlined">group</span>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Total Admin</p>
                    <p class="text-2xl font-black text-slate-900 dark:text-white">{{ $users->total() }}</p>
                </div>
            </div>
        </div>
        {{-- Add more stats if needed --}}
    </div>


    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-slate-200 dark:border-gray-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-gray-800/50 border-b border-slate-100 dark:border-gray-800">
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Nama Admin</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Email</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 text-center">Bergabung</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-gray-800">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50/30 dark:hover:bg-gray-800/20 transition-all group">
                        <td class="px-8 py-5 whitespace-nowrap">
                            <div class="flex items-center gap-4">
                                <div class="size-12 rounded-2xl border-2 border-slate-100 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden shadow-sm shadow-slate-100 dark:shadow-none flex-shrink-0">
                                    @if($user->avatar)
                                        <img src="{{ Storage::url($user->avatar) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-slate-50 text-slate-400 font-black text-lg uppercase tracking-tighter">
                                            {{ substr($user->name, 0, 2) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-black text-slate-900 dark:text-white text-base group-hover:text-blue-600 transition-colors tracking-tight">{{ $user->name }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5 whitespace-nowrap">
                            <div class="flex items-center gap-2 text-sm font-bold text-slate-600 dark:text-slate-300">
                                <span class="material-symbols-outlined text-[16px] text-slate-400">mail</span>
                                <span>{{ $user->email }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-5 whitespace-nowrap text-center">
                            <span class="text-xs font-black text-slate-500 uppercase tracking-tight">
                                {{ $user->created_at->translatedFormat('d M Y') }}
                            </span>
                        </td>
                        <td class="px-8 py-5 whitespace-nowrap">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('admin.users.show', $user) }}" class="inline-flex size-10 items-center justify-center rounded-xl bg-white dark:bg-gray-800 border border-slate-200 dark:border-gray-700 text-slate-400 hover:text-blue-600 hover:border-blue-200 transition-all shadow-sm group/btn" title="Lihat Profil">
                                    <span class="material-symbols-outlined text-[20px]">visibility</span>
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex size-10 items-center justify-center rounded-xl bg-white dark:bg-gray-800 border border-slate-200 dark:border-gray-700 text-slate-400 hover:text-blue-600 hover:border-blue-200 transition-all shadow-sm" title="Edit">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-btn inline-flex size-10 items-center justify-center rounded-xl bg-white dark:bg-gray-800 border border-slate-200 dark:border-gray-700 text-slate-400 hover:text-red-500 hover:border-red-100 transition-all shadow-sm" title="Hapus">
                                        <span class="material-symbols-outlined text-[20px]">delete_outline</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-24 text-center">
                            <div class="flex flex-col items-center gap-4 opacity-30">
                                <span class="material-symbols-outlined text-6xl">person_off</span>
                                <p class="text-slate-900 font-black uppercase tracking-widest">Belum ada admin ditemukan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
        <div class="px-8 py-6 border-t border-slate-100 dark:border-gray-800 bg-slate-50/30 dark:bg-gray-800/30">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
