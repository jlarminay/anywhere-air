<?php
session_start();
require '../library/stripe-php-2.2.0/init.php';

if ($_POST) {
  Stripe\Stripe::setApiKey("sk_test_UYrpaLslRJJDQd0Wk3sDFePZ");

  try {
    if (!isset($_POST['stripeToken']))
      throw new Exception("The Stripe Token was not generated correctly");
    Stripe\Charge::create(array("amount" => $_POST['amount'],
                                "currency" => "cad",
                                "card" => $_POST['stripeToken']));
   print 'Your payment was successful.';
 

   if (isset($_COOKIE["user"])) {
		$x= explode("-",$_COOKIE["user"]);
		$usr = $x[0];
		//print "usr is set \n";

	   if (isset($_SESSION['cart'])) {
	   	//print "cookie is set \n";
			$cart = $_SESSION['cart'];
			$ids = array();
			$totalQuantity = 0;
			$totalCost = 0;
			$items = array();
			require "../library/connect.php";
			$conn = server_connect();


			foreach ($cart as $k => $x) {
				$ids[] = $k;
				$totalQuantity += $x;

				$query = "select sale_price as price from sale where item_id = $k and date_end > now() and date_start < now()";
				$result = mysqli_query($conn,$query);
				//print_r($result);
				//print_r($result);
				$row = mysqli_fetch_assoc($result);
				if (!$row) {
					//print_r($row);
					$query = "select price from item where item_id = $k";
					$result = mysqli_query($conn,$query);
					//print_r($result);
					$row = mysqli_fetch_assoc($result);
					//print_r($row);
				}

				$totalCost += $row["price"]*$x;
				$items[$k] = array($x,$row["price"]);
			}

			$query = "insert into purchases (user_id,total_quantity,total_price)
						values (".$usr.",".$totalQuantity.",".$totalCost.") ";

			require "../public_html/php/mysql.php";
			dbUpdate ($query);

			$query = "select max(trans_id) as trans from purchases where user_id = $usr ";
			$result = mysqli_query($conn,$query);
			//print_r($result);
			$row = mysqli_fetch_assoc($result);
			$trans = $row["trans"];
			//print_r($trans);

	 		foreach ($cart as $k => $x) {
	 			//print "adding to transactions";
	 			$query = "insert into transactions (trans_id, item_id, quantity, price)
					values (".$trans.",".$k.",".$x.",".$items[$k][1].") ";
				dbUpdate ($query);
				
				//get original total_sold
				$org = 0;
				$query = "select total_sold from item where item_id ='".$k."'";
				$result = mysqli_query($conn,$query);
				if ($result){
					if (mysqli_num_rows($result) > 0){
						while ($row = mysqli_fetch_array($result)){
							$org = $row[0];
						}
					}
				}	
				//get original available
				$ava = 0;
				$query1 = "select quantity_available from item where item_id ='".$k."'";
				$result1 = mysqli_query($conn,$query1);
				if ($result){
					if (mysqli_num_rows($result1) > 0){
						while ($row1 = mysqli_fetch_array($result1)){
							$ava = $row1[0];
						}
					}
				}
				
				//update date in item
				$today = getdate();
				$date = $today['year']."-".$today['mon']."-".$today['mday'];
				
				$total = $x + $org;
				$new_ava = $ava - $x;
				
				$query = "update item 
							set date_last_sold = '".$date."',
								total_sold = '".$total."',
								quantity_available = '".$new_ava."'
							where item_id = '".$k."' ";
				dbUpdate ($query);
				
				//get original available
				$org = 0;
				$query = "select quantity_available from item where item_id ='".$k."'";
				$result = mysqli_query($conn,$query);
				if ($result){
					if (mysqli_num_rows($result) > 0){
						while ($row = mysqli_fetch_array($result)){
							$org = $row[0];
						}
					}
				}				
				
				//update date in item
				$today = getdate();
				$date = $today['year']."-".$today['mon']."-".$today['mday'];
				
				$total = $x + $org;
				
				$query = "update item 
							set quantity_available = '".$date."',
								total_sold = '".$total."'
							where item_id = '".$k."' ";
				dbUpdate ($query);
			}

			$cart = array();
			$_SESSION['cart'] = $cart;
			print "\n cart updated";

			$query = "select email from users where user_id = $usr";
			$result = mysqli_query($conn,$query);
			$row = mysqli_fetch_assoc($result);
			$email = $row["email"];
			$msg = "Thank you for your purchase at AnywhereAir.com \n Your total is \$$totalCost and you can view your order here: http://deepblue.cs.camosun.bc.ca/~cst463/git/comp199/public_html/success.php";
			$header = "From: noreply@anywhereair.com\r\n";

			if (mail($email, 'Your Anywhere Air order', $msg, $header)) {
				header("Location: ./success.php");
				die();
			} else {
				echo "something went wrong. Your payment might have been processed. Please contact customer service and be ready to provide you account details and time of this transaction.";
				die("");
			}
						
		}
		}
	}
  	catch (\Stripe\Error\Card $e) {
   	print $e->getMessage();
	}
}
print "<br />something went wrong";
die ("");


