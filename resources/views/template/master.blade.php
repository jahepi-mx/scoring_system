<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scoring System</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="flex h-screen bg-gray-50 overflow-hidden" x-data="{ sidebarOpen: false }">

    @include('template.left_menu')

    <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">

        @include('template.header')

        <main class="w-full flex-grow p-6">
            @yield('content')
        </main>

        @include('template.footer')

    </div>
</body>
</html>
