<?
// include helper funtions
require_once(get_file_loc('Plotter.class.inc'));

if (isset($var['from'])) $start = $var['from'];
else $start = $_POST['from'];
if (isset($var['to'])) $target = $var['to'];
else $target = $_POST['to'];

// perform some basic checks on both numbers
if (empty($start) || empty($target))
	create_error('Where do you want to go today?');

if (!is_numeric($start) || !is_numeric($target))
	create_error('Please enter only numbers!');

if ($start == $target)
	create_error('Hmmmm...if ' . $start . '=' . $target . ' then that means...YOUR ALREADY THERE! *cough*your real smart*cough*');

$account->log(5, 'Player plots to '.$target.'.', $player->getSectorID());

$container = array();
$container['url'] = 'skeleton.php';
$container['body'] = 'course_plot_result.php';

$path =& Plotter::findDistanceToX(SmrSector::getSector($player->getGameID(),$target), SmrSector::getSector($player->getGameID(),$start), true);
if($path===false)
	create_error('Unable to plot from '.$start.' to '.$target.'.');
$container['Distance'] = serialize($path);

forward($container);

?>
