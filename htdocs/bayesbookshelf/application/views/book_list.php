<div calss="container">
	
	<?php 
		foreach($books as $obj){	
	
		echo "<div class='container-sm p-3'>";
		echo "	<div><kbd>{$obj['cat']}</kbd></div>";

			$index=0;
			$cnt = count($obj['items']);
			$col = 4;
			$row = intdiv($cnt,$col);
			if($cnt%$col > 0)
				$row++;
			//header("Content-type: " . $row["imageType"]);
			for($i=1; $i<=$row; $i++){
				echo "<div class='row row-eq-heigh'>";
				for($j=1; $j<=$col; $j++){
					if($index <$cnt){
						$book = $obj['items'][$index];
						$image = $book->photo;
						echo "<div class='col-sm-3 py-2'>";
						echo "<div class='card flex-fill h-100'>";
						if($image == null)
							echo " <img class='card-img-top' src='/resources/images/image-not-available.png' alt='Card image'>";
						else
							echo "<img class='card-img-top' src='data:image/jpeg;base64,".base64_encode($image)."'/>";
						//echo " <img class='card-img-top' src='"/resources/images/image-not-available.png"' alt='Card image'>";
						echo " <div class='card-body'>";
						echo "		<h5>{$book->bookTitle}</h5>";
						echo "		<p> - by {$book->author}</p>";
						echo " </div>";
						echo " <div class='card-footer text-center'><a href='".site_url('index.php/Book/viewBook/').$book->id."' class='btn btn-primary'>More</a></div>";
						echo "</div></div>";
						$index++;
					}else{
						$j = $col+1;
						$i = $row+1;
					}
				}
				echo "</div>";
			}
			
		echo "</div>";
		}
	?>
</div>