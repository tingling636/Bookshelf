<html>

<head>
	<title>My Bookshelf - Books Sharing</title>
  	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	  
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<body style="padding:0;cellpadding:0;">
	<?php include('navbar.php'); ?>

	<div class="row" style="margin:10%;">
		<div class="col-sm-8">
			<p class="display-4">Something's wrong here ...</p>
			<?php echo validation_errors(); ?>
			<p><?php if($message != null) echo $message; ?></p>
		</div>

		<div class="col-sm-3">
			<img style="width: 100%;height: auto;" src="<?php echo base_url('/resources/images/error_cat1.png'); ?>"/>
		</div>
	</div>

	<?php include('footer.php'); ?>

</body>

</html>
