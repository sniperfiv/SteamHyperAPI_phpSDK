<?php
class CorfirmTrade extends stermapi{
	public $tradeofferid;
	public $fromsteamuid;
	public $postdate;
	public function exec(){
		$this->preload();
		//$temppost="sessionid=6f0d1a7a444080c005ee523e&serverid=1&tradeofferid=356907915&partner=76561198158548205&captcha=";
		$temppost="sessionid=".($this->ck_sessionid);
		$temppost.='&serverid=1';
		$temppost.='&tradeofferid='.($this->tradeofferid);
		$temppost.='&partner='.($this->fromsteamuid);
		$temppost.='&captcha=';
		//echo $temppost;
		$this->postdate=$temppost;
		$this->head_spec=1;
		//https://steamcommunity.com/tradeoffer/356907915/
		//https://steamcommunity.com/tradeoffer/356907915/accept
		$this-> url_spec = "https://steamcommunity.com/tradeoffer/".($this -> tradeofferid)."/accept";
		$this->url_ref_spec="https://steamcommunity.com/tradeoffer/".($this -> tradeofferid)."/";
		$temprespon=$this-> execspec();
		
		if (preg_match('/tradeid/i',$temprespon)==0){
			$error['success']=0;
			$error['info']='Accept trade offer failed.';
			$error['info'].=$temprespon;
			echo json_encode($error) ;
			exit;
		} else {
			$resbak=json_decode($temprespon,1);
			$res_out['success']=1;
			$res_out['info']='Trade offer has been confirmed.';
			$res_json=json_encode($res_out) ;
			return $res_json;
		}
	}
	private function preload(){
		if (is_null($this -> tradeofferid) or ($this -> tradeofferid=="")){
			$error['success']=0;
			$error['info']='Nessary variaty:$tradeofferid is empry.';
			echo json_encode($error) ;
			exit;
		}
		if (is_null($this -> fromsteamuid) or ($this -> fromsteamuid=="")){
			$error['success']=0;
			$error['info']='Nessary variaty:$fromsteamuid is empry.';
			echo json_encode($error) ;
			exit;
		}
		$tradeofferid=$this -> tradeofferid;
		$this-> url_spec = "https://steamcommunity.com/tradeoffer/".$tradeofferid."/";
		//echo $this-> url_spec;
		//$this-> head_spec = 1;
		$temprespon=$this-> execspec();
		preg_match ('/(?<=\<title\>)[.\s\S]*?(?=\<\/title\>)/i',$temprespon,$htmltitle);
		if (preg_match('/错误|error/i',$htmltitle[0])>0){
			$error['success']=0;
			$error['info']='Trade Offer ID is incorrect';
			echo json_encode($error) ;
			exit;
		}
	}
}
?>