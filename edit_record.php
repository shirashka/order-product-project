<?php 
	$title = "Shira Shkarofsky Assignment 13";
	include 'inc/header.php';
	include 'inc/order.php';
?>

<?php 
	if (isset($_POST["btnDelete"])) {
		$aOrder = new order(array(
			"orderid" => $_POST["orderid"],
			"product" => $_POST["product"],
			"quantity" => $_POST["quantity"],
			"unit_price" => $_POST["unit_price"],
			"discount_rate" => $_POST["discount_rate"],
			"order_date" => $_POST["order_date"],
			"first_name" => $_POST["first_name"],
			"last_name" => $_POST["last_name"],
			"payment_type" => $_POST["payment_type"],
			"card_number" => $_POST["card_number"],
			"security_code" => $_POST["security_code"]
		));
		$aOrder->delete();
	}
	
	if (isset($_POST["btnEdit"])) {
		$aOrder = new order(array(
			"orderid" => $_POST["orderid"],
			"product" => $_POST["product"],
			"quantity" => $_POST["quantity"],
			"unit_price" => $_POST["unit_price"],
			"discount_rate" => $_POST["discount_rate"],
			"order_date" => $_POST["order_date"],
			"first_name" => $_POST["first_name"],
			"last_name" => $_POST["last_name"],
			"payment_type" => $_POST["payment_type"],
			"card_number" => $_POST["card_number"],
			"security_code" => $_POST["security_code"]
		));
		$aOrder->update();
	}
	
	if (isset($_GET["id"])) {
			include "inc/connection.php";
			$sqlstr = "SELECT * FROM orders WHERE id = ?";
			$stmt = $con->prepare($sqlstr);
			$stmt->bind_param("i",$_GET["id"]);
			$stmt->execute();
			$result = $stmt->get_result();
			while ($row = $result->fetch_assoc()) {
				$aOrder = new order(array (
					"orderid" => $row["id"],
					"product" => $row["product"],
					"quantity" => $row["quantity"],
					"unit_price" => $row["unit_price"],
					"discount_rate" => $row["discount_rate"],
					"order_date" => $row["order_date"],
					"first_name" => $row["first_name"],
					"last_name" => $row["last_name"],
					"payment_type" => $row["payment_type"],
					"card_number" => $row["card_number"],
					"security_code" => $row["security_code"]
				));
			}
			$con->close();
			if (!isset($aOrder)) {
				echo "Record not found";
			} else {
				$myVals = $aOrder->getValues();
				
	?>
<div id="editForm">	
	<h3>Edit your Order:</h3>
	<form method="post">
		<h4><?php echo "Total: $".$aOrder->getTotal(); ?></h4>
		<input type="hidden" id = "orderid" name = "orderid" value = "<?php echo $myVals['orderid']; ?>" />
		<table class="gridtable">
			<tr>
				<th><label for="product">Product</label></th>
				<td><select name="product" id="product">
						<option value="">--Select One--</option>
						<option <?php
							if($myVals["product"] == "iPad") { echo "selected";}
						?>>iPad</option>
						<option <?php
							if($myVals["product"] == "iPhone 6S") { echo "selected";}
						?>>iPhone 6S</option>
						<option <?php
							if($myVals["product"] == "Galaxy 5S") { echo "selected";}
						?>>Galaxy 5S</option>
						<option <?php
							if($myVals["product"] == "Moto X") { echo "selected";}
						?>>Moto X</option>
					</select>
				</td>
			</tr>
			<tr>
				<th><label for="quantity">Quantity:</label></th>
				<td><input type="number" name="quantity" id="quantity" value="<?php echo $myVals['quantity']; ?>"></input></td>
			</tr>
			<tr>
				<th><label for="unit_price">Unit Price:</label></th>
				<td><input type="number" name="unit_price" id="unit_price" value="<?php echo $myVals['unit_price']; ?>"></input></td>
			</tr>
			<tr>
				<th><label for="discount_rate">Discount Rate:</label></th>
				<td><input type="number" name="discount_rate" id="discount_rate" value="<?php echo $myVals['discount_rate']; ?>"></input></td>
			</tr>
			<tr>
				<th><label for="order_date">Order Date:</label></th>
				<td><input type="date" name="order_date" id="order_date" value="<?php echo $myVals['order_date']; ?>"></input></td>
			</tr>
			<tr>
				<th><label for="first_name">First Name:</label></th>
				<td><input type="text" name="first_name" id="first_name" value="<?php echo $myVals['first_name']; ?>"></input></td>
			</tr>
			<tr>
				<th><label for="last_name">Last Name:</label></th>
				<td><input type="text" name="last_name" id="last_name" value="<?php echo $myVals['last_name']; ?>"></input></td>
			</tr>
			<tr>
				<th><label for="payment_type">Payment Type:</label></th>
				<td><select name="payment_type" id="payment_type">
					<option value="">--Select One--</option>
					<option <?php
							if ($myVals["payment_type"] == "Visa") { echo "selected";}
						?>>Visa</option>
					<option <?php
							if($myVals["payment_type"] == "Mastercard") { echo "selected";}
						?>>Mastercard</option>
					<option <?php
							if($myVals["payment_type"] == "Discover") { echo "selected";}
						?>>Discover</option>
					<option <?php
							if($myVals["payment_type"] == "AMEX") { echo "selected";}
						?>>AMEX</option>
				</select></td>
			</tr>
			<tr>
				<th><label for="card_number">Card Number:</label></th>
				<td><input type="text" name="card_number" id="card_number" value="<?php echo $myVals['card_number']; ?>"></input></td>
			</tr>
			<tr>
				<th><label for="security_code">Security Code:</label></th>
				<td><input type="text" name="security_code" id="security_code" value="<?php echo $myVals['security_code']; ?>"></input></td>
			</tr>
			<tr>
				<th><input type="submit" value="Delete" id="btnDelete" name="btnDelete" /></th>
				<td><input type="submit" value="Update" id="btnEdit" name="btnEdit" /></td>
			</tr>
		</table>
</form>
</div>
<?php 
		}
	} else {echo "no product found";}
?>

<?php include 'inc/footer.php'; ?>