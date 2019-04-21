<?php 	
/*
 * File Explorer to show the files of a path described 
 * Developer : Sat Singh Rana
 * Created at : 12-04-2018
 */

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>File Explorer</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="fe_input_wrapper">
		<input type="text" name="path" value="D:\xampp\htdocs" id="path">
		<input type="text" name="explore_FE" value="" id="explore_FE">
		<input type="button" name="explore" value="Explore" id="explore">
	</div>
	<div class="fe_wrapper">

	

	
	</div>

	

	<script type="text/javascript" src="jquery.js"></script>
	<script type="text/javascript">

		$( function(el){

			console.log('Explorer Init.');

			var ct = $.now();
			$( "#explore_FE" ).val( ct );
			var path 	   = $( "#path" ).val();
			var explore_FE = $( "#explore_FE" ).val();

			getFiles(path, explore_FE);

			$( "#explore" ).click(function(){
				var path 	   = $( "#path" ).val();
				var explore_FE = $( "#explore_FE" ).val();

				$(".fe_wrapper").html( "" );
				getFiles(path, explore_FE);
				
			});
			$( ".fe_wrapper").on("click" , ".single-file", function(el){
				if ($( this ).hasClass("open")) {
					$( this ).next().remove();
					$( this ).removeClass("open");
					return;
				}
				var path 	   = $( this ).attr("path");
				var explore_FE = $( "#explore_FE" ).val();


				getFiles(path, explore_FE, $( this ));
				
			});


			function getFiles(path, explore_FE, targetDiv = "") {
				$.ajax({
					url:"code/get-directory-data.php",
					method:"post",
					data:{"explore_FE":explore_FE, "path" : path}, 
					success:function(r){
						resultID = $.now();
						var files = r.files
						var f = "";
						f+='<div class="fe_result">';
						if (files=="") {					
							f+='<div class="fe_empty">empty</div>';
						}else{				
							for(file in files){

								if(files[file] == "file"){
									var icon = "d.png";
								}else{
									var icon = "f.png";
								}

								f += '<div class="single-file" path = "'+r.path+file+'\\" >'+
									 '<img class="file_icon" src="'+icon+'">'+
									 '<span class="file_name">'+ file +'</span>'+
									 '</div>';

							}
						}

						f+='</div>';

						if (targetDiv!="") {
							targetDiv.after( f );
							targetDiv.addClass( "open" );
							return;
						}

						$(".fe_wrapper").append( f );

					}
				});				
			}			
		});
		
	</script>

</body>
</html>