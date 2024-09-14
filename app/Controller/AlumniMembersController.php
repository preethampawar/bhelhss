<?php
App::uses('CakeEmail', 'Network/Email');
class AlumniMembersController extends AppController
{
	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->layout = 'hss';
		// $this->Auth->allow('login','add','forgotpassword', 'resetpassword', 'register', 'confirm', 'contactus', 'list'); // Letting users register themselves
	}

	public function index($download = 0)
	{
		$conditions = [];
		$title_for_layout = 'Manage Alumni Members';
		$searchBy = $this->request->query['searchby'] ?? 'total-registered';

		if ($this->request->is('post')) {
			$searchText = $this->data['AlumniMember']['search_text'];
			$date = $this->data['AlumniMember']['date'];

			if (!empty($searchText)) {
				$conditions['or']['AlumniMember.name LIKE'] = "%{$searchText}%";
				$conditions['or']['AlumniMember.phone LIKE'] = "%{$searchText}%";
				$conditions['or']['AlumniMember.email LIKE'] = "%{$searchText}%";
			}

			if (!empty($date)) {
				$conditions['DATE(AlumniMember.created)'] = "$date";
			}
		}

		if ($searchBy === 'registered-today') {
			$conditions['DATE(AlumniMember.created)'] = date('Y-m-d');
		}

		if ($searchBy === 'accounts-verified') {
			$conditions['AlumniMember.account_verified'] = 1;
		}

		if ($searchBy === 'payments-confirmed') {
			$conditions['AlumniMember.payment_confirmed'] = 1;
		}

		$alumniMembers = $this->AlumniMember->find('all', [
			'order' => ['AlumniMember.created desc'],
			'conditions' => $conditions,
		]);

		if ($download) {
			ini_set('max_execution_time', '10000');
			ini_set('memory_limit', '1024M');

			$fileName = 'MembersList-' . $searchBy . '-' . time() . '.csv';
			$this->layout = 'ajax';

			$this->response->compress();
			$this->response->type('csv');
			$this->response->download($fileName);
		}

		// get total members count
		$conditions = [];
		$allAlumniMembersCount = $this->AlumniMember->find('count', [
			'order' => ['AlumniMember.name'],
			'conditions' => $conditions,
		]);

		// get total members count registered today
		$conditions = [];
		$conditions['DATE(AlumniMember.created)'] = date('Y-m-d');
		$todaysAlumniMembersCount = $this->AlumniMember->find('count', [
			'order' => ['AlumniMember.name'],
			'conditions' => $conditions,
		]);

		// get total payments confirmed
		$paymentsConfirmedCount = $this->AlumniMember->find('count', [
			'order' => ['AlumniMember.name'],
			'conditions' => ['AlumniMember.payment_confirmed' => 1],
		]);

		// get total accounts confirmed
		$accountsVerifiedCount = $this->AlumniMember->find('count', [
			'order' => ['AlumniMember.name'],
			'conditions' => ['AlumniMember.account_verified' => 1],
		]);

		$this->set(compact('alumniMembers', 'download', 'title_for_layout', 'allAlumniMembersCount', 'todaysAlumniMembersCount', 'paymentsConfirmedCount', 'accountsVerifiedCount', 'searchBy'));
	}

	public function delete($alumniMemberId)
	{
		$this->AlumniMember->delete($alumniMemberId);

		$this->Flash->set('Member deleted successfully.', ['element'=>'success']);
		$this->redirect(array('action' => 'index'));
	}
}
