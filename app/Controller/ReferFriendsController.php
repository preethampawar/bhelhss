<?php
App::uses('CakeEmail', 'Network/Email');
class ReferFriendsController extends AppController {

	public function beforeFilter() {
		parent::beforeFilter();
		//$this->Auth->allow('login','add','forgotpassword', 'resetpassword', 'register', 'confirm', 'contactus', 'list'); // Letting users register themselves
	}

	function referafriend() {
		$errorMsg = array();
		if ($this->request->is('post')) {
			$data = $this->request->data;

			// Validate name
			if(Validation::blank($data['ReferFriend']['name'])) {
				$errorMsg[] = 'Enter the name of the person being referred.';
			}
			// validate user email
			if(trim($data['ReferFriend']['email'])) {
				if(!(Validation::email($data['ReferFriend']['email']))) {
					$errorMsg[] = 'Invalid Email Address.';
				}
			}
			// check if email or phone no. is entered
			if(!((trim($data['ReferFriend']['email'])) or (trim($data['ReferFriend']['phone'])))) {
				$errorMsg[] = 'Please enter Email address or Phone no. of the person being referred.';
			}

			$data['ReferFriend']['referred_by_name'] = $this->Session->read('User.name');
			$data['ReferFriend']['referred_by_email'] = $this->Session->read('User.email');
			$data['ReferFriend']['referred_by_user_id'] = $this->Session->read('User.id');

			$this->ReferFriend->save($data);

			if(empty($errorMsg)) {
				try {
					$mailContent = '
Dear Admin,

A person has tried to refer someone on '.Configure::read('Domain').'.

Details of person being referred:
----------------------------------------
Name: '.$data['ReferFriend']['name'].'
Batch: '.$data['ReferFriend']['batch'].'
Email: '.$data['ReferFriend']['email'].'
Phone no: '.$data['ReferFriend']['phone'].'
Message: '.$data['ReferFriend']['message'].'


Referred by:
----------------------------------------
Name: '.$data['ReferFriend']['referred_by_name'].'
Email: '.$data['ReferFriend']['referred_by_email'].'


-
'.Configure::read('Domain').'

*This is a system generated message. Please do not reply.

';
					$supportEmail = Configure::read('SupportEmail');
					$supportEmail2 = Configure::read('SupportEmail2');
					$email = new CakeEmail();
					$email->from(array('noreply@bhelhss.com' => 'bhelhss.com'));
					$email->replyTo(array($data['ReferFriend']['referred_by_email'] => $data['ReferFriend']['referred_by_email']));
					$email->to($supportEmail);
					$email->bcc($supportEmail2);
					$email->subject('Refer a friend');
					$email->send($mailContent);

				}
				catch(Exception $ex) {
					//$this->Session->setFlash('An error occurred while communicating with the server. Please try again.', 'default', array('class'=>'error'));
				}
				$this->Session->setFlash('Your message has been sent successfully.', 'default', array('class'=>'success'));
				$this->redirect('/ReferFriends/referafriend');
			}
		}
		$errorMsg = implode('<br>', $errorMsg);
		$this->set('errorMsg', $errorMsg);
		$this->set('title_for_layout', 'Refer Your School Friend');
	}

	function showReferredPeople() {
		$referredPeople = $this->ReferFriend->find('all');
		$this->set('referredPeople', $referredPeople);
		$this->set('title_for_layout', 'Referred People List');
	}
}
?>
