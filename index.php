<?php

require_once('/opt/kwynn/kwutils.php');

dci_2021_1::get();

class dci_2021_1 {
    
    const liveURL   = 'https://www.dci.org/';
    const localTempFilePath = '/tmp/dci_2020_1_1.html';
    
    public static function get() {
	$ret = self::mget();
	self::pop2021Eval($ret);
	return $ret;
    }
  
    private static function mget() {

	if (!isAWS() &&   
	    file_exists(self::localTempFilePath))
	         $url = self::localTempFilePath;
	else     $url = self::liveURL;
	
	$res = file_get_contents($url);

	$b = microtime(1);
	$res  = file_get_contents($url);	
	$e = microtime(1);
	unset($http_response_header);
	$callElapsed = $e - $b;
	
	if ($url ===	     self::localTempFilePath) 
	     $ts = filemtime(self::localTempFilePath);
	else $ts = intval($e); unset($b, $e);
	$len = strlen($res);
	file_put_contents(self::localTempFilePath, $res);
	return get_defined_vars();
    }
    
    private static function pop2021Eval(&$ref) {

	$ht = $ref['res'];
	$d = getDOMO($ht);
	$as = $d->getElementsByTagName('a');
	
	$cnt = 0;
	$is21 = false;
	
	foreach($as as $a) {
	    if (!isset($a->textContent) || 
	        strpos($a->textContent, 'Schedule & Tickets') === false) continue;

	    $cnt++;
	    $href = $a->getAttribute('href');
	    if ($href !== 'https://www.dci.org/news/member-corps-vote-to-cancel-2020-dci-tour') $is21 = true;
	}
	
	$ref['is21']       = $is21;
	$ref['schedLinks'] = $cnt;
    }
}
