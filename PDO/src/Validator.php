<?php
class Validator{
	
	public static $errors;
	public static $valid = true;
	
	public static function validate( $fields ){
		foreach($fields as  $field ){
			$rules = explode( ",", $field['rules'] );
			$value = $field['value'];
			$name = $field['name'];
			foreach( $rules as $rule ){
				self::$rule( $name, $value );
			}
		}
	}
	
	private static function required( $name, $value ){
		if( !isset($value) || empty( $value ) ){
			self::$valid = false;
			self::$errors[] = "The field " . $name . " is required";
		}
	}
	
	private function file( $name, $value ){
		if( !isset($value) || empty( $value ) ){
			self::$valid = false;
			self::$errors[] = "The field " . $name . " is required";
		}
		if ($value['error'] > 0){
  			self::$errors[] = $value['error'];
  		}
	}

	private static function selection( $name, $value ){
		if( $value=="-1" ){
			self::$valid = false;
			self::$errors[] = "The field " . $name . " doesn't have a valid selection";
		}
	}
	
	private static function email( $name, $value ){
		$mail_rule = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";
		if( !preg_match( $mail_rule, $value ) ){
			self::$valid = false;
			self::$errors[] = "The field " . $name . " isn't valid";
		}
	}
	
	private static function phone( $name, $value ){
		$phone_rule = "/^[0-9]{10}$/";
		if( !preg_match( $phone_rule, $value ) ){
			self::$valid = false;
			self::$errors[] = "The field " . $name . " isn't valid";
		}
	}
}