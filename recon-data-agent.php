<?php 
	header('Content-type: application/json');
	include 'simple_html_dom.php';
	include 'helper.php';
	$db = include 'db.php';

	$config = include 'config.php';

	$links = explode('/', $_GET['page']);
	$slug = $links[count($links) - 1];
	$buy = 'none';

	if(isset($db[$slug])) {
		$html = file_get_html('https://www.jakartanotebook.com/'.$db[$slug]);
		$buy = stripPrice($html->find('.price-final > span', 0)->plaintext);
		$buy = $buy + (ceil($buy * $config['asuransi'] / 100) * 100) + (ceil($buy * $config['jasaToped'] / 100) * 100)  + $config['jasaSuplier'];
	}

	$result = [
		'buy' => $buy,
	];

	echo json_encode($result);
?>