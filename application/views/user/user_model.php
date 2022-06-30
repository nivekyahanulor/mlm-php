<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);
class User_model extends CI_Model {

    public function __construct()
    {
		header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        parent::__construct();
        $this->load->database();
		$this->load->library('session');
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
	
	public function get_user_data() {
		$this->db->select('*');
		$this->db->from('biowash_members');
		$this->db->where('memberID', $this->session->userdata['logged_in']['userid']);
		$query = $this->db->get();
		return $query->result();
	}
	public function get_financial_data() {
		$this->db->select('*');
		$this->db->from('biowash_membesr_financial_method');
		$this->db->where('memberID', $this->session->userdata['logged_in']['userid']);
		$query = $this->db->get();
		return $query->result();
	}
    public function get_members_data() {
		$this->db->select('*');
		$this->db->from('biowash_members');
		$this->db->where('referral_code', $this->session->userdata['logged_in']['code']);
		$query = $this->db->get();
		return $query->num_rows();
	} 
	public function get_earnhistory_data() {
		$this->db->select('*');
		$this->db->from('biowash_members_earning');
		$this->db->where('membercode', $this->session->userdata['logged_in']['code']);
		$query = $this->db->get();
		return $query->result();
	}
	public function get_binary_earnhistory_data() {
		$this->db->select('*');
		$this->db->from('biowash_binary_earning');
		$this->db->where('membercode', $this->session->userdata['logged_in']['code']);
		$query = $this->db->get();
		return $query->result();
	}
    public function get_genealogy_data() {
		$this->db->select('*');
		$this->db->from('biowash_members');
		$this->db->where('referral_code', $this->session->userdata['logged_in']['code']);
		$query = $this->db->get();
		return $query->result();
	}   
	public function get_wallet_data() {
		$this->db->select('*');
		$this->db->from('biowash_members_wallet');
		$this->db->where(array('membercode'=> $this->session->userdata['logged_in']['code'] ));
		$query = $this->db->get();
		return $query->result();
	} 
	public function get_wallet_floating_data() {
		$this->db->select('*');
		$this->db->from('biowash_members_earning');
		$this->db->where(array('membercode'=> $this->session->userdata['logged_in']['code'] , 'earnstatus'=>0));
		$query = $this->db->get();
		return $query->result();
	} 
	public function get_product_purchased_data() {
		$this->db->select('*');
		$this->db->from('biowash_product_orders');
		$this->db->where(array('memberID'=> $this->session->userdata['logged_in']['userid'] , 'approval_status'=>1));
		$query = $this->db->get();
		return $query->result();
	} 
	public function get_withdrawal_request_data() {
		$this->db->select('*');
		$this->db->from('biowash_member_withdrawal');
		$this->db->where('memberID', $this->session->userdata['logged_in']['userid']);
		$query = $this->db->get();
		return $query->result();
	}  
	public function get_paymethod_data() {
		$this->db->select('*');
		$this->db->from('biowash_payment_options');
		$query = $this->db->get();
		return $query->result();
	} 
	public function getpaymethod($data) {
		$this->db->select('*');
		$this->db->from('biowash_payment_options');
		$this->db->where('payment_type', $data['paymethod']);
		$query = $this->db->get();
		return $query->result();
	}  
	public function get_orders_data() {
		$this->db->select('*');
		$this->db->from('biowash_product_orders');
		$this->db->join('biowash_products', 'biowash_products.productID = biowash_product_orders.productID');
		$this->db->where(array('checkout_status'=>0,'transcode'=> $this->session->userdata['logged_in']['transactioncode'] , 'memberID'=>$this->session->userdata['logged_in']['userid']));
		$query = $this->db->get();
		return $query->result();
	}
    public function get_cnt_orders_data() {
		$this->db->select('*');
		$this->db->from('biowash_product_orders');
		$this->db->where(array('checkout_status'=>0,'transcode'=> $this->session->userdata['logged_in']['transactioncode'] , 'memberID'=>$this->session->userdata['logged_in']['userid']));
		$query = $this->db->get();
		return $query->num_rows();
	}
	public function deletepurchased($data) {
        $this->db->where('orderID', $data['orderID']);
		$this->db->delete('biowash_product_orders');
		redirect('user/checkout');
    }
    public function get_purchased_product_data($data) {
		$this->db->select('*');
		$this->db->from('biowash_orders_checkout');
		if($data !=''){
		$this->db->where(array('transcode'=> $data , 'memberID'=>$this->session->userdata['logged_in']['userid']));
		} else {
		$this->db->where('memberID',$this->session->userdata['logged_in']['userid']);
		}
		$query = $this->db->get();
		return $query->result();
	}
	public function get_purchased_orders_product_data($data) {
		$this->db->select('*');
		$this->db->from('biowash_product_orders');
		$this->db->join('biowash_products', 'biowash_products.productID = biowash_product_orders.productID');
		$this->db->where(array('checkout_status'=>1,'transcode'=> $data , 'memberID'=>$this->session->userdata['logged_in']['userid']));
		$query = $this->db->get();
		return $query->result();
	}
    public function get_referral_data($data) {
		$this->db->select('*');
		$this->db->from('biowash_members');
		$this->db->where('referral_code',$data);
		$query = $this->db->get();
		return $query->result();
	}
   
    public function processpurchase($data) {
	    $this->db->insert('biowash_product_orders',$data);
    }
	
	public function processbinary($data) {
		$getearn    = $this->settings_model->get_settings_data();
		$code       = $data['binarycode'];
		$level      = $data['level'] + 1;
		$position   = $data['position'];
		$cnt 	    = $data['cnt'];
		echo $cntlvl;
		echo $position;
		echo $cnt;
		exit;
		$sPosition  = $data['secondaryPosition'];
		$checkcode = $this->db->query("select * from biowash_binary_codes where transactioncode='$code' and isUsed='0'");
		$checkres  = $checkcode->num_rows();
		if($checkres == 0){
			redirect('user/genealogy/binary_tree?data='.$data['callback'].'&errorcode');
		}  else { 
			$results  = $checkcode->result();
			if($data['position']=='Left'){
				$membercodeLeft  = $results[0]->membercode.'-'.$data['binarycode'];
				$binarycodeLeft  = $data['binarycode'];
			} 
			if($data['position']=='Right'){
				$membercodeRight = $results[0]->membercode.'-'.$data['binarycode'];
				$binarycodeRight = $data['binarycode'];
			}
			
			if($data['position']=='Left'){
				$data1 = array(
						'binary_code_left'  	 => $binarycodeLeft,
						'membercode_left'     	 => $membercodeLeft,
				);
			} if($data['position']=='Right'){
					$data1 = array(
						'binary_code_right'  	 => $binarycodeRight,
						'membercode_right'  	 => $membercodeRight,
				);
			}
			$this->db->where('bpID', $data['bpID']);
			$this->db->update('biowash_binary_process', $data1);
			$transcode  = $this->transactionCode();
			$directcode = $results[0]->membercode.'-'.$data['binarycode'];
			$maincode   = 'mell';
			$sponsors   = $this->session->userdata['logged_in']['code'];
			$underBy    = $data['directMemberCode'];
			if($underBy == 'mell'){
				$earnbuy	= 'mell';
			} else {
				$earnbuy    = substr($data['directMemberCode'] ,0, -10);
			}
			$cntlvl = $data['level'];
			if($data['position']=='Right'){
			$this->db->query("update biowash_binary_process set count_right=count_right+1 where level ='0' ");
			if($cntlvl !=0){
				if($sPosition=='Right'){
					for ($x = 1 ; $x <= $cntlvl; $x++) {
						if($x != $cntlvl){
						$this->db->query("update biowash_binary_process set count_right=count_right+1 where level ='$x' and position='Right' ");
						} else {
						$this->db->query("update biowash_binary_process set count_right=count_right+1 where level ='$x' and position='Right' ");
						}
					}
				}
				else if($sPosition=='Left'){
					for ($x = 1 ; $x <= $cntlvl; $x++) {
						if($x != $cntlvl){
						$this->db->query("update biowash_binary_process set count_right=count_right+1 where level ='$x' and position='Right' ");
						} else {
						$this->db->query("update biowash_binary_process set count_right=count_right+1 where level ='$x' and position='Right' ");
						}
				}
			}
			}	
			}
			if($data['position']=='Left'){
			$this->db->query("update biowash_binary_process set count_left=count_left+1 where level ='0' ");
			if($cntlvl !=0){
				if($sPosition=='Right'){
					for ($x = 1 ; $x <= $cntlvl; $x++) {
						// echo "update biowash_binary_process set count_right=count_right+1 where level ='$x' and position='Left' ";
						if($x != $cntlvl){
						$this->db->query("update biowash_binary_process set count_right=count_right+1 where level ='$x' and position='Left' ");
						} else {
						$this->db->query("update biowash_binary_process set count_right=count_right+1 where level ='$x' and position='Left' ");
						}
					}
				}
				else if($sPosition=='Left'){
					for ($x = 1 ; $x <= $cntlvl; $x++) {
						if($x != $cntlvl){
						$this->db->query("update biowash_binary_process set count_left=count_left+1 where level ='$x' and position='Left' ");
						} else {
						$this->db->query("update biowash_binary_process set count_left=count_left+1 where level ='$x' and position='Left'");
						}
					}
				}
			}
			}
			//** For Adding new row **//
			$cntlevel 	 = $this->db->query("select * from biowash_binary_process where level ='$level' and position='$position' order by bpID desc limit 1");
			$cntlevelres = $cntlevel->result();
			if($cntlevelres[0]->mainLevel == 0){
			$countlvl = 1;
			} else {
			$countlvl    = $cntlevelres[0]->mainLevel + 1;
			}
			$this->db->query("INSERT INTO biowash_binary_process (binaryTransaction,directMemberCode,underBy,sponsorMemberCode,mainMembercode,level,mainLevel,position,secondaryPosition,placement)
																VALUES ('$transcode','$directcode','$underBy','$sponsors','$maincode','$level','$countlvl','$position','$sPosition','$cnt')");
			
			// ** GET BINARY PAIRING FOR LEFT AND RIGHT **//
			$this->binary_matching($level,$data['position'],$cnt);
			
					
			//** Update isUsed to 1 **//													
			$this->db->query("UPDATE biowash_binary_codes set isUsed=1 where transactioncode='$code'");
			
			//** Get Pairing Bunos **//
			$bpID       = $data['bpID'];
			$getpairing = $this->db->query("select * from biowash_binary_process where bpID ='$bpID'");
			$pairing    = $getpairing->result();
			$pairamount = $getearn[0]->pairing_earning;
			if($pairing[0]->binary_code_left !="" && $pairing[0]->binary_code_right!=""){
				$this->db->query("update biowash_binary_process set isPAIR=1 where bpID ='$bpID'");
				$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																  VALUES ('$earnbuy' ,'12345','Pairing Bonus' ,'$pairamount')");
				$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$earnbuy'");
				$leftcode  = $pairing[0]->binary_code_left;
				$rightcode = $pairing[0]->binary_code_right;
				$this->db->query("INSERT INTO biowash_binary_match_pairing (left_code,right_code,match_earn) VALUES ('$leftcode','$rightcode','$earnbuy')");
				$userID = $this->session->userdata['logged_in']['userid'];
				$this->db->query("UPDATE biowash_members set flashout = flashout-1 where memberID='$userID'");
			}
			// redirect('user/genealogy/binary_tree?data='.$data['callback'].'&added');
		}
    }
	public function processbinary_left($data) {
		$getearn    = $this->settings_model->get_settings_data();
		$pairamount = $getearn[0]->pairing_earning;
		$code       = $data['binarycode'];
		$level      = $data['level'] + 1;
		$position   = $data['position'];
		$cnt        = $data['cnt'];
		$sPosition  = $data['secondaryPosition'];
		$checkcode = $this->db->query("select * from biowash_binary_codes where transactioncode='$code' and isUsed='0'");
		$checkres  = $checkcode->num_rows();
		if($checkres == 0){
			redirect('user/genealogy/binary_tree?data='.$data['callback'].'&errorcode');
		}  else { 
			$results  = $checkcode->result();
			if($data['secondaryPosition']=='Left'){
				$membercodeLeft  = $results[0]->membercode.'-'.$data['binarycode'];
				$binarycodeLeft  = $data['binarycode'];
			} 
			if($data['secondaryPosition']=='Right'){
				$membercodeRight = $results[0]->membercode.'-'.$data['binarycode'];
				$binarycodeRight = $data['binarycode'];
			}
			
			if($data['secondaryPosition']=='Left'){
				$data1 = array(
						'binary_code_left'  	 => $binarycodeLeft,
						'membercode_left'     	 => $membercodeLeft,
						'directMemberCode'       => $data['directMemberCode'],
						'mainMembercode'         => 'mell',
						// 'sponsorMemberCode'      => $data['sponsorMemberCode'],
				);
			} if($data['secondaryPosition']=='Right'){
					$data1 = array(
						'binary_code_right'  	 => $binarycodeRight,
						'membercode_right'  	 => $membercodeRight,
						'directMemberCode'       => $data['directMemberCode'],
						'mainMembercode'         => 'mell',
						// 'sponsorMemberCode'      => $data['sponsorMemberCode'],
				);
			}
			$cntlvl =   $data['level'];
			if($data['position']=='Right'){
			$this->db->query("update biowash_binary_process set count_right=count_right+1 where level ='0' ");
			if($cntlvl !=0){
				if($sPosition=='Right'){
					for ($x = 1 ; $x <= $cntlvl; $x++) {
						if($x != $cntlvl){
						$this->db->query("update biowash_binary_process set count_right=count_right+1 where level ='$x' and position='Right' ");
						} else {
						$this->db->query("update biowash_binary_process set count_right=count_right+1 where level ='$x' and position='Right' ");
						}
					}
				}
				else if($sPosition=='Left'){
					for ($x = 1 ; $x <= $cntlvl; $x++) {
						if($x != $cntlvl){
						$this->db->query("update biowash_binary_process set count_left=count_left+1 where level ='$x' and position='Right' ");
						} else {
						$this->db->query("update biowash_binary_process set count_left=count_left+1 where level ='$x' and position='Right' ");
						}
				}
			}
			}	
			}
			if($data['position']=='Left'){
			$this->db->query("update biowash_binary_process set count_left=count_left+1 where level ='0' ");
			if($cntlvl !=0){
				if($sPosition=='Right'){
					for ($x = 1 ; $x <= $cntlvl; $x++) {
						// echo "update biowash_binary_process set count_right=count_right+1 where level ='$x' and position='Left' ";
						if($x != $cntlvl){
						$this->db->query("update biowash_binary_process set count_right=count_right+1 where level ='$x' and position='Left' ");
						} else {
						$this->db->query("update biowash_binary_process set count_right=count_right+1 where level ='$x' and position='Left' ");
						}
					}
				}
				else if($sPosition=='Left'){
					for ($x = 1 ; $x <= $cntlvl; $x++) {
						if($x != $cntlvl){
						$this->db->query("update biowash_binary_process set count_left=count_left+1 where level ='$x' and position='Left' ");
						} else {
						$this->db->query("update biowash_binary_process set count_left=count_left+1 where level ='$x' and position='Left'");
						}
					}
				}
			}
			}
			$this->db->where('bpID', $data['bpID']);
			$this->db->update('biowash_binary_process', $data1);
			$transcode    = $this->transactionCode();
			$directcode   = $results[0]->membercode.'-'.$data['binarycode'];
			$maincode     = 'mell';
			$underby      = $data['directMemberCode'];
			$sponsors     = str_replace("-".$data['sponsorMemberCode'],"",$data['directMemberCode']);

			//** For Adding new row **//
			$cntlevel 	 = $this->db->query("select * from biowash_binary_process where level ='$level' and position='$position' order by bpID desc limit 1");
			$cntlevelres = $cntlevel->result();
			if($cntlevelres[0]->mainLevel == 0){
			$countlvl = 1;
			} else {
			$countlvl    = $cntlevelres[0]->mainLevel + 1;
			}
			$this->db->query("INSERT INTO biowash_binary_process (binaryTransaction,directMemberCode,underBy,sponsorMemberCode,mainMembercode,level,mainLevel,position,secondaryPosition,placement)
																VALUES ('$transcode','$directcode','$underby','$sponsors','$maincode','$level','$countlvl','$position','$sPosition','$cnt')");

			
			// ** GET BINARY PAIRING FOR LEFT AND RIGHT **//
			$this->binary_matching($level,$data['position'],$cnt);
			
			
			//** SET Code isUsed =1 **//
			$this->db->query("UPDATE biowash_binary_codes set isUsed=1 where transactioncode='$code'");
			//** Get Pairing Bunos **//
			$bpID         = $data['bpID'];
			$getpairing   = $this->db->query("select * from biowash_binary_process where bpID ='$bpID'");
			$pairing      = $getpairing->result();
			
			if($pairing[0]->binary_code_left !="" && $pairing[0]->binary_code_right!=""){
				$this->db->query("update biowash_binary_process set isPAIR=1 where bpID ='$bpID'");
				$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																  VALUES ('$sponsors' ,'$transcode','Pairing Bunos' ,'$pairamount')");
				$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsors'");
				$leftcode  = $pairing[0]->binary_code_left;
				$rightcode = $pairing[0]->binary_code_right;
				$this->db->query("INSERT INTO biowash_binary_match_pairing (left_code,right_code,match_earn) VALUES ('$leftcode','$rightcode','$sponsors')");
				$userID = $this->session->userdata['logged_in']['userid'];
				$this->db->query("UPDATE biowash_members set flashout = flashout-1 where memberID='$userID'");
			}
			// redirect('user/genealogy/binary_tree?data='.$data['callback'].'&added');
		}
    }
	public function processbinary_auto($data) {
		$getearn    = $this->settings_model->get_settings_data();
		$pairamount = $getearn[0]->pairing_earning;
		$code       = $data['binarycode'];
		$position   = $data['position'];
		$checkcode = $this->db->query("select * from biowash_binary_codes where transactioncode='$code' and isUsed='0'");
		$checkres  = $checkcode->num_rows();
		if($checkres == 0){
			redirect('user/genealogy/binary_tree?data='.$data['callback'].'&errorcode');
		}  else { 
			$transcode    = $this->transactionCode();
			$results  = $checkcode->result();
			$membercode  = $results[0]->membercode.'-'.$data['binarycode'];
			$binarycode  = $data['binarycode'];
			
			if($position == 'Left'){
				$getbinarydata = $this->db->query("select * from biowash_binary_process where position='Left' and binary_code_left='' order by bpID asc limit 1 ");
			} else if($position == 'Right'){
				$getbinarydata = $this->db->query("select * from biowash_binary_process where position='Right' and binary_code_right='' order by bpID asc limit 1 ");
			}
			$getbinaryres  = $getbinarydata->result();
			$transcode    = $this->transactionCode();
			$directcode   = $results[0]->membercode.'-'.$data['binarycode'];
			$maincode     = 'mell';
			$underby      = $getbinaryres[0]->directMemberCode ;
			$sponsors     = substr($getbinaryres[0]->directMemberCode ,0, -10);
			$level        = $getbinaryres[0]->level + 1;
			$bpid         = $getbinaryres[0]->bpID;
			$ssPosition   = $getbinaryres[0]->secondaryPosition;
			$cntlvl       = $getbinaryres[0]->level ;
			
		
			
			
			if($position == 'Left'){
				if($getbinaryres[0]->binary_code_left =="" ){
				$sPosition    = "Left";
				if($level == 2 || $level == 3 || $level == 4){
					$placement = 1;
				}

				$this->db->query("update biowash_binary_process set binary_code_left='$code' , membercode_left='$membercode' where bpID='$bpid'");
				$this->db->query("INSERT INTO biowash_binary_process (binaryTransaction,directMemberCode,underBy,sponsorMemberCode,mainMembercode,level,position,secondaryPosition,placement)
																	VALUES ('$transcode','$directcode','$underby','$sponsors','$maincode','$level','$position','$sPosition','$placement')");

				
								if($level ==2){
				$getright    = $this->db->query("select * from biowash_binary_process where level='2' and position ='Right' and placement=2");
				$getrightres = $getright->num_rows();
					if($getrightres !=0){
						$rigthresult = $getright->result();
						if($$rigthresult[0]->isMatch ==0){
							$this->db->query("update biowash_binary_process set  isMatch=1 where level='2' and position ='Right' and placement=2");
							$this->db->query("update biowash_binary_process set  isMatch=1 where level='2' and position ='Left' and placement='1'");
							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																		  VALUES ('mell' ,'$transcode','Pairing Bunos' ,'$pairamount')");
							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='mell'");
						}
					}
				}
				if($level ==3){
				$getright    = $this->db->query("select * from biowash_binary_process where level='3' and position ='Right' ");
				$getrightres = $getright->num_rows();
					if($getrightres !=0){
						$rigthresult = $getright->result();
						foreach($rigthresult as $val=>$row){
						if($row->placement==4 && $row->isMatch ==0){
							$this->db->query("update biowash_binary_process set  isMatch=1 where level='3' and position ='Right' and placement=4");
							$this->db->query("update biowash_binary_process set  isMatch=1 where level='3' and position ='Left' and placement='1'");
							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																		  VALUES ('mell' ,'$transcode','Pairing Bunos' ,'$pairamount')");
							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='mell'");
						} 
						}
					}
				}
				if($level ==4){
				$getright    = $this->db->query("select * from biowash_binary_process where level='4' and position ='Right' ");
				$getrightres = $getright->num_rows();
					if($getrightres !=0){
						$rigthresult = $getright->result();
						foreach($rigthresult as $val=>$row){
						if($row->placement==8 && $row->isMatch ==0){
							$this->db->query("update biowash_binary_process set  isMatch=1 where level='4' and position ='Right' and placement=8");
							$this->db->query("update biowash_binary_process set  isMatch=1 where level='4' and position ='Left' and placement='1'");
							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																		  VALUES ('mell' ,'$transcode','Pairing Bunos' ,'$pairamount')");
							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='mell'");
						} 
						}
					}
				}
				
				
					$this->db->query("update biowash_binary_process set count_left=count_left+1 where level ='0' ");
					if($cntlvl !=0){
							for ($x = 1 ; $x <= $cntlvl; $x++) {
								if($x != $cntlvl){
								$this->db->query("update biowash_binary_process set count_left=count_left+1 where level ='$x' and position='Left' ");
								} else {
								$this->db->query("update biowash_binary_process set count_left=count_left+1 where level ='$x' and position='Left'");
								}
						}
					}
				}
			
			} 
			else if($position == 'Right'){
				if($getbinaryres[0]->binary_code_right =="" ){
				$sPosition    = "Right";
				if($level == 2){
					$placement = 2;
				}if($level == 3){
					$placement = 4;
				}if($level == 4){
					$placement = 8;
				}
				
				$this->db->query("update biowash_binary_process set binary_code_right='$code' , membercode_right='$membercode' where bpID='$bpid'");
				$this->db->query("INSERT INTO biowash_binary_process (binaryTransaction,directMemberCode,underBy,sponsorMemberCode,mainMembercode,level,position,secondaryPosition,placement)
																	VALUES ('$transcode','$directcode','$underby','$sponsors','$maincode','$level','$position','$sPosition','$placement')");

				
				if($level ==2){

				$getright    = $this->db->query("select * from biowash_binary_process where level='2' and position ='Left' and placement=1");
				$getrightres = $getright->num_rows();
					if($getrightres !=0){
						$rigthresult = $getright->result();
						if($rigthresult[0]->isMatch ==0){
							$updateright = $this->db->query("UPDATE biowash_binary_process set  isMatch=1 where level='2' and position ='Right' and placement=2");
							$updateleft  = $this->db->query("UPDATE biowash_binary_process set  isMatch=1 where level='2' and position ='Left' and placement=1");
							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																		  VALUES ('mell' ,'$transcode','Pairing Bunos' ,'$pairamount')");
							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='mell'");
							
						} 
					}
				}
				if($level ==3){
				$getright    = $this->db->query("select * from biowash_binary_process where level='3' and position ='Left' ");
				$getrightres = $getright->num_rows();
					if($getrightres !=0){
						$rigthresult = $getright->result();
						foreach($rigthresult as $val=>$row){
						if($row->placement==1 && $row->isMatch ==0){
							$this->db->query("update biowash_binary_process set  isMatch=1 where level='3' and position ='Right' and placement=4");
							$this->db->query("update biowash_binary_process set  isMatch=1 where level='3' and position ='Left' and placement='1'");
							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																		  VALUES ('mell' ,'$transcode','Pairing Bunos' ,'$pairamount')");
							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='mell'");
						} 
						}
					}
				}
				if($level ==4){
				$getright    = $this->db->query("select * from biowash_binary_process where level='4' and position ='Left' ");
				$getrightres = $getright->num_rows();
					if($getrightres !=0){
						$rigthresult = $getright->result();
						foreach($rigthresult as $val=>$row){
						if($row->placement==1 && $row->isMatch ==0){
							$this->db->query("update biowash_binary_process set  isMatch=1 where level='4' and position ='Right' and placement=8");
							$this->db->query("update biowash_binary_process set  isMatch=1 where level='4' and position ='Left' and placement='1'");
							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																		  VALUES ('mell' ,'$transcode','Pairing Bunos' ,'$pairamount')");
							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='mell'");
						} 
						}
					}
				}
				
				
					$this->db->query("update biowash_binary_process set count_right=count_right+1 where level ='0' ");
					if($cntlvl !=0){
							for ($x = 1 ; $x <= $cntlvl; $x++) {
								if($x != $cntlvl){
								$this->db->query("update biowash_binary_process set count_right=count_right+1 where level ='$x' and position='Right' ");
								} else {
								$this->db->query("update biowash_binary_process set count_right=count_right+1 where level ='$x' and position='Right'");
								}
							}
						}
					}
			} 
		
	
			$this->db->query("UPDATE biowash_binary_codes set isUsed=1 where transactioncode='$code'");
			$checkforpairing = $this->db->query("select * from biowash_binary_process where  bpID = '$bpid'");
			$pairingresult   = $checkforpairing->result();
			
			if($pairingresult[0]->binary_code_left !="" && $pairingresult[0]->binary_code_right!=""){
				$this->db->query("update biowash_binary_process set isPAIR=1 where bpID ='$bpid'");
				$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																  VALUES ('$sponsors' ,'$transcode','Pairing Bunos' ,'$pairamount')");
				$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsors'");
				$userID = $this->session->userdata['logged_in']['userid'];
				$this->db->query("UPDATE biowash_members set flashout = flashout-1 where memberID='$userID'");
			}
			redirect('user/genealogy/binary_tree?data='.$data['callback'].'&added');
		}
    }
	public function savefinancialmethod($data) {
	    $this->db->insert('biowash_membesr_financial_method',$data);
		redirect('user/profile?added');
    }
	public function processwithdrawal($data) {
	    $this->db->insert('biowash_member_withdrawal',$data);
		$memberID = $data['memberID'];
	    $this->db->query("UPDATE biowash_members set withdrawal_status=1 where memberID='$memberID'");
		redirect('user/wallet/withdrawal?requested');
    }	
	public function checkoutprocess($data) {
		$transcode  =  $this->session->userdata['logged_in']['transactioncode'];
		if($data['deliveryoption'] == 'cod'){
			$datas = array(
				'transcode'        => $this->session->userdata['logged_in']['transactioncode'],
				'memberID'         => $this->session->userdata['logged_in']['userid'],
				'deliveryoption'   => $data['deliveryoption'],
				'deliveryaddress'  => $data['deliveryaddress'],
				'paydate'          => date('Y-m-d'),
			);
			
		} else {
			$image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
			$image_name = addslashes($_FILES['image']['name']);
			$image_size = getimagesize($_FILES['image']['tmp_name']);
			move_uploaded_file($_FILES["image"]["tmp_name"], "assets/receipts/" . $_FILES["image"]["name"]);
			$location 	=  $_FILES["image"]["name"];
			$datas = array(
				'transcode'        => $this->session->userdata['logged_in']['transactioncode'],
				'memberID'         => $this->session->userdata['logged_in']['userid'],
				'deliveryoption'   => $data['deliveryoption'],
				'deliveryaddress'  => $data['deliveryaddress'],
				'paymentmethod'    => $data['paymentmethod'],
				'payreceipt'   	   => $location,
				'paytranscode'     => $data['paytranscode'],
				'payname'          => $data['payname'],
				'payamount'        => $data['payamount'],
				'paydate'          => date('Y-m-d'),
			);
		}
		
	    $this->db->insert('biowash_orders_checkout',$datas);
		$this->db->query("UPDATE biowash_product_orders set checkout_status=1 where transcode='$transcode'");
		
		$session_data    = array(
							'userid'              => $this->session->userdata['logged_in']['userid'],
							'code'                => $this->session->userdata['logged_in']['code'],
							'username'            => $this->session->userdata['logged_in']['username'],
							'name'                => $this->session->userdata['logged_in']['name'],
							'contactnumber'       => $this->session->userdata['logged_in']['contactnumber'],
							'emailaddress'        => $this->session->userdata['logged_in']['emailaddress'],
							'referral_code'       => $this->session->userdata['logged_in']['referral_code'],
							'referral_main_code'  => $this->session->userdata['logged_in']['referral_main_code'],
							'transactioncode'     => $this->transactionCode(),
							);
		$this->session->set_userdata('logged_in', $session_data);
		redirect('user/success');
    }	
	public function updateprofiledetails($data) {
        $datas = array(
            'firstname'      => $data['firstname'],
            'lastname'       => $data['lastname'],
            'emailaddress'   => $data['emailaddress'],
            'contactnumber'  => $data['contactnumber'],
            'tinnumber'      => $data['tinnumber'],
            );
        $this->db->where('memberID', $data['memberID']);
        $this->db->update('biowash_members', $datas);
        redirect('user/profile?updated');
    }
	public function updateprofilepicture($data) {
		$image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
        $image_name = addslashes($_FILES['image']['name']);
        $image_size = getimagesize($_FILES['image']['tmp_name']);
        move_uploaded_file($_FILES["image"]["tmp_name"], "assets/profile/" . $_FILES["image"]["name"]);
		$location   =  $_FILES["image"]["name"];
        $datas = array(
            'profilepicture'      => $location,
            );
        $this->db->where('memberID', $data['memberID']);
        $this->db->update('biowash_members', $datas);
        redirect('user/profile?uploaded');
    }
	public function verifyemail($data) {
		$email    = $data['email'];
		$link     = base_url().'verify/request/'. urlencode(base64_encode($data['email']));
		$this->db->query("update biowash_members set isVerified =1 where emailaddress='$email'");
		$message  = '<b>BioWASH System Email Verification</b>';
		$message .= '<br><br> Hello  , ' . $data['name'];
		$message .= '<br> <br> Verify your account by clicking this <a href="'.$link.'" target="_blank"> link </a>';
		$message .= '<br> <br> <br> Thank You!</a>';
		$subject  = 'Email Verification';
		$to       = $email;
		$message_result = '';
		//To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: BioWASH System <support@biowash.system>' . "\r\n";
		mail($to, $subject, $message, $headers);
    }
	public function binary_matching($cntlvl,$position,$cnt){
		echo $cntlvl;
		echo $position;
		echo $cnt;
		$getearn    = $this->settings_model->get_settings_data();
		$pairamount = $getearn[0]->pairing_earning;
		$transcode  = $this->transactionCode();
		if($cntlvl ==2){
			if($position == 'Left'){
				$getright    = $this->db->query("select * from biowash_binary_process where level='$cntlvl' and position ='Right' ");
				$getrightres = $getright->num_rows();
				if($getrightres !=0){
					$rigthresult = $getright->result();
					foreach($rigthresult as $val=>$row){
					if($cnt ==1){
					if($row->placement==1 && $row->isMatch ==0){
						$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement=1");
						$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement='1'");
						$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																	  VALUES ('mell' ,'$transcode','Pairing Bunos' ,'$pairamount')");
						$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='mell'");
						break;
					} 
					else if($row->placement==2 && $row->isMatch ==0){
							$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement=2");
							$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement='1'");
							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																		  VALUES ('mell' ,'$transcode','Pairing Bunos' ,'$pairamount')");
							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='mell'");
						break;
					} 
					} else if($cnt ==2){
						if($row->placement==1 && $row->isMatch ==0){
							$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement=1");
							$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement='2'");
							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																		  VALUES ('mell' ,'$transcode','Pairing Bunos' ,'$pairamount')");
							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='mell'");
							break;
							} else if($row->placement==2 && $row->isMatch ==0){
							$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement=2");
							$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement='2'");
							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																		  VALUES ('mell' ,'$transcode','Pairing Bunos' ,'$pairamount')");
							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='mell'");
							break;
							}
						
					}
				}
				}
			}
			if($position == 'Right'){
				$getleft      = $this->db->query("select * from biowash_binary_process where level='$cntlvl' and position ='Left' ");
				$getleftres   = $getleft->num_rows();
				if($getleftres !=0){
					$leftresult = $getleft->result();
					foreach($leftresult as $val=>$row){
					if($cnt ==1){
						if($row->placement==1 && $row->isMatch ==0){
							$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement=1");
							$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement='1'");
							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																		  VALUES ('mell' ,'$transcode','Pairing Bunos' ,'$pairamount')");
							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='mell'");
							break;
						} else if($row->placement==2 && $row->isMatch ==0){
							$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement=2");
							$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement='1'");
							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																		  VALUES ('mell' ,'$transcode','Pairing Bunos' ,'$pairamount')");
							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='mell'");
							break;
						}
					}
					else if($cnt ==2){
						if($row->placement==1 && $row->isMatch ==0){
							$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement=1");
							$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement='2'");
							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																		  VALUES ('mell' ,'$transcode','Pairing Bunos' ,'$pairamount')");
							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='mell'");
							break;
						} else if($row->placement==2 && $row->isMatch ==0){
							$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement=2");
							$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement='2'");
							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																		  VALUES ('mell' ,'$transcode','Pairing Bunos' ,'$pairamount')");
							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='mell'");
							break;
						}
					}
				}
				}
			}
		}
		if($cntlvl==3){
			// ** earnings for left ** //
			if($position == 'Left' ){
				if($cnt == 1 || $cnt ==2 ){
					$getleftarn    = $this->db->query("select * from biowash_binary_process where level='2' and position ='Left' and placement =1");
					$getlres       = $getleftarn->result();
					$sponsor       = $getlres[0]->sponsorMemberCode;
				} if($cnt == 3 || $cnt ==4 ){
					$getleftarn    = $this->db->query("select * from biowash_binary_process where level='2' and position ='Left' and placement =2");
					$getlres       = $getleftarn->result();
					$sponsor       = $getlres[0]->sponsorMemberCode;
				}
				$getleft2    = $this->db->query("select * from biowash_binary_process where level='$cntlvl' and position ='Left' ");
				$getleftres2 = $getleft2->num_rows();
				if($getleftres2 !=0){
					foreach($getleft2->result() as $val=>$row){
						if($cnt ==1){
							if($row->placement==3 && $row->isMatchlvl3_left ==0){
									$this->db->query("update biowash_binary_process set  isMatchlvl3_left=1 where level='$cntlvl' and position ='Left' and placement=3");
									$this->db->query("update biowash_binary_process set  isMatchlvl3_left=1 where level='$cntlvl' and position ='Left' and placement='1'");
									$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																				  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
									$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
							break;
							}  else if($row->placement==4 && $row->isMatchlvl3_left ==0){
										$this->db->query("update biowash_binary_process set  isMatchlvl3_left=1 where level='$cntlvl' and position ='Left' and placement=4");
										$this->db->query("update biowash_binary_process set  isMatchlvl3_left=1 where level='$cntlvl' and position ='Left' and placement='1'");
										$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																					  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
										$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
							break;
							}
						} 
						else if($cnt ==2 ){
							if($row->placement==3 && $row->isMatchlvl3_left ==0){
									$this->db->query("update biowash_binary_process set  isMatchlvl3_left=1 where level='$cntlvl' and position ='Left' and placement=3");
									$this->db->query("update biowash_binary_process set  isMatchlvl3_left=1 where level='$cntlvl' and position ='Left' and placement='$cnt'");
									$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																				  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
									$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
							break;
							} else if($row->placement==4 && $row->isMatchlvl3_left ==0){
									$this->db->query("update biowash_binary_process set  isMatchlvl3_left=1 where level='$cntlvl' and position ='Left' and placement=4");
									$this->db->query("update biowash_binary_process set  isMatchlvl3_left=1 where level='$cntlvl' and position ='Left' and placement='$cnt'");
									$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																				  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
									$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
							break;
							}
						}
						else if($cnt ==3 ){
							if($row->placement==1 && $row->isMatchlvl3_left ==0){
									$this->db->query("update biowash_binary_process set  isMatchlvl3_left=1 where level='$cntlvl' and position ='Left' and placement=1");
									$this->db->query("update biowash_binary_process set  isMatchlvl3_left=1 where level='$cntlvl' and position ='Left' and placement='3'");
									$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																				  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
									$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
							break;
							} else if($row->placement==2 && $row->isMatchlvl3_left ==0){
									$this->db->query("update biowash_binary_process set  isMatchlvl3_left=1 where level='$cntlvl' and position ='Left' and placement=2");
									$this->db->query("update biowash_binary_process set  isMatchlvl3_left=1 where level='$cntlvl' and position ='Left' and placement='3'");
									$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																				  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
									$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
							break;
							} 
						}
						else if($cnt ==4 ){
							if($row->placement==1 && $row->isMatchlvl3_left ==0){
									$this->db->query("update biowash_binary_process set  isMatchlvl3_left=1 where level='$cntlvl' and position ='Left' and placement=1");
									$this->db->query("update biowash_binary_process set  isMatchlvl3_left=1 where level='$cntlvl' and position ='Left' and placement='$cnt'");
									$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																				  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
									$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
								
							break;
							} else if($row->placement==2 && $row->isMatchlvl3_left ==0){
										$this->db->query("update biowash_binary_process set  isMatchlvl3_left=1 where level='$cntlvl' and position ='Left' and placement=2");
										$this->db->query("update biowash_binary_process set  isMatchlvl3_left=1 where level='$cntlvl' and position ='Left' and placement='$cnt'");
										$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																					  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
										$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
									
							break;
							}
						}
						
					}
				}
			} 
			if($position == 'Right' ){
				if($cnt == 1 ||$cnt==2){
					$getleftarn    = $this->db->query("select * from biowash_binary_process where level='2' and position ='Right' and placement =1");
					$getlres       = $getleftarn->result();
					$sponsor       = $getlres[0]->sponsorMemberCode;
				} if($cnt == 3 ||$cnt==4){
					$getleftarn    = $this->db->query("select * from biowash_binary_process where level='2' and position ='Right' and placement =2");
					$getlres       = $getleftarn->result();
					$sponsor       = $getlres[0]->sponsorMemberCode;
				}
				$getright2    = $this->db->query("select * from biowash_binary_process where level='$cntlvl' and position ='Right' ");
				$getrightres2 = $getright2->num_rows();
				if($getrightres2 !=0){
					foreach($getright2->result() as $val=>$row){
						if($cnt ==1){
							if($row->placement==3 && $row->isMatchlvl3_right ==0){
									$this->db->query("update biowash_binary_process set  isMatchlvl3_right=1 where level='$cntlvl' and position ='Right' and placement=3");
									$this->db->query("update biowash_binary_process set  isMatchlvl3_right=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
									$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																				  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
									$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
								
							break;
							} else if($row->placement==4 && $row->isMatchlvl3_right ==0){
									$this->db->query("update biowash_binary_process set  isMatchlvl3_right=1 where level='$cntlvl' and position ='Right' and placement=4");
									$this->db->query("update biowash_binary_process set  isMatchlvl3_right=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
									$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																				  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
									$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
							break;
							}
						} 
						else if($cnt ==2 ){
							if($row->placement==3 && $row->isMatchlvl3_right ==0){
									$this->db->query("update biowash_binary_process set  isMatchlvl3_right=1 where level='$cntlvl' and position ='Right' and placement=3");
									$this->db->query("update biowash_binary_process set  isMatchlvl3_right=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
									$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																				  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
									$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
							break;
							
							}  else if($row->placement==4 && $row->isMatchlvl3_right ==0){
									$this->db->query("update biowash_binary_process set  isMatchlvl3_right=1 where level='$cntlvl' and position ='Right' and placement=4");
									$this->db->query("update biowash_binary_process set  isMatchlvl3_right=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
									$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																				  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
									$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
							break;
							}
						} 
						else if($cnt ==3 ){
							if($row->placement==1 && $row->isMatchlvl3_right ==0){
									$this->db->query("update biowash_binary_process set  isMatchlvl3_right=1 where level='$cntlvl' and position ='Right' and placement=1");
									$this->db->query("update biowash_binary_process set  isMatchlvl3_right=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
									$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																				  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
									$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
									
							break;
							} else if($row->placement==2 && $row->isMatchlvl3_right ==0){
									$this->db->query("update biowash_binary_process set  isMatchlvl3_right=1 where level='$cntlvl' and position ='Right' and placement=2");
									$this->db->query("update biowash_binary_process set  isMatchlvl3_right=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
									$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																				  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
									$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
							break;
							}
						}
						else if($cnt ==4 ){
							if($row->placement==1 && $row->isMatchlvl3_right ==0){
									$this->db->query("update biowash_binary_process set  isMatchlvl3_right=1 where level='$cntlvl' and position ='Right' and placement=1");
									$this->db->query("update biowash_binary_process set  isMatchlvl3_right=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
									$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																				  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
									$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
							break;
							}  else if($row->placement==2 && $row->isMatchlvl3_right ==0){
										$this->db->query("update biowash_binary_process set  isMatchlvl3_right=1 where level='$cntlvl' and position ='Right' and placement=2");
										$this->db->query("update biowash_binary_process set  isMatchlvl3_right=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
										$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																					  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
										$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
							break;
							} 
						}
						
					}
				}
			}
			// ** for top earnings ** //
			if($position == 'Left'){
				$getright    = $this->db->query("select * from biowash_binary_process where level='$cntlvl' and position ='Right' ");
				$getrightres = $getright->num_rows();
				if($getrightres !=0){
					$rigthresult = $getright->result();
					foreach($rigthresult as $val=>$row){
					if($row->placement==1 && $row->isMatch ==0){
						$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement=1");
						$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement='$cnt'");
						$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																	  VALUES ('mell' ,'$transcode','Pairing Bunos' ,'$pairamount')");
						$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='mell'");
					break;
					} else if($row->placement==2 && $row->isMatch ==0){
							$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement=2");
							$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement='$cnt'");
							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																		  VALUES ('mell' ,'$transcode','Pairing Bunos' ,'$pairamount')");
							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='mell'");
						} else if($row->placement==3 && $row->isMatch ==0){
								$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement=3");
								$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement='$cnt'");
								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																			  VALUES ('mell' ,'$transcode','Pairing Bunos' ,'$pairamount')");
								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='mell'");
							break;
							} else if($row->placement==4 && $row->isMatch ==0){
									$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement=4");
									$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement='$cnt'");
									$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																				  VALUES ('mell' ,'$transcode','Pairing Bunos' ,'$pairamount')");
									$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='mell'");
							break;
							}
				}
				}
			}
			if($position == 'Right'){
				$getleft      = $this->db->query("select * from biowash_binary_process where level='$cntlvl' and position ='Left' ");
				$getleftres   = $getleft->num_rows();
				if($getleftres !=0){
					$leftresult = $getleft->result();
					foreach($leftresult as $val=>$row){
					if($row->placement==1 && $row->isMatch ==0){
						$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement=1");
						$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
						$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																	  VALUES ('mell' ,'$transcode','Pairing Bunos' ,'$pairamount')");
						$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='mell'");
					break;
					} else if($row->placement==2 && $row->isMatch ==0){
							$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement=2");
							$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																		  VALUES ('mell' ,'$transcode','Pairing Bunos' ,'$pairamount')");
							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='mell'");
					break;
					} else if($row->placement==3 && $row->isMatch ==0){
								$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement=3");
								$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																			  VALUES ('mell' ,'$transcode','Pairing Bunos' ,'$pairamount')");
								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='mell'");
					break;
					} else if($row->placement==4 && $row->isMatch ==0){
									$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement=4");
									$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
									$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																				  VALUES ('mell' ,'$transcode','Pairing Bunos' ,'$pairamount')");
									$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='mell'");
					break;
					}
				}
				}
			}
			
		}
		if($cntlvl==4){
			
			// ** for top earnings ** //
			if($position == 'Left'){
				$getright    = $this->db->query("select * from biowash_binary_process where level='$cntlvl' and position ='Right' ");
				$getrightres = $getright->num_rows();
				if($getrightres !=0){
					$rigthresult = $getright->result();
					foreach($rigthresult as $val=>$row){
					if($row->placement==1 && $row->isMatch ==0){
						$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement=1");
						$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement='$cnt'");
						$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																	  VALUES ('mell' ,'$transcode','Pairing Bunos' ,'$pairamount')");
						$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='mell'");
					} else {
						if($row->placement==2 && $row->isMatch ==0){
							$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement=2");
							$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement='$cnt'");
							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																		  VALUES ('mell' ,'$transcode','Pairing Bunos' ,'$pairamount')");
							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='mell'");
						break;
						} else if($row->placement==3 && $row->isMatch ==0){
								$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement=3");
								$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement='$cnt'");
								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																			  VALUES ('mell' ,'$transcode','Pairing Bunos' ,'$pairamount')");
								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='mell'");
						break;
						} else if($row->placement==4 && $row->isMatch ==0){
									$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement=4");
									$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement='$cnt'");
									$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																				  VALUES ('mell' ,'$transcode','Pairing Bunos' ,'$pairamount')");
									$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='mell'");
						break;
						} else if($row->placement==5 && $row->isMatch ==0){
										$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement=5");
										$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement='$cnt'");
										$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																					  VALUES ('mell' ,'$transcode','Pairing Bunos' ,'$pairamount')");
										$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='mell'");
						break;
						} else if($row->placement==6 && $row->isMatch ==0){
											$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement=6");
											$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement='$cnt'");
											$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																						  VALUES ('mell' ,'$transcode','Pairing Bunos' ,'$pairamount')");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='mell'");
						break;
						} else if($row->placement==7 && $row->isMatch ==0){
												$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement=7");
												$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement='$cnt'");
												$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																							  VALUES ('mell' ,'$transcode','Pairing Bunos' ,'$pairamount')");
												$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='mell'");
						break;
						} else if($row->placement==8 && $row->isMatch ==0){
													$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement=8");
													$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement='$cnt'");
													$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																								  VALUES ('mell' ,'$transcode','Pairing Bunos' ,'$pairamount')");
													$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='mell'");
						break;
						}
					}
				}
				}
			}
			if($position == 'Right'){
				$getleft      = $this->db->query("select * from biowash_binary_process where level='$cntlvl' and position ='Left' ");
				$getleftres   = $getleft->num_rows();
				if($getleftres !=0){
					$leftresult = $getleft->result();
					foreach($leftresult as $val=>$row){
					if($row->placement==1 && $row->isMatch ==0){
						$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement=1");
						$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
						$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																	  VALUES ('mell' ,'$transcode','Pairing Bunos' ,'$pairamount')");
						$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='mell'");
					break;
					} else if($row->placement==2 && $row->isMatch ==0){
							$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement=2");
							$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																		  VALUES ('mell' ,'$transcode','Pairing Bunos' ,'$pairamount')");
							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='mell'");
					break;
					} else if($row->placement==3 && $row->isMatch ==0){
								$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement=3");
								$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																			  VALUES ('mell' ,'$transcode','Pairing Bunos' ,'$pairamount')");
								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='mell'");
							break;
							} else if($row->placement==4 && $row->isMatch ==0){
									$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement=4");
									$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
									$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																				  VALUES ('mell' ,'$transcode','Pairing Bunos' ,'$pairamount')");
									$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='mell'");
								break;
								} else if($row->placement==5 && $row->isMatch ==0){
										$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement=5");
										$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
										$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																					  VALUES ('mell' ,'$transcode','Pairing Bunos' ,'$pairamount')");
										$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='mell'");
									break;
									} else if($row->placement==6 && $row->isMatch ==0){
											$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement=6");
											$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
											$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																						  VALUES ('mell' ,'$transcode','Pairing Bunos' ,'$pairamount')");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='mell'");
										break;
										} else if($row->placement==7 && $row->isMatch ==0){
												$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement=7");
												$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
												$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																							  VALUES ('mell' ,'$transcode','Pairing Bunos' ,'$pairamount')");
												$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='mell'");
											break;
											}  else if($row->placement==8 && $row->isMatch ==0){
													$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement=8");
													$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
													$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																								  VALUES ('mell' ,'$transcode','Pairing Bunos' ,'$pairamount')");
													$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='mell'");
												break;
												}  
					}
				}
			}
		}
			
	}
	
}
	
?>