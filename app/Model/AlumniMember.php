<?php
App::uses('AppModel', 'Model');

class AlumniMember extends AppModel {
    public $name = 'AlumniMember';
	public $useTable = 'alumni_members';

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
