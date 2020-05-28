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
    
    <!--タイトル-->
    <div id="title_row" class="row">
      <h1 id="title">Kumaetto</h1>
    </div>

    <!--メイン画像のスライドショー-->
    <div class="row">
      <div id="carouselControls-anime" class="carousel slide" data-ride="false">

        <!-- ページャー部分 -->
        <ol class="carousel-indicators">
          <li data-target="#carouselControls-anime" data-slide-to="0" class="active"></li>
          <li data-target="#carouselControls-anime" data-slide-to="1"></li>
          <li data-target="#carouselControls-anime" data-slide-to="2"></li>
        </ol>

        <!--スライド部分-->
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="slide_item" id="item1"></div>
          </div>
          <div class="carousel-item">
            <div class="slide_item" id="item2"></div>        
          </div>
          <div class="carousel-item" >
            <div class="slide_item" id="item3"></div>
          </div>
        </div>

      </div>
    </div>
</body>
</html>
