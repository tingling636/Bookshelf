	<?php
		if(isset($_POST["dropdownValue"])){
			$category=$_POST["dropdownValue"];
			foreach($cat as $obj){
				if($obj["name"] == $category){
					$subcat = $obj["items"];
					foreach($subcat as $str)
						echo " ".$str;
				}
				
			}
			
		}
	?>

           $(document).ready(function(){
            $('#bcategory').change(function(){				
                //Selected value
				var inputValue = $(this).val(); 
				alert(0);
				document.cookie = "selected="+inputValue;
				var sublist = new Array();
				<?php foreach($cat as $obj){ 
					$value = $_COOKIE['selected'];
					if($obj["name"] == $value){
						$subcat = $obj["items"];?>
						sublist = <?php echo json_encode($subcat); ?>;
				<?php 	
						delete_cookie('selected'); 
				    }
				}
				?>
				alert(sublist);
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

				//var f = "<?php echo test();?>";
				//alert(f);
						
            });
		});