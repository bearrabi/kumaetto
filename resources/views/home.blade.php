<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Styles -->
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}" >

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

   <!-- Scripts -->
   <script src="{{ asset('js/app.js') }}" defer></script>
  
   <title>Kumaetto</title>

</head>
<body>
  <div class="container">
    <div id="title_row" class="row">
      <h1 id="title">Kumaetto</h1>
    </div>
  </div>
  

</body>
</html>
