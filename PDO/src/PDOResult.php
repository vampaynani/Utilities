<?php
class PDOResult{
	private $result;
	public function __construct( $result ){
		$this->result = $result;
	}
	public function get(){
		return $this->result;
	}
	public function count(){
		return count($this->result);
	}
	public function average( $field ){
		$total = 0;
		foreach($this->result as $value){
			$total += $value->$field;
		}
		if($this->count() <= 0) return 0;
		return $total/$this->count();
	}
}