<?php 
	include 'simple_html_dom.php';

	$db = include 'db.php';
	$config = include 'config.php';

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
	    	$links = explode('/', $link);
	    	$slug = $links[count($links) - 1];

	    	$toped = file_get_html($link);
	    	$buy = null;;

	    	if(isset($db[$slug])) {
	    		$agent = file_get_html('https://www.jakartanotebook.com/'.$db[$slug]);
	    		$buy = stripPrice($agent->find('.price-final > span', 0)->plaintext);
	    		$buy = $buy + (ceil($buy * $config['asuransi'] / 100) * 100) + (ceil($buy * $config['jasaToped'] / 100) * 100)  + $config['jasaSuplier'];
	    	}

	    	if($toped->find('[data-testid="stock-label"] > b', 0)) {

		    	$results[] = [
		    		'link' => $link,
		    		'stock' => $toped->find('[data-testid="stock-label"] > b', 0)->plaintext,
		    		'img' => $toped->find('[data-testid="PDPImageMain"] img', 0)->getAttribute('src'),
					'buy' => $buy ?? 'unavailable',
					'price' => stripPrice($toped->find('.price', 0)->plaintext),
					'slug' => $slug,
		    	];
	    	}
		} catch (Exception $e) {
		}
    }

    function stripPrice($price) {
    	return str_replace(['.', ' ', 'rp'], '', strtolower($price));
    }

    function dd($obj) {
    	echo '<pre>', var_dump($obj);die();
    }
?>

<?php if (count($results) > 0) { ?>
	<?php foreach ($results as $key => $row): array_map('htmlentities', $row); ?>
		<tr>
			<td style="white-space: nowrap;"><?= $page.'-'.($key+1) ?></td>
			<td><img height="150" src="<?= $row['img'] ?>"></td>
			<td><?= $row['stock'] ?></td>
			<td><?= $row['buy'] ?></td>
			<td><?= $row['price'] ?></td>
			<td><?= $row['slug'] ?></td>
			<td> <a target="_blank" href="<?= $row['link'] ?>">GO</a></td>	
		</tr>
	<?php endforeach; ?>
<?php } else { return false;} ?>