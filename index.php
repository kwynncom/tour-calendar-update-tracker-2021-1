<?php

require_once('/opt/kwynn/kwcod.php');
require_once('get.php');
require_once('/opt/kwynn/email.php');

doit();
function doit() {
    if (isAWS() && time() > strtotime('2020-09-08 02:00')) sleep(random_int(0, 5400));
    $r = dci_2021_1::get();
    if ($r['is21']) {
	$sub  = 'DCI schedule change!';
	$body = 'is21 = true';
    } else if (date('D') === 'Mon') {
	$sub  = 'schedule ping';
	$body = print_r($r, 1);
	$len  = strlen($body);
	kwas($len < 2000, 'res / body too big - 1116pm');
    }

    if (isset($sub)) {
	$eret = kwynn_email::send($sub, $body, false);
    }
}
