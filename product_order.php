<?php 
	$title = "Shira Shkarofsky Assignment 13";
	include 'inc/header.php';
	//inc/order_process.php
	
// Define Variables and Set to Empty Values
$productErr = $quantityErr = $unit_priceErr = $discount_rateErr = $order_dateErr = "";
$first_nameErr = $last_nameErr = $payment_typeErr = $card_numberErr = $security_codeErr = "";

$product = $quantity = $unit_price = $discount_rate = $order_date = "";
$first_name = $last_name = $payment_type = $card_number = $security_code = "";

//VALIDATE INPUT 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$valid = true;
	
	if (empty($_POST["product"])) {
		$productErr = "Product is required";
		$valid = false;
	} else {
		$product = test_input($_POST["product"]);
	}
	
	if (empty($_POST["quantity"])) {
		$quantityErr = "Quantity is required";
		$valid = false;
	} else {
		$quantity = test_input($_POST["quantity"]);
	}
	
	if (empty($_POST["unit_price"])) {
		$unit_priceErr = "Unit Price is required";
		$valid = false;
	} else {
		$unit_price = test_input($_POST["unit_price"]);
	}
	
	if (empty($_POST["discount_rate"])) {
		$discount_rateErr = "Discount Rate is required";
		$valid = false;
	} else {
		$discount_rate = test_input($_POST["discount_rate"]);
	}
	
	if (empty($_POST["order_date"])) {
		$order_dateErr = "Order Date is required";
		$valid = false;
	} else {
		$order_date = test_input($_POST["order_date"]);
	}
  
	if (empty($_POST["first_name"])) {
		$first_nameErr = "First Name is required";
		$valid = false;
	} else {
		$first_name = test_input($_POST["first_name"]);
	}
  
	if (empty($_POST["last_name"])) {
		$last_nameErr = "Last Name is required";
		$valid = false;
	} else {
		$last_name = test_input($_POST["last_name"]);
	}
	
	if (empty($_POST["payment_type"])) {
		$payment_typeErr = "Payment Type is required";
		$valid = false;
	} else {
		$payment_type = test_input($_POST["payment_type"]);
	}
	
	if (empty($_POST["card_number"])) {
		$card_numberErr = "Card Number is required";
		$valid = false;
	} else {
		$card_number = test_input($_POST["card_number"]);
	}
	
	if (empty($_POST["security_code"])) {
		$security_codeErr = "Security Code is required";
		$valid = false;
	} else {
		$security_code = test_input($_POST["security_code"]);
	}
	
	//MOVE ON IF VALID
	if($valid){
		
		include 'inc/order.php';
		$aOrder = new order(array(
			"product" => $product,
			"quantity" => $quantity,
			"unit_price" => $unit_price,
			"discount_rate" => $discount_rate,
			"order_date" => $order_date,
			"first_name" => $first_name,
			"last_name" => $last_name,
			"payment_type" => $payment_type,
			"card_number" => $card_number,
			"security_code" => $security_code
		));
		$aOrder->addNew();
		
	} //END IF(VALID) 
} //END SERVER_REQUEST==POST

//REMOVE ANY CODE INJECTIONS
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<!-- START FORM -->
<div id="orderPanel">
<h3>Place your Order:</h3>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="myForm">
<p><span class="error">* Indicates required field.</span></p>
		<table class="gridtable">
			<tr>
				<th><label for="product">Product<span class="error">*</span></label></th>
					<td>
						<span class="error"><?php echo $productErr;?></span><br/>
						<select name="product" id="product">
							<option value="">--Select One--</option>
							<option <?php
								if($product == "iPad") { echo "selected";}
							?>>iPad</option>
							<option <?php
								if($product == "iPhone 6S") { echo "selected";}
							?>>iPhone 6S</option>
							<option <?php
								if($product == "Galaxy 5S") { echo "selected";}
							?>>Galaxy 5S</option>
							<option <?php
								if($product == "Moto X") { echo "selected";}
							?>>Moto X</option>
						</select>
					</td>
			</tr>
			<tr>
				<th><label for="quantity">Quantity:<span class="error">*</span></label></th>
				<td>
					<span class="error"><?php echo $quantityErr;?></span><br/>
					<input type="number" name="quantity" id="quantity" value="<?php echo $quantity;?>"></input>
				</td>
			</tr>
			<tr>
				<th><label for="unit_price">Unit Price:<span class="error">*</span></label></th>
				<td>
					<span class="error"><?php echo $unit_priceErr;?></span><br/>
					<input type="number" name="unit_price" id="unit_price" value="<?php echo $unit_price;?>"></input>
				</td>
			</tr>
			<tr>
				<th><label for="discount_rate">Discount Rate<span class="error">*</span></label></th>
				<td>
					<span class="error"><?php echo $discount_rateErr;?></span><br/>
					<input type="number" name="discount_rate" id="discount_rate" value="<?php echo $discount_rate;?>"></input>
				</td>
			</tr>
			<tr>
				<th><label for="order_date">Order Date<span class="error">*</span></label></th>
				<td>
					<span class="error"><?php echo $order_dateErr;?></span><br/>
					<input type="date" name="order_date" id="order_date" value="<?php echo $order_date;?>"></input>
				</td>
			</tr>
			<tr>
				<th><label for="first_name">First Name<span class="error">*</span></label></th>
				<td>
					<span class="error"><?php echo $first_nameErr;?></span><br/>
					<input type="text" name="first_name" id="first_name" value="<?php echo $first_name;?>"></input>
				</td>
			</tr>
			<tr>
				<th><label for="last_name">Last Name<span class="error">*</span></label></th>
				<td>
					<span class="error"><?php echo $last_nameErr;?></span><br/>
					<input type="text" name="last_name" id="last_name" value="<?php echo $last_name;?>"></input>
				</td>
			</tr>
			<tr>
				<th><label for="payment_type">Payment Type<span class="error">*</span></label></th>
				<td>
					<span class="error"><?php echo $payment_typeErr;?></span><br/>
					<select name="payment_type" id="payment_type">
						<option value="">--Select One--</option>
						<option <?php
									if ($payment_type == "Visa") { echo "selected";}
								?>>Visa</option>
						<option <?php
									if($payment_type == "Mastercard") { echo "selected";}
								?>>Mastercard</option>
						<option <?php
									if($payment_type == "Discover") { echo "selected";}
								?>>Discover</option>
						<option <?php
									if($payment_type == "AMEX") { echo "selected";}
								?>>AMEX</option>
					</select>
				</td>
			</tr>
			<tr>
				<th><label for="card_number">Card Number<span class="error">*</span></label></th>
				<td>
					<span class="error"><?php echo $card_numberErr;?></span><br/>
					<input type="text" name="card_number" id="card_number" value="<?php echo $card_number;?>"></input>
				</td>
			</tr>
			<tr>
				<th><label for="security_code">Security Code<span class="error">*</span></label></th>
				<td>
					<span class="error"><?php echo $security_codeErr;?></span><br/>
					<input type="text" name="security_code" id="security_code" value="<?php echo $security_code;?>"></input>
				</td>
			</tr>
			<tr>
				<th></th>
				<td><input type="submit" id="btnGo" name="btnGo" /></td>
			</tr>
		</table>
</form>
</div><!-- END ORDER PANEL -->
<?php include 'inc/footer.php'; ?>