<?php

class SmrPortGood {

	protected $good;
	protected $transactionType;
	protected $amount;

	protected function __construct($goodID, $transactionType) {
		$this->good = SmrTradeGood::getGood($goodID);
		$this->
		$this->db = new SmrMySqlDatabase();

		//'Type' => 'Good',
		$this->goodID = $dbRow->getInt('good_id');
		$this->goodName = $dbRow->getField('good_name');
		$this->maxAmount = $dbRow->getInt('max_amount');
		$this->basePrice = $dbRow->getInt('base_price');
		$this->class = $dbRow->getInt('good_class');
		$this->alignRestriction = $dbRow->getInt('align_restriction');
		$this->imageLink = 'images/port/' . $this->goodID . '.png';
	}

	/**
	 * Expose transactionType, amount, and the get methods of the
	 * SmrTradeGood member.
	 */
	public function __get($name) {
		if ($name == "transactionType" || $name == "amount") {
			return $this->$name;
		} else {
			return $this->good->$name;
		}
	}

	public function setAmount($amount) {
		$this->amount = $amount;
	}

?>
