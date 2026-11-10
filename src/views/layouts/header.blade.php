<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Laravel Decomposer</title>

<!-- Fonts: Figtree & JetBrains Mono -->
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700|jetbrains-mono:400,500,600&display=swap" rel="stylesheet" />

<!-- Theme Init (Prevent FOUC) -->
<script>
    (function () {
        const theme = localStorage.getItem('decomposer-theme');
        if (theme === 'dark' || (!theme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    })();
</script>

<!-- Compiled Styles -->
<link rel="stylesheet" href="{{ asset('lubusin/laravel-decomposer/dist/style.css') }}">
