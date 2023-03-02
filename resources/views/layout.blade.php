<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Dashboard</title>
    <meta name="description" content="Dashboard">
</head>
<body>
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex justify-center items-center h-screen">
    <div class="mx-auto w-full">
       {{ $slot }}
    </div>
</div>
</body>
</html>