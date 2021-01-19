<?php

			else if ($player->getShip()->isUnderAttack() === true
				&&($player->hasPlottedCourse() === false || $player->getPlottedCourse()->getEndSector()->offersFederalProtection() === false)
				&&($fedContainer == null ? $fedContainer = plotToFed($player, true) : $fedContainer) !== true) { //We're under attack and need to plot course to fed.
				// Get the lock, remove under attack and update.
				acquire_lock($player->getSectorID());
				$ship = $player->getShip(true);
				$ship->removeUnderAttack();
				$ship->updateHardware();
				release_lock();

				debug('Under Attack');
				$underAttack = true;
				processContainer($fedContainer);
			}
