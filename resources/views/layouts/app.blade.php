<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facturo - Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <aside class="w-64 bg-slate-900 text-white flex flex-col hidden md:flex">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-blue-400">Facturo.</h2>
            </div>
            <nav class="flex-1 px-4 space-y-2">
                <a href="{{ route('products.index') }}" class="block px-4 py-3 rounded-lg hover:bg-slate-800 transition {{ request()->routeIs('products.*') ? 'bg-slate-800 text-blue-400 font-medium' : 'text-slate-300' }}">
                    Products
                </a>
                <a href="{{ route('invoices.index') }}" class="block px-4 py-3 rounded-lg hover:bg-slate-800 transition {{ request()->routeIs('invoices.*') ? 'bg-slate-800 text-blue-400 font-medium' : 'text-slate-300' }}">
                    Invoices
                </a>
            </nav>
            <div class="p-4 border-t border-slate-800 text-sm text-slate-400">
                &copy; {{ date('Y') }} Facturo
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto bg-gray-50">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b px-8 py-4 flex items-center justify-between">
                <h1 class="text-xl font-semibold text-gray-800">@yield('title', 'Dashboard')</h1>
            </header>

            <!-- Page Content -->
            <div class="p-8">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif
                
                @yield('content')
            </div>
        </main>
    </div>

</body>
</html>
