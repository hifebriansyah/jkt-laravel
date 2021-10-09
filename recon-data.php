<?php 
	include 'simple_html_dom.php';

	$page = $_GET['page'] ?? 1;

	$store = $_GET['store'] ?? 'hifebriansyah';

	$url = "https://www.tokopedia.com/".$store."/page/".$page."?perpage=10";

    $results = [];

	$html = file_get_html($url);

	if(!$html->find('[data-testid="btnShopProductPageNext"]', 0) && $page!=1) {
		return 0;
	};

	$products = $html->find('[data-testid="master-product-card"]');

    foreach ($products as $key => $product) {
		try {
	    	$link = $product->find('a', 0)->getAttribute('href');
	    	$detail = file_get_html($link);

	    	if($detail->find('[data-testid="stock-label"] > b', 0)) {
		    	$results[] = [
		    		'link' => $link,
		    		'stock' => $detail->find('[data-testid="stock-label"] > b', 0)->plaintext,
		    		'img' => $detail->find('[data-testid="PDPImageMain"] img', 0)->getAttribute('src'),
					'price' => stripPrice($detail->find('.price', 0)->plaintext),
		    	];
	    	}
		} catch (Exception $e) {
			
		}
    }

    function stripPrice($price) {
    	return str_replace(['.', ' ', 'rp'], '', strtolower($price));
    }
?>

<?php if (count($results) > 0) { ?>
	<?php foreach ($results as $key => $row): array_map('htmlentities', $row); ?>
		<tr>
			<td style="white-space: nowrap;"><?= $page.'-'.($key+1) ?></td>
			<td><img height="150" src="<?= $row['img'] ?>"></td>
			<td><?= $row['stock'] ?></td>
			<td><?= $row['price'] ?></td>
			<td> <a target="_blank" href="<?= $row['link'] ?>">GO</a></td>	
		</tr>
	<?php endforeach; ?>
<?php } else { return false;} ?>