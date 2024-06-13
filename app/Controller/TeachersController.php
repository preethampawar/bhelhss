<?php
App::uses('CakeEmail', 'Network/Email');
class TeachersController extends AppController {
	
	public function beforeFilter() {
		parent::beforeFilter();		
		//$this->Auth->allow('');
	}	
	
	public function index() {
		$this->checkModerator();
		
		$teachersInfo = $this->Teacher->find('all', array('order'=>'Teacher.created ASC'));
		$this->set(compact('teachersInfo'));
	}
	
	public function addInfo() {
		$errorMsg = array();
		if($this->request->isPost()) {
			$data = $this->request->data;
			// Validate name
			if(Validation::blank($data['Teacher']['name'])) {
				$errorMsg[] = "Enter Teacher's Name";
			}
			// Validate phone no.
			if(Validation::blank($data['Teacher']['phone'])) {
				$errorMsg[] = "Enter Phone No.";
			}
		
			if(empty($errorMsg)) {
				$data['Teacher']['user_id'] = $this->Session->read('User.id');
				if($this->Teacher->save($data)) {
					$this->Session->setFlash("Thank you for your contribution. Teacher's contact information has been recorded.", 'default', array('class'=>'success'));
					$this->redirect('/teachers/addInfo');
				}
			}
		}
		
		$errorMsg = implode('<br>', $errorMsg);
		$this->set(compact('errorMsg'));
	}
	
	public function editInfo($teacherID) {
		$errorMsg = array();
		
		if(!$teacherInfo = $this->Teacher->findById($teacherID)) {
			$this->Session->setFlash("Record not found", 'default', array('class'=>'error'));
			$this->redirect('/teachers/');
		}
		
		if($this->request->isPut()) {
			$data = $this->request->data;
			// Validate name
			if(Validation::blank($data['Teacher']['name'])) {
				$errorMsg[] = "Enter Teacher's Name";
			}
			// Validate phone no.
			if(Validation::blank($data['Teacher']['phone'])) {
				$errorMsg[] = "Enter Phone No.";
			}
		
			if(empty($errorMsg)) {				
				$data['Teacher']['id'] = $teacherID;
				if($this->Teacher->save($data)) {
					$this->Session->setFlash("Teacher's contact information has been updated.", 'default', array('class'=>'success'));
					$this->redirect('/teachers/');
				}
			}
		}
		else {
			$this->data = $teacherInfo;
		}
		
		$errorMsg = implode('<br>', $errorMsg);
		$this->set(compact('errorMsg', 'teacherInfo'));
	}
	
	function delete($teacherID) {
		if(!$teacherInfo = $this->Teacher->findById($teacherID)) {
			$this->Session->setFlash("Record not found", 'default', array('class'=>'error'));
			$this->redirect('/teachers/');
		}
		
		$this->Teacher->delete($teacherID);
		$this->Session->setFlash("Record deleted successfully", 'default', array('class'=>'success'));
		$this->redirect('/teachers/');
	}
}
?>