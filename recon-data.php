<?php 
	include 'simple_html_dom.php';
	include 'helper.php';

	$config = include 'config.php';

	$page = $_GET['page'] ?? 1;

	$store = $_GET['store'] ?? 'hifebriansyah';

	$url = "https://www.tokopedia.com/".$store."/page/".$page."?perpage=10";

    $results = [];

	$html = file_get_html($url);
	//$view = $html->find('#zeus-root', 0); die($view);

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
				'slug' => $slug,
	    	];
		} catch (Exception $e) {
		}
    }
?>

<?php if (count($results) > 0) { ?>
	<?php foreach ($results as $key => $row): array_map('htmlentities', $row); ?>
		<tr class="need-detail" data-page="<?= $row['link'] ?>">
			<td style="white-space: nowrap;"><?= $page.'-'.($key+1) ?></td>
			<td class="toped-img">...</td>
			<td class="toped-stock">...</td>
			<td class="agent-buy">...</td>
			<td><?= $row['price'] ?></td>
			<td><?= $row['slug'] ?></td>
			<td> <a target="_blank" href="<?= $row['link'] ?>">GO</a></td>	
		</tr>
	<?php endforeach; ?>
<?php } else { return false;} ?>