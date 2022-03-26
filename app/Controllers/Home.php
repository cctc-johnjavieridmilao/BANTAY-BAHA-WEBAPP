<?php namespace App\Controllers;

use App\Models\UserModel;

class Home extends BaseController
{
	public function index() {
		if($this->session->has('u_id')) {
			return view('User/Dashboard');
		}
		return view('index');
	}

	public function RegisterView() {
		if($this->session->has('u_id')) {
			return view('User/Dashboard');
		}
		return view('register');

	}

	public function VerifyOtp() {
		if($this->session->has('u_id')) {
			return view('User/Dashboard');
		}
		return view('VerifyOtp');

	}

	public function DashBoard() {
		if($this->session->has('u_id')) {
			return view('User/Dashboard');
		}
		return view('index');
	}

	public function Analytics() {
		if($this->session->has('u_id')) {
			return view('User/UserAnalytics');
		}
		return view('index');
	}


	public function Setting() {
		if($this->session->has('u_id')) {
			return view('User/Setting');
		}
		return view('index');
	}

	public function Announcement() {
		if($this->session->has('u_id')) {
			return view('User/Announcement');
		}
		return view('index');
	}

	public function GetProfile() {
		$user = $this->session->get('u_id');
		$user_model = new UserModel();

		return $this->response->setJSON($user_model->where('RecID', $user)->findAll());
	}

	public function SendOtp($number) {
		$ch = curl_init();

		$parameters = array(
			'apikey' => 'f3c50253fcb065c0cd20997ee40b6b1d', //Your API KEY
			'number' => $number,
			'message' => 'Your One Time Password is: {otp}. Please use it within 5 minutes.',
			'sendername' => 'SEMAPHORE'
		);
		
		curl_setopt( $ch, CURLOPT_URL,'https://api.semaphore.co/api/v4/otp' );
		curl_setopt( $ch, CURLOPT_POST, 1 );

		//Send the parameters set above with the request
		curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );

		// Receive response from server
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		$output = curl_exec( $ch );
		curl_close ($ch);

		//Show the server response
		return $output;
	}

	public function SendSmsOtp() {
		$result = $this->SendOtp('639750148734');

		$decode = json_decode($result, true);

		echo $decode[0]['code'];
	}

	public function RegisterAccount() {
		$user_model = new UserModel();

		$str = 'SELECT * FROM user_access WHERE phone_number = :phone_number:';

		$query = $this->db->query($str, [
			'phone_number' => $this->request->getVar('phone_number'),
		]);

		if($query->getNumRows() > 0) {
			return $this->response->setJSON(['msg' => 'Phone number alread used!']);
		} 

		$result = $this->SendOtp($this->request->getVar('phone_number'));

		$decode = json_decode($result, true);

		$OTP_CODE = $decode[0]['code'];

		$data = [
			'firtname'   => $this->request->getVar('fname'),
			'lastname'   => $this->request->getVar('lname'),
			'username'   => $this->request->getVar('username'),
			'email'      => $this->request->getVar('email'),
			'phone_number'  => $this->request->getVar('phone_number'),
			'middlename' => $this->request->getVar('mname'),
			'password'   => hashPassword($this->request->getVar('password')),
			'user_type'  => 'user',
			'lat'        => $this->request->getVar('lat'),
			'lang'       => $this->request->getVar('lang'),
			'created_at' => date('Y-m-d H:i:s'),
			'OtpCode'    => $OTP_CODE,
			'OtpDate'    => date('Y-m-d H:i:s'),
			'Status'     => 2,
			'address_id'    => $this->request->getVar('location'),
		];

		$res = $user_model->insert($data);

		$name = $this->request->getVar('fname') . ' ' . $this->request->getVar('mname') . ' ' . $this->request->getVar('lname');
		$user_id = $user_model->getInsertID();

		if($res) {

			$this->session->set('otp_phone_number', $this->request->getVar('phone_number'));
			$this->session->set('otp_user_id', $user_id);

			return $this->response->setJSON([
				'msg' => 'success',
				'user_type' => 'user',
				'email' => $this->request->getVar('email'),
				'username' => $this->request->getVar('username'),
				'phone_number' => $this->request->getVar('phone_number'),
				'name' => $name,
				'user_id' => $user_id
			]);
		}

		return $this->response->setJSON(['msg' => $res]);
	}

	public function ReSendCode() {
		$phone_number = $this->session->get('otp_phone_number');
		$otp_user_id = $this->session->get('otp_user_id');

		if(empty($phone_number)) {
			return $this->response->setJSON(['msg' => 'Phone number is required!']);
		}

		$result = $this->SendOtp($phone_number);

		$decode = json_decode($result, true);

		$OTP_CODE = $decode[0]['code'];

		$this->db->table('user_access')->where(['RecID' => $otp_user_id])->update([
			'OtpCode' => $OTP_CODE,
			'OtpDate' => date('Y-m-d H:i:s')
		]);

		return $this->response->setJSON(['msg' => 'success']);
	}

	public function VerifyOtpCode() {
		$code = $this->request->getVar('code');

		$str = 'SELECT * FROM user_access WHERE OtpCode = :code:';

		$query = $this->db->query($str, [
			'code' => $code,
		]);

		if(!$query) {
			return $this->response->setJSON(['msg' => $this->db->error()]);
		}

		if($query->getNumRows() == 0) {
			return $this->response->setJSON(['msg' => 'Invalid Verification Code!']);
		} 

		$this->db->table('user_access')->where(['OtpCode' => $code])->update([
			'Status' => 1
		]);

		return $this->response->setJSON(['msg' => 'success']);

	}
 
	public function Login() {
		$u_email = $this->request->getVar('u_email');
		$u_pass = hashPassword($this->request->getVar('u_pass'));
		$str = 'SELECT * FROM user_access WHERE (email = :email: OR username = :username:) AND password = :password: AND Status = 1';

		$query = $this->db->query($str, [
			'email' => $u_email,
			'username' => $u_email,
			'password' => $u_pass
		]);

		if(!$query) {
			return $this->response->setJSON(['msg' => $this->db->error()]);
		}

		if($query->getNumRows() == 0) {
			return $this->response->setJSON(['msg' => 'Account not found!']);
		} 

		$row = $query->getRow();

		$this->session->set('u_id', $row->RecID);
		$this->session->set('u_address', $row->address_id);
		$this->session->set('user_type', $row->user_type);
		$this->session->set('fname', strtoupper($row->firtname));
		$this->session->set('lastname', strtoupper($row->lastname));
		$this->session->set('middlename', strtoupper($row->middlename));
		$this->session->set('phone_number', strtoupper($row->phone_number));

		$this->db->table('user_access')->where(['RecID' => $row->RecID])->update([
			'lat' => $this->request->getVar('lat'),
			'lang' => $this->request->getVar('lang')
		]);

		return $this->response->setJSON(['msg' => 'success','fname' => $row->firtname, 'user_type' => $row->user_type, 'user_id' => $row->RecID]);
	}

	public function UpdateProfile() {
		$user = $this->session->get('u_id');
		$user_model = new UserModel();

		$res = $user_model->update($user, [
			'firtname' => $this->request->getVar('firstname'),
			'lastname' => $this->request->getVar('lastname'),
			'middlename' => $this->request->getVar('middlename'),
			'email' => $this->request->getVar('email'),
			'username' => $this->request->getVar('username'),
			'phone_number' => $this->request->getVar('phone_number'),
		]);

		if(!$res) {
			return $this->response->setJSON(['msg' => $res]);
		}
		return $this->response->setJSON(['msg' => 'success']);
	}

	public function UpdatePassword() {
		$user = $this->session->get('u_id');
		$user_model = new UserModel();
		$current_pass = hashPassword($this->request->getVar('current_pass'));

		$user = $user_model->find($user);

		if($user['password'] != $current_pass) {
			return $this->response->setJSON(['msg' => 'Current password not found!']);
		}

		$res = $user_model->update($user, [
			'password' => hashPassword($this->request->getVar('new_pass'))
		]);

		if(!$res) {
			return $this->response->setJSON(['msg' => $res]);
		}
		return $this->response->setJSON(['msg' => 'success']);
		
	}

	public function SendSms() {
		$ch = curl_init();
		$fullname = $this->session->get('fname') . ' ' . $this->session->get('middlename') . ' '. $this->session->get('lastname');
		$lat = $this->request->getVar('lat');
		$lang = $this->request->getVar('lang');

		$recepient = '09750148734'; //ADMIN CP NUMBER;
		$msg = 'NAME: '.$fullname.PHP_EOL;
		$msg .= 'MESSAGE: '. $this->request->getVar('msg').PHP_EOL;
		$msg .= 'LAT: '. $lat.PHP_EOL;
		$msg .= 'LANG: '. $lang.PHP_EOL;
		//$msg .= 'LOCATION LINK: '. 'https://www.google.com/maps/dir/'+$lat+','+$lang;

		$parameters = array(
			'apikey' => 'f3c50253fcb065c0cd20997ee40b6b1d', //Your API KEY
			'number' => $recepient,
			'message' => $msg,
			'sendername' => 'SEMAPHORE'
		);
		
		curl_setopt( $ch, CURLOPT_URL,'https://semaphore.co/api/v4/messages' );
		curl_setopt( $ch, CURLOPT_POST, 1 );

		//Send the parameters set above with the request
		curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );

		// Receive response from server
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		$output = curl_exec( $ch );
		curl_close ($ch);

		//Show the server response
		echo $output;

	}

	public function GetAddress() {

		$str = "SELECT * FROM tbl_locations WHERE IsActive = 1;";

		$res = $this->db->query($str);

		if(!$res) {
			return $this->response->setJSON(['msg' => $this->db->error()]);
		}

		return $this->response->setJSON($res->getResultArray());

	}

	public function GetMessageType() {

		$str = "SELECT * FROM message_type WHERE IsActive = 1;";

		$res = $this->db->query($str);

		if(!$res) {
			return $this->response->setJSON(['msg' => $this->db->error()]);
		}

		return $this->response->setJSON($res->getResultArray());

	}

	public function SendMessage() {

		$user = $this->session->get('u_id');
		$address = $this->session->get('u_address');

		$res = $this->db->table('tbl_report')->insert([
			'message_type' => $this->request->getVar('msg_type'),
			'address' => $address,
			'message' => $this->request->getVar('message'),
			'created_by' => $user,
			'created_at' => date('Y-m-d H:i:s')
		]);

		if(!$res) {
			return $this->response->setJSON(['msg' => $this->db->error()]);
		}

		return $this->response->setJSON(['msg' => 'success']);

	}

	public function GetAnnouncement() {

		$str = "SELECT T.address,CONCAT(T.address,' is experiencing Floods today please be careful') announcement,X.created_at
			FROM tbl_report X 
		LEFT JOIN tbl_locations T ON T.RecID = X.address
		WHERE CAST(X.created_at AS DATE) = CAST(NOW() AS DATE) AND X.message_type = 3 GROUP BY X.address;";

		$res = $this->db->query($str);

		if(!$res) {
			return $this->response->setJSON(['msg' => $this->db->error()]);
		}

		return $this->response->setJSON($res->getResultArray());

	}


	public function Logout() {
		$this->session->remove('u_id');
		$this->session->remove('user_type');
		$this->session->remove('fname');
		$this->session->remove('lastname');
		$this->session->remove('middlename');
		$this->session->destroy();

		return view('index');
	}

}
