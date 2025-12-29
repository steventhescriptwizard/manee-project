@extends('layouts.admin')

@section('title', 'Detail Admin - ' . $user->name)

@section('content')
<div class="max-w-4xl mx-auto flex flex-col gap-8">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.users.index') }}" class="size-10 flex items-center justify-center rounded-xl bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 text-slate-400 hover:text-blue-600 transition-all shadow-sm">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Profil Admin</h1>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Informasi akun administrator</p>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-900 rounded-3xl border border-slate-200 dark:border-gray-800 shadow-xl overflow-hidden">
        <div class="p-8 border-b border-slate-100 dark:border-gray-800 flex items-center gap-6 bg-slate-50/50 dark:bg-gray-800/20">
            <div class="size-24 rounded-3xl border-4 border-white dark:border-gray-900 shadow-lg overflow-hidden bg-slate-100 dark:bg-gray-800">
                @if($user->avatar)
                    <img src="{{ Storage::url($user->avatar) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-slate-300 font-black text-3xl">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                @endif
            </div>
            <div>
                <h2 class="text-2xl font-black text-slate-900 dark:text-white">{{ $user->name }}</h2>
                <p class="text-slate-500 font-bold tracking-tight mt-1">{{ $user->email }}</p>
                <div class="mt-3 inline-flex px-3 py-1 bg-blue-600 text-white text-[10px] font-black rounded-lg uppercase tracking-widest leading-none">
                    Administrator
                </div>
            </div>
        </div>

        <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="flex flex-col gap-2">
                <span class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Dibuat Pada</span>
                <span class="text-sm font-bold text-slate-900 dark:text-white">{{ $user->created_at->translatedFormat('d F Y, H:i') }} WIB</span>
            </div>
            <div class="flex flex-col gap-2">
                <span class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Terakhir Diperbarui</span>
                <span class="text-sm font-bold text-slate-900 dark:text-white">{{ $user->updated_at->translatedFormat('d F Y, H:i') }} WIB</span>
            </div>
        </div>

        <div class="p-8 bg-slate-50 dark:bg-gray-800/50 border-t border-slate-100 dark:border-gray-800 flex justify-end gap-3">
            <a href="{{ route('admin.users.edit', $user->id) }}" class="flex items-center gap-2 px-6 py-3 bg-slate-900 dark:bg-blue-600 text-white text-sm font-bold rounded-xl hover:opacity-90 transition-all">
                <span class="material-symbols-outlined text-[20px]">edit</span>
                <span>Edit Akun</span>
            </a>
        </div>
    </div>
</div>
@endsection
