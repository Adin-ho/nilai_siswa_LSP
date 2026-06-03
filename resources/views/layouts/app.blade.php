<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pengolahan Nilai Siswa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 text-slate-900 antialiased">
    @auth
        @php
            $role = auth()->user()->role;
            $roleLabel = ucfirst($role);
            $roleColor = $role === 'admin' ? 'bg-blue-600' : ($role === 'guru' ? 'bg-emerald-600' : 'bg-violet-600');

            $menus = [
                ['icon' => '▣', 'label' => 'Dashboard', 'route' => 'dashboard', 'pattern' => 'dashboard', 'roles' => ['admin', 'guru', 'siswa']],
                ['icon' => '🏫', 'label' => 'Data Kelas', 'route' => 'kelas.index', 'pattern' => 'kelas.*', 'roles' => ['admin']],
                ['icon' => '👨‍🎓', 'label' => 'Data Siswa', 'route' => 'siswa.index', 'pattern' => 'siswa.*', 'roles' => ['admin']],
                ['icon' => '👨‍🏫', 'label' => 'Data Guru', 'route' => 'guru.index', 'pattern' => 'guru.*', 'roles' => ['admin']],
                ['icon' => '📚', 'label' => 'Mata Pelajaran', 'route' => 'mata-pelajaran.index', 'pattern' => 'mata-pelajaran.*', 'roles' => ['admin']],
                ['icon' => '📝', 'label' => $role === 'siswa' ? 'Nilai Saya' : 'Data Nilai', 'route' => 'nilai.index', 'pattern' => 'nilai.*', 'roles' => ['admin', 'guru', 'siswa']],
            ];
        @endphp

        <div class="min-h-screen lg:flex">
            <aside class="sticky top-0 z-30 border-b border-slate-200 bg-white/95 shadow-sm backdrop-blur lg:h-screen lg:w-72 lg:border-b-0 lg:border-r">
                <div class="border-b border-slate-100 px-6 py-5">
                    <div class="flex items-center gap-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-700 text-xl font-black text-white shadow-lg shadow-blue-200">
                            NS
                        </div>
                        <div class="min-w-0">
                            <h1 class="truncate text-base font-black leading-tight text-slate-900">Nilai Siswa</h1>
                            <p class="text-xs font-semibold text-slate-500">SDN Bantargebang III</p>
                        </div>
                    </div>
                </div>

                <div class="mx-4 mt-5 rounded-[1.5rem] border border-slate-200 bg-slate-50 p-4">
                    <div class="flex items-center justify-between gap-3">
                        <div class="min-w-0">
                            <p class="text-xs font-bold uppercase tracking-wide text-slate-500">Akun Login</p>
                            <p class="mt-1 truncate text-sm font-black text-slate-900">{{ auth()->user()->name }}</p>
                            <p class="truncate text-xs text-slate-500">{{ auth()->user()->email }}</p>
                        </div>
                        <span class="rounded-full {{ $roleColor }} px-3 py-1 text-xs font-black text-white">{{ $roleLabel }}</span>
                    </div>
                </div>

                <nav class="grid gap-1 px-4 py-5">
                    @foreach ($menus as $menu)
                        @if (in_array($role, $menu['roles'], true))
                            <a href="{{ route($menu['route']) }}"
                               class="group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-bold transition
                               {{ request()->routeIs($menu['pattern']) ? 'bg-slate-900 text-white shadow-lg shadow-slate-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                                <span class="grid h-8 w-8 place-items-center rounded-xl {{ request()->routeIs($menu['pattern']) ? 'bg-white/15' : 'bg-white border border-slate-200 group-hover:border-slate-300' }}">{{ $menu['icon'] }}</span>
                                <span>{{ $menu['label'] }}</span>
                            </a>
                        @endif
                    @endforeach
                </nav>

                <div class="mt-auto px-4 pb-5">
                    <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4 text-xs leading-relaxed text-blue-800">
                        <p class="font-black">Petunjuk UX</p>
                        <p class="mt-1">Menu yang tampil mengikuti role pengguna agar lebih mudah dipahami.</p>
                    </div>
                </div>
            </aside>

            <div class="min-w-0 flex-1">
                <header class="sticky top-0 z-20 border-b border-slate-200 bg-white/90 px-5 py-4 shadow-sm backdrop-blur md:px-8">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wide text-slate-400">Sistem Pengolahan Nilai Siswa</p>
                            <h2 class="text-xl font-black text-slate-900">Panel {{ $roleLabel }}</h2>
                        </div>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-2 rounded-2xl border border-red-100 bg-red-50 px-4 py-2 text-sm font-black text-red-600 transition hover:bg-red-600 hover:text-white">
                                <span>↪</span> Logout
                            </button>
                        </form>
                    </div>
                </header>

                <main class="p-5 md:p-8">
                    @include('partials.alert')
                    @yield('content')
                </main>
            </div>
        </div>
    @else
        @yield('content')
    @endauth
</body>
</html>
