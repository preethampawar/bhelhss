<?php
App::uses('AppModel', 'Model');
class Teacher extends AppModel {
    public $name = 'Teacher';
	
	var $belongsTo = array('User');	
	
}