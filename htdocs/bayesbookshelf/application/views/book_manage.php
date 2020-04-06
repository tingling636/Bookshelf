<html>

<head>
	<title>My Bookshelf - Books Sharing</title>
  	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	  
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  	
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">  
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
	
    
	<style>
       body{
       margin:0;
       padding:0;
       background-color:#f1f1f1;
      }
      .box{
       width:80%;
       padding:20px;
       background-color:#fff;
       border:1px solid #ccc;
       border-radius:5px;
       margin-top:25px;
       box-sizing:border-box;
      }
    </style>
  
</head>

<body style="padding:0;cellpadding:0;">
	<?php include('navbar.php'); ?>

	<div class="container box">
		<blockquote class="blockquote" style="text-align: center">Feed My Mind by Reading Good Books
			<footer class="blockquote-footer"><?php echo $user;?></footer>
		</blockquote>

		<div class="table-responsive">
		
    		<div align="right" style="margin-bottom: 5px;">
    			<button type="button" name="add" id="add" class="btn btn-sm btn-info">Add</button>
    		</div>
		
			<div id="alert_message"></div>
    		<table id="user_data" class="table table-striped table-sm">
    			<thead class="thead-dark">
    			<tr>
    				<th scope="col" width="2%">No.</th>
    				<th scope="col" id="coltitle">Title</th>
    				<th scope="col">Author</th>
    				<th scope="col">Language</th>
    				<th scope="col">Category</th>
    				<th width="3%">Rank</th>
    				<th width="5%">Exhange</th>
    				<th width="13%" style="text-align: center;">Actions</th>
    			</tr>
    			</thead>    			
    		</table>
    		<p>
   		</div>
	</div>
	
  	<br>
	<?php include('footer.php'); 
	$delurl = base_url('index.php/deletebook');
	$fetchurl = base_url('index.php/fetchbook');
	$addurl = base_url('index.php/addbook');
	?>
</body>
</html>

<script>
$(document).ready(function(){

  	fetch_data();

 	function fetch_data(){
 		var page = "<?php echo $fetchurl?>";
 		var dataTable = $('#user_data').DataTable({
        	"processing" : true,
        	"serverSide" : true,
        	"ordering"	 : true,
        	"order" : [1, "asc"],
        	"ajax" : {
         		url:page,
         		type:"POST"
        	}
   		});
  	}
  
  function update_data(id, column_name, value){
   $.ajax({
    url:"update.php",
    method:"POST",
    data:{id:id, column_name:column_name, value:value},
    success:function(data)
    {
     $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
     $('#user_data').DataTable().destroy();
     fetch_data();
    }
   });
   setInterval(function(){
    $('#alert_message').html('');
   }, 5000);
  }

	$(document).on('blur', '.update', function(){
   		var id = $(this).data("id");
   		var column_name = $(this).data("column");
   		var value = $(this).text();
   		//update_data(id, column_name, value);
  	});
  
	$('#add').click(function(){
		var page = "<?php echo $addurl?>";
	  	window.location.href = page;
       /* var html = '<tr>';
       html += '<td contenteditable id="data1"></td>';
       html += '<td contenteditable id="data2"></td>';
       html += '<td><button type="button" name="insert" id="insert" class="btn btn-success btn-xs">Insert</button></td>';
       html += '</tr>';
       $('#user_data tbody').prepend(html); */
    });
  
  $(document).on('click', '#insert', function(){
   var first_name = $('#data1').text();
   var last_name = $('#data2').text();
   if(first_name != '' && last_name != '')
   {
    $.ajax({
     url:"insert.php",
     method:"POST",
     data:{first_name:first_name, last_name:last_name},
     success:function(data)
     {
      $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
      $('#user_data').DataTable().destroy();
      fetch_data();
     }
    });
    setInterval(function(){
     $('#alert_message').html('');
    }, 5000);
   }
   else
   {
    alert("Both Fields is required");
   }
  });
  
	$(document).on('click', '.act1', function(){
		var id = $(this).attr("id");
		var page = "<?php echo $delurl?>";
   		if(confirm("Are you sure you want to remove this?")){
    		$.ajax({
     			url:page,
     			method:"POST",
     			data:{id:id},
     			success:function(data){
      				$('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
      				$('#user_data').DataTable().destroy();
      				fetch_data();
     			}
    		});
    
    		setInterval(function(){$('#alert_message').html('');}, 5000);
   		}
  	});

  
 });
</script>
