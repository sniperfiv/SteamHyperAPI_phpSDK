<?php
class WalletBalance extends stermapi{
	public $url_spec='http://steamcommunity.com/market/';
	public function exec(){
		$temp = $this-> execspec();
		//return $temp;
		//echo $temp ;
		preg_match('/(?<=marketWalletBalanceAmount\"\>).*?(?=\<\/span\>)/i',$temp,$newresult);
		$temp=$newresult[0];
		$temp=preg_replace('/\&\#36\;/','',$temp);
		//echo $temp;
		$balance=(float)$temp;
		return $balance;
	}
}
?>