<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.hotkeys.js"></script>
<script type="text/javascript" src="js/ajax.js"></script><?php
if(!empty($js))
{
	?><script type="text/javascript" src="<?php echo $js; ?>"></script><?php
}
if($AJAX_ENABLE_REFRESH)
{
	$AvailableLinks = Globals::getAvailableLinks();
	?><script type="text/javascript">$(function(){
		startRefresh('<?php echo $AJAX_ENABLE_REFRESH; ?>');
	})</script><?php
} ?>