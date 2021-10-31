<?php 
	ini_set('display_errors', 0);

	include 'simple_html_dom.php';

	$config = include 'config.php';
	$type = $_GET['cat'];
	$sort = 'newitem';
	$key = "";

	if($_GET['key'] != '') {
		$type = 'search';
		$key = '&key='.$_GET['key'];
		$sort = 'match';
	}

	$url = "https://www.jakartanotebook.com/".$type."?show=40&sort=".$sort."newitem&price=&sku=&ready=0yjwK5".$key;

    $results = [];

	$html = file_get_html($url."&page=".$_GET['page']);
	$products = $html->find('.product-list-wrapper > div');

    foreach ($products as $key => $product) {
    	if($product->find('.product-list__price', 0)) {
    		try {
    			$buy = stripPrice($product->find('.product-list__price', 0)->plaintext);
	    		$buy = $buy + (ceil($buy * $config['asuransi'] / 100) * 100) + (ceil($buy * $config['jasaToped'] / 100) * 100)  + $config['jasaSuplier'];
	    		$recommend = stripPrice($product->find('.product-list__price--coret', 0)->plaintext ?? $buy) + $config['jasaSuplier'];
	    		$minimum = ceil(($buy + ($buy * $config['margin'])) / 1000) * 1000;

		    	$link = $product->find('a', 0)->getAttribute('href');
		    	$links = explode('/', $link);	
		    	$slug = $links[count($links) - 1];

		    	$results[] = [
		    		'src' => $product->find('img', 0)->getAttribute('src'),
		    		'buy' => number_format($buy, 0, ',', '.'),
		    		'recommend' => number_format($recommend, 0, ',', '.'),
		    		'minimum' => number_format($minimum, 0, ',', '.'),
		    		'desc' => $detailBox,
		    		'title' => $product->find('a', 0)->getAttribute('title'),
		    		'slug' => $slug,
		    		'link' => $link,
		    	];
    		} catch (Exception $e) {
    			
    		}
    	}
    }

    function stripPrice($price) {
    	return str_replace(['.', 'Rp '], '', $price);
    }
?>

<?php if (count($results) > 0) { ?>
	<?php foreach ($results as $key => $row) { array_map('htmlentities', $row); ?>
		<tr class="need-detail" data-page="<?= $row['link'] ?>">
			<td style="white-space: nowrap;"><?= $_GET['page'].'-'.($key+1) ?></td>
			<td>
				<img src="<?= $row['src'] ?>">
				<div class="images"></div>
			</td>
			<td><?= $row['buy'] ?></td>
			<td><?= $row['recommend'] ?></td>		
			<td class="admin"><?= $row['minimum'] ?></td>	
			<td class="desc">
				<b><?= $row['title'] ?></b>
				<div class="admin">
					<br/>
					<?= $row['slug'] ?><br/><br/>
					<div class="detail"></div><br/>
					Tolong tanyakan stok terlebih dahulu<br/>
					No return/refund<br/>
					Membeli berarti menyetujui<br/>
					<br>
					<div class="weight"></div>
					<div class="warantly"></div>
				</div>
			</td>		
			<td class="admin"> <a target="_blank" href="<?= $row['link'] ?>">GO</a></td>	
		</tr>
	<?php } ?>
<?php } else { return false;} ?>