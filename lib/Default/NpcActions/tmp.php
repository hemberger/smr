<?php declare(strict_types=1);
				NpcActions\BuyShip => [],
				NpcActions\UnderAttack => [],
				NpcActions\FollowCourse => ['fed_only' => true],
				NpcActions\DoUNO => ['allow_plot' => false],
				NpcActions\FollowCouse => [],
				NpcActions\PlotToFed => [],
				NpcActions\PlotToShipShop => [],
				NpcActions\PlotToUNO => [],
				NpcActions\TradeRoute => [],
				NpcActions\Fallback => [],

			$fedContainer = null;
			if ($var['url'] == 'shop_ship_processing.php' && ($fedContainer = plotToFed($player, true)) !== true) { //We just bought a ship, we should head back to our trade gal/uno - we use HQ for now as it's both in our gal and a UNO, plus it's safe which is always a bonus
				processContainer($fedContainer);
			}

			else if (($container = canWeUNO($player, true)) !== false) { //We have money and are at a uno, let's uno!
				debug('We\'re UNOing');
				processContainer($container);
			}

			else if ($player->hasPlottedCourse() === true) { //We have a route to follow, figure it's probably a sensible thing to follow.
				debug('Follow Course: ' . $player->getPlottedCourse()->getNextOnPath());
				processContainer(moveToSector($player, $player->getPlottedCourse()->getNextOnPath()));
			}

			else if ($player->getTurns() < NPC_LOW_TURNS || ($player->getTurns() < $player->getMaxTurns() / 2 && $player->getNewbieTurns() < NPC_LOW_NEWBIE_TURNS) || $underAttack) { //We're low on turns or have been under attack and need to plot course to fed
				if ($player->getTurns() < NPC_LOW_TURNS) {
					debug('Low Turns:' . $player->getTurns());
				}
				if ($underAttack) {
					debug('Fedding after attack.');
				}
				if ($player->hasNewbieTurns()) { //We have newbie turns, we can just wait here.
					debug('We have newbie turns, let\'s just switch to another NPC.');
					changeNPCLogin();
				}
				if ($player->hasFederalProtection()) {
					debug('We are in fed, time to switch to another NPC.');
					changeNPCLogin();
				}
				$ship = $player->getShip();
				processContainer(plotToFed($player, !$ship->hasMaxShields() || !$ship->hasMaxArmour() || !$ship->hasMaxCargoHolds()));
			}

			else if (($container = checkForShipUpgrade($player)) !== false) { //We have money and are at a uno, let's uno!
				debug('We\'re reshipping!');
				processContainer($container);
			}

			else if (($container = canWeUNO($player, false)) !== false) { //We need to UNO and have enough money to do it properly so let's do it sooner rather than later.
				debug('We need to UNO, so off we go!');
				processContainer($container);
			}

			else if ($TRADE_ROUTE instanceof Route) {
				debug('Trade Route');
				$forwardRoute =& $TRADE_ROUTE->getForwardRoute();
				$returnRoute =& $TRADE_ROUTE->getReturnRoute();
				if ($forwardRoute->getBuySectorId() == $player->getSectorID() || $returnRoute->getBuySectorId() == $player->getSectorID()) {
					if ($forwardRoute->getBuySectorId() == $player->getSectorID()) {
						$buyRoute =& $forwardRoute;
						$sellRoute =& $returnRoute;
					}
					else if ($returnRoute->getBuySectorId() == $player->getSectorID()) {
						$buyRoute =& $returnRoute;
						$sellRoute =& $forwardRoute;
					}

					$ship = $player->getShip();
					if ($ship->getUsedHolds() > 0) {
						if ($ship->hasCargo($sellRoute->getGoodID())) { //Sell goods
							$goodID = $sellRoute->getGoodID();

							$port = $player->getSector()->getPort();
							$tradeable = checkPortTradeable($port, $player);

							if ($tradeable === true && $port->getGoodAmount($goodID) >= $ship->getCargo($sellRoute->getGoodID())) { //TODO: Sell what we can rather than forcing sell all at once?
								//Sell goods
								debug('Sell Goods');
								processContainer(tradeGoods($goodID, $player, $port));
							}
							else {
								//Move to next route or fed.
								if (($TRADE_ROUTE =& changeRoute($TRADE_ROUTES)) === false) {
									debug('Changing Route Failed');
									processContainer(plotToFed($player));
								}
								else {
									debug('Route Changed');
									continue;
								}
							}
						}
						else if ($ship->hasCargo($buyRoute->getGoodID()) === true) { //We've bought goods, plot to sell
							debug('Plot To Sell: ' . $buyRoute->getSellSectorId());
							processContainer(plotToSector($player, $buyRoute->getSellSectorId()));
						}
						else {
							//Dump goods
							debug('Dump Goods');
							processContainer(dumpCargo($player));
						}
					}
					else { //Buy goods
						$goodID = $buyRoute->getGoodID();

						$port = $player->getSector()->getPort();
						$tradeable = checkPortTradeable($port, $player);

						if ($tradeable === true && $port->getGoodAmount($goodID) >= $ship->getEmptyHolds()) { //Buy goods
							debug('Buy Goods');
							processContainer(tradeGoods($goodID, $player, $port));
						}
						else {
							//Move to next route or fed.
							if (($TRADE_ROUTE =& changeRoute($TRADE_ROUTES)) === false) {
								debug('Changing Route Failed');
								processContainer(plotToFed($player));
							}
							else {
								debug('Route Changed');
								continue;
							}
						}
					}
				}
				else {
					debug('Plot To Buy: ' . $forwardRoute->getBuySectorId());
					processContainer(plotToSector($player, $forwardRoute->getBuySectorId()));
				}
			}
			else { //Something weird is going on.. Let's fed and wait.
				debug('No actual action? Wtf?');
				processContainer(plotToFed($player));
			}
			/*
			else { //Otherwise let's run around at random.
				$links = $player->getSector()->getLinks();
				$moveTo = $links[array_rand($links)];
				debug('Random Wanderings: '.$moveTo);
				processContainer(moveToSector($player,$moveTo));
			}
			*/
