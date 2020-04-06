<html>

<head>
	<title>My Bookshelf - Books Sharing</title>
  	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	  
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
	  
	<script>
		function selectcat(){
			var inputValue = document.getElementById('bcategory').value; 
			document.cookie = "selected="+inputValue;
			var sublist = new Array();
			sublist = <?php 
				$value = "Non Fiction";
				if( isset($_COOKIE["selected"])) 
					$value = $_COOKIE["selected"];
				$subcat = array();
				foreach($cat as $obj){ 				
				if($obj["name"] == $value){
					$subcat = $obj["items"];
				}
				}
				echo json_encode($subcat) ;
			?>;
			
			var cSelect = document.getElementById('bsubcategory'); 
			var len=cSelect.options.length; 
			while (cSelect.options.length > 0) { 
				cSelect.remove(0); 
			} 
			var newOption; 
				// create new options 
			for (var i=0; i<sublist.length; i++) { 
				newOption = document.createElement("option"); 
				newOption.value = sublist[i];  // assumes option string and value are the same 
				newOption.text=sublist[i]; 
				try { 
					cSelect.add(newOption);  // this will fail in DOM browsers but is needed for IE 
				} catch (e) { 
					cSelect.appendChild(newOption); 
				} 
			}
		}
    </script>

	<style type="text/css" media="screen">
		.input-group>.input-group-prepend {
			flex: 0 0 20%;
		}

		.input-group .input-group-text {
			width: 100%;
		}
	</style>
</head>

<body style="padding:0;cellpadding:0;">
	<?php include('navbar.php'); ?>

	<div class="container pt-3">
		<div class="card">
			<h6 class="card-header text-center">Share A Book</h6>
		</div>
			<form method="post" action="<?php echo base_url('index.php/savebook');?>" enctype="multipart/form-data">
			<div class="input-group mb-2">
				<div class="input-group-prepend" >
					<span class="input-group-text"> Title</span>
				</div>
				<input type="text" class="form-control" placeholder="Book Title" name="btitle" id="btitle" required>
				<div class="invalid-feedback">Please fill out this field.</div>
			</div>

			<div class="input-group mb-2">
				<div class="input-group-prepend">
					<span class="input-group-text">Author</span>
				</div>
				<input type="text" class="form-control" placeholder="Book Author" name="bauthor" id="bauthor" required>
			</div>

			<div class="input-group mb-2">
				<div class="input-group-prepend">
					<span class="input-group-text">Publisher</span>
				</div>
				<input type="text" class="form-control" placeholder="Book Author" name="bpublisher" id="bpublisher" required>
			</div>

			<div class="input-group mb-2">
				<div class="input-group-prepend">
					<span class="input-group-text">Category</span>
				</div>
				<select class="form-control custom-select" placeholder="Category" name="bcategory" id="bcategory" onchange="selectcat()" required >
				<?php 
					foreach($cat as $catlist){
						echo "<option>{$catlist["name"]}</option>";
					}
				?>
				</select>
				<select class="form-control custom-select" placeholder="Subcategory" name="bsubcategory" id="bsubcategory" required>
				<?php 
					$subcatlist = $cat[0]["items"];
					foreach($subcatlist as $str){
						echo "<option>{$str}</option>";
					}
				?>
				</select>
			</div>

			<div class="input-group mb-2">
				<div class="input-group-prepend">
					<span class="input-group-text">Language</span>
				</div>
				<select class="form-control custom-select"  placeholder="Langague" name="blanguage" id="blanguage" required>
				<?php 
					foreach($lag as $str){
						echo "<option>{$str}</option>";
					}
				?>
				</select>
				<div class="input-group-prepend">
					<span class="input-group-text">Papercover</span>
				</div>
				<input type="text" class="form-control" placeholder="Paper Cover" name="bpapercover" id="bpapercover" value="0">
			</div>

			<div class="input-group mb-2">
				<div class="input-group-prepend">
					<span class="input-group-text">Copyright</span>
				</div>
				<input type="text" class="form-control" placeholder="Copyright" name="bcopyright" id="bcopyright">
				<div class="input-group-prepend">
					<span class="input-group-text">ISBN</span>
				</div>
				<input type="text" class="form-control" placeholder="ISBN" name="bisbn" id="bisbn">
			</div>

			<div class="input-group mb-2">
				<div class="custom-file">
				<input type="file" class="custom-file-input" id="imageile" name="imageFile">
    			<label class="custom-file-label" for="imageFile">Choose file</label>
				</div>
			</div>

			<div class="form-group">
  				<label for="comment" class="input-group-text">Review</label>
				<textarea class="form-control" rows="5" id="breview" name="breview"></textarea>
			</div>

			<div class="form-group text-center">
				<button class="btn btn-secondary" type="submit" name="save">Submit</button>
			</div>
		</form>
	</div>
	<?php include('footer.php'); ?>

<script>
// Add the following code if you want the name of the file appear on select
$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
</script>
</body>

</html>

