<html>

<head>
	<title>My Bookshelf - Books Sharing</title>
  	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<style>
		.pt-3-half {padding-top: 1.4rem;}
	</style>
	  
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>

<body style="padding:0;cellpadding:0;">
	<?php include('navbar.php'); ?>

	<div class="container" style="margin-top:1%"">
	<div class="row">
		<div class="col-sm-3">
			<?php 
				$image = $data[0]->photo;
				if($image == null)
					echo " <img class='card-img-top' src='/resources/images/image-not-available.png' alt='Card image'>";
				else
					echo "<img class='card-img-top' src='data:image/jpeg;base64,".base64_encode($image)."'/>";
			?>
		</div>
		<div class="col-sm-6">
			<ul class="list-group list-group-flush">
				<li class="list-group-item"><h6><?php echo $data[0]->bookTitle;?></h6></li>
				<li class="list-group-item"><h7><?php echo "Written by ".$data[0]->author; ?></h7> </li>
				<li class="list-group-item"><h7><?php echo "Published By ".$data[0]->publisher;?></h7></li>
				<li class="list-group-item"><h7><?php echo $data[0]->subcategory;?></h7></li>
				<li class="list-group-item"><h7>ranking</h7></li>
			</ul>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-6">
			<div><h7>Review :</h7></div>
			<div><?php echo $data[0]->review;?></div>
		</div>

		<div class="col-sm-6">
			<div class="card">
				<h6 class="card-header text-center">Books Available To Exchange</h6>
				
				<div class="card-body" style="padding:3px 5px;">
				<div id="table" class="table-editable">
					<span class="table-add float-right mb-3 mr-2"><a href="#!" class="text-success"><i
							class="fas fa-plus fa-2x" aria-hidden="true">xxx</i></a></span>
					<table class="table table-bordered table-responsive-md table-striped text-center">
					<thead>
					<tr>
						<th class="text-center">User</th>
						<th class="text-center">Condition</th>
						<th class="text-center">Status</th>
						<th class="text-center">Want</th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<td class="pt-3-half" contenteditable="true">Aurelia Vega</td>
						<td class="pt-3-half" contenteditable="true">30</td>
						<td class="pt-3-half" contenteditable="true">Deepends</td>
						<td>
						<span class="table-remove"><button type="button"
							class="btn btn-Warning btn-rounded btn-sm my-0">Select</button></span>
						</td>
					</tr>
					</tbody>
					</table>
				</div>
				</div>
			</div>
		</div>
	</div>

	</div>
	<?php include('footer.php'); ?>

	
</body>

</html>