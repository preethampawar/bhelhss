<?php
App::uses('AppModel', 'Model');
class Blog extends AppModel {
    var $name = 'Blog';
    
	var $useTable = 'posts';	
	
	var $belongsTo = array('User');	
	
}