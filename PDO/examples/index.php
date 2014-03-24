<?php
require_once('../src/config.php');
require_once('../src/PDODB.php');
require_once('../src/PDOResult.php');
require_once('../src/Validator.php');
class Name extends PDODB {
	public function __construct(){
		parent::__construct();
		$this->table = 'names';
	}
	public function create( $n ){
		$data = array('name' => $n);
		return $this->_insert( $data );
	}
	public function exist( $name ){
		$fields = 'id';
		$condition = "name='$name'";
		$result = $this->_where( $fields, $condition );
		return $result->count() > 0;
	}
	public function all(){
		$fields = '*';
		return $this->_all( $fields );
	}
}

$name = new Name();
if( !$name->exist('Hello world') ){
	$name->create('Hello world');
}
print_r( $name->all()->get() );