<?php
	$store = $_GET['store'] ?? 'hifebriansyah';
	$store = "&store=".$store;
?>

<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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

		.green {
			color: green;
		}

		.red {
			color: red;
		}

		.bg-red {
			background: #EEEE9B;
		}

		*:focus {outline:0px none transparent;}
	</style>

	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</head>
<body>
	<input style="display: none;" type="button" onclick="toJson()" value="export">
	<form action="convert.php" method="post" target="_blank">
		<input name="data" type="hidden" value="">
	</form>
	<table>
		<thead>
			<tr>
				<th width="1">No</th>
				<th width="1">image</th>
				<th width="1">stok</th>
				<th width="1">buy</th>
				<th width="1">sell</th>
				<th width="1">margin</th>
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
						$(this).find('.no').html($(this).index() + 1);
						getToped($(this), $(this).data('page'), $(this).data('price'));
					})
				} else {
					$('body > img').hide();
					$('body > input').show();
				}
			});
		}

		function getAgent(obj, page, price) {
			obj.attr('data-page', '');
			$.ajax({
				url: "recon-data-agent.php?page="+page+"&price="+price
			})
			.done(function( data ) {
				if(data) {
					obj.find('.agent-buy').html(data.buy);
					obj.find('.margin').html(data.margin);
					if(!data.avail) {
						obj.find('td').addClass('bg-red')
					};
				}
			});
		}

		function getToped(obj, page, price) {
			$.ajax({
				url: "recon-data-toped.php?page="+page
			})
			.done(function( data ) {
				if(data) {
					obj.find('.toped-img').html(data.img).find('img').click(function(){
						$(this).unbind();
						src = $(this).attr('src');
						$(this).attr('src', './img.jpg?img='+src)
					});

					obj.find('.toped-stock').html(data.stock);
					obj.find('.agent-slug').html(data.slug);

					page = (data.slug != '...')
						? data.slug
						: page;

					getAgent(obj, page, price);
				}
			});
		}

		function toJson() {
			data = [];
			$('[data-page]').each(function() {
				data.push([
					$(this).find('.no').text(),
					$(this).data('name'),
					'-',
					'in stock',
					'new',
					$(this).data('price'),
					$(this).data('link'),
					$(this).find('.toped-img img').attr('src'),
					$(this).find('.agent-slug').text()
				])
			})

			json = JSON.stringify(data);

			$('input[name=data]').val(json);
			$('form').submit();
		}
	</script>
</body>
</html>