<?php 
	$title = "Search.php";
	include 'inc/header.php';
	include 'inc/order.php';
?>

<?php
	if (isset($_POST["btnGo"])) {
		$strHTM = "";
		$orders = array();
		include "inc/connection.php";
		$strSQL = "SELECT * FROM orders WHERE last_name LIKE ?";
		$stmt = $con->prepare($strSQL);
		$last_name = "%".$_POST["last_name"]."%";
		$stmt->bind_param("s",$last_name);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($a,$b,$c,$d,$e,$f,$g,$h,$i,$j,$k);
		if ($stmt ->num_rows > 0) {
			while ($stmt->fetch()) {
				$aOrder = new order(array(
					"orderid" => $a,
					"product" => $b,
					"quantity" => $c,
					"unit_price" => $d,
					"discount_rate" => $e,
					"order_date" => $f,
					"first_name" => $g,
					"last_name" => $h,
					"payment_type" => $i,
					"card_number" => $j,
					"security_code" => $k
				));
				array_push($orders, $aOrder);
				//echo $aOrder->printReceipt();
			}
			echo order::getTable($orders);
		} else { echo "Sorry, no matches found."; }
		$con->close();
	} else {
?>
	<h3>Search by Last Name:</h3>
	<form method="post" class="searchForm">
		<input type="text" name="last_name" id="last_name" />
		<input type="submit" name="btnGo" id="btnGo" />
	</form>
<?php
	}
?>

<?php include 'inc/footer.php'; ?>