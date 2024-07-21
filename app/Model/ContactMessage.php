<?php
App::uses('AppModel', 'Model');

class ContactMessage extends AppModel {
    public $name = 'ContactMessage';
	public $useTable = 'contact_messages';

	public $validate = array(
		'email' => array(
            'email' => array(
                'rule' => 'email',
                'message' => 'Invalid Email Address.'
            ),
        )
	);

}
