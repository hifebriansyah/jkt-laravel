<?php
	$cat = $_GET['cat'] ?? "home-appliance";
	$key = $_GET['key'] ?? "";
	if($key != "") {
		$cat = "";
	}
	$admin = isset($_GET['admin'])
		? '&admin='.$_GET['admin']
		: '';
?>

<!DOCTYPE html>
<html>

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<head>
	<style type="text/css">
		body {
			margin: 0;
		}
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

		table tr > td:nth-child(2) {
			padding: 0;
			width: 250px;
			vertical-align: midle;
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

		body > div {
			margin-bottom: 16px;
		}

		form {
			margin-top: 32px;
			margin-bottom: 16px;
			white-space: nowrap;
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

		td > img {
			width: 100%;
			min-width: 150px;
			display: block;
		}

		.images {
			padding: 4px;
			background: #404040	;
		}

		.images:after {
			content: " ";
			clear: both;
			display: block;
		}

		.images > img {
			width: calc(20% - 4px);
			float: left;
			margin: 2px;
			cursor: pointer;
			border-radius: 4px;
		}

		.desc {
			font-size: 14px;
		}

		.desc b {
			font-size: 16px;
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

		<?php if($admin) { ?>
			<input type="hidden" name="admin" value="1">
		<?php } ?>

		<input type="submit" value="cari">
	</form>

	<div>
		<a href="?cat=electronic<?= $admin ?>" class="<?= $cat == 'electronic' ? 'active' : '' ?>">electronic</a>
		<a href="?cat=home-appliance<?= $admin ?>" class="<?= $cat == 'home-appliance' ? 'active' : '' ?>">home appliance</a>
		<a href="?cat=toys-kids-and-baby<?= $admin ?>" class="<?= $cat == 'toys-kids-and-baby' ? 'active' : '' ?>">toys kids and baby</a>
		<a href="?cat=hobby<?= $admin ?>" class="<?= $cat == 'hobby' ? 'active' : '' ?>">hobby</a>
		<a href="?cat=sport-and-outdoor<?= $admin ?>" class="<?= $cat == 'sport-and-outdoor' ? 'active' : '' ?>">sport and outdoor</a>
		<a href="?cat=fashion-make-up-and-beauty-care<?= $admin ?>" class="<?= $cat == 'fashion-make-up-and-beauty-care' ? 'active' : '' ?>">fashion, make up & beauty</a>
		<a href="?cat=pc-and-laptop<?= $admin ?>" class="<?= $cat == 'pc-and-laptop' ? 'active' : '' ?>">pc and laptop</a>
		<a href="?cat=photography<?= $admin ?>" class="<?= $cat == 'photography' ? 'active' : '' ?>">photography</a>
		<a href="?cat=smartphone-and-tablet<?= $admin ?>" class="<?= $cat == 'smartphone-and-tablet' ? 'active' : '' ?>">smartphone and tablet</a>
	</div>
	<table>
		<thead>
			<tr>
				<th width="1">No</th>
				<th>img</th>
				<th width="1">buy</th>
				<th width="1">sell</th>
				<th class="admin">min</th>
				<th>desc</th>
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
				url: "data.php?page="+page+"&cat=<?= $cat ?>&key=<?= urlencode($key) ?>"
			})
			.done(function( data ) {
				data = data.replace(/\r?\n|\r/, "")

				if(data != "" && page <= 100) {
					$('tbody').append(data);
					getData(++page);

					$('.need-detail').each(function() {
						$(this).attr('class', '');
						getDetail($(this), $(this).data('page'));
					})
				} else {
					$('body > img').hide();
				}
			});
		}

		function getDetail(obj, page) {
			obj.attr('data-page', '');
			$.ajax({
				url: "data-detail.php?page="+page
			})
			.done(function( data ) {
				if(data) {
					obj.find('.detail').html(data.detail);
					obj.find('.images').html(data.srcs).promise().done(function(){
						obj.find('.images > img').hover(function(){
							$(this).parent().parent().find('img').eq(0).attr('src', $(this).attr('src'));
						})  
					});	
				}
			});
		}
	</script>
</body>
</html>