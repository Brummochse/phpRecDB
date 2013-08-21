<?php
class StateMsgHandler {

	private $stateMsgs=array();
	
	private static $instance = NULL;

	public static function getInstance() {
		if (self :: $instance === NULL) {
			self :: $instance = new self;
		}
		return self :: $instance;
	}
	
	public function addStateMsg($stateMsg) {
		$this->stateMsgs[]=$stateMsg;
	}
	
	public function getStateMsgs() {
		return $this->stateMsgs;
	}

}
?>
