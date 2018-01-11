<?php
$template->assign('PageTopic','Dump Cargo');

require_once(LIB . 'Default/SmrTradeGood.class.inc');

$db->query('SELECT * FROM ship_has_cargo JOIN good USING(good_id)
			WHERE account_id = ' . $db->escapeNumber($player->getAccountID()) . '
				AND game_id = ' . $db->escapeNumber($player->getGameID()));

if ($db->getNumRows()) {

	$goods = array();
	while ($db->nextRecord()) {
		$container = create_container('cargo_dump_processing.php');
		$container['good_id'] = $db->getInt('good_id');

		$goods[] = array(
			'image' => SmrTradeGood::getGood($db->getInt('good_id'))->imageLink,
			'name' => $db->getField('good_name'),
			'amount' => $db->getInt('amount'),
			'dump_href' => SmrSession::getNewHREF($container),
		);
	}

	$template->assign('Goods', $goods);
}

?>
