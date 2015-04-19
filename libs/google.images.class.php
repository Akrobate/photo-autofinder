<?

class GoogleImages {

	public static $mode;
	public static $url;


	public static function getResultsUntil($query, $nbrmax = 20) {
		
		$start = 0;
		$url = "http://ajax.googleapis.com/ajax/services/search/images?v=1.0&start=" . $start. "&q=" .urlencode($query);
		$r = self::getGoogleArray($url);
		$results_count = $r->responseData->cursor->resultCount;
		
		$results_count = str_replace(",","", $results_count);


		$data = $r->responseData->results;

		if ($nbrmax > $results_count) {
			$nbrmax = $results_count;
		}
		
		$start += 4;
		
		while ($start < $nbrmax) {
		
			$url = "http://ajax.googleapis.com/ajax/services/search/images?v=1.0&start=" . $start. "&q=" .urlencode($query);
			$r = self::getGoogleArray($url);
			$start += 4;
			$data = array_merge($data, $r->responseData->results);
		}
		
		
		
		return $data;
	
	}




	public static function getGoogleArray($query) {
		
		return json_decode(self::getGoogleResponse($query));
	
	}




	public static function getGoogleResponse($query) {
	
		
		// Mecanique de gestion d'un minicache pour economiser les requettes google
		$filecachename =  md5($query);

		if (file_exists(CACHE . $filecachename)) {
			$resp = file_get_contents(CACHE . $filecachename);
			self::$mode = 'cache';
		} else {
			$resp = file_get_contents($query);
			file_put_contents(CACHE . $filecachename, $resp);
			self::$mode = 'live';
		}
	
		return $resp;
	
	}
	
	public static function queryArrayToResultArrayWithCache($qarray, $nrb_results_max = 20) {
	
		// Mecanique de gestion d'un minicache pour economiser du calcul global
		$filecachename =  "hn_" . md5(json_encode($qarray));

		if (file_exists(CACHE . $filecachename)) {
			$resp = file_get_contents(CACHE . $filecachename);
			$resp = json_decode($resp);
		} else {
			$resp = self::queryArrayToResultArray($qarray, $nrb_results_max);
			$resp2s = json_encode($resp);
			file_put_contents(CACHE . $filecachename, $resp2s);
		}
		return $resp;
	}


	public static function queryArrayToResultArray($qarray, $nrb_results_max = 20) {
		
		foreach($qarray as &$item) {
			$item['results'] = self::getResultsUntil($item['query'], $nrb_results_max);
			$pnd = $item['ponderation'];
			$allcount = count($item['results']);
			foreach ($item['results'] as $key => &$itm) {
				$itm->weight =  (($allcount - $key) / $allcount) * $pnd;
			}
		}
		
		foreach($qarray as $item) {
			foreach ($item['results'] as $key => $itm) {
				$itm->weight;
		
				if (isset($globalarr[ $itm->imageId ])) {
					$globalarr[ $itm->imageId ]->weight += $itm->weight;
				} else {
					$globalarr[ $itm->imageId ] = $itm;		
				} 
			}
		}
		
		$order = array();

		foreach($globalarr as $key => $itm) {
			$order[$key] = $itm->weight;
		}

		uasort($order, 'cmp');

		$data2 = array();
		foreach ($order as $key => $w) {
			$data2[] = $globalarr[$key];
		}

		return $data2;	
	}

}



function cmp($a, $b) {
    if ($a == $b) {
        return 0;
    }
    return ($a < $b) ? 1 : -1;
}
