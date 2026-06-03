@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-100 px-4 py-10">
    <div class="mx-auto flex min-h-[calc(100vh-5rem)] max-w-6xl items-center justify-center">
        <div class="w-full rounded-[2rem] border border-slate-300 bg-white p-8 shadow-xl md:p-12">
            <div class="mx-auto max-w-2xl text-center">
                <div class="mx-auto mb-6 flex h-24 w-24 items-center justify-center rounded-3xl bg-blue-100 text-5xl">
                    🏫
                </div>

                <h1 class="text-3xl font-black tracking-wide text-slate-900 md:text-4xl">
                    SISTEM PENGOLAHAN NILAI SISWA
                </h1>

                <p class="mt-3 text-xl font-semibold text-slate-500">
                    SDN BANTARGEBANG III
                </p>
            </div>

            @include('partials.alert')

            <form action="{{ route('login.process') }}" method="POST" class="mx-auto mt-8 max-w-2xl space-y-5">
                @csrf

                <div>
                    <label class="mb-2 block text-sm font-black text-slate-700">
                        Username / Email
                    </label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Masukkan username/email"
                        class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-5 py-4 text-lg outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                        required>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-black text-slate-700">
                        Password
                    </label>
                    <input
                        type="password"
                        name="password"
                        placeholder="Masukkan password"
                        class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-5 py-4 text-lg outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                        required>
                </div>

                <button
                    type="submit"
                    class="w-full rounded-2xl bg-slate-900 px-5 py-4 text-lg font-black tracking-wide text-white shadow-lg transition hover:bg-blue-700">
                    LOGIN
                </button>
            </form>

            <div class="mx-auto mt-8 max-w-2xl rounded-2xl border border-blue-100 bg-blue-50 p-5 text-sm text-blue-800">
                <p class="mb-2 font-black">Akun Demo</p>
                <p><strong>Admin:</strong> admin@admin.test / password</p>
                <p><strong>Guru:</strong> siti@guru.test / password</p>
                <p><strong>Siswa:</strong> andi@siswa.test / password</p>
            </div>
        </div>
    </div>
</div>
@endsection