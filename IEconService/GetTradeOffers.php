<?php
class GetTradeOffers extends stermapi
{
public $service = 'IEconService';
public $interfaces = 'GetTradeOffers';
public $version = 'v1';
//public $quest = array();
public $get_received_offers=1;
public $get_sent_offers=0;
public $get_descriptions=1;
public $language='schinese';
public $active_only=1;
public $historical_only=0;
public $time_historical_cutoff = 0;
public function exec(){
	if ($this->get_received_offers > 0){
		$temparr['get_received_offers']=$this->get_received_offers;
	}
	if ($this->get_sent_offers > 0){
		$temparr['get_sent_offers']=$this->get_sent_offers;
	}
	if ($this->get_descriptions > 0){
		$temparr['get_descriptions']=$this->get_descriptions;
	}
	if ($this->language != ''){
		$temparr['language']=$this->language;
	}
	if ($this->active_only > 0){
		$temparr['active_only']=$this->active_only;
	}
	if ($this->historical_only > 0){
		$temparr['historical_only']=$this->historical_only;
	}
	if ($this->time_historical_cutoff > 0){
		$temparr['time_historical_cutoff']=$this->time_historical_cutoff;
	}
	$this->quest = $temparr;
	$execsteamapi = $this->exeapi();
	return $execsteamapi;
	}
}

?>