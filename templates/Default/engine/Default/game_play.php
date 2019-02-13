<?php
if(isset($ErrorMessage)) {
	echo $ErrorMessage; ?><br /><br /><?php
}
if(isset($Message)) {
	echo $Message; ?><br /><br /><?php
} ?>

<style>
#categories{
  overflow:hidden;
  width:90%;
  margin:0 auto;
}
.clr:after{
  content:"";
  display:block;
  clear:both;
}
#categories li{
  position:relative;
  list-style-type:none;
  width:27.85714285714286%; /* = (100-2.5) / 3.5 */
  padding-bottom: 32.16760145166612%; /* =  width /0.866 */
  float:left;
  overflow:hidden;
  visibility:hidden;
 
  -webkit-transform: rotate(-60deg) skewY(30deg);
  -ms-transform: rotate(-60deg) skewY(30deg);
  transform: rotate(-60deg) skewY(30deg);
}
#categories li:nth-child(3n+2){
  margin:0 1%;
}
#categories li:nth-child(6n+4){
  margin-left:0.5%;
}
#categories li:nth-child(6n+4), #categories li:nth-child(6n+5), #categories li:nth-child(6n+6) {
	margin-top: -6.9285714285%;
  margin-bottom: -6.9285714285%;
  
  -webkit-transform: translateX(50%) rotate(-60deg) skewY(30deg);
  -ms-transform: translateX(50%) rotate(-60deg) skewY(30deg);
  transform: translateX(50%) rotate(-60deg) skewY(30deg);
}
#categories li:nth-child(6n+4):last-child, #categories li:nth-child(6n+5):last-child, #categories li:nth-child(6n+6):last-child{
  margin-bottom:0%;
}
#categories li *{
  position:absolute;
  visibility:visible;
}
#categories li > div{
  width:100%;
  height:100%;
  text-align:center;
  color:#fff;
  overflow:hidden;
  
  -webkit-transform: skewY(-30deg) rotate(60deg);
  -ms-transform: skewY(-30deg) rotate(60deg);
  transform: skewY(-30deg) rotate(60deg);
  
	-webkit-backface-visibility:hidden;
  
}

/* HEX CONTENT */
#categories li img{
  left:-100%; right:-100%;
  width: auto; height:100%;
  margin:0 auto;   
}

#categories div h1, #categories div p{
  width:90%;
  padding:0 5%;
  background-color:#008080; background-color: rgba(0, 128, 128, 0.8);
  font-family: 'Raleway', sans-serif;
  
  -webkit-transition: top .2s ease-out, bottom .2s ease-out, .2s padding .2s ease-out;
  -ms-transition: top .2s ease-out, bottom .2s ease-out, .2s padding .2s ease-out;
  transition: top .2s ease-out, bottom .2s ease-out, .2s padding .2s ease-out;
}
#categories li h1{
  bottom:110%;
  font-style:italic;
  font-weight:normal;
  font-size:1.5em;
  padding-top:100%;
  padding-bottom:100%;
}
#categories li h1:after{
	content:'';
  display:block;
  position:absolute;
  bottom:-1px; left:45%;
  width:10%;
  text-align:center;
  z-index:1;
  border-bottom:2px solid #fff;
}
#categories li p{
	padding-top:50%;
	top:110%;
	padding-bottom:50%;
}


/* HOVER EFFECT  */

#categories li div:hover h1 {
  bottom:50%;
  padding-bottom:10%;
}

#categories li div:hover p{
  top:50%;
  padding-top:10%;
}

img {
  width: 280px;
  height: 280px;
  object-fit: cover;
}
</style>

<img width="180px" height="180px" src="images/race/race5.jpg" />

<ul id="categories" class="clr">
<li class="pusher"></li>
<?php
foreach (Globals::getRaces() as $race) { ?>
	<li>
	<div>
		<h1>TEST</h1>
		<img width="280px" height="280px" src="<?php echo $race['ImageLink']; ?>" />
	</div>
	</li>
<?php
} ?>

<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
width='1300px' height='800px' viewBox='0 0 1300 800'>
<defs>
<polygon id="hx" points="15,-26 30,0 15,26 -15,26 -30,0 -15,-26"/>
<style> text { text-anchor: middle; } </style> 
</defs>
<g id="demo">
<clipPath id="race6">
	<path fill="#FFFFFF" stroke="#231F20" d="M127.9,458.6L5.5,246.7l122.4-212h244.8l122.4,212l-122.4,212 H127.9z" transform="translate(200, 0)"></path>
</clipPath>
<use xlink:href="#hx" x="35" y="35" style="fill: #f00"/>
<use xlink:href="#hx" x="165" y="35" style="fill: #0f0"/>
<use xlink:href="#hx" x="800" y="665" style="fill: #00f"/>
<image width="500" height="500" clip-path="url(#race6)" id="luna" xlink:href="images/race/head/race6.jpg" x="200" y="0"></image>
<text x="35" y="40">RED</text> 
<text x="165" y="40">GREEN</text> 
<text x="100" y="70">BLUE</text> 
</g>
</svg>

<a href="<?php echo $ThisAccount->getUserRankingHREF(); ?>"><b class="yellow">Rankings</b></a>
<br />You are ranked as <?php $this->doAn($ThisAccount->getRankName()); ?> <span style="font-size:125%;color:greenyellow;"><?php echo $UserRankName ?></span> player.<br /><br />

<div id="playGames" class="ajax"><?php
	if(isset($Games['Play'])) { ?>
		<table class="standard">
			<tr>
				<th>&nbsp;</th>
				<th>Game Name</th>
				<th>Turns</th>
				<th>Playing</th>
				<th>Last Movement</th>
				<th>End Date</th>
				<th>Game Type</th>
				<th>Game Speed</th>
			</tr><?php
			foreach($Games['Play'] as $Game) { ?>
				<tr>
					<td>
						<div class="buttonA">
							<a id="game_play_<?php echo $Game['ID']; ?>" class="buttonA" href="<?php echo $Game['PlayGameLink']; ?>">Play Game</a>
						</div>
					</td>
					<td width="35%"><a href="<?php echo $Game['GameStatsLink']; ?>"><?php echo $Game['Name']; ?> (<?php echo $Game['ID']; ?>)</a></td>

					<td class="center"><?php echo $Game['Turns']; ?></td>
					<td class="center"><?php echo $Game['NumberPlaying']; ?></td>
					<td><?php echo $Game['LastMovement']; ?></td>
					<td class="noWrap"><?php echo $Game['EndDate']; ?></td>
					<td class="center"><?php echo $Game['Type']; ?></td>
					<td class="center"><?php echo $Game['Speed']; ?></td>
				</tr><?php
			} ?>
		</table><br />
		<br /><?php
	} ?>
</div>
		
<h1><a href="<?php echo $VotingHref; ?>">Voting</a></h1><?php
if (isset($Voting)) {
	?>Please take a couple of seconds to answer the following question(s) for the SMR Admin team. Thanks!<?php
	foreach($Voting as $Vote) {
		?><br /><br />
		<form name="FORM" method="POST" action="<?php echo $Vote['HREF'] ?>">
			<span class="bold"><?php echo bbifyMessage($Vote['Question']); ?></span> (<?php echo $Vote['TimeRemaining']; ?> Remaining)<br /><?php
			foreach($Vote['Options'] as $VoteOption) { ?>
				<input type="radio" name="vote" value="<?php echo $VoteOption['ID']; ?>"<?php if($VoteOption['Chosen']) { ?> checked<?php } ?>><?php echo bbifyMessage($VoteOption['Text']); ?> (<?php echo $VoteOption['Votes']; ?> votes)<br /><?php
			} ?>
			<input type="submit" name="submit" value="Vote!"><br /><br />
		</form><?php
	}
} ?><br />
<h1>Join Game</h1>
<div id="joinGames" class="ajax"><?php
	if(isset($Games['Join'])) { ?>
		<table class="standard">
			<tr>
				<th>&nbsp;</th>
				<th width="150">Game Name</th>
				<th>Start Date</th>
				<th>End Date</th>
				<th>Players</th>
				<th>Type</th>
				<th>Game Speed</th>
				<th>Credits Needed</th>
			</tr><?php
			foreach($Games['Join'] as $Game) { ?>
				<tr>
					<td>
						<div class="buttonA"><a id="game_join_<?php echo $Game['ID']; ?>" class="buttonA" href="<?php echo $Game['JoinGameLink']; ?>"><?php if(TIME < $Game['StartDate']) {?>View Info<?php }else{ ?>Join Game<?php } ?></a></div>
					</td>
					<td width="35%"><?php echo $Game['Name']; ?> (<?php echo $Game['ID']; ?>)</td>
					<td class="noWrap"><?php echo $Game['StartDate']; ?></td>
					<td class="noWrap"><?php echo $Game['EndDate']; ?></td>
					<td class="center"><?php echo $Game['Players']; ?></td>
					<td class="center"><?php echo $Game['Type']; ?></td>
					<td class="center"><?php echo $Game['Speed']; ?></td>
					<td class="center"><?php echo $Game['Credits']; ?></td>
				</tr>
			<?php } ?>
		</table><?php
	}
	else {
		?><p>You have joined all open games.</p><?php
	} ?>
</div>
<br />
<br />
<h1>Donate Money</h1>
<p>
	<a href="<?php echo $DonateLink; ?>"><img src="images/donation.png" border="0" alt="donate" /></a>
</p>
<br />
<h1><a href="<?php echo $OldAnnouncementsLink; ?>">View Old Announcements</a></h1>
<br />
<br />

<h1>Previous Games</h1>
<a onclick="$('#prevGames').slideToggle(600);">Show/Hide</a>
<div id="prevGames" class="ajax" style="display:none;"><?php
	if(isset($Games['Previous'])) { ?>
		<table class="standard">
			<tr>
				<th width="150">Game Name</th>
				<th>Start Date</th>
				<th>End Date</th>
				<th>Game Speed</th>
				<th colspan="3">Options</th>
			</tr><?php
			foreach($Games['Previous'] as $Game) { ?>
				<tr>
					<td width="35%"><?php if(isset($Game['PreviousGameLink'])){ ?><a href="<?php echo $Game['PreviousGameLink']; ?>"><?php } echo $Game['Name']; ?> (<?php echo $Game['ID']; ?>)<?php if(isset($Game['PreviousGameLink'])){ ?></a><?php } ?></td>
					<td><?php echo $Game['StartDate'] ?></td>
					<td><?php echo $Game['EndDate'] ?></td>
					<td class="center"><?php echo $Game['Speed'] ?></td>
					<td class="center"><a href="<?php echo $Game['PreviousGameHOFLink']; ?>">Hall Of Fame</a></td>
					<td class="center"><a href="<?php echo $Game['PreviousGameNewsLink']; ?>">Game News</a></td>
					<td class="center"><?php if(isset($Game['PreviousGameStatsLink'])){ ?><a href="<?php echo $Game['PreviousGameStatsLink']; ?>">Game Stats</a><?php } ?></td>
				</tr>
			<?php } ?>
		</table><?php
	}
	else {
		?><p>There are no previous games.</p><?php
	} ?>
</div>
