<?php 
	//ini_set('display_errors', 0);
	//ini_set('default_socket_timeout', 5);
	include 'simple_html_dom.php';
	include 'helper.php';

	$config = include 'config.php';

	$page = $_GET['page'] ?? 1;

	$store = $_GET['store'] ?? 'hifebriansyah';

	$url = "https://www.tokopedia.com/".$store."/product/page/".$page."?perpage=10";

    $results = [];

	$html = file_get_html($url);

	//echo $html->find('#zeus-root', 0);die();

	for ($i=0; $i < 100 ; $i++) { 
		if(strlen($html->plaintext) < 500) {
			$html = file_get_html($url);
		} else {
			break;
		}
	}
	
	if(!$html->find('[data-testid="btnShopProductPageNext"]', 0) && !$html->find('[data-testid="btnShopProductPagePrevious"]', 0)) {
		return 0;
	};

	$products = $html->find('[data-testid="master-product-card"]');

    foreach ($products as $key => $product) {
		try {
	    	$link = $product->find('a', 0)->getAttribute('href');
	    	$links = explode('/', $link);
	    	$slug = $links[count($links) - 1];

	    	$results[] = [
	    		'link' => $link,
				'price' => stripPrice($product->find('[data-testid="linkProductPrice"]', 0)->plaintext),
				'name' => $product->find('[data-testid="linkProductName"]', 0)->plaintext,
				'slug' => $slug,
				'tries' => $i,
	    	];
		} catch (Exception $e) {
		}
    }
?>

<?php if (count($results) > 0) { ?>
	<?php foreach ($results as $key => $row): array_map('htmlentities', $row); ?>
		<tr class="need-detail" data-page="<?= $row['link'] ?>" data-price="<?= $row['price'] ?>" data-name="<?= $row['name'] ?>" data-link="<?= $row['link'] ?>"  data-slug="<?= $row['slug'] ?>">
			<td class="no" style="white-space: nowrap;"><?= $page.'-'.($key+1) ?></td>
			<td class="toped-img">...</td>
			<td class="toped-stock">...</td>
			<td class="agent-buy">...</td>
			<td class="toped-sell"><?= number_format($row['price'], 0, ',', '.') ?></td>
			<td class="margin">...</td>
			<td>'<?= $row['slug'] ?>' =><br/>'<span class="agent-slug"></span>',</td>
			<td> <a target="_blank" href="<?= $row['link'] ?>">GO</a></td>	
		</tr>
	<?php endforeach; ?>
<?php } else { return false;} ?>