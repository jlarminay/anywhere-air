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
	<script src="js.cookie/jquery.cookie.js"></script>
	<script src="js/cookie.js"></script>
	
	<link rel="stylesheet" type="text/css" href="css/user.css" />
	<script src="js/user.js"></script>
	
</head>

<body>

	<div id="wall"></div>

	<div id="full">
	
		<?php
		header_print($conn);	
		?>
		
		<br/>	
		
		<div id="container">
	
			<?php
			
			if (!empty($_COOKIE['user'])){
				
				if (!empty($_COOKIE['uname'])){
					$name = $_COOKIE['uname'];
				}
				
				$string = $_COOKIE['user'];
				$array = explode('-', $string);
				$id = $array[0];
				
				$query = 	"Select user_id,
									name_last,
									name_first,
									username,
									password,
									email,
									birth_day,
									address,
									phone,
									zip,
									city,
									state,
									country
							From users
							where user_id = '".$id."'";
				$result = mysqli_query($conn, $query);
				if ($result){
					$rows = 	mysqli_num_rows($result);
					$fields = 	mysqli_num_fields($result);
					if ($rows > 0) {
						$row = mysqli_fetch_row($result);
						//------------
						
						$og_user_id =		$row[0];
						$og_name_last = 	$row[1];
						$og_name_first = 	$row[2];
						$og_username =		$row[3];
						$og_email = 		$row[5];
						$og_birth_day = 	$row[6];
						if (strlen($og_birth_day)> 0){
							$og_bd_array =		explode('-',$og_birth_day);
							$og_bd_year = 		$og_bd_array[0];
							$og_bd_month = 		$og_bd_array[1];
							$og_bd_day = 		$og_bd_array[2];
						}
						else {
							$og_bd_year = 		NULL;
							$og_bd_month = 		NULL;
							$og_bd_day = 		NULL;
						}
						$og_address = 		$row[7];
						$og_phone = 		$row[8];
						$og_zip = 			$row[9];
						$og_city = 			$row[10];
						$og_state = 		$row[11];
						$og_country = 		$row[12];
						
						//------------
						echo ("<h2 style='padding:1% 1% 0 1%;margin:0;'>Welcome Back ".ucwords($name)."</h2>");
						echo ("<sub class='required'>* Required</sub>");
						
						echo ('
						<div id="log">
							<form  action="php/update.php" autocomplete="on"> 
								<table>
									<tr>
										<td class="left">
											<label for="name_first">First Name: </label>
										</td>
										<td>
											<input id="name_first" name="name_first" type="text" placeholder="First Name" value="'.$og_name_first.'" />
										</td>
										<td>
											<p class="name_first_check"></p>
										</td>
									</tr>
									<tr>
										<td class="left">
											<label for="name_last">Last Name: </label>
										</td class="left">
										<td>
											<input id="name_last" name="name_last" type="text" placeholder="Last Name" value="'.$og_name_last.'" />
										</td>
										<td>
											<p class="name_last_check"></p>
										</td>
									</tr>
									<tr>
										<td class="left">
											<label for="username">Username: </label>
										</td>
										<td>
											<input id="username" name="username" type="text" placeholder="Username" readonly value="'.ucwords($og_username).'" />
										</td>
										<td>
											<p class="username_check"></p>
										</td>
									</tr>
									<tr>
										<td class="left">
											<label for="new_pass">Password: </label>
										</td>
										<td>
											<input id="new_pass" name="new_pass" type="password" placeholder="New Password"/>
										</td>
										<td>
											<p class="new_pass_check"></p>
										</td>
									</tr>
									<tr>
										<td class="left">
											<label for="new_pass_confirm">Confirm Password:</label>
										</td>
										<td>
											<input id="new_pass_confirm" name="new_pass_confirm" type="password" placeholder="Confirm New Password"/>
										</td>
										<td>
											<p class="new_pass_confirm_check"></p>
										</td>
									</tr>
									<tr>
										<td class="left">
											<label for="email">Email:</label>
										</td>
										<td>
											<input id="email" name="email" type="email" placeholder="example@domain.com" value="'.$og_email.'" />
										</td>
										<td>
											<p class="email_check"></p>
										</td>
									</tr>
									<tr>
										<td class="left">
											<label>Date of Birth:</label>
										</td>
										<td>
											<select id="bd_month" name="bd_month" onChange="changeDate(this.options[selectedIndex].value);">
												<option value="na" disabled selected>Month</option>
												');
												$i = 1;
												$month = array('','January','February','March','April','May','June','July','August','September','October','November','December');
												while ($i < 13){
													if ($i == $og_bd_month){
														echo ('<option value="'.$i.'" selected>'.$month[$i].'</option>');
													}
													else {
														echo ('<option value="'.$i.'">'.$month[$i].'</option>');
													}
													$i ++;
												}
											echo ('
											</select>
											<select name="bd_day" id="bd_day">
												<option value="na" disabled selected>Day</option>
												');
												$i = 1;
												while ($i < 32){
													if ($i == $og_bd_day){
														echo ('<option value="'.$i.'" selected>'.$i.'</option>');
													}
													else {
														echo ('<option value="'.$i.'">'.$i.'</option>');
													}
													$i ++;
												}
											echo ('
											</select>
											<select name="bd_year" id="bd_year">
												<option value="na" disabled selected>Year</option>
												');
												$i = 1899;
												$today = date("Y");
												while ($i < $today){
													if ($today == $og_bd_year){
														echo ('<option value="'.$today.'" selected>'.$today.'</option>');
													}
													else {
														echo ('<option value="'.$today.'">'.$today.'</option>');
													}
													$today--;
												}
											echo ('
											</select>
										</td>
										<td>
											<p class="birth_day_check"></p>
										</td>
									</tr>
									<tr>
										<td class="left">
											<label for="address">Address:</label>
										</td>
										<td>
											<input id="address" name="address" type="text" placeholder="Address" value="'.$og_address.'"/> 
										</td>
										<td>
											<p class="address_check"></p>
										</td>
									</tr>
									<tr>
										<td class="left">
											<label for="city">City:</label>
										</td>
										<td>
											<input id="city" name="city" type="text" placeholder="City" value="'.$og_city.'"/> 
										</td>
										<td>
											<p class="city_check"></p>
										</td>
									</tr>
									<tr>
										<td class="left">
											<label for="state">State:</label>
										</td>
										<td>
											<input id="state" name="state" type="text" placeholder="State" value="'.$og_state.'"/> 
										</td>
										<td>
											<p class="state_check"></p>
										</td>
									</tr>
									<tr>
										<td class="left">
											<label for="country">Country:</label>
										</td>
										<td>
											<input id="country" name="country" type="text" placeholder="Country" value="'.$og_country.'"/> 
										</td>
										<td>
											<p class="country_check"></p>
										</td>
									</tr>
									<tr>
										<td class="left">
											<label for="zip">Postal Code:</label>
										</td>
										<td>
											<sub style="font-size:75%;">*Only valid for US and Canadian Postal Codes</sub>
											<input id="zip" name="zip" type="text" placeholder="Zip" value="'.$og_zip.'"/> 
										</td>
										<td>
											<p class="zip_check"></p>
										</td>
									</tr>
									<tr>
										<td class="left">
											<label for="phone">Phone:</label>
										</td>
										<td>
											<input id="phone" name="phone" type="text" placeholder="Phone" value="'.$og_phone.'"/> 
										</td>
										<td>
											<p class="phone_check"></p>
										</td>
									</tr>
									<tr>
										<td class="left">
											<label>Confirm Original Password:</label>
										</td>
										<td>
											<input id="master_pass" name="master_pass" required="required" type="password" placeholder="Confirm Password"/>
										</td>
										<td>
											<p class="required"><sub>* Required</sub></p>
										</td>
									</tr>
								</table>

								<input id="submit" type="submit" value="Update Info"/> 
							</form>
						</div>
						');
					}
				}
			}
			else {
				echo ("<div style='padding:2%;font-size:120%;'>User Not Found</div>");
			}
			?>
			
		</div>
	</div>
</body>

<footer>

	<a href='js/user.txt' style='float:left;'>txt</a>
	
	<?php
	footer_print($conn);	
	?>
</footer>
</html>