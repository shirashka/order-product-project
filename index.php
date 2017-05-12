<?php 
	$title = "Index.php";
	include 'inc/header.php';
?>

<p>Welcome to ABC Loan Company, the generic location for a generic loan! Please select one of the following options:</p>
<table id="homeTable">
	<tr>
		<td>
			<a href="product_order.php">Place an Order<br/>
			<img src="dollar.jpg" alt="dollar sign"/></a><br/>
		</td>
		<td>
			<a href="search.php">Search by Last name<br/>
			<img src="search.png" alt="Search Magnifying Glass" class="magGlass"/></a>
		</td>
		
	</tr>
</table>
<p></p><br/>

<?php include 'inc/footer.php'; ?>