<?php

class VoteSchema extends CakeSchema {

	var $name = 'Vote';

	function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	}
  
	var $votes = array(
			'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
			'user_id' => array('type'=>'string', 'length' => 36, 'null' => false, 'key' => 'index'),
			'foreign_key' => array('type'=>'string', 'length' => 36, 'null' => false, 'key' => 'index'),
			'model' => array('type'=>'string', 'length' => 100, 'null' => false, 'key' => 'index'),
			'type' => array('type'=>'string', 'length' => 10, 'null' => false, 'key' => 'index'),
			'created' => array('type'=>'datetime', 'null' => true),
			'indexes' => array(
  			'PRIMARY' => array('column' => 'id', 'unique' => 1),
  			'model' => array('column' => 'model', 'unique' => 0),
  			'foreign_key' => array('column' => 'foreign_key', 'unique' => 0),
  			'user_id' => array('column' => 'user_id', 'unique' => 0),
  			'type' => array('column' => 'type', 'unique' => 0),
  		),
		);
		
}
?>