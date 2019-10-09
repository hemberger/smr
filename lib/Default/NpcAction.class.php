<?php

interface NpcAction {

	public function __construct(...);
	public function conditionsMet(...) : bool;
	public function act() : void;

}
