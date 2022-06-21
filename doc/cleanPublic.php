<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

echo "Clean the content of documentation in public API\n";

$inputFileName = realpath(dirname(__FILE__)).'/public/api_data.js';
$outputFileName = $inputFileName;

$inputFileContent = file_get_contents($inputFileName);
$inputFileContent = substr($inputFileContent, 7, strlen($inputFileContent) - 10);

$data = json_decode($inputFileContent, TRUE);
$data = $data['api'];

echo 'compte : '.count($data)."\n";
foreach ($data as $id => $item) {
	if (array_key_exists('permission', $item)) {
		$permission = $item['permission'][0]['name'];
		if ($permission == 'private' || $permission == 'admin') {
			unset($data[$id]);
		}
	}
}

$outputFileContent = 'define({ "api": '.json_encode($data).' });';
file_put_contents($outputFileName, $outputFileContent);
