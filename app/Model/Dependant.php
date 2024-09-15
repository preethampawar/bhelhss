<?php
App::uses('AppModel', 'Model');

class Dependant extends AppModel {
    public $name = 'Dependant';
	public $useTable = 'dependants';
	public $belongsTo = ['AlumniMember'];

	public $types = [
		'father' => 'Father',
		'mother' => 'Mother',
		'child1' => 'Child 1',
		'child2' => 'Child 2',
		'child3' => 'Child 3',
	];

}
