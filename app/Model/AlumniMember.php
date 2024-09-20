<?php
App::uses('AppModel', 'Model');

class AlumniMember extends AppModel {
    public $name = 'AlumniMember';
	public $useTable = 'alumni_members';
	public $dependants = [
		'father' => 'Father',
		'mother' => 'Mother',
		'child1' => 'Child 1',
		'child2' => 'Child 2',
		'child3' => 'Child 3',
	];

	public $hasMany = ['Dependant', 'Payment'];

	public $validate = array(
		'email' => array(
            'email' => array(
                'rule' => 'email',
                'message' => 'Invalid Email Address.'
            ),
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' => 'Email is already registered with us.'
            )
        )
	);

}
