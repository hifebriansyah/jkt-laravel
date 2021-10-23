<?php 
	header('Content-type: application/json');
	include 'simple_html_dom.php';
	include 'helper.php';

	$config = include 'config.php';

	$html = file_get_html($_GET['page']);
	//$view = $html->find('#zeus-root', 0); die($view);

	$src = $html->find('[data-testid="PDPImageMain"] img', 0)->getAttribute('src');

	$result = [
		'stock' => $html->find('[data-testid="stock-label"] > b', 0)->plaintext,
		'img' => '<img loading="lazy" height="150" src='.$src.'>',
	];

	echo json_encode($result);
?>