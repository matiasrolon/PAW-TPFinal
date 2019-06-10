<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>

    <h2>Obras:</h2>
    <ul>
    @foreach($obras as $obra)
        <li>{{ $obra }}</li>
    @endforeach
    </ul>
  </body>
</html>
