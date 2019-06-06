<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> {{ $titulo }} </title>
</head>
<body>
    <ul>
    <h2>Mostrando los datos como en PHP</h2>
    <?php foreach ($varName as $item) : ?>
        <li><?= $item; ?></li>
    <?php endforeach; ?>

    <br>

    <h2>Utilizando el motor de plantillas Blade</h2>
    @foreach($varName as $item)
        <li>{{ $item }}</li>
    @endforeach
    </ul>
</body>
</html>