<!DOCTYPE html>
<html lang="{{ config('app.locale', 'en') }}" class="h-full">

<head>
    @include('Decomposer::layouts.header')
</head>

<body class="min-h-full flex flex-col font-sans bg-zinc-50 text-zinc-900 dark:bg-zinc-950 dark:text-zinc-100 antialiased selection:bg-brand-500/20 selection:text-brand-700 dark:selection:bg-brand-500/30 dark:selection:text-brand-300">
    @include('Decomposer::index')
    @include('Decomposer::layouts.footer')
</body>

</html>
