<h2>Exemption Requests</h2><br />
if ($db->getNumRows()) {
	Selecting a box will authorize it, leaving a box unselected will make it unauthorized after you submit.<br />
	<form method="POST" action="<?php echo $ExemptHREF; ?>">
		<table class="standard">
			<tr>
				<th>Player Name</th>
				<th>Type</th>
				<th>Reason</th>
				<th>Amount</th>
				<th>Approve</th>
			</tr><?php
			while ($db->nextRecord()) { ?>
				<tr>
					<td>' . $players[$db->getInt('payee_id')] . '</td>
					<td>' . $trans . '</td>
					<td>' . $db->getField('reason') . '</td>
					<td>' . number_format($db->getInt('amount')) . '</td>
					<td><input type="checkbox" name="exempt[' . $db->getField('transaction_id') . ']"></td>
				</tr><?php
			} ?>
		</table>
		<br />
		<input type="submit" name="action" value="Make Exempt" />
	</form>
}
else {
	$PHP_OUTPUT.=('Nothing to authorize.');
}
