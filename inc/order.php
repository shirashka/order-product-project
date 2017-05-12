<?php
class order {
	private $orderid;
	private $product;
	private $quantity;
	private $unit_price;
	private $discount_rate;
	private $order_date;
	private $first_name;
	private $last_name;
	private $payment_type;
	private $card_number;
	private $security_code;
	
	//CONSTRUCT THE OBJECT
	public function __construct($aArray) {
		if(isset($aArray["orderid"])) {
			$this->orderid = $aArray["orderid"];
		}
		$this->product = $aArray['product'];
		$this->quantity = $aArray['quantity'];
		$this->unit_price = $aArray['unit_price'];
		$this->discount_rate = $aArray['discount_rate'];
		$this->order_date = $aArray['order_date'];
		$this->first_name = $aArray['first_name'];
		$this->last_name = $aArray['last_name'];
		$this->payment_type = $aArray['payment_type'];
		$this->card_number = $aArray['card_number'];
		$this->security_code = $aArray['security_code'];
	}
	
	public function getValues() {
		$aArray = array(
			"orderid" => $this->orderid,
			"product" => $this->product,
			"quantity" => $this->quantity,
			"unit_price" => $this->unit_price,
			"discount_rate" => $this->discount_rate,
			"order_date" => $this->order_date,
			"first_name" => $this->first_name,
			"last_name" => $this->last_name,
			"payment_type" => $this->payment_type,
			"card_number" => $this->card_number,
			"security_code" => $this->security_code
		);
		return $aArray;
	}
	
	public function addNew() {
		include 'connection.php';
		$strSQL = "INSERT INTO orders (product, first_name, last_name, quantity, unit_price, ";
		$strSQL .= "discount_rate, order_date, payment_type, card_number, security_code)";
		$strSQL .= "VALUES (?,?,?,?,?,?,?,?,?,?)";
		$stmt = $con->prepare($strSQL);
		$stmt->bind_param("sssiddssss",
			$this->product, $this->first_name,
			$this->last_name, $this->quantity,
			$this->unit_price, $this->discount_rate,
			$this->order_date, $this->payment_type,
			$this->card_number, $this->security_code
			);
		$stmt->execute();
		if (mysqli_affected_rows($con) == 1) {
			$this->orderid = $con->insert_id;
			echo $this-> printReceipt();
		} else {echo mysqli_err($conn);}
		mysqli_close($con);
	}
	
	//UPDATE THE DATABASE
	
	public function update() {
		include 'connection.php';
		$strSQL = "UPDATE orders SET product = ?, quantity = ?, first_name = ?, last_name = ?, unit_price = ?, ";
		$strSQL .= "discount_rate = ?, order_date = ?, payment_type = ?, card_number = ?, security_code = ? ";
		$strSQL .= "WHERE id = ?";
		$stmt = $con->prepare($strSQL);
		$stmt -> bind_param("sissddssssi" ,
			$this->product,  $this->quantity,
			$this->first_name,
			$this->last_name,
			$this->unit_price, $this->discount_rate,
			$this->order_date, $this->payment_type,
			$this->card_number, $this->security_code,
			$this->orderid
			);
		$stmt->execute();
		if (mysqli_affected_rows($con) == 1) {
			echo "Updated. ";
		} else {echo mysqli_err($con);}
		$con->close();
	}
	
	// Delete the Order record
	public function delete() {
		include "connection.php";
		$strSQL = "DELETE FROM orders ";
		$strSQL .= "WHERE id= ?";
		$stmt = $con->prepare($strSQL);
		$stmt->bind_param("i", $this->orderid);
		$stmt->execute();
		if (mysqli_affected_rows($con) == 1) {
			echo "Record Deleted Successfully.";
			$goBack = "<p><form action='/portfolio/projects/loanproject/index.php'>";
			$goBack .= "<input type='submit' value='Return to Homepage' /></form></p>";
			echo($goBack);
			?>
			<!-- Hide the Edit Form panel since the Order no longer exists -->
			<style type="text/css">#editForm { display:none; } </style>
			<?php
		} else {echo mysqli_error($con); }
		$con->close();
		
	}
	
	// STATIC METHOD- to turn orders array into HTML table
	public static function getTable($orders) {
		$strHTM = "<br/><h3>Here are your search results:</h3><table class='gridtable'><tr>";
		$strHTM .= "<th>FNAME</th><th>LNAME</th>";
		$strHTM .= "<th>Product</th><th>Price</th>";
		$strHTM .= "<th>Discount</th><th>Total</th>";
		$strHTM .= "<th>Payment</th>";
		foreach($orders as $i) {
			$strHTM .= $i->getRow();
		}
		return $strHTM . "</table><br/>";
	}
	
	private function getRow() {
		$strHTM = "<tr>";
		$strHTM .="<td>".$this->first_name."</td>";
		$strHTM .="<td><a href='edit_record.php?id=".$this->orderid."'>".$this->last_name."</a></td>";
		$strHTM .="<td>".$this->product."</td>";
		$strHTM .="<td>$".$this->unit_price."</td>";
		$strHTM .="<td>".$this->discount_rate."%</td>";
		$strHTM .="<td>$".$this->getTotal()."</td>";
		$strHTM .="<td>".$this->payment_type.$this->processPayment()."</td>";
		return $strHTM . "</tr>";
	}
	
	//PRINT RECEIPT ON PAGE
	public function printReceipt() {
		?>
		<!-- Hide the Order Panel -->
		<style type="text/css">#orderPanel { display:none; } </style>
		<?php
		
		$strHTML = "<h3>Thanks for ordering!</h3><table class='gridtable'>";
		$strHTML .= "<tr><th>Product:</th><td>".$this->product."</td></tr>";
		$strHTML .= "<tr><th>Name:</th><td>".$this->first_name ." ". $this->last_name."</td></tr>";
		$strHTML .= "<tr><th>Unit Price:</th><td>" . $this->unit_price ."</td></tr>";
		$strHTML .= "<tr><th>Discount Rate:</th><td>".$this->discount_rate."</td></tr>";
		$strHTML .= "<tr><th>Order Total:</th><td>".$this->getTotal()."</td></tr>";
		$strHTML .= "<tr><th>Order Date:</th><td>".$this->order_date."</td></tr>";
		$strHTML .= "<tr><th>Payment Type:</th><td>".$this->payment_type."</td></tr>";
		$strHTML .= "<tr><th>Payment Info:</th><td>". $this->processPayment() ."</td></tr>";
		$strHTML .= "<tr><th>Today's Date:</th><td>".date('F j, Y')."</td></tr>";
		$strHTML .= "</table><br/>";
		$strHTML .= "<p><form action='/portfolio/projects/loanproject/product_order.php'>";
		$strHTML .= "<input type='submit' value='Place New Order' /></form></p>";
		return $strHTML;	
	}
	
	//CALCULATE TOTAL AMOUNT OF ORDER
		public function getTotal() {
		$discAmount = $this->unit_price - ($this->unit_price * ($this->discount_rate / 100));
		return $discAmount * $this->quantity;
	}
	
	//HIDE CREDIT CARD DETAILS
	public function processPayment() {
		$hideCard = "************" . substr($this->card_number, -4);
		return $hideCard;
	}
}

?>