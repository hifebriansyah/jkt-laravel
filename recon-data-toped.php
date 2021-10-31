<?php 
	ini_set('default_socket_timeout', 5);
	header('Content-type: application/json');
	include 'simple_html_dom.php';
	include 'helper.php';

	$config = include 'config.php';
	$url = $_GET['page'];

	$html = file_get_html($url);

	for ($i=0; $i < 100 ; $i++) { 
		if(strlen($html->plaintext) < 500) {
			$html = file_get_html($url);
		} else {
			break;
		}
	}

	$src = $html->find('[data-testid="PDPImageMain"] img', 0)->getAttribute('src');
	$slug = trim(explode(PHP_EOL, $html->find('[data-testid="lblPDPDescriptionProduk"]', 0)->plaintext)[0]);

	$result = [
		'stock' => $html->find('[data-testid="stock-label"] > b', 0)->plaintext,
		'img' => '<img loading="lazy" height="150" src='.$src.'>',
		'tries' => $i,
		'slug' => substr_count($slug, '-') >= 3 && !substr_count($slug, ' ') ? $slug : '...',
	];

	echo json_encode($result);
?>