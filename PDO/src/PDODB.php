<?php
class PDODB{
	private $DBH;
	protected $record = true;
	protected $table;
	protected function __construct(){
		try{
			switch(DB_TYPE){
				case 'pgsql':
					$this->DBH = new PDO("pgsql:dbname=".DB_NAME.";host=".DB_SRVR, DB_USR, DB_PWD);
					break;
				case 'mysql':
					$this->DBH = new PDO("mysql:host=".DB_SRVR.";dbname=".DB_NAME, DB_USR, DB_PWD);
					break;
				case 'sqlite':
					$this->DBH = new PDO("sqlite:".DB_NAME);
					break;
			}
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}
	protected function _relationship( $q ){
		$STH = $this->DBH->exec( $q );
	}
	protected function _query( $q ){
		$result = array();
		$STH = $this->DBH->query( $q );
		if($STH){
			$STH->setFetchMode(PDO::FETCH_OBJ);
			while( $row = $STH->fetch() ){
				$result[] = $row;
			}
			return new PDOResult($result);
		}else{
			return new PDOResult();
		}
	}
	protected function _insert( $data ){
		$fields = array();
		foreach($data as $key=>$value){
			$fields[] = $key;
		}
		$fieldsstr = implode( ', ', $fields );
		$fieldsval = ':' . implode( ', :', $fields );
		if($this->record){
			$fieldsstr .= ', created_at';
			switch (DB_TYPE) {
				case 'pgsql':
					$fieldsval .= ", now()";
					break;
				case 'mysql':
					$fieldsval .= ", NOW()";
					break;
				case 'sqlite':
					$fieldsval .= ", date('now')";
					break;
			}
			
		}
		$STH = $this->DBH->prepare("INSERT INTO " . $this->table . " ( $fieldsstr ) values ( $fieldsval )");
		$STH->execute( $data );
		return $this->DBH->lastInsertId();
	}
	protected function _all( $fields, $limit = NULL, $orderby = NULL ){
		$result = array();
		$query = "SELECT $fields FROM " . $this->table;
		if($limit) $query .= " LIMIT $limit";
		if($orderby) $query .= " ORDER BY $orderby";
		$STH = $this->DBH->query( $query );
		$STH->setFetchMode(PDO::FETCH_OBJ);
		while( $row = $STH->fetch() ){
			$result[] = $row;
		}
		return new PDOResult( $result );
	}
	protected function _where( $fields, $condition, $limit = NULL, $orderby = NULL ){
		$result = array();
		$query = "SELECT $fields FROM " . $this->table . " WHERE $condition";
		if($orderby) $query .= " ORDER BY $orderby";
		if($limit) $query .= " LIMIT $limit";
		$STH = $this->DBH->query( $query );
		if($STH){
			$STH->setFetchMode(PDO::FETCH_OBJ);
			while( $row = $STH->fetch() ){
				$result[] = $row;
			}
			return new PDOResult( $result );
		}else{
			return new PDOResult( NULL );
		}
	}
	protected function _delete( $condition ){
		$this->DBH->exec("DELETE FROM " . $this->table . " WHERE $condition");
		return true;  
	}
	protected function _update( $data, $condition ){
		$fields = array();
		foreach($data as $key=>$value){
			$fields[] = $key . '=:' . $key;
		}
		$fieldsstr = implode( ', ', $fields );
		$STH = $this->DBH->prepare("UPDATE " . $this->table . " SET $fieldsstr WHERE $condition");
		$STH->execute( $data );
		return $STH->rowCount();	
	}
}