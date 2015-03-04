<?php
class DeclineTradeOffer extends stermapi
{
public $service = 'IEconService';
public $interfaces = 'DeclineTradeOffer';
public $version = 'v1';
//public $quest = array();
public $tradeofferid ="";
public $method = "post";
public function exec(){
	if ($this->tradeofferid != ""){
		$temparr['tradeofferid']=$this->tradeofferid;
	}

	$this->quest = $temparr;
	$execsteamapi = $this->exeapi();
	return $execsteamapi;
	}
}

?>