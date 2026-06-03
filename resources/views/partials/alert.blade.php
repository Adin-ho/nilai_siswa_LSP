@if (session('success'))
    <div class="mb-6 flex items-start gap-3 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-green-800 shadow-sm">
        <div class="mt-0.5 flex h-6 w-6 items-center justify-center rounded-full bg-green-600 text-white">✓</div>
        <div>
            <p class="font-bold">Berhasil</p>
            <p class="text-sm">{{ session('success') }}</p>
        </div>
    </div>
@endif

@if (session('error'))
    <div class="mb-6 flex items-start gap-3 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-red-800 shadow-sm">
        <div class="mt-0.5 flex h-6 w-6 items-center justify-center rounded-full bg-red-600 text-white">!</div>
        <div>
            <p class="font-bold">Gagal</p>
            <p class="text-sm">{{ session('error') }}</p>
        </div>
    </div>
@endif

@if ($errors->any())
    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-red-800 shadow-sm">
        <p class="font-bold">Data belum valid</p>
        <ul class="mt-2 list-inside list-disc text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
