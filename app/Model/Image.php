<?php
App::uses('AppModel', 'Model');
class Image extends AppModel
{
	var $name = 'Image';
	
	var $belongsTo = array('Post');
}
?>