<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

date_default_timezone_set('Asia/Manila');


class Admin_model extends CI_Model {

    public function __construct()
    {
		header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        parent::__construct();
		$this->load->model('settings_model');
		$this->load->library('phpmailer_library');
		$this->load->model('empathy_model');
		$this->load->model('members_model');
        $this->load->model('binarycode_model');
    }
	public function hash($password){
       $hash = password_hash($password,PASSWORD_DEFAULT);
       return $hash;
    }

	public function get_admin_data() {
		$this->db->select('*');
		$this->db->from('biowash_administrator');
		$query = $this->db->get();
		return $query->result();
	}
	public function get_top_five_endorser() {
		$settings  = $this->settings_model->get_settings_data();
		$datestart = $settings[0]->top_5_endorser_start_date;
		$dateends  = $settings[0]->top_5_endorser_end_date;
		$query     = $this->db->query("SELECT referral_code , count(referral_code)cnt from biowash_members 
								   WHERE datgeregistered BETWEEN CAST('$datestart' AS datetime) AND CAST('$dateends' AS datetime) 
								   group by referral_code  order by cnt desc limit 5");
		return $query->result();
	}
	
	public function get_purchased_data() {
		$this->db->select('*');
		$this->db->from('biowash_product_orders');
		$this->db->where(array('approval_status'=> 1));
		$query = $this->db->get();
		return $query->result();
	}
    public function get_members_data() {
		$this->db->select('*');
		$this->db->from('biowash_members');
		$query = $this->db->get();
		return $query->num_rows();
	}
	public function get_members_data_v() {
		$this->db->select('*');
		$this->db->from('biowash_members');
		$query = $this->db->get();
		return $query->result();
	}
    public function get_products_data() {
		$this->db->select('*');
		$this->db->from('biowash_products');
		$query = $this->db->get();
		return $query->num_rows();
	}
   
    public function saveadduser($data) {
		$datas = array(
            'firstname'      => $data['firstname'],
            'lastname'       => $data['lastname'],
            'username' 	     => $data['username'],
            'password'       => $this->hash($data['password']),
			);
	    $this->db->insert('biowash_administrator',$datas);
		redirect('administrator/settings/admin_accounts?=added');
	}
   
    public function updateadminuser($data) {
		$datas = array(
            'firstname'      => $data['firstname'],
            'lastname'       => $data['lastname'],
            'username' 	     => $data['username'],
            'password'       => $this->hash($data['password']),
			);
	    $this->db->where('adminID', $data['adminID']);
        $this->db->update('biowash_administrator', $datas);
		redirect('administrator/settings/admin_accounts?=updated');
	}
	public function savetop5endorser($data) {
		$datas = array(
            'top_5_endorser_start_date'     => $data['datestart'],
            'top_5_endorser_end_date'       => $data['dateend'],
			);
        $this->db->update('biowash_system_settings', $datas);
		redirect('administrator/index?=updated');
	}
	public function updatetopfivestatus($data) {
        $this->db->update('biowash_system_settings', $data);
		redirect('administrator/index?=updated');
	}
	
    public function deleteadminaccount($data) {
		$this->db->where('adminID', $data['adminID']);
		$this->db->delete('biowash_administrator');
		redirect('administrator/settings/admin_accounts?=deleted');
	}
	public function binaryCode() {
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array(); 
		$alphaLength = strlen($alphabet) - 1; 
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		static $result;
		if ( $result !== null ) 
			return $result;
		$result = implode($pass);
		return $result;
	}
	public function send_mail($data,$toemail)
	{
		$mail = $this->phpmailer_library->load();
		$mail->isSMTP();
		$mail->Host     = 'smtp.hostinger.com';
		$mail->SMTPAuth = true;
		$mail->Username = 'admin@empathybl3nd.com';
		$mail->Password = '@Empathy2021';
		$mail->SMTPSecure = 'ssl'; // tls
		$mail->Port     = 465; // 587
		$mail->setFrom('admin@empathybl3nd.com', 'EmpathyBl3nd');
			$mail->addAddress('admin@empathybl3nd.com');		
			$mail->addAddress('randysignar529@gmail.com');
			$mail->addAddress($toemail);
		$mail->addBCC('jeffrybordeos@gmail.com');
		$mail->addBCC('kevinjayroluna@gmail.com');
		$mail->Subject = 'Package Approval';
		$mail->isHTML(true);


		$mail->Body = "<html>
							<body>
								<h1>Package Approved</h1>
								<p>This Member's package has been approved:
								<br><br>
								Member's Code: ".$data['membercode']."
								<br><br>
								Binary Code:  ".$data['transactioncode']."   </p>
							</body>
						</html>";

		if ($mail->send()) {
			$message = 'success';
		} else {
			$message = 'failed';
		}

		return $message;
	}
	
	public function validate_ref_code($code){
		$validate             =  $this->db->query("select * from biowash_members where member_code like '$code%'");
		$cnt                  =  $validate->num_rows();
		if($cnt == 0){
			return false;
		}else{
			return $cnt;
		}
	}
	
	public function save_member_details($data) {
		$code                 =  str_replace(' ', '', $data['firstname']).str_replace(' ', '', $data['lastname']);

		$emailaddress         =  $data['emailaddress'];
		$refcode              =  $data['referralcode'];
		
		if($this->validate_ref_code($code) > 0){
				
					$code = $code.'-'.$this->validate_ref_code($code);
				
		}
		
		$validate2            =  $this->db->query("select * from biowash_members where emailaddress ='$emailaddress'");
		$cnt2                 =  $validate2->num_rows();
		
		if($cnt2 !=0){
			redirect('register?code='.$refcode.'&erroremail');
		} else {
		
		/** GET MAIN REF CODE */
		$validate             =  $this->db->query("select * from biowash_members where member_code ='$refcode'");
		$cnt                  =  $validate->num_rows();

		$results              = $validate->result();
		$maincode             = $results[0]->referral_main_code;
		$mearnlevel           = $results[0]->earn_level;
		$referralcode         = $results[0]->referral_code;

		/** GET COUNT LEVEL */
		$linerefr             = $this->db->query("select line_level from biowash_members where member_code ='$refcode' order by memberID desc limit 1");
		$lineresult           = $linerefr->result();

		if($cnt){
			if($lineresult[0]->line_level == 1){
					$line_level           = $lineresult[0]->line_level;
			} else {
					$line_level           = $lineresult[0]->line_level + 1;
			}
		} 
		$getrefline           = $this->db->query("select referral_cnt_level , line_level  from biowash_members where referral_code ='$refcode' order by referral_cnt_level desc limit 1");
		if(empty($getrefline->result())){
				$cnt_level        = 1;
		} else {
			foreach($getrefline->result() as $a=> $b){
				$cnt_level        = $b->referral_cnt_level+1;
			}
		}
		$data1 = array(
			'referral_code'    	 => $refcode,
			'referral_main_code' => $referralcode,
			'referral_cnt_level' => $cnt_level,
			'line_level'         => $line_level,
			'firstname'          => $data['firstname'],
			'lastname'           => $data['lastname'],
			'emailaddress'       => $data['emailaddress'],
			'username'           => $data['emailaddress'],
			'contactnumber'      => $data['contactnumber'],
			'password'           => $this->hash($data['password']),
			'member_code'        => $code,
			'isActive'           => 0,
			'memberType'         => $data['membertype']
		);
		
		$this->db->insert('biowash_members',$data1);
		$insert_id = $this->db->insert_id();
		
		$this->db->query("UPDATE biowash_members set ref_cnt = ref_cnt+1 where member_code ='$refcode'");
		$this->db->query("INSERT INTO biowash_members_wallet (membercode) values ('$code')");
		
	/** PROCESS BINARY */
	
	if( $data['membertype'] ==1){
		$package_id  = 4;
	} else if( $data['membertype'] ==2){
		$package_id  = 3;
	}
	
	$datas = array(
		'membercode' => $code,
		'uplinecode' => $refcode,
		'mainuplinecode' => $referralcode,
		'transactioncode' => $this->binaryCode(),
		'package_id' => $package_id
	);
	
    $this->binarycode_model->insert($datas);

	$memberid    = $code;
	
	
    $upline      = $refcode;

	$earn    = '750';
	$package = '600';
	$limit   = 30;
	$transcode =  $this->binaryCode();
	
	$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,packageamount,earnfrom,earnstatus) VALUES ('$upline','$earn' , '$package' , '$memberid','2')");
	
	$this->db->query("INSERT INTO biowash_member_package (package_id , member_id,status,member_code,referralID,referralmainID,transcode,is_approved) VALUES ('$package_id','$insert_id','1' , '$memberid' , '$refcode','$referralcode','$transcode','1')");
	
	$this->db->query("update biowash_members set  isActive=1 , package_type='$package_id' , flashout = '$limit' where member_code='$memberid'");
	

	$emp = $this->empathy_model->process_empathy_bonus($refcode,$referralcode,$package_id,$memberid);
	
    $email = $this->members_model->get_upline_email($refcode);

    $this->send_mail($datas,$email[0]->emailaddress);

	if( $data['membertype'] ==1){
	/** 90 EKit*/
	for ($x = 1; $x <= 90; $x++) {
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array(); 
		$alphaLength = strlen($alphabet) - 1; 
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		static $result;
		if ( $result !== null ) 
			return $result;
		$pCode1 = implode($pass);
		$this->db->query("INSERT INTO empathy_mega_accounts (member_code , package_id,package_code,count) VALUES ('$code','1','$pCode1' , '$x')");
	}

	for ($xx = 1; $xx <= 27; $xx++) {
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array(); 
		$alphaLength = strlen($alphabet) - 1; 
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		static $result;
		if ( $result !== null ) 
			return $result;
		$pCode2 = implode($pass);
		$this->db->query("INSERT INTO empathy_mega_accounts (member_code , package_id,package_code,count) VALUES ('$code','2','$pCode2' , '$xx')");
	}

	$pCode3 = $this->binaryCode();
	$this->db->query("INSERT INTO empathy_mega_accounts (member_code , package_id,package_code,count) VALUES ('$code','4','$pCode3' , '1')");
	
    } else if( $data['membertype'] ==2){
		$pCode3 = $this->binaryCode();
		
		
		
		/** 23 EKit*/
		for ($x = 1; $x <= 23; $x++) {
			$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
			$pass = array(); 
			$alphaLength = strlen($alphabet) - 1; 
			for ($i = 0; $i < 8; $i++) {
				$n = rand(0, $alphaLength);
				$pass[] = $alphabet[$n];
			}
			static $result;
			if ( $result !== null ) 
				return $result;
			$pCode1 = implode($pass);
			$this->db->query("INSERT INTO empathy_mega_accounts (member_code , package_id,package_code,count) VALUES ('$code','1','$pCode1' , '$x')");
		}
		
		    //$this->db->query("INSERT INTO empathy_mega_accounts (member_code , package_id,package_code,count) VALUES ('$code','3','$pCode3' , '1')");
	}

	redirect('/administrator/members/register?=added');
	}
    }

}
	
?>