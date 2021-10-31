<?php 
	header('Content-type: application/json');

	include 'simple_html_dom.php';

	$config = include 'config.php';

	$html = file_get_html($_GET['page']);

	$detailBox = str_ireplace(['fitur', 'features'], '<br/><br/>Fitur:<br/>', $html->find('.boxContent.mce', 0)->plaintext);
	$detailBox = str_ireplace(['kelengkapan', 'package contents', 'package content', 'Product content'], '<br/><br/>Kelengkapan:<br/>', $detailBox);
	$images = $html->find('.detailGallery a');
	$weight = $html->find('.detailInfo dd', 1)->plaintext;
	$warantly = $html->find('.detailInfo dd', 2)->plaintext;

	
	$srcs = [];

	foreach ($images as $key => $image) {
		$srcs[] = '<img loading="lazy" src='.$image->getAttribute('href').'>';
		if($key === 4) break;
	}

	$result = [
		'srcs' => $srcs,
		'detail' => $detailBox,
		'weight' => $weight,
		'warantly' => $warantly,
	];

	echo json_encode($result);
?>