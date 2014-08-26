<?php
class PDOResult{
	private $result;
	public function __construct( $result = NULL ){
		if($result){
			$this->result = $result;	
		}else{
			$this->result = NULL;
		}
	}
	public function get(){
		return $this->result;
	}
	public function first(){
		if( !$this->result ) return NULL;
		return $this->result[0];
	}
	public function count(){
		return count($this->result);
	}
	public function sum($field){
		$total = 0;
		if($this->result){
			foreach($this->result as $value){
				$total += $value->$field;
			}
		}
		return $total;
	}
	public function average( $field ){
		$total = $this->sum($field);
		if($this->count() <= 0) return 0;
		return $total/$this->count();
	}
	public function UTF8Encode(){
		if($this->result){
			foreach($this->result as $item){
				foreach($item as $property => $value){
					if(is_string($value)){
						$item->$property = utf8_encode($value);
					}
				}
			}
		}
		return $this;
	}
}