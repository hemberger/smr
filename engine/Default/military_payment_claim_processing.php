<?php

$payment = $player->getMilitaryPayment();
$player->increaseHOF($payment, array('Military Payment','Money','Claimed'), HOF_PUBLIC);

// add to our cash
$player->increaseCredits($payment);
$player->setMilitaryPayment(0);
$player->update();

$container = create_container('skeleton.php', 'military_payment_claim.php');
$container['payment'] = $payment;
forward($container);
