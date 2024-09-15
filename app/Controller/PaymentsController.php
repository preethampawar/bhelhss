<?php
App::uses('CakeEmail', 'Network/Email');

class PaymentsController extends AppController
{
	public function beforeFilter()
	{
		parent::beforeFilter();
	}
}
