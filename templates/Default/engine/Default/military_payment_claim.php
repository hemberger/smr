<?php
if (isset($Payment)) { ?>
	<p>For your military activity, you have been paid <span class="creds"><?php echo number_format($payment); ?></span> credits.<?php
} elseif ($ThisPlayer->hasMilitaryPayment()) { ?>
	<p>You are eligible to claim <span class="creds"><?php echo number_format($ThisPlayer->getMilitaryPayment()); ?></span> credits for your military activity.</p>
	<div class="buttonA">
		<a class="buttonA" href="<?php echo $ClaimHREF; ?>">Claim Payment</a>
	</div><?php
} else { ?>
	<p>You have done nothing worthy of military payment.</p><?php
}
