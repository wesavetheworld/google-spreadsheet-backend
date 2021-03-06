<?php

	# This index page is purely for demonstation purposes.
	require_once 'GetSpreadsheetData.class.php';

	$spreadsheetId = "1B40WXBz1d3zkR5-ZFieKiannA-WGScUEf3MANYI0jo0";
	$GetSpreadsheetData = new GetSpreadsheetData($spreadsheetId);

	$i = 0;
	$lang = "en";
	$results = [];

	if(!$data = $GetSpreadsheetData->returnData()) {
		die();
	}

	foreach($data as $row) {
		$currentRow = array();

		// Build each result / row out
		foreach ($row as $key => $value) {

			$dontWant = ['id', 'updated', 'category', 'title', 'content', 'link'];
			if (in_array($key, $dontWant)) {
				continue;
			}

			if ( strpos($key, 'gsx$') !== -1 ) {
				$cleanLabel = str_replace('gsx$', '', $key);
				// $cleanLabel = $key;
				$currentRow[$cleanLabel] = $value->{'$t'};
			}

		}

		array_push($results, $currentRow);
	}

	// Must check...
	try {
		$jsonData = json_encode($results);
	} catch (Exception $e) {
		print_r($e);
	}

	print_r( $jsonData );
?>