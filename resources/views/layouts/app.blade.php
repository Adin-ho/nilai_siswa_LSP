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

            $menus = [
                [
                    'label' => 'Dashboard',
                    'route' => 'dashboard',
                    'pattern' => 'dashboard',
                    'roles' => ['admin', 'guru', 'siswa'],
                    'icon' => 'dashboard',
                ],
                [
                    'label' => 'Data Kelas',
                    'route' => 'kelas.index',
                    'pattern' => 'kelas.*',
                    'roles' => ['admin'],
                    'icon' => 'building',
                ],
                [
                    'label' => 'Data Siswa',
                    'route' => 'siswa.index',
                    'pattern' => 'siswa.*',
                    'roles' => ['admin'],
                    'icon' => 'users',
                ],
                [
                    'label' => 'Data Guru',
                    'route' => 'guru.index',
                    'pattern' => 'guru.*',
                    'roles' => ['admin'],
                    'icon' => 'teacher',
                ],
                [
                    'label' => 'Mata Pelajaran',
                    'route' => 'mata-pelajaran.index',
                    'pattern' => 'mata-pelajaran.*',
                    'roles' => ['admin'],
                    'icon' => 'book',
                ],
                [
                    'label' => $role === 'siswa' ? 'Nilai Pribadi' : 'Data Nilai',
                    'route' => 'nilai.index',
                    'pattern' => 'nilai.*',
                    'roles' => ['admin', 'guru', 'siswa'],
                    'icon' => 'clipboard',
                ],
                [
                    'label' => 'Laporan',
                    'route' => 'laporan.index',
                    'pattern' => 'laporan.*',
                    'roles' => ['admin', 'guru'],
                    'icon' => 'report',
                ],
            ];

            $tablerIcon = function ($name) {
                $class = 'h-6 w-6';

                $icons = [
                    'dashboard' => '<svg xmlns="http://www.w3.org/2000/svg" class="'.$class.'" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 13m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"/><path d="M13.45 11.55l2.05 -2.05"/><path d="M6.4 20a9 9 0 1 1 11.2 0z"/></svg>',

                    'building' => '<svg xmlns="http://www.w3.org/2000/svg" class="'.$class.'" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21l18 0"/><path d="M9 8l1 0"/><path d="M9 12l1 0"/><path d="M9 16l1 0"/><path d="M14 8l1 0"/><path d="M14 12l1 0"/><path d="M14 16l1 0"/><path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16"/></svg>',

                    'users' => '<svg xmlns="http://www.w3.org/2000/svg" class="'.$class.'" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"/><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/><path d="M21 21v-2a4 4 0 0 0 -3 -3.85"/></svg>',

                    'teacher' => '<svg xmlns="http://www.w3.org/2000/svg" class="'.$class.'" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 4h14a2 2 0 0 1 2 2v7a2 2 0 0 1 -2 2h-5l-4 4v-4h-5a2 2 0 0 1 -2 -2v-7a2 2 0 0 1 2 -2"/><path d="M8 9h8"/><path d="M8 12h6"/></svg>',

                    'book' => '<svg xmlns="http://www.w3.org/2000/svg" class="'.$class.'" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0"/><path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0"/><path d="M3 6l0 13"/><path d="M12 6l0 13"/><path d="M21 6l0 13"/></svg>',

                    'clipboard' => '<svg xmlns="http://www.w3.org/2000/svg" class="'.$class.'" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"/><path d="M9 5a3 3 0 0 1 6 0a3 3 0 0 1 -6 0"/><path d="M9 12h6"/><path d="M9 16h6"/></svg>',

                    'report' => '<svg xmlns="http://www.w3.org/2000/svg" class="'.$class.'" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 17v-5"/><path d="M12 17v-8"/><path d="M15 17v-2"/><path d="M5 3h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2"/></svg>',

                    'logout' => '<svg xmlns="http://www.w3.org/2000/svg" class="'.$class.'" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2"/><path d="M9 12h12l-3 -3"/><path d="M18 15l3 -3"/></svg>',

                    'user' => '<svg xmlns="http://www.w3.org/2000/svg" class="'.$class.'" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"/><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"/></svg>',
                ];

                return $icons[$name] ?? $icons['dashboard'];
            };
        @endphp

        <div class="min-h-screen lg:flex">
            <aside class="sticky top-0 z-30 border-b border-slate-200 bg-white text-slate-800 shadow-sm lg:h-screen lg:w-72 lg:border-b-0 lg:border-r">
                <div class="flex items-center gap-4 border-b border-slate-200 px-6 py-6">
                    <div class="flex h-14 w-14 items-center justify-center rounded-full bg-slate-100 text-slate-700">
                        {!! $tablerIcon('user') !!}
                    </div>

                    <div>
                        <p class="text-lg font-black">
                            {{ ucfirst($role) }}
                        </p>

                        <p class="text-sm font-medium text-slate-500">
                            @if ($role === 'admin')
                                Administrator
                            @elseif ($role === 'guru')
                                Guru
                            @else
                                Siswa
                            @endif
                        </p>
                    </div>
                </div>

                <nav class="space-y-2 px-4 py-6">
                    @foreach ($menus as $menu)
                        @if (!Route::has($menu['route']))
                            @continue
                        @endif

                        @if (in_array($role, $menu['roles'], true))
                            <a href="{{ route($menu['route']) }}"
                                class="group flex items-center gap-4 rounded-2xl px-4 py-3 text-sm font-bold transition
                                {{ request()->routeIs($menu['pattern'])
                                    ? 'bg-slate-900 text-white shadow-lg shadow-slate-200'
                                    : 'text-slate-700 hover:bg-slate-100 hover:text-slate-950' }}">

                                <span class="grid h-8 w-8 place-items-center rounded-xl
                                    {{ request()->routeIs($menu['pattern'])
                                        ? 'bg-white/15 text-white'
                                        : 'bg-slate-100 text-slate-700 group-hover:bg-white' }}">
                                    {!! $tablerIcon($menu['icon']) !!}
                                </span>

                                <span>{{ $menu['label'] }}</span>
                            </a>
                        @endif
                    @endforeach

                    <form action="{{ route('logout') }}" method="POST"
                        onsubmit="return confirm('Apakah Anda yakin ingin logout?')">
                        @csrf

                        <button type="submit"
                            class="group flex w-full items-center gap-4 rounded-2xl px-4 py-3 text-left text-sm font-bold text-slate-700 transition hover:bg-red-50 hover:text-red-700">

                            <span class="grid h-8 w-8 place-items-center rounded-xl bg-slate-100 text-slate-700 group-hover:bg-red-100 group-hover:text-red-700">
                                {!! $tablerIcon('logout') !!}
                            </span>

                            <span>Logout</span>
                        </button>
                    </form>
                </nav>
            </aside>

            <div class="min-w-0 flex-1">
                <header class="sticky top-0 z-20 border-b border-slate-200 bg-white/90 px-6 py-5 shadow-sm backdrop-blur">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <h1 class="text-xl font-black text-slate-900">
                                Sistem Pengolahan Nilai Siswa
                            </h1>

                            <p class="text-sm text-slate-500">
                                Panel {{ ucfirst($role) }}
                            </p>
                        </div>

                        <div class="hidden rounded-2xl bg-slate-100 px-4 py-2 text-sm font-bold text-slate-600 md:block">
                            {{ now()->translatedFormat('l, d F Y') }}
                        </div>
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