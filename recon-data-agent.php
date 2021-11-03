<?php 
	ini_set('display_errors', 0);
	header('Content-type: application/json');
	include 'simple_html_dom.php';
	include 'helper.php';
	$db = include 'db.php';

	$config = include 'config.php';

	$links = explode('/', $_GET['page']);
	$slug = $links[count($links) - 1];
	$buy = '...';

	if(isset($db[$slug])) {
		$html = file_get_html('https://www.jakartanotebook.com/'.$db[$slug]);
	} else {
		$html = file_get_html('https://www.jakartanotebook.com/'.$slug);
	}

	if($html && $html->find('.price-final > span', 0)) {
		$buy = stripPrice($html->find('.price-final > span', 0)->plaintext);
		$buy = $buy + (ceil($buy * $config['asuransi'] / 100) * 100) + (ceil($buy * $config['jasaToped'] / 100) * 100)  + $config['jasaSuplier'];
	}

	$margin = $_GET['price'] - $buy;

	$result = [
		'buy' => number_format($buy, 0, ',', '.') ?? '...',
		'margin' => '<span class="'.($margin <= 0 ? 'red' : 'green').'">'.number_format($margin, 0, ',', '.').'</span>',
		'avail' => $html->find('[data-stock]', 0)->getAttribute('data-stock') + 0
	];

	echo json_encode($result);
?>