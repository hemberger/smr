<?php declare(strict_types=1);

/**
 * 
 */
class SmrBBCode {

	/**
	 * Converts a BBCode tag into some other text depending on the tag and value.
	 * This is called in two stages: first with action BBCODE_CHECK (where the
	 * returned value must be a boolean) and second, if the first check passes,
	 * with action BBCODE_OUTPUT.
	 */
	static function parse($bbParser, $action, $tagName, $default, $tagParams, $tagContent) {
	global $overrideGameID, $disableBBLinks, $player, $account, $var;
		try {
			self::$tagName($default, $tagParams);
		} catch (InvalidSmrBBCode) {
			if ($action === \Nbbc\BBCode::BBCODE_CHECK) {
				return false
			switch ($tagName) {
				case 'combatlog':
				if ($action == \Nbbc\BBCode::BBCODE_CHECK) {
					return is_numeric($default);
				}
				$logID = (int)$default;
				return linkCombatLog($logID);
			break;
			case 'player':
				if ($action == \Nbbc\BBCode::BBCODE_CHECK) {
					return is_numeric($default);
				}
				$playerID = (int)$default;
				$bbPlayer = SmrPlayer::getPlayerByPlayerID($playerID, $overrideGameID);
				$showAlliance = isset($tagParams['showalliance']) ? parseBoolean($tagParams['showalliance']) : false;
				if ($disableBBLinks === false && $overrideGameID == SmrSession::getGameID()) {
					return $bbPlayer->getLinkedDisplayName($showAlliance);
				}
				return $bbPlayer->getDisplayName($showAlliance);
			break;
			case 'alliance':
				if ($action == \Nbbc\BBCode::BBCODE_CHECK) {
					return is_numeric($default);
				}
				$allianceID = (int)$default;
				$alliance = SmrAlliance::getAlliance($allianceID, $overrideGameID);
				if ($disableBBLinks === false && $overrideGameID == SmrSession::getGameID()) {
					$container = create_container('skeleton.php');
					$container['alliance_id'] = $alliance->getAllianceID();
					if (is_object($player) && $alliance->getAllianceID() == $player->getAllianceID()) {
						$container['body'] = 'alliance_mod.php';
					} else {
						$container['body'] = 'alliance_roster.php';
					}
					return create_link($container, $alliance->getAllianceDisplayName());
				}
				return $alliance->getAllianceDisplayName();
			break;
			case 'race':
				$raceNameID = $default;
				foreach (Globals::getRaces() as $raceID => $raceInfo) {
					if ((is_numeric($raceNameID) && $raceNameID == $raceID)
						|| $raceNameID == $raceInfo['Race Name']) {
						if ($action == \Nbbc\BBCode::BBCODE_CHECK) {
							return true;
						}
						$linked = $disableBBLinks === false && $overrideGameID == SmrSession::getGameID();
						return AbstractSmrPlayer::getColouredRaceNameOrDefault($raceID, $player, $linked);
					}
				}
			break;
			case 'servertimetouser':
				if ($action == \Nbbc\BBCode::BBCODE_CHECK) {
					return true;
				}
				$timeString = $default;
				if ($timeString != '' && ($time = strtotime($timeString)) !== false) {
					if (is_object($account)) {
						$time += $account->getOffset() * 3600;
					}
					return date(DATE_FULL_SHORT, $time);
				}
			break;
			case 'chess':
				if ($action == \Nbbc\BBCode::BBCODE_CHECK) {
					return is_numeric($default);
				}
				$chessGameID = (int)$default;
				$chessGame = ChessGame::getChessGame($chessGameID);
				return '<a href="' . $chessGame->getPlayGameHREF() . '">chess game (' . $chessGame->getChessGameID() . ')</a>';
			break;

			case 'sector':
				if ($action == \Nbbc\BBCode::BBCODE_CHECK) {
					return is_numeric($default);
				}

				$sectorID = (int)$default;
				$sectorTag = '<span class="sectorColour">#' . $sectorID . '</span>';

				// The use of $var here is for a corner case where an admin can check reported messages whilst being in-game.
				// Ugly but working, probably want a better mechanism to check if more BBCode tags get added
				if ($disableBBLinks === false
					&& SmrSession::hasGame()
					&& SmrSession::getGameID() == $overrideGameID
					&& SmrSector::sectorExists($overrideGameID, $sectorID)) {
					return '<a href="' . Globals::getPlotCourseHREF($player->getSectorID(), $sectorID) . '">' . $sectorTag . '</a>';
				}

				return $sectorTag;
			break;
			case 'join_alliance':
				if ($action == \Nbbc\BBCode::BBCODE_CHECK) {
					return is_numeric($default);
				}
				$allianceID = (int)$default;
				$alliance = SmrAlliance::getAlliance($allianceID, $overrideGameID);
				$container = create_container('alliance_invite_accept_processing.php');
				$container['alliance_id'] = $alliance->getAllianceID();
				return '<div class="buttonA"><a class="buttonA" href="' . SmrSession::getNewHREF($container) . '">Join ' . $alliance->getAllianceDisplayName() . '</a></div>';
			break;
		}
	} catch (Throwable $e) {
		// If there's an error, we will silently display the original text
	}
	if ($action == \Nbbc\BBCode::BBCODE_CHECK) {
		return false;
	}
	return htmlspecialchars($tagParams['_tag']) . $tagContent . htmlspecialchars($tagParams['_endtag']);
}

