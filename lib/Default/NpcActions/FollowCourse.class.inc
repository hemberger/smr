<?php

			else if ($player->hasPlottedCourse() === true && $player->getPlottedCourse()->getEndSector()->offersFederalProtection()) { //We have a route to fed to follow, figure it's probably a damned sensible thing to follow.
				debug('Follow Course: ' . $player->getPlottedCourse()->getNextOnPath());
				processContainer(moveToSector($player, $player->getPlottedCourse()->getNextOnPath()));
			}
