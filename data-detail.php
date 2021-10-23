<?php 
	//ini_set('display_errors', 0);
	header('Content-type: application/json');

	include 'simple_html_dom.php';

	$config = include 'config.php';

	$html = file_get_html($_GET['page']);

	$detailBox = str_replace('.', '.<br/><br/>', $html->find('.boxContent.mce', 0)->plaintext);
	$images = $html->find('.detailGallery img');
	$srcs = [];

	foreach ($images as $key => $image) {
		$srcs[] = '<img loading="lazy" src='.$image->getAttribute('src').'>';
		if($key === 4) break;
	}

	$result = [
		'srcs' => $srcs,
		'detail' => $detailBox,
	];

	echo json_encode($result);
?>