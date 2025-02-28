<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Videos App</title>
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="/">Inici</a></li>
            <li><a href="/videos">Videos</a></li>
            <li><a href="/videos/manage">Gestió de vídeos</a></li>
        </ul>
    </nav>
</header>


<main>
    {{ $slot }}
</main>

<footer>
    <p>&copy; 2025 Videos App</p>
</footer>
</body>
</html>
