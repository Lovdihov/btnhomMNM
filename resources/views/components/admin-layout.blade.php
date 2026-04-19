<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin - ThreeX Music</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex min-h-screen">

    <aside class="w-64 bg-slate-900 text-white flex-shrink-0">
        <div class="p-6 text-2xl font-bold border-b border-slate-700">ThreeX Admin</div>
        <nav class="p-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="block p-3 hover:bg-slate-800 rounded">Tổng quan</a>
            <a href="{{ route('admin.songs') }}" class="block p-3 hover:bg-slate-800 rounded">Bài hát</a>
            <a href="{{ route('admin.albums') }}" class="block p-3 hover:bg-slate-800 rounded">Album</a>
            <a href="{{ route('admin.artists') }}" class="block p-3 hover:bg-slate-800 rounded">Nghệ sĩ</a>
            <a href="{{ route('admin.users') }}" class="block p-3 hover:bg-slate-800 rounded">Người dùng</a>
            <div class="border-t border-slate-700 my-4"></div>
            <a href="{{ route('home') }}" class="block p-3 text-gray-400 hover:text-white">Về trang chủ</a>
        </nav>
    </aside>

    <main class="flex-grow flex flex-col">
        <header class="bg-white shadow p-4 flex justify-end items-center px-8">
            <span class="text-gray-600 mr-4">Chào, <strong>{{ Auth::user()->name }}</strong></span>
        </header>
        <div class="p-8">
            {{ $slot }}
        </div>
    </main>

</body>
</html>