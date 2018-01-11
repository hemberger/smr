<?php

class SmrTradeGood {
	protected static $CACHE_GOODS = array();

	protected $goodID;
	protected $goodName;
	protected $maxAmount;
	protected $basePrice;
	protected $class; // tier
	protected $imageLink;
	protected $alignRestriction;

	public static function getGoods() {
		if (!isset(self::$CACHE_GOODS)) {
			$db = new SmrMySqlDatabase();
			$db->query('SELECT * FROM good');
			while ($db->nextRecord()) {
				self::$CACHE_GOODS[$db->getInt('good_id')] = new SmrTradeGood($db->getRow());
			}
		}
		return self::$CACHE_GOODS;
	}

	public static function getGood($goodID) {
		return self::getGoods()[$goodID];
	}

	protected function __construct($dbRow) {
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

	public function __get($name) {
		return $this->$name;
	}

?>
