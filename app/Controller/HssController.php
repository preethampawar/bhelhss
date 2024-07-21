<?php
App::uses('CakeEmail', 'Network/Email');
App::uses('AlumniMember', 'Model');
App::uses('ContactMessage', 'Model');
App::uses('Post', 'Model');
class HssController extends AppController {

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(); // Letting users register themselves
		$this->layout = 'hss';
	}

	public function about_us()
	{

	}

	public function about_school()
	{
		$slug = 'about-school';
		$postModel = new Post();
		$post = $postModel->findBySlug($slug);

		$this->set(compact('post'));
	}

	public function news_and_events()
	{
		$categoryId = 5;
		$postModel = new Post();
		$postModel->bindModel(['hasMany' => ['Image']]);
		$posts = $postModel->find('all', [
			'conditions' => ['Post.category_id' => $categoryId, 'Post.active' => 1],
			'order' => 'Post.created DESC',
			'limit' => 50
		]);

		$this->set(compact('posts'));
	}

	public function contact_us()
	{
		$errorMsg = '';
		$successMsg = '';

		if ($this->request->is('post')) {
			$data = $this->request->data;
			$response = $this->save_contactus_data($data);

			if ($response['success']) {
				$this->Flash->set('Thank you for contacting us. We will get back to you at the earliest.', ['class' => 'alert alert-success']);
				$this->redirect('/hss/contact_message_sent');
			}

			$errorMsg = $response['errors'];
		}

		$this->set(compact('errorMsg'));
	}

	private function save_contactus_data($data) {
		$contactMessage = new ContactMessage();
		$errorMsg = array();
		$response['success'] = false;
		$response['errors'] = '';
		$response['memberInfo'] = null;

		// Validations

		// validate user email
		if (Validation::blank($data['User']['name'])) {
			$errorMsg[] = 'Enter Name.';
		} elseif(Validation::blank($data['User']['email'])) {
			$errorMsg[] = 'Enter Email Address.';
		} elseif(!(Validation::email($data['User']['email']))) {
			$errorMsg[] = 'Invalid Email Address.';
		} elseif (Validation::blank($data['User']['message'])) {
			$errorMsg[] = 'Enter message.';
		}

		if(empty($errorMsg)) {
			$data = $this->sanitizeData($data);
		}

		if(empty($errorMsg)) {
			$data['ContactMessage'] = $data['User'];
			$data['ContactMessage']['id'] = null;

			if($contactMessage->save($data)) {
				$response['success'] = true;
				$contactInfo = $contactMessage->read();
				$response['memberInfo'] = $contactInfo;
				$userName = $contactInfo['ContactMessage']['name'];
				$userEmail = $contactInfo['ContactMessage']['email'];

				$mailContent = '
Dear '.$userName.',

Thank you for contacting BHEL HSS Alumni. We will get back to you as soon as possible.

-
'.Configure::read('Domain').'


*This is a system generated message. Please do not reply.

';
				$email = new CakeEmail();
				$email->from(array('noreply@bhelhss.com' => 'bhelhss.com'));
				$email->to($userEmail);
				$email->subject('Contact message');
				// $email->send($mailContent); //todo: uncomment if email has to be sent

			}
			else {
				$response['errors'] = 'An error occurred while communicating with the server. Please try again.';
			}
		}

		if (!empty($errorMsg)) {
			$errorMsg = implode('<br/>', $errorMsg);
			$response['errors'] = $errorMsg;
		}

		return $response;
	}


	function sanitizeContactUsData($data) {
		// Initialize & Sanitize data
		$data['User']['name'] = (isset($data['User']['name'])) ? htmlentities($data['User']['name'], ENT_QUOTES) : null;
		$data['User']['email'] = (isset($data['User']['email'])) ? htmlentities($data['User']['email'], ENT_QUOTES) : null;
		$data['User']['phone'] = (isset($data['User']['phone'])) ? htmlentities($data['User']['phone'], ENT_QUOTES) : null;
		$data['User']['message'] = (isset($data['User']['message'])) ? htmlentities($data['User']['message'], ENT_QUOTES) : null;

		return $data;
	}

	public function contact_message_sent()
	{

	}


	public function register()
	{
		$errorMsg = '';

		if ($this->request->is('post')) {
			$data = $this->request->data;
			$response = $this->save_registration_data($data);

			if ($response['success']) {
				$this->redirect('/hss/registration_success/');
			}

			$errorMsg = $response['errors'];
		}

		$this->set(compact('errorMsg'));
	}

	private function save_registration_data($data) {
		$alumniMember = new AlumniMember();
		$errorMsg = array();
		$response['success'] = false;
		$response['errors'] = '';
		$response['memberInfo'] = null;
		$userId = $data['User']['id'] ?? null;

		// Validations

		// validate user email
		if(Validation::blank($data['User']['email'])) {
			$errorMsg[] = 'Enter Email Address.';
		}
		elseif(!(Validation::email($data['User']['email']))) {
			$errorMsg[] = 'Invalid Email Address.';
		}
		elseif($userInfo = $alumniMember->findByEmail($this->request->data['User']['email'])) {
			if ($userInfo['AlumniMember']['id'] != $userId) {
				$errorMsg[] = 'User with this email address is already registered.';
			}
		}
		if(isset($data['User']['amount_paid'])
			&& !Validation::blank($data['User']['amount_paid'])
			&& !Validation::numeric($data['User']['amount_paid'])) {
			$errorMsg[] = 'Enter Valid Amount.';
		}

		if(empty($errorMsg)) {
			$errorMsg = $this->validateData($data);
			if(empty($errorMsg)) {
				$data = $this->sanitizeData($data);
			}
		}

		if(!$errorMsg) {
			$data['AlumniMember'] = $data['User'];
			$data['AlumniMember']['id'] = $data['User']['id'] ?? null;


			if($alumniMember->save($data)) {
				$response['success'] = true;
				$memberInfo = $alumniMember->read();
				$response['memberInfo'] = $memberInfo;
				$userName = $memberInfo['AlumniMember']['name'];
				$userEmail = $memberInfo['AlumniMember']['email'];

				$encodedUserID = base64_encode($memberInfo['AlumniMember']['id']);
				$mailContent = '
Dear '.$userName.',

Your have successfully registered with BHEL HSS Alumni. Thanks for signing up with us.

-
'.Configure::read('Domain').'


*This is a system generated message. Please do not reply.

';
				$email = new CakeEmail();
				$email->from(array('noreply@bhelhss.com' => 'bhelhss.com'));
				$email->to($userEmail);
				$email->subject('Registration successful');
				// $email->send($mailContent); //todo: uncomment if email has to be sent

			} else {
				$response['errors'] = 'An error occurred while communicating with the server. Please try again.';
			}
		}

		if (!empty($errorMsg)) {
			$errorMsg = implode('<br/>', $errorMsg);
			$response['errors'] = $errorMsg;
		}

		return $response;
	}

	public function registration_success()
	{

	}

	public function login() {
		$this->set('title_for_layout', 'Log In');

		if ($this->request->is('post')) {
			if ($this->Auth->login()) {

				$userInfo = $this->Auth->user();
				if(!$userInfo['registered']) {
					$encodedUserID = base64_encode($userInfo['id']);
					$this->sendConfirmationLink($encodedUserID);
					$this->Session->setFlash('Your account is not confirmed yet. A confirmation link has been sent to your email address.', 'default', array('class'=>'notice'));
					$this->redirect('/users/login');
				}

				if(!$userInfo['active']) {
					$this->Session->setFlash('Your account is blocked/inactive. Please contact the site administrator or email the issue to support@bhelhss.com', 'default', array('class'=>'error'));
					$this->redirect('/users/login');
				}


				App::uses('PrivacySetting', 'Model');
				$this->PrivacySetting = new PrivacySetting;
				$pSettings = $this->PrivacySetting->findByUserId($userInfo['id']);

				$this->Session->write('PrivacySetting', $pSettings['PrivacySetting']);
				$this->Session->write('User', $userInfo);
				$this->Session->write('User.login', '1');
				$this->redirect($this->Auth->redirectUrl());
			} else {
				$this->set('errorMsg', 'Invalid email address or password. Please try again');
			}
		}
	}

	function admin_login() {
		$this->redirect('/users/login');
	}

	function admin_logout() {
		$this->redirect('/users/logout');
	}

	public function logout() {
		$this->Session->delete('User');
		$this->Session->delete('Company');
		$this->Session->delete('UserCompany');
		$this->Session->destroy();
		$this->redirect($this->Auth->logout());
	}

    public function index() {
		//$users = $this->User->find('all');


		$conditions = array('UserCompany.company_id'=>$this->Session->read('Company.id'));
		$users = $this->User->UserCompany->find('all', array('conditions'=>$conditions, 'order'=>array('UserCompany.created')));

		$this->set('users', $users);
    }

	/**
	 * Function to edit user profile
	 */
	public function edit($userID) {
		App::uses('Company', 'Model');
		$this->Company = new Company;
		if($this->Session->read('UserCompany.user_level') == '4') {
			$this->set('companies', $this->Company->find('list'));
		}
		else{
			$this->set('companies', $this->Company->find('list', array('conditions'=>array('Company.id'=>$this->Session->read('Company.id')))));
		}

		$errorMsg = null;
		$userInfo = $this->User->find('first', array('conditions'=>array('User.id'=>$userID)));

		if(empty($userInfo)) {
			$this->Session->setFlash('User not found', 'default', array('class'=>'error'));
			$this->redirect('/users/');
		}

		if($this->request->is('put')) {
			$data = $this->request->data;
			// validations
			$errorMsg = null;
			if(Validation::blank($data['User']['name'])) {
				$errorMsg = 'Enter Name';
			}
			elseif(!(Validation::between($data['User']['name'], 3, 55))) {
				$errorMsg = 'Name should be 3 to 55 characters long';
			}
			elseif($this->User->find('first', array('conditions'=>array('User.email'=>$data['User']['email'], 'User.id NOT'=>$userID)))) {
				$errorMsg = 'User with this email address is already registered with us';
			}
			if(!$errorMsg) {
				$data['User']['id'] = $userID;
				if ($this->User->save($data)) {
					$this->Session->setFlash('Account Updated Successfully', 'default', array('class'=>'success'));
					$this->redirect(array('action' => 'index'));
				}
				else {
					$this->Session->setFlash('An error occurred while communicating with the server', 'default', array('class'=>'error'));
				}
			}
		}
		else {
			$this->data = $userInfo;
		}
		$this->set('errorMsg', $errorMsg);
		$this->set('userInfo', $userInfo);
	}

	/**
	 * Function to request code for password reset
	 */
	public function forgotpassword() {
		$this->set('title_for_layout', 'Forgot your password?');

		if ($this->request->is('post')) {

			$data = $this->request->data;

			$errorMsg = null;
			$err = false;

			if(empty($data['User']['email'])){
				$errorMsg = 'Enter Email Address';
				$err = true;
			}
			if($err){
				$this->set('errorMsg',$errorMsg);
			}else{
				$email  = $data['User']['email'];
				$user = $this->User->findByEmail($email);

				if(!$user){
					$this->Session->setFlash('Account not found.', 'default', array('class'=>'error'));
				}
				else{
					$randomPass = $this->generatePassword(4);
					$this->Session->write('verification_code', $randomPass);
					$this->Session->write('verification_email', $email);

					try {
						$mailContent = '
Dear '.$user['User']['name'].',

You have requested to reset your password.

Below is the verification code, which is needed to reset your password.

Verification Code: '.$randomPass.'


-
'.Configure::read('Domain').'


*This is a system generated message. Please do not reply.
						';

						// send verification code in email
						$email = new CakeEmail();
						$email->from(array('noreply@bhelhss.com' => 'bhelhss.com'));
						$email->to($user['User']['email']);
						$email->subject('Password Reset');
						$email->send($mailContent);
					}
					catch(Exception $ex) {
					}

					$this->Session->setFlash('Verification Code has been sent to your Email Address.', 'default', array('class'=>'success'));
					$this->redirect('/users/resetpassword');
				}
			}
		}

	}

	public function resetpassword() {
		$this->set('title_for_layout', 'Reset your password');
		if(!$this->Session->check('verification_code')) {
			$this->Session->setFlash('Your session has expired. Please try again.', 'default', array('class'=>'error'));
			$this->redirect('/users/forgotpassword');
		}

		$errorMsg = null;
		if ($this->request->is('post')) {
			$data = $this->request->data;
			if(empty($data['User']['verification_code'])) {
				$errorMsg = 'Enter Verification Code';
			}
			else {
				if($this->data['User']['verification_code'] == $this->Session->read('verification_code')) {
					$email = $this->Session->read('verification_email');
					$user = $this->User->findByEmail($email);
					if(!empty($user)) {
						$randomPass = $this->generatePassword();

						$tmp['User']['id'] = $user['User']['id'];
						$tmp['User']['password'] = md5($randomPass);
						if($this->User->save($tmp)) {
							try {
								$mailContent = '
Dear '.$user['User']['name'].',

Your password has been reset. Below are your login credentials.

Email: '.$email.'
Password: '.$randomPass.'


-
'.Configure::read('Domain').'


*This is a system generated message. Please do not reply.
								';

								// send login credentials in email
								$email = new CakeEmail();
								$email->from(array('noreply@bhelhss.com' => 'bhelhss.com'));
								$email->to($user['User']['email']);
								$email->subject('Your New Password');
								$email->send($mailContent);
							}
							catch(Exception $ex) {
							}
							$this->Session->delete('verification_code');
							$this->Session->delete('verification_email');

							$this->Session->setFlash('Your password has been reset. Login details have been sent to your email address. Please check your Email.', 'default', array('class'=>'success'));
							$this->redirect('/users/login');
						}
					}
					else {
						$errorMsg = 'Account Not Found';
					}
				}
				else {
					$errorMsg = 'Invalid Verification Code';
				}
			}

		}
		$this->set('errorMsg', $errorMsg);
	}

	/**
	 * Function to genereate random password
	 */
	function generatePassword ($length = 8) {
        // inicializa variables
        $password = "";
        $i = 0;
        $possible = "0123456789bcdfghjkmnpqrstvwxyz";

        // agrega random
        while ($i < $length){
            $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);

            if (!strstr($password, $char)) {
                $password .= $char;
                $i++;
            }
        }
        return $password;
    }

	/**
	 * Function to change password
	 */
	function changepassword() {
		$this->set('title_for_layout', 'Change your password');
		$errorMsg = '';
		if($this->request->ispost()) {
			$oldPwd = $this->request->data['User']['password'];
			$oldPwd = AuthComponent::password($oldPwd);
			$conditions = array('User.id'=>$this->Session->read('User.id'), 'User.password'=>$oldPwd);
			$userInfo = $this->User->find('first', array('conditions'=>$conditions, 'recursive'=>'-1'));

			if(!empty($userInfo)) {
				$newPwd = $this->request->data['User']['new_password'];
				$confirmPwd = $this->request->data['User']['confirm_password'];

				if(!(Validation::equalTo($newPwd, $confirmPwd))) {
					$errorMsg = 'New Password and Confirm Password do not match';
				}
				else {
					$this->User->id = $userInfo['User']['id'];
					$this->User->set('password',  AuthComponent::password($newPwd));
					$this->User->save();
					$this->Session->setFlash('Password has been changed successfully', 'default', array('class'=>'success'));
					$this->redirect('/users/changepassword');
				}
			}
			else{
				$errorMsg = 'Incorrect Old Password';
			}
		}


		$this->set('errorMsg', $errorMsg);
	}

	/**
	 * Function to register a user
	 */
	function register_() {
		$this->set('title_for_layout', 'Register Your Account');
		if ($this->request->is('post')) {
			$data = $this->request->data;
			$errorMsg = array();

			// Validations

			// validate user email
			if(Validation::blank($data['User']['email'])) {
				$errorMsg[] = 'Enter Email Address';
			}
			elseif(!(Validation::email($data['User']['email']))) {
				$errorMsg[] = 'Invalid Email Address';
			}
			elseif($this->User->findByEmail($this->request->data['User']['email'])) {
				$errorMsg[] = 'User with this email address is already registered with us';
			}


			// validate password
			elseif(Validation::blank($data['User']['password'])) {
				$errorMsg[] = 'Enter Password';
			}
			elseif(Validation::blank($data['User']['confirm_password'])) {
				$errorMsg[] = 'Confirm Password field is empty';
			}
			elseif($data['User']['confirm_password'] != $data['User']['password']) {
				$errorMsg[] = 'Passwords do not match';
			}

			if(empty($errorMsg)) {
				$errorMsg = $this->validateData($data);
				if(empty($errorMsg)) {
					$data = $this->sanitizeData($data);
				}
			}

			if(!$errorMsg) {
				// unset($data['User']['confirm_password']);
				$data['User']['id'] = null;
				$password = $data['User']['password'];
				if($this->User->save($data)) {
					$userInfo = $this->User->read();

					$tmp = array();
					$tmp['Activity']['type'] = 'user_registration';
					$tmp['Activity']['title'] = 'New User';
					$tmp['Activity']['user_id'] = $userInfo['User']['id'];
					$tmp['Activity']['url'] = '/users/info/'.$userInfo['User']['id'];
					$this->saveActivity($tmp);

					App::uses('PrivacySetting', 'Model');
					$this->PrivacySetting = new PrivacySetting;
					$pData['PrivacySetting']['id'] = ($this->Session->check('PrivacySetting')) ? $this->Session->read('PrivacySetting') : null;
					$pData['PrivacySetting']['user_id'] = $userInfo['User']['id'];
					$this->PrivacySetting->save($pData);

					$encodedUserID = base64_encode($userInfo['User']['id']);
					$this->sendConfirmationLink($encodedUserID, $password);
					$this->Session->setFlash('You have successfully registered with bhelhss.com', 'default', array('class'=>'success'));
					$this->redirect('/pages/registration_success');
				}
				else {
					$this->Session->setFlash('An error occurred while communicating with the server. Please try again.', 'default', array('class'=>'error'));
				}
			}
			$errorMsg = implode('<br/>', $errorMsg);
			$this->set(compact('errorMsg'));

		}
	}

	/**
	 * Function to send a account confirmation link to the user being registered
	 */
	function sendConfirmationLink($encodedUserID, $password=null) {
		try {
			$userID = base64_decode($encodedUserID);
			$userInfo = $this->User->findById($userID);
			$linkPath = Configure::read('DomainUrl').'users/confirm/'.$encodedUserID;
			//$hyperLink = '<a href="'.$linkPath.'">'.$linkPath.'</a>';
			$pwd = ($password) ? $password : '***** (not shown for security reasons)';
			if(!empty($userInfo)) {

				$mailContent = '
Dear User,

Your account has been successfully created. Before you start using your account, you need to confirm it.

Click the below link to confirm your account.
'.$linkPath.'

If the above link doesnt work for you, then copy paste the same in the address bar.

Below are your login details
	Email: '.$userInfo['User']['email'].'
	Password: '.$pwd.'


Thank you!.

-
'.Configure::read('Domain').'


*This is a system generated message. Please do not reply.

';
				$email = new CakeEmail();
				$email->from(array('noreply@bhelhss.com' => 'bhelhss.com'));
				$email->to($userInfo['User']['email']);
				$email->subject('Registration');
				$email->send($mailContent);

				// send message to support team
				$mailContent = '
Dear Admin,

'.
$userInfo['User']['name'].'('.$userInfo['User']['email'].') has registered on bhelhss.com.

This message is for notification purpose only.

-
'.Configure::read('Domain').'
*This is a system generated message. Please do not reply.

';
				$supportEmail = Configure::read('SupportEmail');
				$supportEmail2 = Configure::read('SupportEmail2');
				$email = new CakeEmail();
				$email->from(array('noreply@bhelhss.com' => 'bhelhss.com'));
				$email->to($supportEmail);
				$email->bcc($supportEmail2);
				$email->subject('New Registration');
				$email->send($mailContent);
			}
		}
		catch(Exception $ex) {

		}
	}

	/**
	 * Function to confirm a user's account
	 */
	function confirm($encodedUserID) {
		$userID = base64_decode($encodedUserID);
		if($userInfo = $this->User->findById($userID)) {
			if($userInfo['User']['registered']) {
				$this->Session->setFlash('Your account has been already confirmed.', 'default', array('class'=>'notice'));
				$this->redirect('/');
			}

			$data['User']['id'] = $userID;
			$data['User']['registered'] = '1';
			if($this->User->save($data)) {

				$messageType = 'notification';
				$subject = 'New memeber on bhelhss.com';

				$message = '
'.$userInfo['User']['name'].' ('.Configure::read('UserTypes.'.$userInfo['User']['type']).') has registered on bhelhss.com.

For more details visit:
http://www.bhelhss.com/users/info/'.$userInfo['User']['id'].'

Unsubscribe from the mailing list:
http://www.bhelhss.com/users/subscribe


-
bhelhss.com
support@bhelhss.com

This message is for notification purpose only and is auto generated. Please do not reply.

';

				try {
					$this->sendBulkEmail($messageType, $subject, $message);
				}
				catch(Exception $e) {

				}

				$this->Session->destroy();

				$this->Session->setFlash('Your account has been confirmed. Please login to continue', 'default', array('class'=>'success'));
				$this->redirect('/users/login');
			}
			else {
				$this->Session->setFlash('An error occurred while communicating with the server. Please try again.', 'default', array('class'=>'error'));
			}
		}
		else {
			$this->Session->setFlash('Unknown user', 'default', array('class'=>'error'));
		}
		$this->redirect('/');
	}

	/**
	 * Function to remove a user from the selected company
	 */
	function remove($userID=0) {

		$conditions = array('UserCompany.user_id'=>$userID, 'UserCompany.company_id'=>$this->Session->read('Company.id'));
		App::uses('UserCompany', 'Model');
		$this->UserCompany = new UserCompany;

		$this->UserCompany = new UserCompany();
		if($companyInfo = $this->UserCompany->find('first', array('conditions'=>$conditions))) {
			$this->UserCompany->delete($companyInfo['UserCompany']['id']);
			$this->Session->setFlash('User has been successfully removed', 'default', array('class'=>'success'));
		}
		else {
			$this->Session->setFlash('You are not authorized to perform this action [Restricted Access]', 'default', array('class'=>'error'));
		}
		$this->redirect('/users/');
	}

	/**
	 * Show all registered users
	 */
	function admin_index() {
		$this->User->recursive = -1;
		$users = $this->User->find('all');
		$totalUsers = $this->User->find('count');
		$activeUsers = $this->User->find('count', array('conditions'=>array('active'=>'1')));
		$inactiveUsers = $this->User->find('count', array('conditions'=>array('active NOT'=>'1')));
		$notRegisteredUsers = $this->User->find('count', array('conditions'=>array('registered NOT'=>'1')));

		$this->set(compact('users', 'totalUsers', 'activeUsers', 'inactiveUsers', 'notRegisteredUsers'));
	}

	/**
	 * Function to edit a user
	 */
	public function admin_edit($userID) {
		$this->set('userID', $userID);
		$errorMsg = null;
		$userInfo = $this->User->find('first', array('conditions'=>array('User.id'=>$userID), 'recursive'=>2));

		if(empty($userInfo)) {
			$this->Session->setFlash('User not found', 'default', array('class'=>'message'));
			$this->redirect('/admin/users/');
		}

		if($this->request->is('put')) {
			$data = $this->request->data;
			// validations
			$errorMsg = null;
			if(Validation::blank($data['User']['name'])) {
				$errorMsg = 'Enter Name';
			}
			elseif(!(Validation::between($data['User']['name'], 3, 55))) {
				$errorMsg = 'Name should be 3 to 55 characters long';
			}
			elseif($this->User->find('first', array('conditions'=>array('User.email'=>$data['User']['email'], 'User.id NOT'=>$userID)))) {
				$errorMsg = 'User with this email address is already registered with us';
			}
			if(!$errorMsg) {
				$data['User']['id'] = $userID;
				if ($this->User->save($data)) {
					$this->Session->setFlash('Account Updated Successfully', 'default', array('class'=>'success'));
					$this->redirect('/admin/users/');
				}
				else {
					$this->Session->setFlash('An error occurred while communicating with the server', 'default', array('class'=>'error'));
				}
			}
		}
		else {
			$this->data = $userInfo;
		}
		$this->set('errorMsg', $errorMsg);
		$this->set('userInfo', $userInfo);
	}

	function createProfile() {
		$this->set('title_for_layout', 'Create Profile');
		$errorMsg = array();
		if($this->request->isPut()) {
			$data = $this->request->data;
			$data['User']['id'] = $this->Session->read('User.id');
			$data['User']['type'] = $this->Session->read('User.type');
			$errorMsg = $this->validateData($data);

			if(!$errorMsg) {
				$data['User']['has_completed_profile'] = true;
				$data = $this->sanitizeData($data);

				if($this->User->save($data)) {
					$userInfo = $this->User->read();
					if(!empty($data['Image']['file']['name'])) {
						// upload user image
						$results = $this->uploadImage($data);
						if($results['errorMsg']) {
							$errorMsg = $results['errorMsg'];
							$this->Session->setFlash('Image could not be uploaded: '.$errorMsg, 'default', array('class'=>'error'));
							$userInfo = $this->User->read();
							$this->Session->write('User', $userInfo['User']);
							$this->redirect('/users/editProfile');
						}
						else {
							$imageID = $results['imageID'];
							$tmp['User']['id'] = $userInfo['User']['id'];
							$tmp['User']['image_id'] = $imageID;
							$this->User->save($tmp);
							$userInfo = $this->User->read();
						}
					}
					$this->Session->write('User', $userInfo['User']);

					if($this->Session->read('User.type') == 'student') {
						$this->Session->setFlash('Congratulations! Your profile has been created.', 'default', array('class'=>'success'));
						// $this->redirect('/schoolclasses/classInfo');
						$this->redirect('/users/viewProfile');
					}
					else {
						$this->Session->setFlash('Congratulations! Your profile has been created.', 'default', array('class'=>'success'));
						$this->redirect('/users/viewProfile');
					}
				}
				else {
					$errorMsg[] = 'An error occurred while communicating with the server';
				}
			}
		}
		else {
			$userInfo['User'] = $this->Session->read('User');
			$this->data = $userInfo;
		}
		$errorMsg = implode('<br>', $errorMsg);
		$this->set(compact('errorMsg'));
	}

	function validateData($data) {
		$errorMsg = array();

		if(Validation::blank($data['User']['type'])) {
			$errorMsg[] = 'Select Member Type';
		}
		if(Validation::blank($data['User']['name'])) {
			$errorMsg[] = 'Enter Name';
		}
		if(Validation::blank($data['User']['phone'])) {
			$errorMsg[] = 'Enter Phone Number';
		}

		return $errorMsg;
	}

	function sanitizeData($data) {
		// Initialize & Sanitize data
		$data['User']['name'] = (isset($data['User']['name'])) ? htmlentities($data['User']['name'], ENT_QUOTES) : null;
		$data['User']['phone'] = (isset($data['User']['phone'])) ? htmlentities($data['User']['phone'], ENT_QUOTES) : null;
		$data['User']['address'] = (isset($data['User']['address'])) ? htmlentities($data['User']['address'], ENT_QUOTES) : null;
		$data['User']['city'] = (isset($data['User']['city'])) ? htmlentities($data['User']['city'], ENT_QUOTES) : null;
		$data['User']['state'] = (isset($data['User']['state'])) ? htmlentities($data['User']['state'], ENT_QUOTES) : null;
		$data['User']['country'] = (isset($data['User']['country'])) ? htmlentities($data['User']['country'], ENT_QUOTES) : null;
		$data['User']['pincode'] = (isset($data['User']['pincode'])) ? htmlentities($data['User']['pincode'], ENT_QUOTES) : null;
		$data['User']['profession'] = (isset($data['User']['profession'])) ? htmlentities($data['User']['profession'], ENT_QUOTES) : null;
		$data['User']['organization'] = (isset($data['User']['organization'])) ? htmlentities($data['User']['organization'], ENT_QUOTES) : null;

		$data['User']['passout_year'] = (isset($data['User']['passout_year'])) ? $data['User']['passout_year'] : null;
		$data['User']['subjects'] = (isset($data['User']['subjects'])) ? htmlentities($data['User']['subjects'], ENT_QUOTES) : null;
		$data['User']['service_start_year'] = (isset($data['User']['service_start_year'])) ? $data['User']['service_start_year'] : null;
		$data['User']['service_end_year'] = (isset($data['User']['service_end_year'])) ? $data['User']['service_end_year'] : null;
		$data['User']['current_profession'] = (isset($data['User']['current_profession'])) ? htmlentities($data['User']['current_profession'], ENT_QUOTES) : null;
		//$data['User']['amount_paid'] = (isset($data['User']['amount_paid'])) ? ((float)$data['User']['amount_paid']) : 0;

		return $data;
	}

	function viewProfile($userID = null) {
		$this->set('title_for_layout', 'My Profile');
		$userInfo['User'] = $this->Session->read('User');


		$this->set(compact('userInfo'));
	}


	function editProfile($userID = null) {
		$this->set('title_for_layout', 'Create Profile');

		$userInfo['User'] = $this->Session->read('User');
		$method = $this->request->isPut();
		if(!empty($userID)) {
			$method = $this->request->isPut();
			$userInfo = $this->User->findById($userID);
			if(empty($userInfo)) {
				$this->Session->setFlash('Profile not found', 'default', array('class'=>'error'));
				$this->redirect('/');
			}
		}

		$errorMsg = array();
		if($method) {
			$data = $this->request->data;
			$data['User']['id'] = $userInfo['User']['id'];
			$data['User']['type'] = $userInfo['User']['type'];

			$errorMsg = $this->validateData($data);

			if(!$errorMsg) {
				$data = $this->sanitizeData($data);

				if($this->User->save($data)) {
					$userInfo = $this->User->read();

					// upload user image
					if(!empty($data['Image']['file']['name'])) {
						$results = $this->uploadImage($data);
						if($results['errorMsg']) {
							$errorMsg = $results['errorMsg'];
							$this->Session->setFlash('Image could not be uploaded: '.$errorMsg, 'default', array('class'=>'error'));
							$this->redirect('/users/editProfile');
						}
						else {
							$imageID = $results['imageID'];
							$tmp['User']['id'] = $userInfo['User']['id'];
							$tmp['User']['image_id'] = $imageID;
							$this->User->save($tmp);
							$userInfo = $this->User->read();
						}
					}

					$this->Session->write('User', $userInfo['User']);

					if($this->Session->read('User.type') == 'student') {
						$this->Session->setFlash('Your profile has been modified.', 'default', array('class'=>'success'));
						$this->redirect('/users/viewProfile');
						// $this->redirect('/schoolclasses/classInfo');
					}
					else {
						$this->Session->setFlash('Your profile has been modified.', 'default', array('class'=>'success'));
						$this->redirect('/users/viewProfile');
					}
				}
				else {
					$errorMsg[] = 'An error occurred while communicating with the server';
				}
			}
		}
		else {
			$this->data = $userInfo;
		}
		$errorMsg = implode('<br>', $errorMsg);
		$this->set(compact('errorMsg', 'userInfo'));
	}

	function changePrivacySettings() {
		$this->set('title_for_layout', 'Privacy Settings');

		$userID = $this->Session->read('User.id');

		App::uses('PrivacySetting', 'Model');
		$this->PrivacySetting = new PrivacySetting;
		$pSettings = $this->PrivacySetting->findByUserId($userID);
		if(empty($pSettings)) {
			$this->Session->setFlash('Privacy settings not found for this profile', 'default', array('class'=>'error'));
			$this->redirect('/users/viewProfile');
		}

		$errorMsg = array();
		if($this->request->isPost()) {
			$data = $this->request->data;
			$data['PrivacySetting']['id'] = $pSettings['PrivacySetting']['id'];
			if($this->PrivacySetting->save($data)) {
				$tmp = $this->PrivacySetting->read();
				$this->Session->write('PrivacySetting', $tmp['PrivacySetting']);
				$this->Session->setFlash('Your privacy settings have been changed.', 'default', array('class'=>'success'));
				$this->redirect('/users/viewProfile');
			}
			else {
				$this->Session->setFlash('An error occurred while communicating with the server', 'default', array('class'=>'success'));
				$errorMsg[] = 'An error occurred while communicating with the server';
			}
		}
		$this->data = $pSettings;
		$errorMsg = implode('<br>', $errorMsg);
		$this->set(compact('errorMsg', 'pSettings'));
	}

	function contactus() {
		$errorMsg = array();
		if ($this->request->is('post')) {
			$data = $this->request->data;

			if(!$this->Session->check('User')) {
				// Validate name
				if(Validation::blank($data['User']['name'])) {
					$errorMsg[] = 'Enter your name';
				}

				// validate user email
				if(Validation::blank($data['User']['email'])) {
					$errorMsg[] = 'Enter Email Address';
				}
				elseif(!(Validation::email($data['User']['email']))) {
					$errorMsg[] = 'Invalid Email Address';
				}
			}
			else {
				$data['User']['name'] = $this->Session->read('User.name');
				$data['User']['email'] = $this->Session->read('User.email');
			}
			// Validate message
			if(Validation::blank($data['User']['message'])) {
				$errorMsg[] = 'Message field cannot be empty';
			}

			if(empty($errorMsg)) {
				try {
					$mailContent = '
Dear Admin,

A person has tried to contact you on '.Configure::read('Domain').'.

Contact Details:
----------------------------------------
Name: '.$data['User']['name'].'
Email: '.$data['User']['email'].'
Message: '.$data['User']['message'].'


-
'.Configure::read('Domain').'

*This is a system generated message. Please do not reply.

';
					$supportEmail = Configure::read('SupportEmail');
					$supportEmail2 = Configure::read('SupportEmail2');
					$email = new CakeEmail();
					$email->from(array('noreply@bhelhss.com' => 'bhelhss.com'));
					$email->replyTo(array($data['User']['email'] => $data['User']['name']));
					$email->to($supportEmail);
					$email->bcc($supportEmail2);
					$email->subject('Contact Us');
					$email->send($mailContent);

					$this->Session->setFlash('Your message has been sent successfully.', 'default', array('class'=>'success'));
					$this->redirect('/pages/contactus_message_sent');
				}
				catch(Exception $ex) {
					$this->Session->setFlash('An error occurred while communicating with the server. Please try again.', 'default', array('class'=>'error'));
				}
			}
		}
		$errorMsg = implode('<br>', $errorMsg);
		$this->set('errorMsg', $errorMsg);
		$this->set('title_for_layout', 'Contact Us');
	}

	function uploadImage($data) {
		$status = array();
		$imageID = null;
		$errorMsg = null;

		// upload image
		if(!empty($data['Image']['file']['name']))
		{
			if(!$this->isValidImageSize($data['Image']['file']['size'])) {
				$errorMsg =  'Image size exceeded '.Configure::read('MaxImageSize').'Mb limit';
			}
			elseif(!$this->isValidImage($data['Image']['file'])) {
				$errorMsg = 'Not a valid image';
			}
			else {
				App::import('Controller', 'Images');
				$Images = new ImagesController;
				$Images->constructClasses();
				$imageID = $Images->uploadImage($data['Image']['file']);
				$tmp['Image']['id'] = $imageID;
				$tmp['Image']['uploaded_by'] = $this->Session->read('User.id');
				App::uses('Image', 'Model');
				$this->Image = new Image;
				if(!$this->Image->save($tmp))
				{
					$Images->delete($imageID);
					$errorMsg = 'Image could not be uploaded';
				}
			}
		}
		else
		{
			$errorMsg = 'Select an Image to upload';
		}

		$status['errorMsg'] = $errorMsg;
		$status['imageID'] = $imageID;
		return $status;
	}

	function _removeUserPhoto($encodedImageID = null) {
		if($encodedImageID) {
			$imageID = base64_decode($encodedImageID);
		}
		else {
			$imageID = $this->Session->read('User.image_id');
		}
		$this->deleteImage($imageID);
		return true;
	}

	function removePhoto() {
		$this->_removeUserPhoto();
		$this->User->id = $this->Session->read('User.id');
		$tmp['User']['id'] = $this->Session->read('User.id');
		$tmp['User']['image_id'] = null;
		$this->User->save($tmp);
		$userInfo = $this->User->read();
		$this->Session->write('User', $userInfo['User']);
		$this->redirect('/users/viewProfile');
	}

	function search() {
		$this->set('title_for_layout', 'Search');
		$type = 'student';

		if($this->request->isPost()) {
			$data = $this->request->data;
			$conditions = null;
			if(isset($data['User']['type']) and !empty($data['User']['type'])) {
				$type = $data['User']['type'];
				$conditions[] = array('User.type'=>$type);
			}
			else {
				$conditions[] = array('User.type'=>$type);
			}
			if(isset($data['User']['batch']) and !empty($data['User']['batch'])) {
				$batch = $data['User']['batch'];

				if($type != 'student') {
					$conditions[] = array('User.service_start_year <='=>$batch);
					$conditions[] = array('User.service_end_year >='=>$batch);
				}
				else {
					$conditions[] = array('User.batch'=>$batch);
				}
			}
			if(isset($data['User']['name']) and !empty($data['User']['name'])) {
				$name = '%'.Sanitize::paranoid($data['User']['name'], array(' ')).'%';
				$conditions[] = array('User.name LIKE '=>$name);
			}
			$this->User->bindModel(array('hasOne'=>array('PrivacySetting')));
			$users = $this->User->find('all', array('conditions'=>$conditions, 'order'=>array('User.batch DESC', 'User.class DESC', 'User.section ASC', 'User.name ASC', 'User.passout_year DESC' )));
		}
		$this->set(compact('users', 'batch', 'type'));
	}

	function studentsDirectory() {
		if($this->request->isPost()) {
			$data = $this->request->data;
			$batch = $data['User']['batch'];

			$this->User->bindModel(array('hasOne'=>array('PrivacySetting')));
			$users = $this->User->find('all', array('conditions'=>array('User.batch'=>$batch), 'order'=>array('User.passout_year DESC', 'User.class DESC', 'User.section ASC', 'User.name ASC')));
			$this->set(compact('users', 'batch'));
		}
	}

	function info($userID) {
		if($userInfo = $this->User->findById($userID)) {
			App::uses('PrivacySetting', 'Model');
			$this->PrivacySetting = new PrivacySetting;
			$this->PrivacySetting->recursive = -1;
			$privacySettings = $this->PrivacySetting->findByUserId($userID);

			$this->set(compact('userID', 'userInfo', 'privacySettings'));
		}
		else {
			$this->Session->setFlash('Member not found', 'default', array('class'=>'error'));
			$this->redirect($this->request->referer());
		}
	}

	function sendMessage($userID) {
		if(!$userInfo = $this->User->findById($userID)) {
			$this->Session->setFlash('Member not found', 'default', array('class'=>'error'));
			$this->redirect($this->request->referer());
		}

		$errorMsg = array();
		if ($this->request->is('post')) {
			$data = $this->request->data;


			$fromUserName = $this->Session->read('User.name');
			$fromUserEmail = $this->Session->read('User.email');

			$toUserName = $userInfo['User']['name'];
			$toUserEmail = $userInfo['User']['email'];

			// Validate message
			if(Validation::blank($data['User']['message'])) {
				$errorMsg[] = 'Message field cannot be empty';
			}

			if(empty($errorMsg)) {
				try {
					$mailContent = '
Dear '.$toUserName.',

A person has tried to contact you on '.Configure::read('Domain').'.

Contact Details:
----------------------------------------
Name: '.$fromUserName.'
Email: '.$fromUserEmail.'
Message: '.htmlentities($data['User']['message']).'


-
'.Configure::read('Domain').'

*This is a system generated message. Please do not reply.

';
					$supportEmail = Configure::read('SupportEmail');
					$email = new CakeEmail();
					$email->from(array('noreply@bhelhss.com' => 'bhelhss.com'));
					$email->replyTo(array($fromUserEmail => $fromUserName));
					$email->to(array($toUserEmail=>$toUserName));
					$email->subject('Message from '.$fromUserName);
					$email->send($mailContent);

					$this->Session->setFlash('Your message has been sent successfully.', 'default', array('class'=>'success'));
					$this->redirect('/users/sendMessage/'.$userID);
				}
				catch(Exception $ex) {
					$this->Session->setFlash('An error occurred while communicating with the server. Please try again.', 'default', array('class'=>'error'));
				}
			}
		}
		$title_for_layout = 'Contact Member';
		$errorMsg = implode('<br>', $errorMsg);
		$this->set(compact('userID', 'userInfo', 'title_for_layout', 'errorMsg'));
	}

	function membersList() {
		$this->checkModerator();

		$users = $this->User->find('all', array('order'=>'User.created ASC'));
		$this->set(compact('users'));
	}

	function subscribe() {
		if($this->request->isPost() or $this->request->isPut()) {
			$data = $this->request->data;
			$data['User']['id'] = $this->Session->read('User.id');
			$this->User->save($data);
			$this->Session->setFlash('Your information has been successfully updated.', 'default', array('class'=>'success'));
			$this->redirect('/users/subscribe');
		}
		else {
			$this->User->recursive = -1;
			$this->data = $this->User->findById($this->Session->read('User.id'));
		}
	}

	public function add_member()
	{
		$errorMsg = '';
		$this->layout = 'hss';

		if ($this->request->is('post')) {
			$data = $this->request->data;
			$response = $this->save_registration_data($data);

			if ($response['success']) {
				$this->Flash->set('Member information saved successfully.', ['element' => 'success']);
				$this->redirect('/AlumniMembers/');
			}

			$errorMsg = $response['errors'];
		}

		$this->set(compact('errorMsg'));
	}


	public function edit_member($alumiMemberId)
	{
		$errorMsg = '';
		$this->layout = 'hss';

		$alumiMemberModel = new AlumniMember();

		$alumniMemberInfo = $alumiMemberModel->findById($alumiMemberId);

		if (empty($alumniMemberInfo)) {
			$this->Flash->set('Member not found.', ['element' => 'error']);
			$this->redirect('/AlumniMembers/');
		}

		if ($this->request->is('post')) {
			$data = $this->request->data;
			$data['User']['id'] = $alumiMemberId;
			$response = $this->save_registration_data($data);

			if ($response['success']) {
				$this->Flash->set('Member information saved successfully.', ['element' => 'success']);
				$this->redirect('/AlumniMembers/');
			}

			$errorMsg = $response['errors'];
		} else {
			$user['User'] =  $alumniMemberInfo['AlumniMember'];
			$this->data = $user;
		}

		$this->set(compact('errorMsg'));
	}
}
?>
