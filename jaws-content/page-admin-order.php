<?php include $_SERVER['DOCUMENT_ROOT']."/jaws-content/header.php";	include $_SERVER['DOCUMENT_ROOT']."/jaws-content/navAdmin.php";?>	
		<section class="wrapper">
			<article class="main-content">
				<?php if (isset($_SESSION['IsAdmin'])){ ?>
				<table class="table">
					<tr>
						<td><strong>Order</strong></td>
						<td>43274324</td>
					</tr>
					<tr>
						<td><strong>Date</strong></td>
						<td>2013-09-26</td>
					</tr>
				</table>
				<table class="table">
					<tr>
						<th><strong>Shipping Address</strong></th>
						<th></th>
						<th><strong>Billing Address</strong></th>
						<th></th>
					</tr>
					<tr>
						<td><strong>Street Address</strong></td>
						<td>Hermansvägen 104</td>
						<td>Street Address</td>
						<td>Hermansvägen 104</td>
					</tr>
					<tr>
						<td>Post Address</td>
						<td>55453</td>
						<td>Post Address</td>
						<td>55453</td>
					</tr>
					<tr>
						<td>City</td>
						<td>Jönköping</td>
						<td>City</td>
						<td>Jönköping</td>
					</tr>
				</table>
				<table class="table">
					<tr>
						<th>Name</th>
						<th>Weight</th>
						<th>Price</th>
						<th>Amount</th>
						<th>Total Price</th>
					</tr>
					<tr>
						<td>Nintendo 64</td>
						<td>1,2 kg</td>
						<td>1200 kr</td>
						<td>2</td>
						<td>2400 kr</td>
					</tr>
					<tr>
						<td>Nintendo 65</td>
						<td>1,2 kg</td>
						<td>2000 kr</td>
						<td>1</td>
						<td>2000 kr</td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td>Sum</td>
						<td>4400 kr</td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td>Total Weight</td>
						<td>4,6 kg</td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td>Shipping Cost</td>
						<td>150 kr</td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td>Total value of order</td>
						<td>4550 kr</td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td>Total value of order including VAT</td>
						<td><strong>5687.5 kr</strong></td>
					</tr>
				</table>
				<?php } else {
				echo "<p>You do not have authorization to see this page!</p>";
				} ?>
			</article>
		</section><!-- .wrapper -->
<?php include $_SERVER['DOCUMENT_ROOT']."/jaws-content/footer.php";	?>