<?php
	$store = $_GET['store'] ?? 'hifebriansyah';
	$store = "&store=".$store;
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

		*:focus {outline:0px none transparent;}
	</style>

	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</head>
<body>
	<table>
		<thead>
			<tr>
				<th width="1">No</th>
				<th width="1">image</th>
				<th width="1">stok</th>
				<th width="1">buy</th>
				<th width="1">sell</th>
				<th>slug</th>
				<th width="1">link</th>
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
				url: "recon-data.php?page="+page+"<?= $store ?>"
			})
			.done(function( data ) {
				data = data.replace(/\r?\n|\r/, "")

				if(data != "" && page <= 100) {
					$('tbody').append(data);
					getData(++page);

					$('.need-detail').each(function() {
						$(this).attr('class', '');
						getAgent($(this), $(this).data('page'));
					})
				} else {
					$('body > img').hide();
				}
			});
		}

		function getAgent(obj, page) {
			obj.attr('data-page', '');
			$.ajax({
				url: "recon-data-agent.php?page="+page
			})
			.done(function( data ) {
				if(data) {
					obj.find('.agent-buy').html(data.buy);
					getToped(obj, page);
				}
			});
		}

		function getToped(obj, page) {
			$.ajax({
				url: "recon-data-toped.php?page="+page
			})
			.done(function( data ) {
				if(data) {
					obj.find('.toped-img').html(data.img);
					obj.find('.toped-stock').html(data.stock);
				}
			});
		}
	</script>
</body>
</html>