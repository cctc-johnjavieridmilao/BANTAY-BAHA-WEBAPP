<?php namespace App\Controllers;

use App\Models\UserModel;

class Admin extends BaseController
{
	public function index() {
		if($this->session->has('u_id')) {
			return view('Admin/DashBoard');
		}
		return view('index');
	}

	public function Dashboard() {
		if($this->session->has('u_id')) {
			return view('Admin/DashBoard');
		}
		return view('index');
	}

	
	public function Setting() {
		if($this->session->has('u_id')) {
			return view('Admin/Setting');
		}
		return view('index');
	}

	public function Analytics() {
		if($this->session->has('u_id')) {
			return view('Admin/Analytics');
		}
		return view('index');
	}

	public function Announcement() {
		if($this->session->has('u_id')) {
			return view('Admin/Announcement');
		}
		return view('index');
	}
	

	public function UserManagement() {
		if($this->session->has('u_id')) {
			return view('Admin/UserManagement');
		}
		return view('index');
	}

	public function GetProfile() {
		$user = $this->session->get('u_id');
		$user_model = new UserModel();

		return $this->response->setJSON($user_model->where('RecID', $user)->findAll());
	}

	public function GetUsers() {
        $user_model = new UserModel();

        return $this->response->setJSON($user_model->findAll());
    }

	public function DeleteUser() {
        $user_model = new UserModel();

		$res = $user_model->delete($this->request->getVar('id'));

		if(!$res) {
			return $this->response->setJSON(['msg' => $res]);
		}
		return $this->response->setJSON(['msg' => 'success']);
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

	public function GetCpNumber($userid) {
		$user_model = new UserModel();

		$user = $user_model->find($userid);

		return $user['phone_number'];

	}

	public function ApprovedAccount() {

		$user = intval($this->request->getVar('u_id'));
		$user_model = new UserModel();

		$user = $user_model->find($user);

		$res = $user_model->update($user, [
			'Status' => 1
		]);

		if(!$res) {
			return $this->response->setJSON(['msg' => $res]);
		}
		return $this->response->setJSON(['msg' => 'success']);

	}

	public function DisApprovedAccount() {

		$user = intval($this->request->getVar('u_id'));
		$user_model = new UserModel();

		$user = $user_model->find($user);

		$res = $user_model->update($user, [
			'Status' => 2
		]);

		if(!$res) {
			return $this->response->setJSON(['msg' => $res]);
		}
		return $this->response->setJSON(['msg' => 'success']);

	}

	public function RegisterAccount() {
		$user_model = new UserModel();

		$data = [
			'firtname'   => $this->request->getVar('fname'),
			'lastname'   => $this->request->getVar('lname'),
			'username'   => $this->request->getVar('username'),
			'email'      => $this->request->getVar('email'),
			'phone_number'  => $this->request->getVar('phone_number'),
			'middlename' => $this->request->getVar('mname'),
			'password'   => hashPassword($this->request->getVar('password')),
			'user_type'  =>  $this->request->getVar('role'),
			'lat'        => $this->request->getVar('lat'),
			'lang'       => $this->request->getVar('lang'),
			'Status'     => 1,
			'created_at' => date('Y-m-d H:i:s')
		];

		$res = $user_model->insert($data);

		$name = $this->request->getVar('fname') . ' ' . $this->request->getVar('mname') . ' ' . $this->request->getVar('lname');
		$user_id = $user_model->getInsertID();

		if($res) {
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

	public function SendSmsToUser() {
		$userid = $this->request->getVar('userid');
		$message = $this->request->getVar('msg');
		$recepient = $this->GetCpNumber($userid);

		$ch = curl_init();
		$fullname = 'BANTAY BAHA ADMIN';
		//$lat = $this->request->getVar('lat');
		//$lang = $this->request->getVar('lang');

		$msg = 'NAME: '.$fullname.PHP_EOL;
		$msg .= 'MESSAGE: '. $message.PHP_EOL;

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

	public function SendBulk() {
		//$userid = $this->request->getVar('userid');
		$message = $this->request->getVar('msg');
		//$recepient = $this->GetCpNumber($userid);
		$recepient = $this->request->getVar('phone_number');

		$ch = curl_init();
		$fullname = 'BANTAY BAHA ADMIN';
		//$lat = $this->request->getVar('lat');
		//$lang = $this->request->getVar('lang');

		$msg = 'NAME: '.$fullname.PHP_EOL;
		$msg .= 'MESSAGE: '. $message.PHP_EOL;

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
		$res = json_decode($output, true);

		echo json_encode(['msg' => 'success']);
	}

	public function GetAnalyticsFloods() {

		$str = "SELECT COUNT(X.message_type) count_baha,L.address label
		FROM tbl_report X 
		  INNER JOIN (SELECT * FROM tbl_locations WHERE IsActive = 1) L ON L.RecID = X.address
	  WHERE X.message_type = 3 AND MONTH(X.created_at) = MONTH(NOW()) AND YEAR(X.created_at) = YEAR(NOW())
	  GROUP BY X.address ORDER BY COUNT(X.message_type) DESC;";

		$res = $this->db->query($str);

		if(!$res) {
			return $this->response->setJSON(['msg' => $this->db->error()]);
		}

		return $this->response->setJSON($res->getResultArray());
	}

	public function GetAnalyticsAll() {

		$str = "SELECT T.address label,
		CASE WHEN XX.count_baha IS NULL THEN 0 ELSE XX.count_baha END count_baha,
		CASE WHEN ZZ.count_malakas_ulan IS NULL THEN 0 ELSE ZZ.count_malakas_ulan END count_malakas_ulan,
		CASE WHEN AA.umulan IS NULL THEN 0 ELSE AA.umulan END umulan 
		FROM tbl_report X
		  INNER JOIN tbl_locations T ON T.RecID = X.address
			LEFT JOIN (
			SELECT COUNT(X.message_type) umulan,L.address label,L.RecID
			FROM tbl_report X 
			  INNER JOIN (SELECT * FROM tbl_locations WHERE IsActive = 1) L ON L.RecID = X.address
			WHERE X.message_type = 1 GROUP BY X.address
		  ) AA ON AA.RecID = X.address
			LEFT JOIN (
			SELECT COUNT(X.message_type) count_malakas_ulan,L.address label,L.RecID
			FROM tbl_report X 
			  INNER JOIN (SELECT * FROM tbl_locations WHERE IsActive = 1) L ON L.RecID = X.address
			WHERE X.message_type = 2 GROUP BY X.address
		  ) ZZ ON ZZ.RecID = X.address
		  LEFT JOIN (
			SELECT COUNT(X.message_type) count_baha,L.address label,L.RecID
			FROM tbl_report X 
			  INNER JOIN (SELECT * FROM tbl_locations WHERE IsActive = 1) L ON L.RecID = X.address
			WHERE X.message_type = 3 GROUP BY X.address
		  ) XX ON XX.RecID = X.address
		  WHERE CAST(X.created_at AS DATE) = CAST(NOW() AS DATE)
		GROUP BY T.address;";

		$res = $this->db->query($str);

		if(!$res) {
			return $this->response->setJSON(['msg' => $this->db->error()]);
		}

		return $this->response->setJSON($res->getResultArray());
	}

}
