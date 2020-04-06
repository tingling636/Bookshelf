<!-- 
  //Get the best books for carousel display by XMLHttpRequest
<script type="text/javascript">
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
      load_xml(this);
    }
  };
  xhttp.open("GET", "../resources/top_books.xml", true)
  xhttp.send();

  function load_xml(xml){    
    var xmldoc = xml.responseXML;
    var data = xmldoc.getElementsByTagName('book');
    var txt = "";
    for(i=0; i < data.length; i++){
      var state = "";
      if(i==0) state = "active";

      var lang = data[i].getAttribute("lang");
      var title = data[i].getElementsByTagName('title')[0].childNodes[0].nodeValue;
      var author = data[i].getElementsByTagName('author')[0].childNodes[0].nodeValue;
      var img = data[i].getElementsByTagName('imageUrl')[0].childNodes[0].nodeValue;
      var language = data[i].getElementsByTagName('language')[0].childNodes[0].nodeValue;
      var snippet = data[i].getElementsByTagName('snippet')[0].childNodes[0].nodeValue;

      txt = txt+"<div class='carousel-item "+state+"'>"+
            "<div class='row' style='padding:0 10% 0 10%;'>"+
              "<div class='col-sm-5'><img src='"+img+"' height='381' width='268'></div>"+
              "<div class='col-sm-6'><p class='display-4' style='font-size:3vw;'>"+title+"</p>"+
                "<blockquote class='blockquote' style='font-size:1.5vw;'><p class='mb-0'>"+snippet+"</p>"+
                "<footer class='blockquote-footer'>by <cite>"+author+"</cite></footer></blockquote></div>"+
              "</div></div>";
    }
    document.getElementById("tb").innerHTML = txt;
  }

</script>
-->

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
      <div class="carousel-inner" style="width: 100%;" id="tb">
      <?php
      $i=0;
        foreach($data as $book){      
          if($i == 0){
            echo "<div class='carousel-item active'>";
          }else{
            echo "<div class='carousel-item' >";
            
          }
            echo "  <div class='row' style='padding:0 10% 0 10%;'>";
            echo "    <div class='col-sm-5'><img class='responsive' src='".base_url($book['imageUrl'])."' height='381' width='268'></div>";
            echo "    <div class='col-sm-6'><p class='display-4' style='font-size:3vw;'>".$book['title']."</p>
                            <blockquote class='blockquote' style='font-size:1.5vw;'><p class='mb-0'>".$book['snippet']."</p>
                            <footer class='blockquote-footer'>by <cite>".$book['author']."</cite></footer></blockquote></div>";
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
