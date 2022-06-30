<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(1);

date_default_timezone_set('Asia/Manila');


class Authentication_Model extends CI_Model {

    public function __construct()  {
		header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        parent::__construct();
		$this->load->model('settings_model');

    }
	public function transactionCode() {
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
	public function verifyHash($password,$vpassword) {
       if(password_verify($password,$vpassword))
       {
           return TRUE;
       }
       else{
           return FALSE;
       }
    }
	public function authentication($data){
		$user     = $this->user_authentication($data);
		if($user === 'success') { echo 'user'; } 
		else {
			$admin = $this->admin_authentication($data);
			if($admin === 'success') { echo 'admin'; } 
			else{
				$mega = $this->mega_authentication($data);
				if($mega === 'success') { echo 'mega'; } 
			}
		}
	}
	
	public function user_authentication($data) {
		$this->db->select('*');
		$this->db->from('biowash_members');
		$this->db->where('emailaddress',$data['username']);
		$query = $this->db->get();
		if ( $query->num_rows() > 0 ) {
				$datas 	      = $query->result();
				if($this->verifyHash($data['password'],$datas[0]->password) == TRUE){
					$memberid = $datas[0]->memberID;
					$validate = $this->db->query("select * from biowash_product_orders where memberID='$memberid' and checkout_status='0' ");
					$cntval   = $validate->num_rows();
					if($cntval==0){
						$code =  $this->transactionCode();
					} else {
						$valresu  = $validate->result();
						$code     =  $valresu[0]->transcode;
					}
							$session_data    = array(
								'userid'              => $datas[0]->memberID,
								'code'                => $datas[0]->member_code,
								'username'            => $datas[0]->username,
								'name'                => $datas[0]->firstname .' '. $datas[0]->lastname,
								'contactnumber'       => $datas[0]->contactnumber,
								'emailaddress'        => $datas[0]->emailaddress,
								'referral_code'       => $datas[0]->referral_code,
								'referral_main_code'  => $datas[0]->referral_main_code,
								'transactioncode'     => $code,
								'isActive'            => $datas[0]->isActive,
								'package_type'        => $datas[0]->package_type,
								'member_type'         => $datas[0]->memberType,
								);
							$this->session->set_userdata('logged_in', $session_data);
							$memcode       = $datas[0]->member_code;
							// UNILEVEL
							//$checkearnings = $this->db->query("select sum(earnamount)earnamount from biowash_members_earning where membercode='$memcode'");
							//$earnresults   = $checkearnings->result();
							// BINARY 
							// $checkbinary   = $this->db->query("select sum(EarnAmount)EarnAmount from biowash_binary_earning where memberCode='$memcode'");
							// $binaryresult  = $checkbinary->result();
							// $binarytotal   = $binaryresult[0]->EarnAmount;
							// $wallettotal   = $binarytotal;
							// $this->db->query("update biowash_members_wallet set balance='$wallettotal' where membercode='$memcode'");
	
					return 'success';   
				} else {
					return 'fail';
				}
		} else {
				return 'fail';   
		}
	}

	public function mega_authentication($data) {
		$this->db->select('*');
		$this->db->from('biowash_members');
		$this->db->where('emailaddress',$data['username']);
		$query = $this->db->get();
		if ( $query->num_rows() > 0 ) {
				$datas 	      = $query->result();
				if($this->verifyHash($data['password'],$datas[0]->password) == TRUE){
					$memberid = $datas[0]->memberID;
					$validate = $this->db->query("select * from biowash_product_orders where memberID='$memberid' and checkout_status='0' ");
					$cntval   = $validate->num_rows();
					if($cntval==0){
						$code =  $this->transactionCode();
					} else {
						$valresu  = $validate->result();
						$code     =  $valresu[0]->transcode;
					}
							$session_data    = array(
								'userid'              => $datas[0]->memberID,
								'code'                => $datas[0]->member_code,
								'username'            => $datas[0]->username,
								'name'                => $datas[0]->firstname .' '. $datas[0]->lastname,
								'contactnumber'       => $datas[0]->contactnumber,
								'emailaddress'        => $datas[0]->emailaddress,
								'referral_code'       => $datas[0]->referral_code,
								'referral_main_code'  => $datas[0]->referral_main_code,
								'transactioncode'     => $code,
								'isActive'            => $datas[0]->isActive,
								'package_type'        => $datas[0]->package_type,
								'member_type'         => $datas[0]->memberType,
								);
							$this->session->set_userdata('logged_in', $session_data);
							$memcode       = $datas[0]->member_code;
							// UNILEVEL
							//$checkearnings = $this->db->query("select sum(earnamount)earnamount from biowash_members_earning where membercode='$memcode'");
							//$earnresults   = $checkearnings->result();
							// BINARY 
							// $checkbinary   = $this->db->query("select sum(EarnAmount)EarnAmount from biowash_binary_earning where memberCode='$memcode'");
							// $binaryresult  = $checkbinary->result();
							// $binarytotal   = $binaryresult[0]->EarnAmount;
							// $wallettotal   = $binarytotal;
							// $this->db->query("update biowash_members_wallet set balance='$wallettotal' where membercode='$memcode'");
	
					return 'success';   
				} else {
					return 'fail';
				}
		} else {
				return 'fail';   
		}
	}

	public function admin_authentication($data) {
		$this->db->select('*');
		$this->db->from('biowash_administrator');
		$this->db->where('username',$data['username']);
		$query = $this->db->get();
		if ( $query->num_rows() > 0 ) {
						$datas 			 = $query->result();
			if($this->verifyHash($data['password'],$datas[0]->password) == TRUE){
						$session_data    = array(
							'userid'     => $datas[0]->adminID,
							'username'   => $datas[0]->username,
							'name'       => $datas[0]->firstname .' '. $datas[0]->lastname,
							);
						$this->session->set_userdata('logged_in', $session_data);
				return 'success';   
			} else{
				return 'fail';   
			}
			} else {
				return 'fail';   
		}
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
	
	public function authentication_register($data){
		if(isset($data)){
			$getearn             =  $this->settings_model->get_settings_data();
			$earnlevel           =  $getearn[0]->earn_limit ;
			
			$code                 =  str_replace(' ', '', $data['firstname']).str_replace(' ', '', $data['lastname']);
			if($this->validate_ref_code($code) > 0){
				
					$code = $code.'-'.$this->validate_ref_code($code);
				
			}
			$emailaddress         =  $data['emailaddress'];
			$refcode              =  $data['referralcode'];
			$validate2            =  $this->db->query("select * from biowash_members where emailaddress ='$emailaddress'");
			$cnt2                 =  $validate2->num_rows();
			if($cnt2 !=0){
				redirect('register?code='.$refcode.'&erroremail');
			} else {
				$validate             =  $this->db->query("select * from biowash_members where member_code ='$refcode'");
				$cnt                  =  $validate->num_rows();
			if($cnt == 0){
				redirect('register?code='.$refcode.'&error');
			} else {
				$results              = $validate->result();
				$maincode             = $results[0]->referral_main_code;
				$mearnlevel           = $results[0]->earn_level;
				$referralcode         = $results[0]->referral_code;
				if($mearnlevel==0){
					$refearnlevel     = $getearn[0]->earn_limit;
				} else {
					$refearnlevel     = $getearn[0]->earn_limit * $mearnlevel ;
				}
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
				$date = date('Y-m-d h:i:s');
				$datas = array(
					'referral_code'    	 => $refcode,
					'referral_main_code' => $referralcode,
					'referral_cnt_level' => $cnt_level,
					'line_level'         => $line_level,
					'firstname'          => $data['firstname'],
					'lastname'           => $data['lastname'],
					'emailaddress'       => $data['emailaddress'],
					'username'           => $data['emailaddress'],
					'contactnumber'      => $data['contactnumber'],
					'password'           => $data['password'],
					'member_code'        => $code,
					'isActive'           => 0,
					'datgeregistered'    => $date
					);
				$this->db->insert('biowash_members',$datas);
				$this->db->query("UPDATE biowash_members set ref_cnt = ref_cnt+1 where member_code ='$refcode'");
				$this->db->query("INSERT INTO biowash_members_wallet (membercode) values ('$code')");
				
				/** @ Set Earning Process via Earning Limit once activated **/
				/** @ User should buy products before earnings will activated **/

				$getearnlevel  		  =  $this->db->query("select earn_level from biowash_members where member_code ='$refcode'");
				$getearnlevelresult   =  $getearnlevel->result();
				$earn_level           =  $getearnlevelresult[0]->earn_level;
				
				$getnewmembercode    =  $this->db->query("select * from biowash_members where member_code ='$code'");
				$getnewmembercoderes =  $getnewmembercode->result();
				$newmemlinelevel     =  $getnewmembercoderes[0]->line_level;


				/** @ insert to binary process **/
				/** @ this will be activated once package approved **/
					
				if($newmemlinelevel ==1){
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$refcode' , '$code','0','$newmemlinelevel')");
				}
				if($newmemlinelevel ==2){
					$getmainrefcode     =  $this->db->query("select referral_main_code from biowash_members where member_code ='$code'");
					$getmainrefcodere   =  $getmainrefcode->result();
					$referral_main_code =  $getmainrefcodere[0]->referral_main_code;
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$referral_main_code' , '$code','0','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$refcode' , '$code','$refearnlevel','$newmemlinelevel')");
				}
				if($newmemlinelevel ==3){
					$getmainrefcode     =  $this->db->query("select referral_main_code from biowash_members where member_code ='$code'");
					$getmainrefcodere   =  $getmainrefcode->result();
					$referral_main_code =  $getmainrefcodere[0]->referral_main_code;
					
					$getrefcode1        =  $this->db->query("select referral_code , earn_level ,member_code from biowash_members where member_code ='$referralcode'");
					$getrefcode1res     =  $getrefcode1->result();
					$referral1          =  $getrefcode1res[0]->referral_code;
					$member_code1       =  $getrefcode1res[0]->member_code;
					$earn_level1        =  $getrefcode1res[0]->earn_level;
					if($earn_level1 == 0){
						$mearnlevel1    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel1    = $getearn[0]->earn_limit * $earn_level1 ;
					}
					
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$referral_main_code' , '$code','0','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code1' , '$code','$mearnlevel1','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$refcode' , '$code','$refearnlevel','$newmemlinelevel')");
				}
				if($newmemlinelevel ==4){
					$getmainrefcode     =  $this->db->query("select referral_main_code from biowash_members where member_code ='$code'");
					$getmainrefcodere   =  $getmainrefcode->result();
					$referral_main_code =  $getmainrefcodere[0]->referral_main_code;
					
					$getrefcode1        =  $this->db->query("select referral_code , earn_level ,member_code from biowash_members where member_code ='$referralcode'");
					$getrefcode1res     =  $getrefcode1->result();
					$referral1          =  $getrefcode1res[0]->referral_code;
					$member_code1       =  $getrefcode1res[0]->member_code;
					$earn_level1        =  $getrefcode1res[0]->earn_level;
					if($earn_level1 == 0){
						$mearnlevel1    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel1    = $getearn[0]->earn_limit * $earn_level1 ;
					}
					
					$getrefcode2        =  $this->db->query("select referral_code, earn_level,member_code from biowash_members where member_code ='$referral1'");
					$getrefcode2res     =  $getrefcode2->result();
					$referral2          =  $getrefcode2res[0]->referral_code;
					$member_code2       =  $getrefcode2res[0]->member_code;
					$earn_level2        =  $getrefcode2res[0]->earn_level;
					if($earn_level2 == 0){
						$mearnlevel2    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel2    = $getearn[0]->earn_limit * $earn_level2 ;
					}
					
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$referral_main_code' , '$code','0','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code1' , '$code','$mearnlevel1','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code2' , '$code','$mearnlevel2','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$refcode' , '$code','$refearnlevel','$newmemlinelevel')");
				}
				if($newmemlinelevel ==5){
					$getmainrefcode     =  $this->db->query("select referral_main_code from biowash_members where member_code ='$code'");
					$getmainrefcodere   =  $getmainrefcode->result();
					$referral_main_code =  $getmainrefcodere[0]->referral_main_code;
					
					$getrefcode1        =  $this->db->query("select referral_code , earn_level ,member_code from biowash_members where member_code ='$referralcode'");
					$getrefcode1res     =  $getrefcode1->result();
					$referral1          =  $getrefcode1res[0]->referral_code;
					$member_code1       =  $getrefcode1res[0]->member_code;
					$earn_level1        =  $getrefcode1res[0]->earn_level;
					if($earn_level1 == 0){
						$mearnlevel1    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel1    = $getearn[0]->earn_limit * $earn_level1 ;
					}
					
					$getrefcode2        =  $this->db->query("select referral_code, earn_level,member_code from biowash_members where member_code ='$referral1'");
					$getrefcode2res     =  $getrefcode2->result();
					$referral2          =  $getrefcode2res[0]->referral_code;
					$member_code2       =  $getrefcode2res[0]->member_code;
					$earn_level2        =  $getrefcode2res[0]->earn_level;
					if($earn_level2 == 0){
						$mearnlevel2    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel2    = $getearn[0]->earn_limit * $earn_level2 ;
					}
					
					$getrefcode3        =  $this->db->query("select referral_code, earn_level,member_code from biowash_members where member_code ='$referral2'");
					$getrefcode3res     =  $getrefcode3->result();
					$referral3          =  $getrefcode3res[0]->referral_code;
					$member_code3       =  $getrefcode3res[0]->member_code;
					$earn_level3        =  $getrefcode3res[0]->earn_level;
					if($earn_level3 == 0){
						$mearnlevel3    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel3    = $getearn[0]->earn_limit * $earn_level3 ;
					}
					
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$referral_main_code' , '$code','0','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code1' , '$code','$mearnlevel1','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code2' , '$code','$mearnlevel2','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code3' , '$code','$mearnlevel3','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$refcode' , '$code','$refearnlevel','$newmemlinelevel')");
				}
				if($newmemlinelevel ==6){
					$getmainrefcode     =  $this->db->query("select referral_main_code from biowash_members where member_code ='$code'");
					$getmainrefcodere   =  $getmainrefcode->result();
					$referral_main_code =  $getmainrefcodere[0]->referral_main_code;
					
					$getrefcode1        =  $this->db->query("select referral_code , earn_level ,member_code from biowash_members where member_code ='$referralcode'");
					$getrefcode1res     =  $getrefcode1->result();
					$referral1          =  $getrefcode1res[0]->referral_code;
					$member_code1       =  $getrefcode1res[0]->member_code;
					$earn_level1        =  $getrefcode1res[0]->earn_level;
					if($earn_level1 == 0){
						$mearnlevel1    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel1    = $getearn[0]->earn_limit * $earn_level1 ;
					}
					
					$getrefcode2        =  $this->db->query("select referral_code, earn_level,member_code from biowash_members where member_code ='$referral1'");
					$getrefcode2res     =  $getrefcode2->result();
					$referral2          =  $getrefcode2res[0]->referral_code;
					$member_code2       =  $getrefcode2res[0]->member_code;
					$earn_level2        =  $getrefcode2res[0]->earn_level;
					if($earn_level2 == 0){
						$mearnlevel2    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel2    = $getearn[0]->earn_limit * $earn_level2 ;
					}
					
					$getrefcode3        =  $this->db->query("select referral_code, earn_level,member_code from biowash_members where member_code ='$referral2'");
					$getrefcode3res     =  $getrefcode3->result();
					$referral3          =  $getrefcode3res[0]->referral_code;
					$member_code3       =  $getrefcode3res[0]->member_code;
					$earn_level3        =  $getrefcode3res[0]->earn_level;
					if($earn_level3 == 0){
						$mearnlevel3    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel3    = $getearn[0]->earn_limit * $earn_level3 ;
					}
					
					$getrefcode4        =  $this->db->query("select referral_code, earn_level,member_code from biowash_members where member_code ='$referral3'");
					$getrefcode4res     =  $getrefcode4->result();
					$referral4          =  $getrefcode4res[0]->referral_code;
					$member_code4       =  $getrefcode4res[0]->member_code;
					$earn_level4        =  $getrefcode4res[0]->earn_level;
					if($earn_level4 == 0){
						$mearnlevel4    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel4    = $getearn[0]->earn_limit * $earn_level4 ;
					}
					
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$referral_main_code' , '$code','0','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code1' , '$code','$mearnlevel1','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code2' , '$code','$mearnlevel2','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code3' , '$code','$mearnlevel3','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code4' , '$code','$mearnlevel4','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$refcode' , '$code','$refearnlevel','$newmemlinelevel')");
				}
				if($newmemlinelevel ==7){
					$getmainrefcode     =  $this->db->query("select referral_main_code from biowash_members where member_code ='$code'");
					$getmainrefcodere   =  $getmainrefcode->result();
					$referral_main_code =  $getmainrefcodere[0]->referral_main_code;
					
					$getrefcode1        =  $this->db->query("select referral_code , earn_level ,member_code from biowash_members where member_code ='$referralcode'");
					$getrefcode1res     =  $getrefcode1->result();
					$referral1          =  $getrefcode1res[0]->referral_code;
					$member_code1       =  $getrefcode1res[0]->member_code;
					$earn_level1        =  $getrefcode1res[0]->earn_level;
					if($earn_level1 == 0){
						$mearnlevel1    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel1    = $getearn[0]->earn_limit * $earn_level1 ;
					}
					
					$getrefcode2        =  $this->db->query("select referral_code, earn_level,member_code from biowash_members where member_code ='$referral1'");
					$getrefcode2res     =  $getrefcode2->result();
					$referral2          =  $getrefcode2res[0]->referral_code;
					$member_code2       =  $getrefcode2res[0]->member_code;
					$earn_level2        =  $getrefcode2res[0]->earn_level;
					if($earn_level2 == 0){
						$mearnlevel2    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel2    = $getearn[0]->earn_limit * $earn_level2 ;
					}
					
					$getrefcode3        =  $this->db->query("select referral_code, earn_level,member_code from biowash_members where member_code ='$referral2'");
					$getrefcode3res     =  $getrefcode3->result();
					$referral3          =  $getrefcode3res[0]->referral_code;
					$member_code3       =  $getrefcode3res[0]->member_code;
					$earn_level3        =  $getrefcode3res[0]->earn_level;
					if($earn_level3 == 0){
						$mearnlevel3    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel3    = $getearn[0]->earn_limit * $earn_level3 ;
					}
					
					$getrefcode4        =  $this->db->query("select referral_code, earn_level,member_code from biowash_members where member_code ='$referral3'");
					$getrefcode4res     =  $getrefcode4->result();
					$referral4          =  $getrefcode4res[0]->referral_code;
					$member_code4       =  $getrefcode4res[0]->member_code;
					$earn_level4        =  $getrefcode4res[0]->earn_level;
					if($earn_level4 == 0){
						$mearnlevel4    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel4    = $getearn[0]->earn_limit * $earn_level4 ;
					}
					
					
					$getrefcode5        =  $this->db->query("select referral_code, earn_level,member_code from biowash_members where member_code ='$referral4'");
					$getrefcode5res     =  $getrefcode5->result();
					$referral5          =  $getrefcode5res[0]->referral_code;
					$earn_level5        =  $getrefcode5res[0]->earn_level;
					$member_code5       =  $getrefcode5res[0]->member_code;
					if($earn_level5 == 0){
						$mearnlevel5    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel5    = $getearn[0]->earn_limit * $earn_level5 ;
					}
					
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$referral_main_code' , '$code','0','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code1' , '$code','$mearnlevel1','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code2' , '$code','$mearnlevel2','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code3' , '$code','$mearnlevel3','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code4' , '$code','$mearnlevel4','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code5' , '$code','$mearnlevel5','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$refcode' , '$code','$refearnlevel','$newmemlinelevel')");
				}
				if($newmemlinelevel ==8){
					$getmainrefcode     =  $this->db->query("select referral_main_code from biowash_members where member_code ='$code'");
					$getmainrefcodere   =  $getmainrefcode->result();
					$referral_main_code =  $getmainrefcodere[0]->referral_main_code;
					
					$getrefcode1        =  $this->db->query("select referral_code , earn_level ,member_code from biowash_members where member_code ='$referralcode'");
					$getrefcode1res     =  $getrefcode1->result();
					$referral1          =  $getrefcode1res[0]->referral_code;
					$member_code1       =  $getrefcode1res[0]->member_code;
					$earn_level1        =  $getrefcode1res[0]->earn_level;
					if($earn_level1 == 0){
						$mearnlevel1    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel1    = $getearn[0]->earn_limit * $earn_level1 ;
					}
					
					$getrefcode2        =  $this->db->query("select referral_code, earn_level,member_code from biowash_members where member_code ='$referral1'");
					$getrefcode2res     =  $getrefcode2->result();
					$referral2          =  $getrefcode2res[0]->referral_code;
					$member_code2       =  $getrefcode2res[0]->member_code;
					$earn_level2        =  $getrefcode2res[0]->earn_level;
					if($earn_level2 == 0){
						$mearnlevel2    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel2    = $getearn[0]->earn_limit * $earn_level2 ;
					}
					
					$getrefcode3        =  $this->db->query("select referral_code, earn_level,member_code from biowash_members where member_code ='$referral2'");
					$getrefcode3res     =  $getrefcode3->result();
					$referral3          =  $getrefcode3res[0]->referral_code;
					$member_code3       =  $getrefcode3res[0]->member_code;
					$earn_level3        =  $getrefcode3res[0]->earn_level;
					if($earn_level3 == 0){
						$mearnlevel3    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel3    = $getearn[0]->earn_limit * $earn_level3 ;
					}
					
					$getrefcode4        =  $this->db->query("select referral_code, earn_level,member_code from biowash_members where member_code ='$referral3'");
					$getrefcode4res     =  $getrefcode4->result();
					$referral4          =  $getrefcode4res[0]->referral_code;
					$member_code4       =  $getrefcode4res[0]->member_code;
					$earn_level4        =  $getrefcode4res[0]->earn_level;
					if($earn_level4 == 0){
						$mearnlevel4    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel4    = $getearn[0]->earn_limit * $earn_level4 ;
					}
					
					
					$getrefcode5        =  $this->db->query("select referral_code, earn_level,member_code from biowash_members where member_code ='$referral4'");
					$getrefcode5res     =  $getrefcode5->result();
					$referral5          =  $getrefcode5res[0]->referral_code;
					$earn_level5        =  $getrefcode5res[0]->earn_level;
					$member_code5       =  $getrefcode5res[0]->member_code;
					if($earn_level5 == 0){
						$mearnlevel5    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel5    = $getearn[0]->earn_limit * $earn_level5 ;
					}
					
					
					$getrefcode6        =  $this->db->query("select referral_code, earn_level,member_code  from biowash_members where member_code ='$referral5'");
					$getrefcode6res     =  $getrefcode6->result();
					$referral6          =  $getrefcode6res[0]->referral_code;
					$earn_level6        =  $getrefcode6res[0]->earn_level;
					$member_code6       =  $getrefcode6res[0]->member_code;
					if($earn_level6 == 0){
						$mearnlevel6    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel6    = $getearn[0]->earn_limit * $earn_level6 ;
					}
					
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$referral_main_code' , '$code','0','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code1' , '$code','$mearnlevel1','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code2' , '$code','$mearnlevel2','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code3' , '$code','$mearnlevel3','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code4' , '$code','$mearnlevel4','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code5' , '$code','$mearnlevel5','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code6' , '$code','$mearnlevel6','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$refcode' , '$code','$refearnlevel','$newmemlinelevel')");
				}
				if($newmemlinelevel ==9){
					$getmainrefcode     =  $this->db->query("select referral_main_code from biowash_members where member_code ='$code'");
					$getmainrefcodere   =  $getmainrefcode->result();
					$referral_main_code =  $getmainrefcodere[0]->referral_main_code;
					
					$getrefcode1        =  $this->db->query("select referral_code , earn_level ,member_code from biowash_members where member_code ='$referralcode'");
					$getrefcode1res     =  $getrefcode1->result();
					$referral1          =  $getrefcode1res[0]->referral_code;
					$member_code1       =  $getrefcode1res[0]->member_code;
					$earn_level1        =  $getrefcode1res[0]->earn_level;
					if($earn_level1 == 0){
						$mearnlevel1    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel1    = $getearn[0]->earn_limit * $earn_level1 ;
					}
					
					$getrefcode2        =  $this->db->query("select referral_code, earn_level,member_code from biowash_members where member_code ='$referral1'");
					$getrefcode2res     =  $getrefcode2->result();
					$referral2          =  $getrefcode2res[0]->referral_code;
					$member_code2       =  $getrefcode2res[0]->member_code;
					$earn_level2        =  $getrefcode2res[0]->earn_level;
					if($earn_level2 == 0){
						$mearnlevel2    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel2    = $getearn[0]->earn_limit * $earn_level2 ;
					}
					
					$getrefcode3        =  $this->db->query("select referral_code, earn_level,member_code from biowash_members where member_code ='$referral2'");
					$getrefcode3res     =  $getrefcode3->result();
					$referral3          =  $getrefcode3res[0]->referral_code;
					$member_code3       =  $getrefcode3res[0]->member_code;
					$earn_level3        =  $getrefcode3res[0]->earn_level;
					if($earn_level3 == 0){
						$mearnlevel3    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel3    = $getearn[0]->earn_limit * $earn_level3 ;
					}
					
					$getrefcode4        =  $this->db->query("select referral_code, earn_level,member_code from biowash_members where member_code ='$referral3'");
					$getrefcode4res     =  $getrefcode4->result();
					$referral4          =  $getrefcode4res[0]->referral_code;
					$member_code4       =  $getrefcode4res[0]->member_code;
					$earn_level4        =  $getrefcode4res[0]->earn_level;
					if($earn_level4 == 0){
						$mearnlevel4    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel4    = $getearn[0]->earn_limit * $earn_level4 ;
					}
					
					
					$getrefcode5        =  $this->db->query("select referral_code, earn_level,member_code from biowash_members where member_code ='$referral4'");
					$getrefcode5res     =  $getrefcode5->result();
					$referral5          =  $getrefcode5res[0]->referral_code;
					$earn_level5        =  $getrefcode5res[0]->earn_level;
					$member_code5       =  $getrefcode5res[0]->member_code;
					if($earn_level5 == 0){
						$mearnlevel5    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel5    = $getearn[0]->earn_limit * $earn_level5 ;
					}
					
					
					$getrefcode6        =  $this->db->query("select referral_code, earn_level,member_code  from biowash_members where member_code ='$referral5'");
					$getrefcode6res     =  $getrefcode6->result();
					$referral6          =  $getrefcode6res[0]->referral_code;
					$earn_level6        =  $getrefcode6res[0]->earn_level;
					$member_code6       =  $getrefcode6res[0]->member_code;
					if($earn_level6 == 0){
						$mearnlevel6    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel6    = $getearn[0]->earn_limit * $earn_level6 ;
					}
					
					$getrefcode7        =  $this->db->query("select referral_code, earn_level,member_code    from biowash_members where member_code ='$referral6'");
					$getrefcode7res     =  $getrefcode7->result();
					$referral7          =  $getrefcode7res[0]->referral_code;
					$earn_level7        =  $getrefcode7res[0]->earn_level;
					$member_code7       =  $getrefcode7res[0]->member_code;
					if($earn_level7 == 0){
						$mearnlevel7    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel7    = $getearn[0]->earn_limit * $earn_level7 ;
					}
					
					
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$referral_main_code' , '$code','0','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code1' , '$code','$mearnlevel1','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code2' , '$code','$mearnlevel2','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code3' , '$code','$mearnlevel3','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code4' , '$code','$mearnlevel4','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code5' , '$code','$mearnlevel5','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code6' , '$code','$mearnlevel6','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code7' , '$code','$mearnlevel7','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$refcode' , '$code','$refearnlevel','$newmemlinelevel')");
				}
				if($newmemlinelevel ==10){
					$getmainrefcode     =  $this->db->query("select referral_main_code from biowash_members where member_code ='$code'");
					$getmainrefcodere   =  $getmainrefcode->result();
					$referral_main_code =  $getmainrefcodere[0]->referral_main_code;
					
					$getrefcode1        =  $this->db->query("select referral_code , earn_level ,member_code from biowash_members where member_code ='$referralcode'");
					$getrefcode1res     =  $getrefcode1->result();
					$referral1          =  $getrefcode1res[0]->referral_code;
					$member_code1       =  $getrefcode1res[0]->member_code;
					$earn_level1        =  $getrefcode1res[0]->earn_level;
					if($earn_level1 == 0){
						$mearnlevel1    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel1    = $getearn[0]->earn_limit * $earn_level1 ;
					}
					
					$getrefcode2        =  $this->db->query("select referral_code, earn_level,member_code from biowash_members where member_code ='$referral1'");
					$getrefcode2res     =  $getrefcode2->result();
					$referral2          =  $getrefcode2res[0]->referral_code;
					$member_code2       =  $getrefcode2res[0]->member_code;
					$earn_level2        =  $getrefcode2res[0]->earn_level;
					if($earn_level2 == 0){
						$mearnlevel2    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel2    = $getearn[0]->earn_limit * $earn_level2 ;
					}
					
					$getrefcode3        =  $this->db->query("select referral_code, earn_level,member_code from biowash_members where member_code ='$referral2'");
					$getrefcode3res     =  $getrefcode3->result();
					$referral3          =  $getrefcode3res[0]->referral_code;
					$member_code3       =  $getrefcode3res[0]->member_code;
					$earn_level3        =  $getrefcode3res[0]->earn_level;
					if($earn_level3 == 0){
						$mearnlevel3    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel3    = $getearn[0]->earn_limit * $earn_level3 ;
					}
					
					$getrefcode4        =  $this->db->query("select referral_code, earn_level,member_code from biowash_members where member_code ='$referral3'");
					$getrefcode4res     =  $getrefcode4->result();
					$referral4          =  $getrefcode4res[0]->referral_code;
					$member_code4       =  $getrefcode4res[0]->member_code;
					$earn_level4        =  $getrefcode4res[0]->earn_level;
					if($earn_level4 == 0){
						$mearnlevel4    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel4    = $getearn[0]->earn_limit * $earn_level4 ;
					}
					
					
					$getrefcode5        =  $this->db->query("select referral_code, earn_level,member_code from biowash_members where member_code ='$referral4'");
					$getrefcode5res     =  $getrefcode5->result();
					$referral5          =  $getrefcode5res[0]->referral_code;
					$earn_level5        =  $getrefcode5res[0]->earn_level;
					$member_code5       =  $getrefcode5res[0]->member_code;
					if($earn_level5 == 0){
						$mearnlevel5    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel5    = $getearn[0]->earn_limit * $earn_level5 ;
					}
					
					
					$getrefcode6        =  $this->db->query("select referral_code, earn_level,member_code  from biowash_members where member_code ='$referral5'");
					$getrefcode6res     =  $getrefcode6->result();
					$referral6          =  $getrefcode6res[0]->referral_code;
					$earn_level6        =  $getrefcode6res[0]->earn_level;
					$member_code6       =  $getrefcode6res[0]->member_code;
					if($earn_level6 == 0){
						$mearnlevel6    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel6    = $getearn[0]->earn_limit * $earn_level6 ;
					}
					
					$getrefcode7        =  $this->db->query("select referral_code, earn_level,member_code    from biowash_members where member_code ='$referral6'");
					$getrefcode7res     =  $getrefcode7->result();
					$referral7          =  $getrefcode7res[0]->referral_code;
					$earn_level7        =  $getrefcode7res[0]->earn_level;
					$member_code7       =  $getrefcode7res[0]->member_code;
					if($earn_level7 == 0){
						$mearnlevel7    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel7    = $getearn[0]->earn_limit * $earn_level7 ;
					}
					
					
					$getrefcode8        =  $this->db->query("select referral_code, earn_level,member_code from biowash_members where member_code ='$referral7'");
					$getrefcode8res     =  $getrefcode8->result();
					$referral8          =  $getrefcode8res[0]->referral_code;
					$earn_level8        =  $getrefcode8res[0]->earn_level;
					$member_code8       =  $getrefcode8res[0]->member_code;
					if($earn_level8 == 0){
						$mearnlevel8    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel8    = $getearn[0]->earn_limit * $earn_level8 ;
					}
					
					
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$referral_main_code' , '$code','0','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code1' , '$code','$mearnlevel1','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code2' , '$code','$mearnlevel2','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code3' , '$code','$mearnlevel3','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code4' , '$code','$mearnlevel4','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code5' , '$code','$mearnlevel5','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code6' , '$code','$mearnlevel6','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code7' , '$code','$mearnlevel7','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code8' , '$code','$mearnlevel8','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$refcode' , '$code','$refearnlevel','$newmemlinelevel')");
				}
				if($newmemlinelevel >=11){
					
					$getrefcode1        =  $this->db->query("select referral_code from biowash_members where member_code ='$refcode'");
					$getrefcode1res     =  $getrefcode1->result();
					$referral1          =  $getrefcode1res[0]->referral_code;
					
															$getrefcode1        =  $this->db->query("select referral_code , earn_level ,member_code from biowash_members where member_code ='$referralcode'");
					$getrefcode1res     =  $getrefcode1->result();
					$referral1          =  $getrefcode1res[0]->referral_code;
					$member_code1       =  $getrefcode1res[0]->member_code;
					$earn_level1        =  $getrefcode1res[0]->earn_level;
					if($earn_level1 == 0){
						$mearnlevel1    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel1    = $getearn[0]->earn_limit * $earn_level1 ;
					}
					
					$getrefcode2        =  $this->db->query("select referral_code, earn_level,member_code from biowash_members where member_code ='$referral1'");
					$getrefcode2res     =  $getrefcode2->result();
					$referral2          =  $getrefcode2res[0]->referral_code;
					$member_code2       =  $getrefcode2res[0]->member_code;
					$earn_level2        =  $getrefcode2res[0]->earn_level;
					if($earn_level2 == 0){
						$mearnlevel2    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel2    = $getearn[0]->earn_limit * $earn_level2 ;
					}
					
					$getrefcode3        =  $this->db->query("select referral_code, earn_level,member_code from biowash_members where member_code ='$referral2'");
					$getrefcode3res     =  $getrefcode3->result();
					$referral3          =  $getrefcode3res[0]->referral_code;
					$member_code3       =  $getrefcode3res[0]->member_code;
					$earn_level3        =  $getrefcode3res[0]->earn_level;
					if($earn_level3 == 0){
						$mearnlevel3    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel3    = $getearn[0]->earn_limit * $earn_level3 ;
					}
					
					$getrefcode4        =  $this->db->query("select referral_code, earn_level,member_code from biowash_members where member_code ='$referral3'");
					$getrefcode4res     =  $getrefcode4->result();
					$referral4          =  $getrefcode4res[0]->referral_code;
					$member_code4       =  $getrefcode4res[0]->member_code;
					$earn_level4        =  $getrefcode4res[0]->earn_level;
					if($earn_level4 == 0){
						$mearnlevel4    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel4    = $getearn[0]->earn_limit * $earn_level4 ;
					}
					
					
					$getrefcode5        =  $this->db->query("select referral_code, earn_level,member_code from biowash_members where member_code ='$referral4'");
					$getrefcode5res     =  $getrefcode5->result();
					$referral5          =  $getrefcode5res[0]->referral_code;
					$earn_level5        =  $getrefcode5res[0]->earn_level;
					$member_code5       =  $getrefcode5res[0]->member_code;
					if($earn_level5 == 0){
						$mearnlevel5    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel5    = $getearn[0]->earn_limit * $earn_level5 ;
					}
					
					
					$getrefcode6        =  $this->db->query("select referral_code, earn_level,member_code  from biowash_members where member_code ='$referral5'");
					$getrefcode6res     =  $getrefcode6->result();
					$referral6          =  $getrefcode6res[0]->referral_code;
					$earn_level6        =  $getrefcode6res[0]->earn_level;
					$member_code6       =  $getrefcode6res[0]->member_code;
					if($earn_level6 == 0){
						$mearnlevel6    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel6    = $getearn[0]->earn_limit * $earn_level6 ;
					}
					
					$getrefcode7        =  $this->db->query("select referral_code, earn_level,member_code    from biowash_members where member_code ='$referral6'");
					$getrefcode7res     =  $getrefcode7->result();
					$referral7          =  $getrefcode7res[0]->referral_code;
					$earn_level7        =  $getrefcode7res[0]->earn_level;
					$member_code7       =  $getrefcode7res[0]->member_code;
					if($earn_level7 == 0){
						$mearnlevel7    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel7    = $getearn[0]->earn_limit * $earn_level7 ;
					}
					
					
					$getrefcode8        =  $this->db->query("select referral_code, earn_level,member_code from biowash_members where member_code ='$referral7'");
					$getrefcode8res     =  $getrefcode8->result();
					$referral8          =  $getrefcode8res[0]->referral_code;
					$earn_level8        =  $getrefcode8res[0]->earn_level;
					$member_code8       =  $getrefcode8res[0]->member_code;
					if($earn_level8 == 0){
						$mearnlevel8    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel8    = $getearn[0]->earn_limit * $earn_level8 ;
					}
					
					
					$getrefcode9        =  $this->db->query("select referral_code, earn_level ,member_code from biowash_members where member_code ='$referral8'");
					$getrefcode9res     =  $getrefcode9->result();
					$referral9          =  $getrefcode9res[0]->referral_code;
					$earn_level9        =  $getrefcode9res[0]->earn_level;
					$member_code9       =  $getrefcode9res[0]->member_code;
					if($earn_level9 == 0){
						$mearnlevel9    = $getearn[0]->earn_limit;
					} else{
						$mearnlevel9    = $getearn[0]->earn_limit * $earn_level9 ;
					}
					
					
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code1' , '$code','$mearnlevel1','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code2' , '$code','$mearnlevel2','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code3' , '$code','$mearnlevel3','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code4' , '$code','$mearnlevel4','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code5' , '$code','$mearnlevel5','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code6' , '$code','$mearnlevel6','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code7' , '$code','$mearnlevel7','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code8' , '$code','$mearnlevel8','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$member_code9' , '$code','$mearnlevel9','$newmemlinelevel')");
					$this->db->query("INSERT INTO biowash_earnings_progress (membercode , earningfrom , earninglimit , linelevel) VALUES ('$refcode' , '$code','$refearnlevel','$newmemlinelevel')");
				}
				
				redirect('register/success/'.urlencode(base64_encode($data['password1'])) .'/'.  urlencode(base64_encode($datas['emailaddress'])));
				}
			}
		}
	}
}