<?php
App::uses('AppModel', 'Model');
class Post extends AppModel {
    public $name = 'Post';
	
	var $belongsTo = array('Category');	
	
}