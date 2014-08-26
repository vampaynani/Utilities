<?php
class Validator{
	
	public static $errors;
	public static $valid = true;
	public static $format = array(
		'required' => 'The field %s is required',
		'file' => 'The field %s is required',
		'selection' => 'The field %s doesn\'t have a valid selection',
		'email' => 'The field %s isn\'t valid',
		'phone' => 'The field %s isn\'t valid'
	);
	
	public static function setformat( $field, $nformat ){
		self::$format[$field] = $nformat;
	}
	
	public static function validate( $fields ){
		foreach($fields as  $field ){
			$rules = explode( ",", $field['rules'] );
			$value = $field['value'];
			$name = $field['name'];
			foreach( $rules as $rule){
				self::$rule( $name, $value );
			}
		}
	}
	
	private static function required( $name, $value ){
		if( !isset($value) || empty( $value ) ){
			self::$valid = false;
			self::$errors[] = sprintf(self::$format['required'], $name);
		}
	}
	
	private function file( $name, $value ){
		if( !isset($value) || empty( $value ) ){
			self::$valid = false;
			self::$errors[] = sprintf(self::$format['file'], $name);
		}
		if ($value['error'] > 0){
  			self::$errors[] = $value['error'];
  		}
	}

	private static function selection( $name, $value ){
		if( $value=="-1" ){
			self::$valid = false;
			self::$errors[] = sprintf(self::$format['selection'], $name);
		}
	}
	
	private static function email( $name, $value ){
		$mail_rule = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";
		if( !preg_match( $mail_rule, $value ) ){
			self::$valid = false;
			self::$errors[] = sprintf(self::$format['email'], $name);
		}
	}
	
	private static function phone( $name, $value ){
		$phone_rule = "/^[0-9]{10}$/";
		if( !preg_match( $phone_rule, $value ) ){
			self::$valid = false;
			self::$errors[] = sprintf(self::$format['phone'], $name);
		}
	}
}