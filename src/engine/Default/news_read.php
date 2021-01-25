<?php declare(strict_types=1);
if (!isset($var['GameID'])) {
	SmrSession::updateVar('GameID', $player->getGameID());
}
$gameID = $var['GameID'];

$min_news = Request::getInt('min_news', 1);
$max_news = Request::getInt('max_news', 50);
if ($min_news > $max_news) {
	create_error('The first number must be lower than the second number!');
}
$template->assign('MinNews', $min_news);
$template->assign('MaxNews', $max_news);

$template->assign('PageTopic', 'Reading The News');

Menu::news($template);

require_once(get_file_loc('news.inc.php'));
doBreakingNewsAssign($gameID, $template);
doLottoNewsAssign($gameID, $template);

$template->assign('ViewNewsFormHref', SmrSession::getNewHREF(create_container('skeleton.php', 'news_read.php', array('GameID'=>$var['GameID']))));

$db->query('SELECT * FROM news WHERE game_id = ' . $db->escapeNumber($gameID) . ' AND type != \'lotto\' ORDER BY news_id DESC LIMIT ' . ($min_news - 1) . ', ' . ($max_news - $min_news + 1));
$template->assign('NewsItems', getNewsItems($db));
