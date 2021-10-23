<?php

function stripPrice($price) {
	return str_replace(['.', ' ', 'rp'], '', strtolower($price));
}

function dd($obj) {
	echo '<pre>', var_dump($obj);die();
}