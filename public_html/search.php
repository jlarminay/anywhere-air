<?php
require "../library/template.php";
$conn = start();
?>
<html>
<head>
	<title>Anywhere Air</title>
	<link rel="icon" type="image/ico" href="images/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/blackrose_regular_macroman/stylesheet.css" />
	<link rel="stylesheet" type="text/css" href="fonts/nautilus/stylesheet.css" />
	
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	
	<link rel="stylesheet" href="css/search.css" >
	<script src="js/search.filter.js"></script>

	<script type="text/javascript">
	var sort;
	var continents;
	var countries;
	var sale = false;
	var types;
	var weights;
	var prices;
	var search = "";


	$(function() {
		//
		//change search form
		//
		$("#sgo").submit(function(){
			fetch();
			return false; //stop form from submitting because ajax
		});

		//
		//handle cart event
		//
		$(document).on( 'click', '.cart', function(){
			$.get("actionCart.php", {"item_id" : $(this).attr("data-id"), "action" : "add", "quantity" : $(this).parent().find(".quantity").val() }, function(data){
				$("#cart_count").html(data);
			});
		});
		
		$(document).on( 'click', '.wish', function(){
			$.get("actionWish.php", {"item_id" : $(this).attr("data-id"), "action" : "add", "quantity" : $(this).parent().find(".quantity").val()});
		});

	});




	function fetch() {
		//alert("sort="+sort+"&continents="+continents+"&countries="+countries+"&sale="+sale+"&types="+types+"&weights="+weights);
		
		//
		//get filter preferences
		//

		sort = null; 
		inputElements = document.getElementsByName('sort');
		for(var i=0; inputElements[i]; ++i){
		   if(inputElements[i].checked){
		      sort = inputElements[i].value;
		      break;
		   }
		}

		sale = (document.getElementById("sale").checked);
		recent = (document.getElementById("recent").checked);
		//alert("sort="+sort+"&continents="+continents+"&countries="+countries+"&sale="+sale+"&types="+types+"&weights="+weights);

		search = (document.getElementById("s").value);
		
		countries = [];
		var j=0;
		var inputElements = document.getElementsByName('country');
		for(var i=0; inputElements[i]; ++i){
		   if(inputElements[i].checked){
		      countries[j] = inputElements[i].value;
		      j++;
		   }
		}

		continents = [];
		j=0;
		inputElements = document.getElementsByName('continent');
		for(var i=0; inputElements[i]; ++i){
		   if(inputElements[i].checked){
		      continents[j] = inputElements[i].value;
		      j++;
		   }
		}
		//continents.toString();

		types = []; 
		j=0;
		inputElements = document.getElementsByName('bottle');
		for(var i=0; inputElements[i]; ++i){
		   if(inputElements[i].checked){
		      types[j] = "'"+inputElements[i].value+"'";
		      j++;
		   }
		}
		//types.toString();

		weights = [];
		j=0;
		inputElements = document.getElementsByName('weight');
		for(var i=0; inputElements[i]; ++i){
		   if(inputElements[i].checked){
		      weights[j] = inputElements[i].value;
		      j++;
		   }
		}

		prices = [];
		j=0; 
		inputElements = document.getElementsByName('price');
		for(var i=0; inputElements[i]; ++i){
		   if(inputElements[i].checked){
		      prices[j] = inputElements[i].value;
		      j++;
		   }
		}
	   //alert("sort="+sort+"&continents="+continents+"&countries="+countries+"&sale="+sale+"&types="+types+"&weights="+weights+"&prices="+prices);
	   
	   //
		//AJAX
		//

	   try 
	   	{
	      	xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
	   	}
	    	catch (b)
	    	{
	      	try 
	      	{
	        		xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
	      	}
	      	catch (c)
	      	{
	        		xmlHttp = null;
	      	}
	    	}
	    	if (!xmlHttp && typeof XMLHttpRequest != "undefined")
	      {
	        xmlHttp = new XMLHttpRequest;
	      }

			// Function to execute when the readyState of the connection changes.    
	    	xmlHttp.onreadystatechange=function() {
				// A response of 4 indicates the request is complete, we can get the data.  
				// Otherwise we just ignore this and return 
	      	if(xmlHttp.readyState==4) {
		   		document.getElementById("display").innerHTML=xmlHttp.responseText;
	      	}
	    	}

			//Open a connection to the server and send a request.
	    	

	    	//retrieve query results from lab9.php passing on query input via get
	    	xmlHttp.open("GET", ("actionSearch.php?sort="+sort+"&continents="+continents+"&countries="+countries+"&sale="+sale+"&types="+types+"&weights="+weights+"&prices="+prices+"&search="+search+"&recent="+recent), true);
	    	xmlHttp.send(null);
	  	}
	
	/*//function to call on click of go button
  	$('#go').click(function() {
  		$.get(("searchAction.php?sort="+sort+"&continents="+continents+"&countries="+countries+"&sale="+sale+"&types="+types+"&weights="+weights), {success:function(data) {
  			$('#display').html(data);
  		}});
  	})*/
	</script>
	
</head>

<body onload="fetch();">

	<div id="wall"></div>

	<div id="full">
	
		<?php
		header_print($conn);	
		?>
		
		<br/>	
		
		<div id="container" class="clearfix">
		
			<div id="filter">
				<p id="all_show" style="margin:0px;font-size:140%;text-align:center;"><i class="fa fa-plus-square"></i> <u>Filter</u></p>
				<p id="all_hide" style="margin:0px;font-size:140%;text-align:center;"><i class="fa fa-minus-square"></i> <u>Filter</u></p>
				<form action="search" method="post" onchange="fetch();">	
					<!-- Sort -->
					<div id="sort" class="mass">
						<div id="sort_toggle" class="toggle"><i class="fa fa-plus-square"></i> <u>Sort By</u></div>
						<ul id="sort_show">
							<li><input type="radio" name="sort" value="az1">By Continent</input></li>
							<li><input type="radio" name="sort" value="az2">By Country</input></li>
							<li><input type="radio" name="sort" value="az3">By City</input></li>
							<li><input type="radio" name="sort" value="pl">Price Low-High</input></li>
							<li><input type="radio" name="sort" value="ph">Price High-Low</input></li>
							<li><input type="radio" name="sort" value="p">Popularity</input></li>
							<li><input type="radio" name="sort" value="no">Date New-Old</input></li>
							<li><input type="radio" name="sort" value="on">Date Old-New</input></li>
						</ul>
					</div>
					<!-- Status -->
					<div id="status" class="mass">
						<div id="status_toggle" class="toggle"><i class="fa fa-plus-square"></i> <u>Status</u></div>
						<ul id="status_show">
							<li><input type="checkbox" id="sale" name="status" value="true" <?php if (isset($_GET['promo']) && ($_GET['promo'] == "true")) { echo "checked";} ?> >On Sale</input></li>
							<li><input type="checkbox" id="recent" name="recent" value="true" <?php if (isset($_GET['new']) && ($_GET['new'] == "true")) { echo "checked";} ?> >New!</input></li>
						</ul>
					</div>
					<!-- Continent -->
					<div id="continent" class="mass">
						<div id="continent_toggle" class="toggle"><i class="fa fa-plus-square"></i> <u>Continent</u></div>
						<ul id="continent_show">
							<?php
								$query = "Select * from location_continent";
								$conts =	mysqli_query($conn,$query);
								if ($conts) {
									while ($a=mysqli_fetch_assoc($conts)){
										print '
										<li class="continent"><input type="checkbox" name="continent" value="'.$a["continent_id"].'"><u name="'.str_replace(' ', '', $a["name"]).'">'.$a["name"].'</u></input></li>';

										$query = "Select * from location_country where continent_id = ".$a["continent_id"];
										$counts =	mysqli_query($conn,$query);
										if ($counts) {
											print '<ul id="country_'.str_replace(' ', '', $a["name"]).'" class="country">';
											while ($b=mysqli_fetch_assoc($counts)){
												print '
												<li><input type="checkbox" name="country" value="'.$b["country_id"].'">'.$b["name"].'</input></li>';
											}
											print '</ul>';
										}
									}
								}
							?>
						</ul>
					</div>
					<!-- Bottle -->
					<div id="bottle" class="mass">
						<div id="bottle_toggle" class="toggle"><i class="fa fa-plus-square"></i> <u>Bottle</u></div>
						<ul id="bottle_show">
							<?php
								$query = "Select DISTINCT(type) from bottle";
								$botts =	mysqli_query($conn,$query);
								if ($botts) {
									while ($a=mysqli_fetch_assoc($botts)){
										print '
										<li><input type="checkbox" name="bottle" value="'.$a['type'].'">'.$a['type'].'</input></li>';
									}
								} else {
									//echo mysqli_error($conn);
								}
							?>
						</ul>
					</div>
					<!-- Price -->
					<div id="price" class="mass">
						<div id="price_toggle" class="toggle"><i class="fa fa-plus-square"></i> <u>Price</u></div>
						<ul id="price_show">
							<!-- min and max defined in actionSearch.php -->
							<li><input type="checkbox" name="price" value="5">Under 5$</input></li>
							<li><input type="checkbox" name="price" value="10">5-10$</input></li>
							<li><input type="checkbox" name="price" value="15">10-15$</input></li>
							<li><input type="checkbox" name="price" value="20">15-20$</input></li>
							<li><input type="checkbox" name="price" value="21">More Than 20$</input></li>
						</ul>
					</div>
					<!-- Weight -->
					<div id="weight" class="mass">
						<div id="weight_toggle" class="toggle"><i class="fa fa-plus-square"></i> <u>Weight</u></div>
						<ul id="weight_show">
							<!-- smin and max defined in actionSearch.php -->
							<li><input type="checkbox" name="weight" value="0.15">0.15 KG</input></li>
							<li><input type="checkbox" name="weight" value="0.30">0.3 KG</input></li>
							<li><input type="checkbox" name="weight" value="0.50">0.5 KG</input></li>
							<li><input type="checkbox" name="weight" value="0.80">0.8 KG</input></li>
						</ul>
					</div>

				</form>
			</div>
			
			<div id="result">
				<div id="display">
				</div>
			</div>
			
			<a href="#top">
				<div id="totop">
					<p><i class="fa fa-arrow-up"></i>To Top</p>
				</div>
			</a>
			
		</div>
	</div>
</body>

<footer>
	<?php
	footer_print($conn);	
	?>
</footer>
</html>