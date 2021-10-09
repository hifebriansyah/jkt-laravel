<?php 
	include 'simple_html_dom.php';

	$ongkir = 9000;
	$jasaSuplier = 5000;
	$jasaToped = 0.005;
	$margin = 0.1;
	$asuransi = 0.002;

	$type = $_GET['cat'];
	$key = "";

	if($_GET['key'] != '') {
		$type = 'search';
		$key = '&key='.$_GET['key'];
	}

	$url = "https://www.jakartanotebook.com/".$type."?show=40&sort=newitem&price=&sku=&ready=0yjwK5".$key;

    $results = [];

	$html = file_get_html($url."&page=".$_GET['page']);
	$products = $html->find('.product-list-wrapper > div');

    foreach ($products as $key => $product) {
    	if($product->find('.product-list__price', 0)) {
    		try {
    			$buy = stripPrice($product->find('.product-list__price', 0)->plaintext);
	    		$buy = $buy + (ceil($buy * $asuransi / 100) * 100) + (ceil($buy * $jasaToped / 100) * 100)  + $jasaSuplier;
	    		$recommend = stripPrice($product->find('.product-list__price--coret', 0)->plaintext ?? $buy) + $jasaSuplier;

	    		$minimum = ($buy) + ($buy * $margin);
	    		$maximum = ($recommend) + $ongkir;

		    	$results[] = [
		    		'img' => $product->find('img', 0)->getAttribute('src'),
		    		'buy' => $buy,
		    		'recommend' => $recommend,
		    		'minimum' => $minimum,
		    		'maximum' => $maximum,
		    		'pontential' => ($minimum - $buy) . '-' .($maximum - $buy),
		    		'desc' => $product->find('.product-list__p', 0)->plaintext,
		    		'title' => $product->find('a', 0)->getAttribute('title'),
		    		'link' => $product->find('a', 0)->getAttribute('href'),
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
	<?php foreach ($results as $key => $row): array_map('htmlentities', $row); ?>
		<tr>
			<td style="white-space: nowrap;"><?= $_GET['page'].'-'.($key+1) ?></td>
			<td><img height="150" src="<?= $row['img'] ?>"></td>
			<td><?= $row['buy'] ?></td>
			<td><?= $row['recommend'] ?></td>		
			<td class="admin"><?= $row['minimum'] ?></td>	
			<td class="admin"><?= $row['maximum'] ?></td>
			<td class="admin" style="white-space: nowrap;"><?= $row['pontential'] ?></td>
			<td class="admin">
				<?= $row['desc'] ?><br/><br/>
				No return<br/>
				No Refund<br/>
				Membeli berarti menyetujui<br/>
			</td>		
			<td><?= $row['title'] ?></td>	
			<td class="admin"> <a target="_blank" href="<?= $row['link'] ?>">GO</a></td>	
		</tr>
	<?php endforeach; ?>
<?php } else { return false;} ?>