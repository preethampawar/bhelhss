<?php
App::uses('AppModel', 'Model');
class Payment extends AppModel {
    public $name = 'Payment';
	public $belongsTo = array('AlumniMember', 'Dependant');
}
