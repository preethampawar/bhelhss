<?php
App::uses('AppModel', 'Model');
class Comment extends AppModel {
    public $name = 'Comment';
    public $actsAs = array('Tree');	
	var $belongsTo = array('User', 'ParentComment'=>array('className'=>'Comment', 'foreignKey'=>'parent_id'));	
	
	var $validate = array(
		'name' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => false,
				'message' => 'Comment name is a required field'
			),
			'between' => array(
				'rule' => array('between', 1, 5000),
				'message' => 'Comment name should be minimum of 1 character and maximum of 5000 characters'
			)
		)
	);
}