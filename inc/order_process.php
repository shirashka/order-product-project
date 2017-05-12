<?php 
	$title = "Order Process";
	include 'header.php';
?>

<?php 
	if (isset($_POST['btnGo'])) {
		include 'order.php';
		$aOrder = new order(array(
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
		
		$aOrder->addNew();
	
	}
	
?>
<p><form action="../product_order.php">
    <input type="submit" value="Place New Order" />
</form></p>

<?php include 'footer.php'; ?>