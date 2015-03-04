<?
class AddFriend extends stermapi{
	public $tosteamuid;
	public $fromsteamuid;
	public $postdate;
	public function exec(){
		//sessionID=b917de61fb1ae7a0d48e07b4&steamid=76561198062319969&accept_invite=0
		$temppost="sessionID=".($this->ck_sessionid);
		$temppost.="&steamid=".($this->tosteamuid);
		$temppost.="&accept_invite=0";
		$this->ck_steamuid = $this->fromsteamuid;
		$this->postdate=$temppost;
		$this-> url_spec = "http://steamcommunity.com/actions/AddFriendAjax";
		$this-> url_ref_spec="http://steamcommunity.com/profiles/".($this -> tosteamuid);
		$temprespon=$this-> execspec();
		return $temprespon;
		//exit;
	}
}
?>