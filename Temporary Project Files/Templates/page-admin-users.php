<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include 'head.php'; ?>
<title>Admin - Users</title>
</head>
<body>

<section class="wrapper">
	<?php include 'header.php'; ?>
	<?php include 'navAdmin.php'; ?>
	<article class="main-content">
		<table class="table">
			<thead>
				<tr class="rowBold">
					<td class="col">Personal Number</td>
					<td class="col">Full Name</td>
					<td class="col"></td>
				</tr>
				</thead>
				<tbody>
				<tr class="row">
					<td class="col">A</td>
					<td class="col">5</td>
					<td class="col">
			            <button class="button icon edit">edit</button>
			        </td>
				</tr>
				<tr class="row">
					<td class="col">B</td>
					<td class="col">1</td>
					<td class="col">
			            <button class="button icon edit">edit</button>
			        </td>
				</tr>
				<tr class="row">
					<td class="col">C</td>
					<td class="col">3</td>
					<td class="col">
			            <button class="button icon edit">edit</button>
			        </td>
				</tr>
				<tr class="row">
					<td class="col">D</td>
					<td class="col">4</td>
					<td class="col">
			            <button class="button icon edit">edit</button>
			        </td>
				</tr>
				</tbody>
			</table>        
	    <script class="cssdeck" src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
	    <script src="reg.js"></script>
	</article>
	<?php include 'footer.php'; ?>
</section>
</body>
</html>

