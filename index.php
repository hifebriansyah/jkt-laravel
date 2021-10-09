<?php
	$cat = $_GET['cat'] ?? "home-appliance";
	$key = $_GET['key'] ?? "";
	if($key != "") {
		$cat = "";
	}
	$admin = $_GET['admin'] ?? 0;
?>

<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
		table {
			border-collapse: collapse;
			width: 100%;
		}
		body > img	{
			width: 50px;
			margin: 64px auto ;
			display: block;
		}
		table td, table th {
			border: 1px solid #ddd;
			padding: 8px;
		}
		
		a {
			color: #93CAED;
			padding: 8px 16px;
			text-decoration: none;
			font-size: 24px;
		}

		div > a {
			display: inline-block;
			border: 1px solid #93CAED;
			margin-right: 8px;
			margin-bottom: 8px;
			border-radius: 8px;
		}

		a.active{
			background: #93CAED;
			color: white;
			border: 1px solid #93CAED;
		}

		div {
			margin-bottom: 16px;
		}

		form {
			margin-top: 32px;
			margin-bottom: 16px;
		}

		input {
			padding: 8px 16px;
			border-radius: 8px;
			max-width: 700px;
			border: 1px solid #ddd !important;
			font-size: 24px;
		}


		input[type=submit] {
			cursor: pointer;
		}

		*:focus {outline:0px none transparent;}

		<?php if(!$admin) { ?>
			.admin {
				display: none;
			}
		<?php } ?>
	</style>

	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</head>
<body>
	<h1>Toko Raka</h1>
	<p>Harga untuk <?= date('Y-m-d H:i:s') ?></p>
	<p>Hubungi wa 08989090112 untuk pesan</p>
	<p>Pembayaran boleh melalui tokopedia</p>

	<form action="">
		<input type="text" name="key" value="<?= $key ?>" placeholder="kata kunci">
		<input type="submit" value="cari">
	</form>

	<div>
		<a href="?cat=electronic" class="<?= $cat == 'electronic' ? 'active' : '' ?>">electronic</a>
		<a href="?cat=home-appliance" class="<?= $cat == 'home-appliance' ? 'active' : '' ?>">home appliance</a>
		<a href="?cat=toys-kids-and-baby" class="<?= $cat == 'toys-kids-and-baby' ? 'active' : '' ?>">toys kids and baby</a>
		<a href="?cat=hobby" class="<?= $cat == 'hobby' ? 'active' : '' ?>">hobby</a>
		<a href="?cat=sport-and-outdoor" class="<?= $cat == 'sport-and-outdoor' ? 'active' : '' ?>">sport and outdoor</a>
		<a href="?cat=fashion-make-up-and-beauty-care" class="<?= $cat == 'fashion-make-up-and-beauty-care' ? 'active' : '' ?>">fashion make up and beauty care</a>
		<a href="?cat=pc-and-laptop" class="<?= $cat == 'pc-and-laptop' ? 'active' : '' ?>">pc and laptop</a>
		<a href="?cat=photography" class="<?= $cat == 'photography' ? 'active' : '' ?>">photography</a>
		<a href="?cat=smartphone-and-tablet" class="<?= $cat == 'smartphone-and-tablet' ? 'active' : '' ?>">smartphone and tablet</a>
	</div>
	<table>
		<thead>
			<tr>
				<th width="1">No</th>
				<th width="1">img</th>
				<th width="1">buy</th>
				<th width="1">sell</th>
				<th class="admin">min</th>
				<th class="admin">max</th>
				<th class="admin">potential</th>
				<th class="admin">desc</th>
				<th>title</th>
				<th class="admin">link</th>
			</tr>
		</thead>
		<tbody>

		</tbody>
	</table>

	<img src="https://c.tenor.com/k-A2Bukh1lUAAAAi/loading-loading-symbol.gif">

	<script type="text/javascript">
		getData(1)

		function getData(page) {
			$.ajax({
				url: "data.php?page="+page+"&cat=<?= $cat ?>&key=<?= $key ?>"
			})
			.done(function( data ) {
				data = data.replace(/\r?\n|\r/, "")

				if(data != "" && page <= 100) {
					$('tbody').append(data);
					getData(++page);
				} else {
					$('body > img').hide();
				}
			});
		}
	</script>
</body>
</html>