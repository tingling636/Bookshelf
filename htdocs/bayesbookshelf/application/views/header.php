<div class="jumbotron jumbotron-fluid" style="padding:0;margin:0;">
  <div class="container" style="padding:1%;">

    <div id="top-book" class="carousel slide" data-ride="carousel">

    <!-- Indicators -->
    <ul class="carousel-indicators">
      <li data-slide-to="0" class="active"></li>
      <li data-slide-to="1"></li>
      <li data-slide-to="2"></li>
      <li data-slide-to="3"></li>
    </ul>

    <!-- The slideshow -->
      <div class="carousel-inner">
      <?php
      $i=0;
        foreach($data as $book){          
          if($i == 0){
            echo "<div class='carousel-item active'>";
          }else{
            echo "<div class='carousel-item' >";
            
          }
            echo "  <div class='row' style='padding:0 15% 0 15%;'>";
            echo "    <div class='col-sm-5'><img src='".$book->imageUrl."' height='381' width='268'></div>";
            echo "    <div class='col-sm-6'><p class='display-4'>".$book->title."</p>
                            <blockquote class='blockquote'><p class='mb-0'>".$book->snippet."</p>
                            <footer class='blockquote-footer'>by <cite>".$book->author."</cite></footer></blockquote></div>";
            echo "  </div>";

            echo "</div>";
     
          $i++;
        }
      ?>

  </div>

    <!-- Left and right controls -->
    <a class="carousel-control-prev" href="#demo" data-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </a>
    <a class="carousel-control-next" href="#demo" data-slide="next">
      <span class="carousel-control-next-icon"></span>
    </a>

    </div>
    
  </div>
</div>
