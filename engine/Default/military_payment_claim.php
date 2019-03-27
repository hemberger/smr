<?php

if (!$sector->hasHQ()) {
	throw new Exception('There is no HQ in this sector!');
}

$template->assign('PageTopic', 'Military Payment Center');
require_once(get_file_loc('menu_hq.inc'));
create_hq_menu();

if (isset($var['payment'])) {
	$template->assign('Payment', $var['payment']);
} elseif ($player->hasMilitaryPayment()) {
	$container = create_container('military_payment_claim_processing.php');
	$template->assign('ClaimHREF', SmrSession::getNewHREF($container));
}
