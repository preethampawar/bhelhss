<?php
App::uses('CakeEmail', 'Network/Email');
App::uses('AlumniMember', 'Model');
App::uses('ContactMessage', 'Model');
App::uses('Payment', 'Model');
App::uses('Post', 'Model');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

class HssController extends AppController
{
	private $allowedMethods = [
		'about_us',
		'about_school',
		'news_and_events',
		'contact_us',
		'contact_message_sent',
		'alumni_member_login',
		'alumni_member_login_verification',
		'register',
		'alumni_member_registration_verification',
		'getcaptcha',
		'gallery',
		'testEmail',
	];

	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow(); // Letting users register themselves
		$alumniMemberInfo = $this->Session->read('AlumniMember');
		$userInfo = $this->Auth->user();

		// wrapper to allow pubic pages and access to allow alumni members bypassing CakePHP Auth
		if (!in_array($this->action, $this->allowedMethods)
			&& empty($alumniMemberInfo) && empty($userInfo)) {
			$this->redirect('/hss/alumni_member_login');
		}

		$this->layout = 'hss';
	}

	public function about_us()
	{

	}

	public function about_school()
	{
		$slug = 'about-school';
		$postModel = new Post();
		$postModel->bindModel(['hasMany' => ['Image']]);
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
			'limit' => 200
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
				$this->Flash->set('Thank you for contacting us. We will get back to you at the earliest.', ['element' => 'success']);
				$this->redirect('/hss/contact_message_sent');
			}

			$errorMsg = $response['errors'];
		}

		$this->set(compact('errorMsg'));
	}

	private function save_contactus_data($data)
	{
		$contactMessage = new ContactMessage();
		$errorMsg = array();
		$response['success'] = false;
		$response['errors'] = '';
		$response['memberInfo'] = null;

		// Validations

		// validate user email
		if (Validation::blank($data['User']['name'])) {
			$errorMsg[] = 'Enter Name.';
		} elseif (Validation::blank($data['User']['email'])) {
			$errorMsg[] = 'Enter Email Address.';
		} elseif (!(Validation::email($data['User']['email']))) {
			$errorMsg[] = 'Invalid Email Address.';
		} elseif (Validation::blank($data['User']['message'])) {
			$errorMsg[] = 'Enter message.';
		}

		//validate captcha
		if (isset($data['Image']['captcha'])) {
			$captcha = $this->Session->read('captcha');

			if ($captcha || empty($data['Image']['captcha'])) {
				if ($data['Image']['captcha'] != $captcha) {
					$errorMsg[] = 'Invalid Captcha.';
				}
			} else {
				$errorMsg[] = 'Captcha is empty or not valid.';
			}
		}

		if (empty($errorMsg)) {
			$data = $this->sanitizeData($data);
		}

		if (empty($errorMsg)) {
			$data['ContactMessage'] = $data['User'];
			$data['ContactMessage']['id'] = null;

			if ($contactMessage->save($data)) {
				$response['success'] = true;
				$contactInfo = $contactMessage->read();
				$response['memberInfo'] = $contactInfo;
				$userName = $contactInfo['ContactMessage']['name'];
				$userEmail = $contactInfo['ContactMessage']['email'];
				$adminEmail = 'admin@bhelhss.com';

				$mailContent = '
Dear ' . $userName . ',
<br><br>
Thank you for contacting BHEL HSS Alumni. We will get back to you as soon as possible.
<br><br>
-<br>
' . Configure::read('Domain') . '
<br><br>

*This is a system generated message. Please do not reply.

';
				$email = new CakeEmail('smtpNoReply');
				$email->to($adminEmail);
				$email->subject('Contact message');
				$email->emailFormat('html');
				$email->send($mailContent);

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

	private function sanitizeContactUsData($data)
	{
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

	public function alumni_member_login()
	{
		$errorMsg = [];

		if ($this->request->is('post')) {
			$data = $this->request->data;

			if (Validation::blank($data['User']['email'])) {
				$errorMsg[] = 'Enter Email Address.';
			} elseif (!Validation::email($data['User']['email'])) {
				$errorMsg[] = 'Enter Valid Email Address.';
			}
//			if (Validation::blank($data['User']['phone'])) {
//				$errorMsg[] = 'Enter Phone Number.';
//			}

			$emailAddress = $data['User']['email'];
//			$phoneNumber = $data['User']['phone'];

			$alumniMember = new AlumniMember();
			$memberInfo = $alumniMember->find('first', ['conditions' => ['AlumniMember.email' => $emailAddress]]);

			if ($memberInfo) {
				$otp = rand(1000, 9999);
				$this->Session->write('LoginOtp', $otp);
				$this->Session->write('AlumniMemberNotVerified', $memberInfo['AlumniMember']);

				// send otp in email / sms
				$userName = $memberInfo['AlumniMember']['name'];
				$userEmail = $memberInfo['AlumniMember']['email'];

				$mailContent = '
Dear ' . $userName . ',
<br><br>
Your login OTP is <b>' . $otp . '</b>.
<br><br>
-<br>
' . Configure::read('Domain') . '
<br><br>

*This is a system generated message. Please do not reply.

';
				$email = new CakeEmail('smtpNoReply');
				$email->emailFormat('html');
				$email->to([$userEmail => $userEmail]);
				$email->subject('Login OTP - ' . $otp);
				$email->send($mailContent);


				$this->redirect('/hss/alumni_member_login_verification');
			} else {
				$errorMsg[] = 'User not found.';
			}
		}

		if (count($errorMsg) > 0) {
			$errorMsg = implode('<br/>', $errorMsg);
		}

		$this->set(compact('errorMsg'));
	}

	public function alumni_member_login_verification()
	{
		$errorMsg = '';
		$otp = $this->Session->read('LoginOtp');
		$alumniMemberNotVerified = $this->Session->read('AlumniMemberNotVerified');

		if (empty($alumniMemberNotVerified) || empty($otp)) {
			$this->redirect('/hss/alumni_member_login');
		}

		if ($this->request->is('post')) {
			$data = $this->request->data;

			if (Validation::blank($data['User']['otp'])) {
				$errorMsg = 'Enter OTP.';
			} elseif ($otp != $data['User']['otp']) {
				$errorMsg = 'Invalid OTP.';
			}

			if (empty($errorMsg)) {
				$this->Session->write('AlumniMember', $alumniMemberNotVerified);
				$this->Session->delete('LoginOtp');
				$this->Session->delete('AlumniMemberNotVerified');

				$this->Flash->set('You are logged in successfully.', ['element' => 'success']);
				$this->redirect('/');
			}
		}

		$this->set(compact('errorMsg'));
	}

	public function alumni_member_profile()
	{
		$errorMsg = '';
		$tmp['User']['name'] = $this->Session->read('AlumniMember.name');
		$tmp['User']['phone'] = $this->Session->read('AlumniMember.phone');
		$tmp['User']['email'] = $this->Session->read('AlumniMember.email');
		$tmp['User']['type'] = $this->Session->read('AlumniMember.type');
		$tmp['User']['passout_class'] = $this->Session->read('AlumniMember.passout_class');
		$tmp['User']['passout_section'] = $this->Session->read('AlumniMember.passout_section');
		$tmp['User']['passout_year'] = $this->Session->read('AlumniMember.passout_year');

		if ($this->request->is('post')) {
			$data = $this->request->data;
			$data['User']['id'] = $this->Session->read('AlumniMember.id');
			$errorMsg = $this->validateRegistrationData($data);

			if (empty($errorMsg)) {
				$response = $this->save_registration_data($data);

				if ($response['success']) {
					$this->Flash->set('Your profile has been updated successfully.', ['element' => 'success']);
					$this->redirect('/hss/alumni_member_profile/');
				}

				$errorMsg = $response['errors'];
			}
		} else {
			$this->data = $tmp;
		}

		$this->set(compact('errorMsg'));
	}

	public function registration_payment_details()
	{
		$payments = null;
		$paymentModel = new Payment();
		$alumniMemberId = $this->Session->read('AlumniMember.id');
		$conditions = [
			'Payment.alumni_member_id' => $alumniMemberId,
			'Payment.type' => 'event_registration_fee',
		];

		if ($alumniMemberId) {
			$payments = $paymentModel->find('all', ['conditions' => $conditions]);
		}

		$this->set(compact('payments'));
	}

	public function donation_details()
	{
		$payments = null;
		$paymentModel = new Payment();
		$alumniMemberId = $this->Session->read('AlumniMember.id');
		$conditions = [
			'Payment.alumni_member_id' => $alumniMemberId,
			'Payment.type' => 'donation',
		];

		if ($alumniMemberId) {
			$payments = $paymentModel->find('all', ['conditions' => $conditions]);
		}

		$this->set(compact('payments'));
	}

	public function register()
	{
		$errorMsg = '';

		if ($this->request->is('post')) {
			$data = $this->request->data;
			$this->Session->delete('AlumniMemberRegistration');
			$this->Session->write('AlumniMemberRegistration.User', $data['User']);
			$errorMsg = $this->validateRegistrationData($data);

			if (empty($errorMsg)) {
				$otp = rand(1000, 9999);
				$userName = $data['User']['name'];
				$userEmail = $data['User']['email'];

				$mailContent = '
Dear ' . $userName . ',
<br><br>
Your registration OTP is <b>' . $otp . '</b>.
<br><br>
-<br>
' . Configure::read('Domain') . '
<br><br>

*This is a system generated message. Please do not reply.

';
				$email = new CakeEmail('smtpNoReply');
				$email->emailFormat('html');
				$email->to([$userEmail => $userEmail]);
				$email->subject('Registration OTP - ' . $otp);
				$email->send($mailContent);

				$this->Session->delete('AlumiMemberRegistrationOTP');
				$this->Session->write('AlumiMemberRegistrationOTP', $otp);

				$this->Flash->set('An OTP has been sent to your email address ("' . $userEmail . '").
				Please enter OTP to verify your account.', ['element' => 'notice']);

				$this->redirect('/hss/alumni_member_registration_verification/');
			}
		}

		if (!empty($errorMsg) && is_array($errorMsg)) {
			$errorMsg = implode('<br/>', $errorMsg);
		}

		$this->set(compact('errorMsg'));
	}

	public function alumni_member_registration_verification()
	{
		$errorMsg = '';
		$otp = $this->Session->read('AlumiMemberRegistrationOTP');
		$alumniMemberData = $this->Session->read('AlumniMemberRegistration');

		if (empty($otp) || empty($alumniMemberData)) {
			$this->redirect('/hss/register');
		}

		if ($this->request->is('post')) {
			$data = $this->request->data;

			if (Validation::blank($data['User']['otp'])) {
				$errorMsg = 'Enter OTP.';
			} elseif ($otp != $data['User']['otp']) {
				$errorMsg = 'Invalid OTP.';
			}

			if (empty($errorMsg)) {
				$response = $this->save_registration_data($alumniMemberData);

				if ($response['success']) {
					$memberInfo['AlumniMember'] = $response['AlumniMember'];
					$this->sendRegistrationSuccessEmail($memberInfo);
					$this->Session->delete('AlumiMemberRegistrationOTP');
					$this->Session->delete('AlumniMemberRegistration');
					$this->Session->write('AlumniMember', $response['AlumniMember']);
					$this->Flash->set('Your profile has been created successfully.', ['element' => 'success']);
					$this->redirect('/hss/event_registration/');
				} else {
					$errorMsg = $response['errors'];
				}
			}
		}

		$this->set(compact('errorMsg', 'alumniMemberData'));

	}

	public function add_member()
	{
		$errorMsg = '';
		$this->layout = 'hss';

		if ($this->request->is('post')) {
			$data = $this->request->data;
			$errorMsg = $this->validateRegistrationData($data);

			if (empty($errorMsg)) {
				$response = $this->save_registration_data($data);

				if ($response['success']) {
					$this->Flash->set('Member information saved successfully.', ['element' => 'success']);
					$this->redirect('/hss/alumni_members');
				} else {
					$errorMsg = $response['errors'];
				}
			}
		}

		if (!empty($errorMsg) && is_array($errorMsg)) {
			$errorMsg = implode('<br/>', $errorMsg);
		}

		$this->set(compact('errorMsg'));
	}

	public function member_details($alumiMemberId)
	{
		$errorMsg = '';
		$this->layout = 'hss';

		$alumiMemberModel = new AlumniMember();
		$alumniMemberInfo = $alumiMemberModel->findById($alumiMemberId);

		if (empty($alumniMemberInfo)) {
			$this->Flash->set('Member not found.', ['element' => 'error']);
			$this->redirect('/hss/alumni_members');
		}

		$user['User'] = $alumniMemberInfo['AlumniMember'];
		$this->data = $user;

		$this->set(compact('errorMsg'));
	}

	public function edit_member($alumiMemberId)
	{
		$errorMsg = '';
		$this->layout = 'hss';

		$alumiMemberModel = new AlumniMember();

		$alumniMemberInfo = $alumiMemberModel->findById($alumiMemberId);
		$paymentVerifiedPreviously = $alumniMemberInfo['AlumniMember']['payment_confirmed'];

		if (empty($alumniMemberInfo)) {
			$this->Flash->set('Member not found.', ['element' => 'error']);
			$this->redirect('/hss/alumni_members');
		}

		if ($this->request->is('post')) {
			$data = $this->request->data;
			$data['User']['id'] = $alumiMemberId;
			$errorMsg = $this->validateRegistrationData($data);

			if (empty($errorMsg)) {
				$response = $this->save_registration_data($data);

				if ($response['success']) {
					if (!$paymentVerifiedPreviously && ((bool)$data['User']['payment_confirmed'])) {
						$mailContent = '
Dear ' . $alumniMemberInfo['AlumniMember']['name'] . ',
<br><br>
Your payment towards Reunion-2024 event has been verified successfully.
<br><br>
-<br>
' . Configure::read('Domain') . '
<br><br>

*This is a system generated message. Please do not reply.

';
						$email = new CakeEmail('smtpNoReply');
						$email->to($alumniMemberInfo['AlumniMember']['email']);
						$email->subject('Payment verified successfully');
						$email->emailFormat('html');
						$email->send($mailContent);
					}

					$this->Flash->set('Member information saved successfully.', ['element' => 'success']);
					$this->redirect('/hss/alumni_members');
				}

				$errorMsg = $response['errors'];
			}
		} else {
			$user['User'] = $alumniMemberInfo['AlumniMember'];
			$this->data = $user;
		}

		$this->set(compact('errorMsg'));
	}

	public function payments($paymentType = null)
	{
		$payments = null;
		$paymentModel = new Payment();
		// $alumniMemberId = $this->Session->read('AlumniMember.id');
		$conditions = [];
		$download = false;

		if (strtolower($paymentType) == 'download') {
			$download = true;
			$paymentType = null;
			ini_set('max_execution_time', '10000');
			ini_set('memory_limit', '1024M');

			$fileName = 'Payments-all' . '-' . time() . '.csv';
			$this->layout = 'ajax';

			$this->response->compress();
			$this->response->type('csv');
			$this->response->download($fileName);

		}

		if ($paymentType == 'Event-Fees' || $paymentType == 'Donations') {
			if ($paymentType == 'Event-Fees') {
				$type = 'event_registration_fee';
			}
			if ($paymentType == 'Donations') {
				$type = 'donation';
			}
			$conditions = [
				'Payment.type' => $type,
			];
		}
		$payments = $paymentModel->find('all', ['conditions' => $conditions]);

		$this->set(compact('payments', 'paymentType', 'download'));
	}

	public function member_payments($alumniMemberId)
	{
		$payments = null;
		$alumniMemberModel = new AlumniMember();
		$alumniMemberInfo = $alumniMemberModel->findById($alumniMemberId);

		if (empty($alumniMemberInfo)) {
			$this->Flash->set('Member information not found.', ['element' => 'error']);
			$this->redirect('/hss/alumni_members');
		}

		$paymentModel = new Payment();
		// $alumniMemberId = $this->Session->read('AlumniMember.id');
		$conditions = [
			'Payment.alumni_member_id' => $alumniMemberId,
			//'Payment.type' => 'event_registration_fee',
		];

		if ($alumniMemberId) {
			$payments = $paymentModel->find('all', ['conditions' => $conditions]);
		}

		$this->set(compact('alumniMemberInfo', 'payments'));
	}

	public function update_member_payment($paymentId)
	{
		$errorMsg = '';
		$this->layout = 'hss';
		$paymentModel = new Payment();
		$paymentInfo = $paymentModel->findById($paymentId);

		if (empty($paymentInfo)) {
			$this->Flash->set('Payment information not found.', ['element' => 'error']);
			$this->redirect('/hss/alumni_members');
		}

		if ($this->request->is('post')) {
			$data = $this->request->data;

			if (Validation::blank($data['Payment']['verified_amount'])) {
				$errorMsg = 'Enter Credited Amount.';
			} elseif (!Validation::decimal($data['Payment']['verified_amount'])) {
				$errorMsg = 'Invalid Amount.';
			}

			if (empty($errorMsg)) {
				$data['Payment']['id'] = $paymentId;
				if ($paymentModel->save($data)) {
					$paymentInfo = $paymentModel->read();
					$memberId = $paymentInfo['AlumniMember']['id'];
					$memberName = $paymentInfo['AlumniMember']['name'];
					$memberEmail = $paymentInfo['AlumniMember']['email'];

					if ($data['Payment']['send_email']) {
						$logoUrl = Configure::read('DomainUrl') . 'img/hss_logo_email_optimized.png';
						$associationName = 'BHEL HSS ALUMNI ASSOCIATION';
						$amount = (float)$paymentInfo['Payment']['verified_amount'];
						$paymentType = $paymentInfo['Payment']['type'];
						$body = '';

						$date = date('d-m-Y');
						$receiptNo = 'E-' . $paymentInfo['Payment']['id'];

						if ($paymentType == 'event_registration_fee') {
							$body = 'Received with thanks from Mr/Mrs/Ms. ' . $memberName . ', Rs. ' . $amount . '/- towards EUPHORIA-2024, BHEL HSS Alumni reunion event expenses.';
							$mailContent = '
Dear ' . $memberName . ',
<br><br>
Your payment towards Reunion-2024 event has been verified successfully. Below are your payment details.
<br><br><br>

<div style="padding: 15px; border-radius: 15px; border: 1px solid grey; background-color: #fbfbfb;">
	<table>
	<thead>
		<tr>
			<th style="width: 130px;"><img src="' . $logoUrl . '" alt="bhel-hss-logo" style="height:116px; width:120px;"></th>
			<th style="text-align: left;">' . $associationName . '</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="2"><br><p>Receipt No.: ' . $receiptNo . '</p></td>
		</tr>
		<tr>
			<td colspan="2">
				<p>' . $body . '</p>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p>Date: ' . $date . '</p>
				<p>Account Manager</p><br>
				<p><b>Note:</b> As this is a computer generated receipt, signature is not required.</p>
				<p>Also, please collect the physical copy of receipt on or before the event date, ie: 22-Dec-2024.</p>
			</td>
		</tr>
	</tbody>
	</table>
</div>
<br><br>
-<br>
' . Configure::read('Domain') . '
<br><br>

*This is a system generated message. Please do not reply.

';
						}

						if ($paymentType == 'donation') {
							$body = 'Received with thanks from Mr/Mrs/Ms. ' . $memberName . ', Rs. ' . $amount . '/- towards event expenses and developmental purposes of ' . $associationName . '.';
							$mailContent = '
Dear ' . $memberName . ',
<br><br>
Your donation towards event expenses and development of Alumni community has been verified successfully. Below are your payment details.
<br><br><br>

<div style="padding: 15px; border-radius: 15px; border: 1px solid grey; background-color: #fbfbfb;">
	<table>
	<thead>
		<tr>
			<th style="width: 130px;"><img src="' . $logoUrl . '" alt="bhel-hss-logo" style="height:116px; width:120px;"></th>
			<th style="text-align: left;">' . $associationName . '</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="2"><br><p>Receipt No.: ' . $receiptNo . '</p></td>
		</tr>
		<tr>
			<td colspan="2">
				<p>' . $body . '</p>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p>Date: ' . $date . '</p>
				<p>Account Manager</p><br>
				<p><b>Note:</b> As this is a computer generated receipt, signature is not required.</p>
			</td>
		</tr>
	</tbody>
	</table>
</div>
<br><br>
-<br>
' . Configure::read('Domain') . '
<br><br>

*This is a system generated message. Please do not reply.

';
						}

						$email = new CakeEmail('smtpNoReply');
						$email->to($memberEmail);
						//$email->cc(['accounts@bhelhss.com']);
						$email->cc(['preetham.pawar@gmail.com']);
						$email->subject('Payment verified successfully');
						$email->emailFormat('html');
						$email->send($mailContent);
					}

					$this->Flash->set('Payment information updated successfully.', ['element' => 'success']);
					$this->redirect('/hss/member_payments/' . $memberId);
				}

				$errorMsg = 'Some error occurred. Please try again.';
			}
		} else {
			$user['User'] = $paymentInfo['AlumniMember'];
			$this->data = $user;
		}

		$this->set(compact('errorMsg', 'paymentInfo'));
	}

	private function validateRegistrationData($data)
	{
		$alumniMember = new AlumniMember();
		$errorMsg = array();
		$userId = $data['User']['id'] ?? null;

		//validate captcha
		if (isset($data['Image']['captcha'])) {
			$captcha = $this->Session->read('captcha');

			if ($captcha || empty($data['Image']['captcha'])) {
				if ($data['Image']['captcha'] != $captcha) {
					$errorMsg[] = 'Invalid Captcha.';
				}
			} else {
				$errorMsg[] = 'Captcha is empty or not valid.';
			}
		}

		// validate user email
		if (empty($errorMsg)) {
			if (Validation::blank($data['User']['email'])) {
				$errorMsg[] = 'Enter Email Address.';
			} elseif (!(Validation::email($data['User']['email']))) {
				$errorMsg[] = 'Invalid Email Address.';
			} elseif ($userInfo = $alumniMember->findByEmail($data['User']['email'])) {
				if ($userInfo['AlumniMember']['id'] != $userId) {
					$errorMsg[] = 'User with this Email Address already exists.';
				}
			}
		}

		if (empty($errorMsg)) {
			$errorMsg = $this->validateData($data);
		}

		return $errorMsg;
	}

	private function save_registration_data($data)
	{
		$alumniMember = new AlumniMember();
		$errorMsg = [];
		$response['success'] = false;
		$response['errors'] = '';
		$response['memberInfo'] = null;
		$errorMsg = $this->validateRegistrationData($data);

		if (empty($errorMsg)) {
			$data = $this->sanitizeData($data);
			$data['AlumniMember'] = $data['User'];
			$data['AlumniMember']['id'] = $data['User']['id'] ?? null;
			$data['AlumniMember']['account_verified'] = true;

			if ($alumniMember->save($data)) {
				$memberInfo = $alumniMember->read();
				$this->Session->write('AlumniMember', $memberInfo['AlumniMember']);
				$response['success'] = true;
				$response['AlumniMember'] = $memberInfo['AlumniMember'];
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

	private function sendRegistrationSuccessEmail($alumniMemberInfo)
	{
		try {
			$userName = $alumniMemberInfo['AlumniMember']['name'];
			$userEmail = $alumniMemberInfo['AlumniMember']['email'];

			$mailContent = '
Dear ' . $userName . ',
<br><br>
You have successfully registered with BHEL HSS Alumni. Thanks for signing up with us.
<br><br>
-<br>
' . Configure::read('Domain') . '
<br><br>

*This is a system generated message. Please do not reply.

';
			$email = new CakeEmail('smtpNoReply');
			$email->to($userEmail);
			$email->subject('Registration successful');
			$email->emailFormat('html');
			$email->send($mailContent);

			return true;
		} catch (Exception $e) {

		}

		return false;
	}


	public function event_registration()
	{
		$memberInfo['AlumniMember'] = $this->Session->read('AlumniMember');

		if (!$memberInfo) {
			$this->redirect('/');
		}

		if ($this->request->is('post')) {
			$data = $this->request->data;
			$donationAmount = (float)($data['Donation']['paid_amount'] ?? 0);

			if (empty($data['Payment']['transaction_id']) && empty($data['Payment']['screenshot']['name'])) {
				$this->Flash->set('Please enter transaction UTR ID (or) Upload the payment receipt.', ['element' => 'error']);
			} else {
				$filename = '';

				if (!empty($data['Payment']['screenshot']['name'])) {
					$filename = $memberInfo['AlumniMember']['id'] .
						'_' . time() .
						'_' .
						basename($this->request->data['Payment']['screenshot']['name']);
					move_uploaded_file(
						$this->data['Payment']['screenshot']['tmp_name'],
						WWW_ROOT . DS . 'payments' . DS . $filename
					);
				}


				$paymentModel = new Payment();
				$data['Payment']['alumni_member_id'] = $memberInfo['AlumniMember']['id'];
				$data['Payment']['transaction_file'] = $filename;
				$paymentModel->save($data);

				if ($donationAmount > 0) {
					$eventFeePaymentInfo = $paymentModel->read();

					$tmp['Payment']['id'] = null;
					$tmp['Payment']['alumni_member_id'] = $eventFeePaymentInfo['AlumniMember']['id'];
					$tmp['Payment']['transaction_file'] = $eventFeePaymentInfo['Payment']['transaction_file'];;
					$tmp['Payment']['transaction_id'] = $eventFeePaymentInfo['Payment']['transaction_id'];
					$tmp['Payment']['parent_id'] = $eventFeePaymentInfo['Payment']['id'];
					$tmp['Payment']['paid_amount'] = (float)$data['Donation']['paid_amount'];
					$tmp['Payment']['type'] = 'donation';

					$paymentModel = new Payment();
					$paymentModel->save($tmp);
				}

				$this->Flash->set('Transaction details have been saved successfully.', ['element' => 'success']);
				$this->redirect('/hss/registration_success/');
			}
		}

		$this->set(compact('memberInfo'));
	}

	public function registration_success()
	{
		$memberInfo = $this->Session->read('AlumniMember');

		if (!$memberInfo) {
			$this->redirect('/');
		}

		if ($this->request->is('post')) {
			$data = $this->request->data;
			//debug($data);
			exit;
		}

		$this->set(compact('memberInfo'));
	}


	public function donations()
	{
		$memberInfo['AlumniMember'] = $this->Session->read('AlumniMember');

		if (!$memberInfo) {
			$this->redirect('/');
		}

		if ($this->request->is('post')) {
			$data = $this->request->data;

			if (empty($data['Payment']['transaction_id']) && empty($data['Payment']['screenshot']['name'])) {
				$this->Flash->set('Please enter transaction UTR ID (or) Upload the payment receipt.', ['element' => 'error']);
			} else {
				$filename = '';

				if (!empty($data['Payment']['screenshot']['name'])) {
					$filename = $memberInfo['AlumniMember']['id'] .
						'_' . time() .
						'_' .
						basename($this->request->data['Payment']['screenshot']['name']);
					move_uploaded_file(
						$this->data['Payment']['screenshot']['tmp_name'],
						WWW_ROOT . DS . 'payments' . DS . $filename
					);
				}

				$paymentModel = new Payment();
				$data['Payment']['alumni_member_id'] = $memberInfo['AlumniMember']['id'];
				$data['Payment']['transaction_file'] = $filename;
				$paymentModel->save($data);

				$this->Flash->set('Transaction details have been saved successfully.', ['element' => 'success']);
				$this->redirect('/hss/donation_success/');
			}
		}

		$this->set(compact('memberInfo'));
	}

	public function donation_success()
	{
		$memberInfo = $this->Session->read('AlumniMember');

		if (!$memberInfo) {
			$this->redirect('/');
		}

		if ($this->request->is('post')) {
			$data = $this->request->data;
			//debug($data);
			exit;
		}

		$this->set(compact('memberInfo'));
	}

	public function getcaptcha()
	{
		$this->layout = false;
		// Generate a random number
		// from 1000-9999
		$captcha = rand(1000, 9999);

		// The captcha will be stored
		// for the session
		$this->Session->write('captcha', $captcha);
		$tmp = str_split($captcha);
		$chars = ['', ' ', '  ', '   ', '    '];
		$captcha = '';
		foreach ($tmp as $char) {
			$randomCharIndex = rand(0, (count($chars) - 1));
			$randomChar = $chars[$randomCharIndex];
			$captcha .= $char . ' ' . $randomChar;

		}

		// Generate a 50x24 standard captcha image
		$im = imagecreatetruecolor(300, 75);

		// color
		$bg = imagecolorallocate($im, 100, 100, 100);

		// White color
		$fg = imagecolorallocate($im, 255, 255, 255);

		// Give the image a blue background
		imagefill($im, 0, 0, $bg);

		// Print the captcha text in the image
		// with random position & size
		imagestring($im, rand(4, 5), rand(5, 130),
			rand(5, 50), $captcha, $fg);

		// VERY IMPORTANT: Prevent any Browser Cache!!
		header("Cache-Control: no-store, no-cache, must-revalidate");

		// The PHP-file will be rendered as image
		header('Content-type: image/png');

		// Finally output the captcha as
		// PNG image the browser
		imagepng($im);

		// Free memory
		imagedestroy($im);

		exit;
	}

	private function validateData($data)
	{
		$errorMsg = array();

		if (Validation::blank($data['User']['type'])) {
			$errorMsg[] = 'Select Member Type';
		}
		if (Validation::blank($data['User']['name'])) {
			$errorMsg[] = 'Enter Name';
		}
		if (Validation::blank($data['User']['phone'])) {
			$errorMsg[] = 'Enter Phone Number';
		}

		return $errorMsg;
	}

	private function sanitizeData($data)
	{
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

		return $data;
	}

	public function logout()
	{
		$this->Session->destroy();
		$this->redirect('/hss/alumni_member_login');
	}

	public function gallery()
	{
		$hideFooter = true;

		$this->redirect('/img/gallery');

		$dir = new Folder(WWW_ROOT . 'img/gallery_page/');
		$files = $dir->findRecursive('.*\.jpg|.png|.jpeg|.gif|.bmp');

		$this->set(compact('hideFooter', 'files'));
	}

	public function testEmail()
	{

		$subject = 'Test Login OTP';

		$mailContent = '<p>Please use the below OTP to login.</p><p><b>0420</b></p><p><br>*Note: The above OTP is valid only for 15mins.</p><br><br>-<br>BHEL HSS LOCAL';
		$email = new CakeEmail('smtpNoReply');
		$email->emailFormat('html');
		$email->to(['preetham.pawar@gmail.com' => 'preetham.pawar@gmail.com']);
		$email->subject($subject);
		$email->send($mailContent);
		exit;
	}

	public function alumni_members($download = 0)
	{
		$this->AlumniMember = new AlumniMember();
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
		$paymentsModel = new Payment();
		$paymentsConfirmedCount = $paymentsModel->find('count', [
			'conditions' => ['Payment.payment_confirmed' => 1],
		]);

		// get total payments
		$totalPaymentsConfirmedCount = $paymentsModel->find('count', [
			//'conditions' => ['Payment.payment_confirmed' => 1],
		]);

		// get total accounts confirmed
		$accountsVerifiedCount = $this->AlumniMember->find('count', [
			'order' => ['AlumniMember.name'],
			'conditions' => ['AlumniMember.account_verified' => 1],
		]);

		$this->set(compact('alumniMembers', 'download', 'title_for_layout', 'allAlumniMembersCount', 'todaysAlumniMembersCount', 'paymentsConfirmedCount', 'accountsVerifiedCount', 'searchBy', 'totalPaymentsConfirmedCount'));
	}

	public function delete_member($alumniMemberId)
	{
		$this->AlumniMember = new AlumniMember();
		$this->AlumniMember->delete($alumniMemberId);

		$this->Flash->set('Member deleted successfully.', ['element' => 'success']);
		$this->redirect(array('action' => 'alumni_members'));
	}
}
