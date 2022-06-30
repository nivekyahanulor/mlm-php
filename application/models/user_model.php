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
		$this->load->library('phpmailer_library');
		$this->load->model('settings_model');
		$this->load->model('binarycode_model');
		$this->load->model('empathy_model');
		$this->load->model('members_model');
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
	public function hash($password){
		$hash = password_hash($password,PASSWORD_DEFAULT);
		return $hash;
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
		$this->db->where(array('membercode'=>$this->session->userdata['logged_in']['code'], 'earnstatus'=>2));
		$query = $this->db->get();
		return $query->result();
	}
	public function get_empathy_bunos_data(){
		$this->db->select('*');
		$this->db->from('biowash_members_earning');
		$this->db->where(array('membercode'=>$this->session->userdata['logged_in']['code'], 'earnstatus'=>0));
		$query = $this->db->get();
		return $query->result();
	}
	public function get_binary_earnhistory_data() {
		$code  = $this->session->userdata['logged_in']['code'];
		$query =  $this->db->query("select * from biowash_binary_earning where membercode='$code' and EarnAmount NOT IN ('0','10','20','30')");
		return $query->result();
	}
	public function get_gc_amount() {
		$code  = $this->session->userdata['logged_in']['code'];
		$query =  $this->db->query("select * from biowash_binary_process where directMemberCode='$code'");
		return $query->result();
	}
	public function get_binary_indrect_data() {
		$code  = $this->session->userdata['logged_in']['code'];
		$query =  $this->db->query("select * from biowash_binary_earning where membercode='$code' and EarnAmount  IN ('10','20','30')");
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
		$this->db->where(array('membercode'=> $this->session->userdata['logged_in']['code']));
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
		$sPosition  = $data['secondaryPosition'];
		$package_type = $data['package_type'];

		$checkcode = $this->db->query("select * from biowash_binary_codes where transactioncode='$code'  and isUsed='0'");
		$checkres  = $checkcode->num_rows();
		$results  = $checkcode->result();
		$packageid   = $results[0]->package_id;	
		$mainuplinecode   = $results[0]->mainuplinecode;	
		

		// CHECK MAIN UPLINE PACKAGE TYPE // 
		$checktype = $this->db->query("select * from biowash_members where member_code='$mainuplinecode'");
		$results1  = $checktype->result();
		$uplineptype   = $results1[0]->package_type;	

		// GET FLUSHOUT //
		$mem       = $results[0]->membercode;
		$fo        = $this->db->query("select * from biowash_members where member_code='$mem'");
		$results2  = $fo->result();
		$flash     = $results2[0]->flashOut;

		if($checkres == 0){
			redirect('user/genealogy/binary_tree?data='.$data['callback'].'&errorcode');
		}  else { 
			
			if($data['directMemberCode']=='Empathy-Admin'){

			if($data['position']=='Left'){
				$membercodeLeft  = $results[0]->membercode;
				$binarycodeLeft  = $data['binarycode'];
			} 
			if($data['position']=='Right'){
				$membercodeRight = $results[0]->membercode;
				$binarycodeRight = $data['binarycode'];
			}
			
			if($data['position']=='Left'){
				$data1 = array(
						'binary_code_left'  	 => $binarycodeLeft,
						'membercode_left'     	 => $membercodeLeft,
						'package_left'     	     => $packageid,
				);
			} if($data['position']=='Right'){
					$data1 = array(
						'binary_code_right'  	 => $binarycodeRight,
						'membercode_right'  	 => $membercodeRight,
						'package_right'     	 => $packageid,
				);
			}
			} else {

			if($data['secondaryPosition']=='Left'){
				$membercodeLeft  = $results[0]->membercode;
				$binarycodeLeft  = $data['binarycode'];
			} 
			if($data['secondaryPosition']=='Right'){
				$membercodeRight = $results[0]->membercode;
				$binarycodeRight = $data['binarycode'];
			}
			
			if($data['secondaryPosition']=='Left'){
				$data1 = array(
						'binary_code_left'  	 => $binarycodeLeft,
						'membercode_left'     	 => $membercodeLeft,
						'package_left'     	     => $packageid,
				);
			} if($data['secondaryPosition']=='Right'){
					$data1 = array(
						'binary_code_right'  	 => $binarycodeRight,
						'membercode_right'  	 => $membercodeRight,
						'package_right'     	 => $packageid,
				);
			}
			}

			$this->db->where('bpID', $data['bpID']);
			$this->db->update('biowash_binary_process', $data1);
			$transcode  = $this->transactionCode();
			$directcode = $results[0]->membercode;
			$maincode   = 'Empathy-Admin';
			$sponsors   = $this->session->userdata['logged_in']['code'];
			$underBy    = $data['directMemberCode'];
			if($underBy == 'Empathy-Admin'){
				$earnbuy	= 'Empathy-Admin';
			} else {
				$earnbuy    = $data['directMemberCode'];
			}
			$indirectcode  = $data['sponsorMemberCode'];
			$cntlvl = $data['level'];
			if($data['position']=='Right'){
			// $this->db->query("update biowash_binary_process set count_right=count_right+1 where level ='0' ");
			if($cntlvl !=0){
				if($sPosition=='Right'){
					for ($x = 1 ; $x <= $cntlvl; $x++) {
						if($x != $cntlvl){
						// $this->db->query("update biowash_binary_process set count_right=count_right+1 where level ='$x' and position='Right' ");
						} else {
						// $this->db->query("update biowash_binary_process set count_right=count_right+1 where level ='$x' and position='Right' ");
						}
					}
				}
				else if($sPosition=='Left'){
					for ($x = 1 ; $x <= $cntlvl; $x++) {
						if($x != $cntlvl){
						// $this->db->query("update biowash_binary_process set count_right=count_right+1 where level ='$x' and position='Right' ");
						} else {
						// $this->db->query("update biowash_binary_process set count_right=count_right+1 where level ='$x' and position='Right' ");
						}
				}
			}
			}	
			}
			if($data['position']=='Left'){
			// $this->db->query("update biowash_binary_process set count_left=count_left+1 where level ='0' ");
			if($cntlvl !=0){
				if($sPosition=='Right'){
					for ($x = 1 ; $x <= $cntlvl; $x++) {
						// echo "update biowash_binary_process set count_right=count_right+1 where level ='$x' and position='Left' ";
						if($x != $cntlvl){
						// $this->db->query("update biowash_binary_process set count_right=count_right+1 where level ='$x' and position='Left' ");
						} else {
						// $this->db->query("update biowash_binary_process set count_right=count_right+1 where level ='$x' and position='Left' ");
						}
					}
				}
				else if($sPosition=='Left'){
					for ($x = 1 ; $x <= $cntlvl; $x++) {
						if($x != $cntlvl){
						// $this->db->query("update biowash_binary_process set count_left=count_left+1 where level ='$x' and position='Left' ");
						} else {
						// $this->db->query("update biowash_binary_process set count_left=count_left+1 where level ='$x' and position='Left'");
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


			$this->db->query("INSERT INTO biowash_binary_process (binaryTransaction,directMemberCode,underBy,sponsorMemberCode,mainMembercode,level,mainLevel,position,secondaryPosition,placement,flushout)
																VALUES ('$transcode','$directcode','$underBy','$sponsors','$maincode','$level','$countlvl','$position','$sPosition','$cnt','0')");

			$dcode = $directcode;

			$this->processPairing($dcode,$dcode);
			$this->processBinaryBonus($dcode,$dcode,1,'');


																	
			// ** GET BINARY PAIRING FOR LEFT AND RIGHT **//
			// $this->binary_matching($level,$data['position'],$cnt);
			//** Update isUsed to 1 **//													
			$this->db->query("UPDATE biowash_binary_codes set isUsed=1 where transactioncode='$code'");
			
			if($package_type !=1){
			//** Get Pairing Bunos **//
			$bpID       = $data['bpID'];
			$getpairing = $this->db->query("select * from biowash_binary_process where bpID ='$bpID'");
			$pairing    = $getpairing->result();
			if($position == 'Left'){
				$packageright = $pairing[0]->package_right; 
				// GET PAIRING BUNOS //
				if($packageid == 2 && $packageright == 2 ){
						$pairamount = 150;
				} else if($packageid == 2 && $packageright == 3 ){
						$pairamount = 200;
				} else if($packageid == 2 && $packageright == 4 ){
					$pairamount = 250;
				} else if($packageid ==3 && $packageright == 3 ){
					$pairamount = 300;
				} else if($packageid ==3 && $packageright == 2 ){
					$pairamount = 200;
				} else if($packageid ==3 && $packageright == 4 ){
					$pairamount = 300;
				} else if($packageid ==4 && $packageright == 4 ){
					$pairamount = 450;
				} else if($packageid ==4 && $packageright == 2 ){
					$pairamount = 250;
				}  else if($packageid ==4 && $packageright == 3 ){
					$pairamount = 350;
				} else if($packageid == 1 && $packageright == 1 ){
					$pairamount = 0;
				}  else if($packageid == 1 && $packageright == 2 ){
					$pairamount = 0;
				}  else if($packageid == 1 && $packageright == 3 ){
					$pairamount = 0;
				} else if($packageid == 1 && $packageright == 4 ){
					$pairamount = 0;
				} 
			} else if($position == 'Right'){
				$packageleft = $pairing[0]->package_left; 
					if($packageid == 2 && $packageleft == 2 ){
						$pairamount = 150;
					} else if($packageid == 2 && $packageleft == 3 ){
						$pairamount = 200;
					} else if($packageid == 2 && $packageleft == 4 ){
						$pairamount = 250;
					} else if($packageid ==3 && $packageleft == 3 ){
						$pairamount = 300;
					} else if($packageid ==3 && $packageleft == 2 ){
						$pairamount = 200;
					} else if($packageid ==3 && $packageleft == 4 ){
						$pairamount = 300;
					} else if($packageid ==4 && $packageleft == 4 ){
						$pairamount = 450;
					} else if($packageid ==4 && $packageleft == 2 ){
						$pairamount = 250;
					}  else if($packageid ==4 && $packageleft == 3 ){
						$pairamount = 350;
					} else if($packageid ==1 && $packageleft == 1 ){
						$pairamount = 0;
					} else if($packageid ==1 && $packageleft == 2 ){
						$pairamount = 0;
					} else if($packageid ==1 && $packageleft == 3 ){
						$pairamount = 0;
					} else if($packageid ==1 && $packageleft == 4 ){
						$pairamount = 0;
					} 
			}

			// INDIRECT REFFERAL //


				// if($underBy != $sponsors){
				// 		if($packageid == 2){
				// 			$indirect      = $getearn[0]->silver;
				// 		} else if($packageid == 3){
				// 			$indirect      = $getearn[0]->gold;
				// 		} else if($packageid == 4){
				// 			$indirect      = $getearn[0]->premuim;
				// 		}
				// 		else if($packageid == 1){
				// 			$indirect      = 0;
				// 		}
				// 		$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
				// 		VALUES ('$indirectcode' ,'12345','Indirect Bonus' ,'$indirect')");
				// 		$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$indirect' where membercode='$indirectcode'");
				// }
			
			$userID = $this->session->userdata['logged_in']['userid'];

			// CHECK FLUSHOUT PACKAGE TYPE // 
			$checktype = $this->db->query("select * from biowash_members where memberID='$userID'");
			$results2  = $checktype->result();
			$flush   = $results2[0]->flashOut;	
			// if($flush == 0){} else {
			// 	if($pairing[0]->binary_code_left !="" && $pairing[0]->binary_code_right!=""){
			// 	$this->db->query("update biowash_binary_process set isPAIR=1   where bpID ='$bpID'");
			// 	$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
			// 													  VALUES ('$earnbuy' ,'12345','Pairing Bonus' ,'$pairamount')");
			// 	$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$earnbuy'");
			// 	$this->db->query("UPDATE biowash_members set flashOut = flashOut-1 where memberID='$userID'");
			// }
			// }
			}
			redirect('user/genealogy/binary_tree?data='.$data['callback'].'&added');
		}
    }
	public function processbinary_left($data) {
		$getearn    = $this->settings_model->get_settings_data();
		$code       = $data['binarycode'];
		$level      = $data['level'] + 1;
	
		$position   = $data['position'];
		$cnt        = $data['cnt'];
		$sPosition  = $data['secondaryPosition'];
		$package_type = $data['package_type'];
		$checkcode = $this->db->query("select * from biowash_binary_codes where transactioncode='$code' and isUsed='0'");
		$checkres  = $checkcode->num_rows();
		if($checkres == 0){
			redirect('user/genealogy/binary_tree?data='.$data['callback'].'&errorcode');
		}  else { 
			$results  = $checkcode->result();
			$packageid   = $results[0]->package_id;	
			$mainuplinecode   = $results[0]->mainuplinecode;	
		
			// CHECK MAIN UPLINE PACKAGE TYPE // 
			$checktype = $this->db->query("select * from biowash_members where member_code='$mainuplinecode'");
			$results1  = $checktype->result();
			$uplineptype   = $results1[0]->package_type;	

			// GET FLUSHOUT //
			$mem       = $results[0]->membercode;
			$fo        = $this->db->query("select * from biowash_members where member_code='$mem'");
			$results2  = $fo->result();
			$flash     = $results2[0]->flashOut;
	

			if($data['secondaryPosition']=='Left'){
				$membercodeLeft  = $results[0]->membercode;
				$binarycodeLeft  = $data['binarycode'];
			} 
			if($data['secondaryPosition']=='Right'){
				$membercodeRight = $results[0]->membercode;
				$binarycodeRight = $data['binarycode'];
			}
			
			if($data['secondaryPosition']=='Left'){
				$data1 = array(
						'binary_code_left'  	 => $binarycodeLeft,
						'membercode_left'     	 => $membercodeLeft,
						'directMemberCode'       => $data['directMemberCode'],
						'mainMembercode'         => 'Empathy-Admin',
						'package_left'     	     => $packageid,
				);
			} if($data['secondaryPosition']=='Right'){
					$data1 = array(
						'binary_code_right'  	 => $binarycodeRight,
						'membercode_right'  	 => $membercodeRight,
						'directMemberCode'       => $data['directMemberCode'],
						'mainMembercode'         => 'Empathy-Admin',
						'package_right'     	=> $packageid,

				);
			}
			$cntlvl =   $data['level'];
			if($data['position']=='Right'){
			// $this->db->query("update biowash_binary_process set count_right=count_right+1 where level ='0' ");
			if($cntlvl !=0){
				if($sPosition=='Right'){
					for ($x = 1 ; $x <= $cntlvl; $x++) {
						if($x != $cntlvl){
						// $this->db->query("update biowash_binary_process set count_right=count_right+1 where level ='$x' and position='Right' ");
						} else {
						// $this->db->query("update biowash_binary_process set count_right=count_right+1 where level ='$x' and position='Right' ");
						}
					}
				}
				else if($sPosition=='Left'){
					for ($x = 1 ; $x <= $cntlvl; $x++) {
						if($x != $cntlvl){
						// $this->db->query("update biowash_binary_process set count_left=count_left+1 where level ='$x' and position='Right' ");
						} else {
						// $this->db->query("update biowash_binary_process set count_left=count_left+1 where level ='$x' and position='Right' ");
						}
				}
			}
			}	
			}
			if($data['position']=='Left'){
			// $this->db->query("update biowash_binary_process set count_left=count_left+1 where level ='0' ");
			if($cntlvl !=0){
				if($sPosition=='Right'){
					for ($x = 1 ; $x <= $cntlvl; $x++) {
						// echo "update biowash_binary_process set count_right=count_right+1 where level ='$x' and position='Left' ";
						if($x != $cntlvl){
						// $this->db->query("update biowash_binary_process set count_right=count_right+1 where level ='$x' and position='Left' ");
						} else {
						// $this->db->query("update biowash_binary_process set count_right=count_right+1 where level ='$x' and position='Left' ");
						}
					}
				}
				else if($sPosition=='Left'){
					for ($x = 1 ; $x <= $cntlvl; $x++) {
						if($x != $cntlvl){
						// $this->db->query("update biowash_binary_process set count_left=count_left+1 where level ='$x' and position='Left' ");
						} else {
						// $this->db->query("update biowash_binary_process set count_left=count_left+1 where level ='$x' and position='Left'");
						}
					}
				}
			}
			}
			$this->db->where('bpID', $data['bpID']);
			$this->db->update('biowash_binary_process', $data1);
			$transcode    = $this->transactionCode();
			$directcode   = $results[0]->membercode;
			$maincode     = 'Empathy-Admin';
			$underBy      = $data['directMemberCode'];
			$sponsors     = $this->session->userdata['logged_in']['code'];
			$indirectcode = $data['sponsorMemberCode'];
			$earnbuy      = $data['directMemberCode'];

			//** For Adding new row **//
			$cntlevel 	 = $this->db->query("select * from biowash_binary_process where level ='$level' and position='$position' order by bpID desc limit 1");
			$cntlevelres = $cntlevel->result();
			if($cntlevelres[0]->mainLevel == 0){
			$countlvl = 1;
			} else {
			$countlvl    = $cntlevelres[0]->mainLevel + 1;
			}

			


			$this->db->query("INSERT INTO biowash_binary_process (binaryTransaction,directMemberCode,underBy,sponsorMemberCode,mainMembercode,level,mainLevel,position,secondaryPosition,placement,flushout)
																VALUES ('$transcode','$directcode','$underBy','$sponsors','$maincode','$level','$countlvl','$position','$sPosition','$cnt','0')");

			$dcode = $directcode;
			$this->processPairing($dcode,$dcode);
			$this->processBinaryBonus($dcode,$dcode,1,'');
			// ** GET BINARY PAIRING FOR LEFT AND RIGHT **//
			// $this->binary_matching($level,$data['position'],$cnt);
			
			
			//** SET Code isUsed =1 **//
			$this->db->query("UPDATE biowash_binary_codes set isUsed=1 where transactioncode='$code'");
			//** Get Pairing Bunos **//
			$bpID         = $data['bpID'];
			$getpairing   = $this->db->query("select * from biowash_binary_process where bpID ='$bpID'");
			$pairing      = $getpairing->result();
			
			if($package_type !=1){
				//** Get Pairing Bunos **//
				$bpID       = $data['bpID'];
				$getpairing = $this->db->query("select * from biowash_binary_process where bpID ='$bpID'");
				$pairing    = $getpairing->result();
				if($position == 'Left'){
					$packageright = $pairing[0]->package_right; 
					// GET PAIRING BUNOS //
					if($packageid == 2 && $packageright == 2 ){
							$pairamount = 150;
					} else if($packageid == 2 && $packageright == 3 ){
							$pairamount = 200;
					} else if($packageid == 2 && $packageright == 4 ){
						$pairamount = 250;
					} else if($packageid ==3 && $packageright == 3 ){
						$pairamount = 300;
					} else if($packageid ==3 && $packageright == 2 ){
						$pairamount = 200;
					} else if($packageid ==3 && $packageright == 4 ){
						$pairamount = 300;
					} else if($packageid ==4 && $packageright == 4 ){
						$pairamount = 450;
					} else if($packageid ==4 && $packageright == 2 ){
						$pairamount = 250;
					}  else if($packageid ==4 && $packageright == 3 ){
						$pairamount = 350;
					} else if($packageid == 1 && $packageright == 1 ){
						$pairamount = 0;
					}  else if($packageid == 1 && $packageright == 2 ){
						$pairamount = 0;
					}  else if($packageid == 1 && $packageright == 3 ){
						$pairamount = 0;
					} else if($packageid == 1 && $packageright == 4 ){
						$pairamount = 0;
					} 
				} else if($position == 'Right'){
					$packageleft = $pairing[0]->package_left; 
						if($packageid == 2 && $packageleft == 2 ){
							$pairamount = 150;
						} else if($packageid == 2 && $packageleft == 3 ){
							$pairamount = 200;
						} else if($packageid == 2 && $packageleft == 4 ){
							$pairamount = 250;
						} else if($packageid ==3 && $packageleft == 3 ){
							$pairamount = 300;
						} else if($packageid ==3 && $packageleft == 2 ){
							$pairamount = 200;
						} else if($packageid ==3 && $packageleft == 4 ){
							$pairamount = 300;
						} else if($packageid ==4 && $packageleft == 4 ){
							$pairamount = 450;
						} else if($packageid ==4 && $packageleft == 2 ){
							$pairamount = 250;
						}  else if($packageid ==4 && $packageleft == 3 ){
							$pairamount = 350;
						} else if($packageid ==1 && $packageleft == 1 ){
							$pairamount = 0;
						} else if($packageid ==1 && $packageleft == 2 ){
							$pairamount = 0;
						} else if($packageid ==1 && $packageleft == 3 ){
							$pairamount = 0;
						} else if($packageid ==1 && $packageleft == 4 ){
							$pairamount = 0;
						} 
				}


				// INDIRECT BUNOS //
	
				// if($underBy != $sponsors){
				// 	if($packageid == 2){
				// 		$indirect      = $getearn[0]->silver;
				// 	} else if($packageid == 3){
				// 		$indirect      = $getearn[0]->gold;
				// 	} else if($packageid == 4){
				// 		$indirect      = $getearn[0]->premuim;
				// 	}
				// 	else if($packageid == 1){
				// 		$indirect      = 0;
				// 	}
				// 	$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
				// 	VALUES ('$indirectcode' ,'12345','Indirect Bonus' ,'$indirect')");
				// 	$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$indirect' where membercode='$indirectcode'");
				// } 

		
			$userID = $this->session->userdata['logged_in']['userid'];

			// CHECK FLUSHOUT PACKAGE TYPE // 
			$checktype = $this->db->query("select * from biowash_members where memberID='$userID'");
			$results2  = $checktype->result();
			$flush   = $results2[0]->flashOut;	

			// if($flush == 0){} else {
			// if($pairing[0]->binary_code_left !="" && $pairing[0]->binary_code_right!=""){
			// 	$this->db->query("update biowash_binary_process set isPAIR=1  where bpID ='$bpID'");
			// 	$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
			// 													  VALUES ('$earnbuy' ,'12345','Pairing Bonus' ,'$pairamount')");
			// 	$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$earnbuy'");
			// 	$this->db->query("UPDATE biowash_members set flashOut = flashOut-1 where memberID='$userID'");
			// }
			// }
			}
			redirect('user/genealogy/binary_tree?data='.$data['callback'].'&added');
		}
    }
	public function processbinary_auto($data) {
		$getearn    = $this->settings_model->get_settings_data();
		//$pairamount = $getearn[0]->pairing_earning;
		$code       = $data['binarycode'];
		$position   = $data['position'];
		$checkcode = $this->db->query("select * from biowash_binary_codes where transactioncode='$code' and isUsed='0'");
		$checkres  = $checkcode->num_rows();
		if($checkres == 0){
			redirect('user/genealogy/binary_tree?data='.$data['callback'].'&errorcode');
		}  else { 

			$transcode   = $this->transactionCode();
			$results     = $checkcode->result();
			$membercode  = $results[0]->membercode;
			$binarycode  = $data['binarycode'];
			$packageid   = $data['package_id'];
			if($position == 'Left'){
				$getbinarydata = $this->db->query("select * from biowash_binary_process where position='Left' and binary_code_left=''   order by placement asc limit 1 ");
			} else if($position == 'Right'){
				$getbinarydata = $this->db->query("select * from biowash_binary_process where position='Right' and binary_code_right='' order by placement desc limit 1 ");
			}
			$getbinaryres  = $getbinarydata->result();
			$transcode    = $this->transactionCode();
			$directcode   = $results[0]->membercode;
			$maincode     = 'Empathy-Admin';
			$underby      = $getbinaryres[0]->directMemberCode ;
			$sponsors     = substr($getbinaryres[0]->directMemberCode ,0, -10);
			$level        = $getbinaryres[0]->level + 1;
			$bpid         = $getbinaryres[0]->bpID;
			$ssPosition   = $getbinaryres[0]->secondaryPosition;
			$cntlvl       = $getbinaryres[0]->level ;
			$cntlvl       = $getbinaryres[0]->level ;

			if($position == 'Left'){
				$packageright = $getbinaryres[0]->package_right; 
				// GET PAIRING BUNOS //
				if($packageid == 2 && $packageright == 2 ){
						$pairamount = 150;
				} else if($packageid == 2 && $packageright == 3 ){
						$pairamount = 200;
				} else if($packageid == 2 && $packageright == 4 ){
					$pairamount = 250;
				} else if($packageid ==3 && $packageright == 3 ){
					$pairamount = 300;
				} else if($packageid ==3 && $packageright == 2 ){
					$pairamount = 200;
				} else if($packageid ==3 && $packageright == 4 ){
					$pairamount = 300;
				} else if($packageid ==4 && $packageright == 4 ){
					$pairamount = 450;
				} else if($packageid ==4 && $packageright == 2 ){
					$pairamount = 250;
				}  else if($packageid ==4 && $packageright == 3 ){
					$pairamount = 350;
				} 
			} else if($position == 'Right'){
				$packageleft = $getbinaryres[0]->package_left; 
					if($packageid == 2 && $packageleft == 2 ){
						$pairamount = 150;
					} else if($packageid == 2 && $packageleft == 3 ){
						$pairamount = 200;
					} else if($packageid == 2 && $packageleft == 4 ){
						$pairamount = 250;
					} else if($packageid ==3 && $packageleft == 3 ){
						$pairamount = 300;
					} else if($packageid ==3 && $packageleft == 2 ){
						$pairamount = 200;
					} else if($packageid ==3 && $packageleft == 4 ){
						$pairamount = 300;
					} else if($packageid ==4 && $packageleft == 4 ){
						$pairamount = 450;
					} else if($packageid ==4 && $packageleft == 2 ){
						$pairamount = 250;
					}  else if($packageid ==4 && $packageleft == 3 ){
						$pairamount = 350;
					} 
			}

		
			if($position == 'Left'){
				if($getbinaryres[0]->binary_code_left =="" ){
				$sPosition    = "Left";
				if($level == 2 || $level == 3 || $level == 4){
					$placement = 1;
				}

				$this->db->query("update biowash_binary_process set binary_code_left='$code' , membercode_left='$membercode' ,package_left='$packageid' where bpID='$bpid'");
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
																		  VALUES ('Empathy-Admin' ,'$transcode','Pairing Bunos' ,'$pairamount')");
							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='Empathy-Admin'");
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
																		  VALUES ('Empathy-Admin' ,'$transcode','Pairing Bunos' ,'$pairamount')");
							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='Empathy-Admin'");
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
																		  VALUES ('Empathy-Admin' ,'$transcode','Pairing Bunos' ,'$pairamount')");
							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='Empathy-Admin'");
						} 
						}
					}
				}
				
				
					// $this->db->query("update biowash_binary_process set count_left=count_left+1 where level ='0' ");
					if($cntlvl !=0){
							for ($x = 1 ; $x <= $cntlvl; $x++) {
								if($x != $cntlvl){
								// $this->db->query("update biowash_binary_process set count_left=count_left+1 where level ='$x' and position='Left' ");
								} else {
								// $this->db->query("update biowash_binary_process set count_left=count_left+1 where level ='$x' and position='Left'");
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
				
				$this->db->query("update biowash_binary_process set binary_code_right='$code' , membercode_right='$membercode',package_right='$packageid where bpID='$bpid'");
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
																		  VALUES ('Empathy-Admin' ,'$transcode','Pairing Bunos' ,'$pairamount')");
							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='Empathy-Admin'");
							
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
																		  VALUES ('Empathy-Admin' ,'$transcode','Pairing Bunos' ,'$pairamount')");
							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='Empathy-Admin'");
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
																		  VALUES ('Empathy-Admin' ,'$transcode','Pairing Bunos' ,'$pairamount')");
							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='Empathy-Admin'");
						} 
						}
					}
				}
				
				
					// $this->db->query("update biowash_binary_process set count_right=count_right+1 where level ='0' ");
					if($cntlvl !=0){
							for ($x = 1 ; $x <= $cntlvl; $x++) {
								if($x != $cntlvl){
								// $this->db->query("update biowash_binary_process set count_right=count_right+1 where level ='$x' and position='Right' ");
								} else {
								// $this->db->query("update biowash_binary_process set count_right=count_right+1 where level ='$x' and position='Right'");
								}
							}
						}
					}
			} 
		
	
			$this->db->query("UPDATE biowash_binary_codes set isUsed=1 where transactioncode='$code'");
			$checkforpairing = $this->db->query("select * from biowash_binary_process where  bpID = '$bpid'");
			$pairingresult   = $checkforpairing->result();
			
			// if($pairingresult[0]->binary_code_left !="" && $pairingresult[0]->binary_code_right!=""){
			// 	$this->db->query("update biowash_binary_process set isPAIR=1 where bpID ='$bpid'");
			// 	$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
			// 													  VALUES ('$sponsors' ,'$transcode','Pairing Bunos' ,'$pairamount')");
			// 	$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$ '");
			// 	$userID = $this->session->userdata['logged_in']['userid'];
			// 	$this->db->query("UPDATE biowash_members set flashout = flashout-1 where memberID='$userID'");
			// }
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
		$message  = '<b>EMPATHY System Email Verification</b>';
		$message .= '<br><br> Hello  , ' . $data['name'];
		$message .= '<br> <br> Verify your account by clicking this <a href="'.$link.'" target="_blank"> link </a>';
		$message .= '<br> <br> <br> Thank You!</a>';
		$subject  = 'Email Verification';
		$to       = $email;
		$message_result = '';
		//To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: Empathy Bl3nd System <support@empathybl3nd.system>' . "\r\n";
		mail($to, $subject, $message, $headers);
    }
	
	public function binary_matching($cntlvl,$position,$cnt){
		$pairamount = 150;
		$transcode  = $this->transactionCode();
		// if($cntlvl ==2){
		// 	if($position == 'Left'){
		// 		$getright    = $this->db->query("select * from biowash_binary_process where level='$cntlvl' and position ='Right' ");
		// 		$getrightres = $getright->num_rows();
		// 		if($getrightres !=0){
		// 			$rigthresult = $getright->result();
		// 			foreach($rigthresult as $val=>$row){
		// 			if($cnt ==1){
		// 			if($row->mainLevel==1 && $row->isMatch ==0){
		// 				$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement=1");
		// 				$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement='1'");
		// 				$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 															  VALUES ('Empathy-Admin' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 				$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='Empathy-Admin'");
		// 				break;
		// 			} else if($row->mainLevel==2 && $row->isMatch ==0){
		// 					$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement=2");
		// 					$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement='1'");
		// 					$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																  VALUES ('Empathy-Admin' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 					$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='Empathy-Admin'");
		// 				break;
		// 				} 
		// 			} else if($cnt ==2){
		// 				if($row->mainLevel==1 && $row->isMatch ==0){
		// 					$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement=1");
		// 					$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement='2'");
		// 					$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																  VALUES ('Empathy-Admin' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 					$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='Empathy-Admin'");
		// 					break;
		// 					} else if($row->mainLevel==2 && $row->isMatch ==0){
		// 					$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement=2");
		// 					$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement='2'");
		// 					$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																  VALUES ('Empathy-Admin' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 					$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='Empathy-Admin'");
		// 					break;
		// 					}
						
		// 			}
		// 		}
		// 		}
		// 	}
		// 	if($position == 'Right'){
		// 		$getleft      = $this->db->query("select * from biowash_binary_process where level='$cntlvl' and position ='Left' ");
		// 		$getleftres   = $getleft->num_rows();
		// 		if($getleftres !=0){
		// 			$leftresult = $getleft->result();
		// 			foreach($leftresult as $val=>$row){
		// 			if($cnt ==1){
		// 				if($row->mainLevel==1 && $row->isMatch ==0){
		// 					$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement=1");
		// 					$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement='1'");
		// 					$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																  VALUES ('Empathy-Admin' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 					$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='Empathy-Admin'");
		// 					break;
		// 				} else if($row->mainLevel==2 && $row->isMatch ==0){
		// 					$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement=2");
		// 					$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement='1'");
		// 					$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																  VALUES ('Empathy-Admin' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 					$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='Empathy-Admin'");
		// 					break;
		// 				}
		// 			}
		// 			else if($cnt ==2){
		// 				if($row->mainLevel==1 && $row->isMatch ==0){
		// 					$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement=1");
		// 					$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement='2'");
		// 					$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																  VALUES ('Empathy-Admin' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 					$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='Empathy-Admin'");
		// 					break;
		// 				} else if($row->mainLevel==2 && $row->isMatch ==0){
		// 					$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement=2");
		// 					$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement='2'");
		// 					$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																  VALUES ('Empathy-Admin' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 					$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='Empathy-Admin'");
		// 					break;
		// 				}
		// 			}
		// 		}
		// 		}
		// 	}
		// }
		// if($cntlvl ==3){
		// 	// ** earnings for left ** //
		// 	if($position == 'Left' ){
		// 			$getleftarn    = $this->db->query("select * from biowash_binary_process where level='1' and position ='Left'");
		// 			echo "select * from biowash_binary_process where level='1' and position ='Left'";
		// 			exit;
		// 			$getlres       = $getleftarn->result();
		// 			$sponsor       = $getlres[0]->directMemberCode;
		// 			$bpID          = $getlres[0]->bpID;
		// 			$flushout      = $getlres[0]->flushout;
		// 		// if($flushout == 0){} else {
		// 		$getleft2    = $this->db->query("select * from biowash_binary_process where level='$cntlvl' and position ='Left' ");
		// 		$getleftres2 = $getleft2->num_rows();
		// 		if($getleftres2 !=0){
		// 			foreach($getleft2->result() as $val=>$row){
		// 				if($cnt ==1){
		// 					if($row->mainLevel==3 && $row->isMatchlvl3_left ==0){
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl3_left=1 where level='$cntlvl' and position ='Left' and placement=3");
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl3_left=1 where level='$cntlvl' and position ='Left' and placement='1'");
		// 							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																		  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 							$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					}  else if($row->mainLevel==4 && $row->isMatchlvl3_left ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl3_left=1 where level='$cntlvl' and position ='Left' and placement=4");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl3_left=1 where level='$cntlvl' and position ='Left' and placement='1'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					}
		// 				} 
		// 				else if($cnt ==2 ){
		// 					if($row->mainLevel==3 && $row->isMatchlvl3_left ==0){
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl3_left=1 where level='$cntlvl' and position ='Left' and placement=3");
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl3_left=1 where level='$cntlvl' and position ='Left' and placement='$cnt'");
		// 							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																		  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					} else if($row->mainLevel==4 && $row->isMatchlvl3_left ==0){
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl3_left=1 where level='$cntlvl' and position ='Left' and placement=4");
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl3_left=1 where level='$cntlvl' and position ='Left' and placement='$cnt'");
		// 							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																		  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					}
		// 				}
		// 				else if($cnt ==3 ){
		// 					if($row->mainLevel==1 && $row->isMatchlvl3_left ==0){
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl3_left=1 where level='$cntlvl' and position ='Left' and placement=1");
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl3_left=1 where level='$cntlvl' and position ='Left' and placement='3'");
		// 							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																		  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					} else if($row->mainLevel==2 && $row->isMatchlvl3_left ==0){
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl3_left=1 where level='$cntlvl' and position ='Left' and placement=2");
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl3_left=1 where level='$cntlvl' and position ='Left' and placement='3'");
		// 							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																		  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					} 
		// 				}
		// 				else if($cnt ==4 ){
		// 					if($row->mainLevel==1 && $row->isMatchlvl3_left ==0){
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl3_left=1 where level='$cntlvl' and position ='Left' and placement=1");
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl3_left=1 where level='$cntlvl' and position ='Left' and placement='$cnt'");
		// 							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																		  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					} else if($row->mainLevel==2 && $row->isMatchlvl3_left ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl3_left=1 where level='$cntlvl' and position ='Left' and placement=2");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl3_left=1 where level='$cntlvl' and position ='Left' and placement='$cnt'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					}
		// 				}
						
		// 			}
		// 		}
		// 		// }
		// 	} 
		// 	if($position == 'Right' ){
		// 			$getleftarn    = $this->db->query("select * from biowash_binary_process where level='1' and position ='Right'");
		// 			$getlres       = $getleftarn->result();
		// 			$sponsor       = $getlres[0]->directMemberCode;
		// 			$bpID          = $getlres[0]->bpID;
		// 			$flushout      = $getlres[0]->flushout;
		// 		// if($flushout == 0){} else {
		// 		$getright2    = $this->db->query("select * from biowash_binary_process where level='$cntlvl' and position ='Right' ");
			
		// 		$getrightres2 = $getright2->num_rows();
		// 		if($getrightres2 !=0){
		// 			foreach($getright2->result() as $val=>$row){
		// 				if($cnt ==1){
		// 					if($row->mainLevel==3 && $row->isMatchlvl3_right ==0){
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl3_right=1 where level='$cntlvl' and position ='Right' and placement=3");
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl3_right=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
		// 							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																		  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					} else if($row->mainLevel==4 && $row->isMatchlvl3_right ==0){
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl3_right=1 where level='$cntlvl' and position ='Right' and placement=4");
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl3_right=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
		// 							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																		  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					}
		// 				} 
		// 				else if($cnt ==2 ){
		// 					if($row->mainLevel==3 && $row->isMatchlvl3_right ==0){
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl3_right=1 where level='$cntlvl' and position ='Right' and placement=3");
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl3_right=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
		// 							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																		  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
							
		// 					}  else if($row->mainLevel==4 && $row->isMatchlvl3_right ==0){
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl3_right=1 where level='$cntlvl' and position ='Right' and placement=4");
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl3_right=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
		// 							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																		  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					}
		// 				} 
		// 				else if($cnt ==3 ){
		// 					if($row->mainLevel==1 && $row->isMatchlvl3_right ==0){
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl3_right=1 where level='$cntlvl' and position ='Right' and placement=1");
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl3_right=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
		// 							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																		  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					} else if($row->mainLevel==2 && $row->isMatchlvl3_right ==0){
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl3_right=1 where level='$cntlvl' and position ='Right' and placement=2");
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl3_right=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
		// 							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																		  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					}
		// 				}
		// 				else if($cnt ==4 ){
		// 					if($row->mainLevel==1 && $row->isMatchlvl3_right ==0){
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl3_right=1 where level='$cntlvl' and position ='Right' and placement=1");
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl3_right=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
		// 							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																		  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					}  else if($row->mainLevel==2 && $row->isMatchlvl3_right ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl3_right=1 where level='$cntlvl' and position ='Right' and placement=2");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl3_right=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					} 
		// 				}
						
		// 			}
		// 		}
		// 		// }
		// 	}
		// 	// ** for top earnings ** //
		// 	if($position == 'Left'){
		// 		$getright    = $this->db->query("select * from biowash_binary_process where level='$cntlvl' and position ='Right' ");
		// 		$getrightres = $getright->num_rows();
		// 		if($getrightres !=0){
		// 			$rigthresult = $getright->result();
		// 			foreach($rigthresult as $val=>$row){
		// 			if($row->mainLevel==1 && $row->isMatch ==0){
		// 				$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement=1");
		// 				$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement='$cnt'");
		// 				$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 															  VALUES ('Empathy-Admin' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 				$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='Empathy-Admin'");
		// 				break;
		// 			} else if($row->mainLevel==2 && $row->isMatch ==0){
		// 					$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement=2");
		// 					$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement='$cnt'");
		// 					$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																  VALUES ('Empathy-Admin' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 					$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='Empathy-Admin'");
		// 					break;
		// 				} else if($row->mainLevel==3 && $row->isMatch ==0){
		// 						$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement=3");
		// 						$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement='$cnt'");
		// 						$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																	  VALUES ('Empathy-Admin' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 						$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='Empathy-Admin'");
		// 					break;
		// 					} else if($row->mainLevel==4 && $row->isMatch ==0){
		// 							$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement=4");
		// 							$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement='$cnt'");
		// 							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																		  VALUES ('Empathy-Admin' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='Empathy-Admin'");
		// 					break;
		// 					}
		// 		}
		// 		}
		// 	}
		// 	if($position == 'Right'){
		// 		$getleft      = $this->db->query("select * from biowash_binary_process where level='$cntlvl' and position ='Left' ");
		// 		$getleftres   = $getleft->num_rows();
		// 		if($getleftres !=0){
		// 			$leftresult = $getleft->result();
		// 			foreach($leftresult as $val=>$row){
		// 			if($row->mainLevel==1 && $row->isMatch ==0){
		// 				$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement=1");
		// 				$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
		// 				$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 															  VALUES ('Empathy-Admin' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 				$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='Empathy-Admin'");
		// 				break;
		// 			} else if($row->mainLevel==2 && $row->isMatch ==0){
		// 					$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement=2");
		// 					$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
		// 					$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																  VALUES ('Empathy-Admin' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 					$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='Empathy-Admin'");
		// 				break;
		// 			} else if($row->mainLevel==3 && $row->isMatch ==0){
		// 						$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement=3");
		// 						$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
		// 						$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																	  VALUES ('Empathy-Admin' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 						$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='Empathy-Admin'");
		// 				break;
		// 			} else if($row->mainLevel==4 && $row->isMatch ==0){
		// 							$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement=4");
		// 							$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
		// 							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																		  VALUES ('Empathy-Admin' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='Empathy-Admin'");
		// 				break;
		// 			}
		// 		}
		// 		}
		// 	}
			
		// }
		// if($cntlvl ==4){
		// 	// echo $cnt;
		// 	// ** earnings for left ** //
		// 	$getlefttop     = $this->db->query("select * from biowash_binary_process where level='1' and position ='Left' and placement =1");
		// 	$getltopres     = $getlefttop->result();
		// 	$sponsorl       = substr($getltopres[0]->directMemberCode ,0, -10);
		// 	$bpID1          = $getltopres[0]->bpID;
		// 	$flushout1      = $getltopres[0]->flushout;
		
		// 	$getrighttop    = $this->db->query("select * from biowash_binary_process where level='1' and position ='Right' and placement =1");
		// 	$getlrtopres    = $getrighttop->result();
		// 	$sponsorr       = substr($getlrtopres[0]->directMemberCode ,0, -10);
		// 	$bpID2          = $getlrtopres[0]->bpID;
		// 	$flushout2      = $getlrtopres[0]->flushout;
		// 	if($position == 'Left' ){ 
		// 		if($cnt == 1 || $cnt ==2 || $cnt == 3 || $cnt ==4){
		// 			$getleftarn    = $this->db->query("select * from biowash_binary_process where level='2' and position ='Left' and placement =1");
		// 			$getlres       = $getleftarn->result();
		// 			$sponsor       = $getlres[0]->directMemberCode;
		// 			$bpID          = $getlres[0]->bpID;
		// 			$flushout      = $getlres[0]->flushout;
					
		// 		} if($cnt == 5 || $cnt ==6 || $cnt == 7 || $cnt ==8){
		// 			$getleftarn    = $this->db->query("select * from biowash_binary_process where level='2' and position ='Left' and placement =2");
		// 			$getlres       = $getleftarn->result();
		// 			$sponsor       = $getlres[0]->directMemberCode;
		// 			$bpID          = $getlres[0]->bpID;
		// 			$flushout      = $getlres[0]->flushout;
		// 		}
		// 		if($flushout ==0){} else {
		// 		$getleft2    = $this->db->query("select * from biowash_binary_process where level='$cntlvl' and position ='Left' ");
		// 		$getleftres2 = $getleft2->num_rows();
		// 		if($getleftres2 !=0){
		// 			foreach($getleft2->result() as $val=>$row){
		// 				if($cnt ==1){
		// 					if($row->mainLevel==3 && $row->isMatchlvl4_left ==0){
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl4_left=1 where level='$cntlvl' and position ='Left' and placement=3");
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl4_left=1 where level='$cntlvl' and position ='Left' and placement='1'");
		// 							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																		  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 							$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					} 
		// 					else if($row->mainLevel==4 && $row->isMatchlvl4_left ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4_left=1 where level='$cntlvl' and position ='Left' and placement=4");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4_left=1 where level='$cntlvl' and position ='Left' and placement='1'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					}
							
		// 				} 
		// 				else if($cnt ==2 ){
		// 					if($row->mainLevel==3 && $row->isMatchlvl4_left ==0){
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl4_left=1 where level='$cntlvl' and position ='Left' and placement=3");
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl4_left=1 where level='$cntlvl' and position ='Left' and placement='$cnt'");
		// 							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																		  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 							$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					} else if($row->mainLevel==4 && $row->isMatchlvl4_left ==0){
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl4_left=1 where level='$cntlvl' and position ='Left' and placement=4");
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl4_left=1 where level='$cntlvl' and position ='Left' and placement='$cnt'");
		// 							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																		  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 							$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					}
							
		// 				}
		// 				else if($cnt ==3 ){
		// 					if($row->mainLevel==1 && $row->isMatchlvl4_left ==0){
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl4_left=1 where level='$cntlvl' and position ='Left' and placement=1");
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl4_left=1 where level='$cntlvl' and position ='Left' and placement='3'");
		// 							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																		  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 							$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					} else if($row->mainLevel==2 && $row->isMatchlvl4_left ==0){
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl4_left=1 where level='$cntlvl' and position ='Left' and placement=2");
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl4_left=1 where level='$cntlvl' and position ='Left' and placement='3'");
		// 							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																		  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 							$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					} 
							
		// 				}
		// 				else if($cnt ==4 ){
		// 					if($row->mainLevel==1 && $row->isMatchlvl4_left ==0){
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl4_left=1 where level='$cntlvl' and position ='Left' and placement=1");
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl4_left=1 where level='$cntlvl' and position ='Left' and placement='$cnt'");
		// 							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																		  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 							$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
							
		// 					break;
		// 					} else if($row->mainLevel==2 && $row->isMatchlvl4_left ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4_left=1 where level='$cntlvl' and position ='Left' and placement=2");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4_left=1 where level='$cntlvl' and position ='Left' and placement='$cnt'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
							
		// 					break;
		// 					}
							
		// 				}
		// 				else if($cnt ==5 ){
		// 					if($row->mainLevel==7 && $row->isMatchlvl4_left ==0){
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl4_left=1 where level='$cntlvl' and position ='Left' and placement=7");
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl4_left=1 where level='$cntlvl' and position ='Left' and placement='$cnt'");
		// 							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																		  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 							$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					} else if($row->mainLevel==8 && $row->isMatchlvl4_left ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4_left=1 where level='$cntlvl' and position ='Left' and placement=8");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4_left=1 where level='$cntlvl' and position ='Left' and placement='$cnt'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					}
							
		// 				}
		// 				else if($cnt ==6 ){
		// 					if($row->mainLevel==7 && $row->isMatchlvl4_left ==0){
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl4_left=1 where level='$cntlvl' and position ='Left' and placement=7");
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl4_left=1 where level='$cntlvl' and position ='Left' and placement='$cnt'");
		// 							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																		  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 							$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					} else if($row->mainLevel==8 && $row->isMatchlvl4_left ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4_left=1 where level='$cntlvl' and position ='Left' and placement=8");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4_left=1 where level='$cntlvl' and position ='Left' and placement='$cnt'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					}
							
		// 				}
		// 				else if($cnt ==7 ){
		// 					if($row->mainLevel==5 && $row->isMatchlvl4_left ==0){
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl4_left=1 where level='$cntlvl' and position ='Left' and placement=5");
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl4_left=1 where level='$cntlvl' and position ='Left' and placement='$cnt'");
		// 							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																		  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 							$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					} else if($row->mainLevel==6 && $row->isMatchlvl4_left ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4_left=1 where level='$cntlvl' and position ='Left' and placement=6");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4_left=1 where level='$cntlvl' and position ='Left' and placement='$cnt'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					}
							
		// 				}
		// 				else if($cnt ==8 ){
		// 					if($row->mainLevel==5 && $row->isMatchlvl4_left ==0){
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl4_left=1 where level='$cntlvl' and position ='Left' and placement=5");
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl4_left=1 where level='$cntlvl' and position ='Left' and placement='$cnt'");
		// 							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																		  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 							$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					} else if($row->mainLevel==6 && $row->isMatchlvl4_left ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4_left=1 where level='$cntlvl' and position ='Left' and placement=6");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4_left=1 where level='$cntlvl' and position ='Left' and placement='$cnt'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					}
							
		// 				}
						
		// 			}
		// 		}
		// 		}
		// 	} 
		// 	if($position == 'Left' ){
		// 		if($flushout1==0){} else {
		// 		$getleft2    = $this->db->query("select * from biowash_binary_process where level='$cntlvl' and position ='Left' ");
		// 		$getleftres2 = $getleft2->num_rows();
		// 		if($getleftres2 !=0){
		// 			foreach($getleft2->result() as $val=>$row){
		// 				if($cnt ==1){
		// 					// ** EARN FOR LEFT TOP ** //
		// 					if($row->mainLevel==5 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement=5");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement='1'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorl' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorl'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID1'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==6 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement=6");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement='1'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorl' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorl'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID1'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==7 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement=7");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement='1'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorl' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorl'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID1'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==8 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement=8");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement='1'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorl' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorl'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID1'");
		// 					break;
		// 					}
		// 				} 
		// 				else if($cnt ==2 ){
							
		// 					// ** EARN FOR LEFT TOP ** //
		// 					if($row->mainLevel==5 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement=5");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement='2'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorl' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorl'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID1'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==6 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement=6");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement='2'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorl' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorl'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID1'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==7 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement=7");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement='2'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorl' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorl'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID1'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==8 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement=8");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement='2'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorl' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorl'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID1'");
		// 					break;
		// 					}
		// 				}
		// 				else if($cnt ==3 ){
							
		// 					// ** EARN FOR LEFT TOP ** //
		// 					if($row->mainLevel==5 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement=5");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement='3'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorl' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorl'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID1'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==6 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement=6");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement='3'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorl' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorl'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID1'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==7 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement=7");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement='3'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorl' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorl'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID1'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==8 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement=8");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement='3'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorl' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorl'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID1'");
		// 					break;
		// 					}
		// 				}
		// 				else if($cnt ==4 ){
							
		// 					// ** EARN FOR LEFT TOP ** //
		// 					if($row->mainLevel==5 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement=5");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement='4'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorl' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorl'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID1'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==6 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement=6");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement='4'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorl' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorl'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID1'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==7 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement=7");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement='4'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorl' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorl'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID1'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==8 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement=8");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement='4'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorl' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorl'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID1'");
		// 					break;
		// 					}
		// 				}
		// 				else if($cnt ==5 ){
						
		// 					// ** EARN FOR LEFT TOP ** //
		// 					if($row->mainLevel==1 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement=5");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement='1'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorl' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorl'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID1'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==2 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement=5");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement='2'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorl' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorl'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID1'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==3 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement=5");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement='3'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorl' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorl'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID1'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==4 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement=5");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement='4'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorl' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorl'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID1'");
		// 					break;
		// 					}
		// 				}
		// 				else if($cnt ==6 ){
							
		// 					// ** EARN FOR LEFT TOP ** //
		// 					if($row->mainLevel==1 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement=6");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement='1'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorl' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorl'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID1'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==2 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement=6");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement='2'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorl' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorl'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID1'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==3 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement=6");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement='3'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorl' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorl'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID1'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==4 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement=6");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement='4'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorl' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorl'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID1'");
		// 					break;
		// 					}
		// 				}
		// 				else if($cnt ==7 ){
							
		// 					// ** EARN FOR LEFT TOP ** //
		// 					if($row->mainLevel==1 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement=7");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement='1'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorl' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorl'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID1'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==2 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement=7");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement='2'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorl' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorl'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID1'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==3 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement=7");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement='3'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorl' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorl'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID1'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==4 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement=7");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement='4'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorl' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorl'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID1'");
		// 					break;
		// 					}
		// 				}
		// 				else if($cnt ==8 ){
							
		// 						// ** EARN FOR LEFT TOP ** //
		// 					if($row->mainLevel==1 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement=8");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement='1'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorl' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorl'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID1'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==2 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement=8");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement='2'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorl' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorl'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID1'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==3 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement=8");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement='3'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorl' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorl'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID1'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==4 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement=8");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Left' and placement='4'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorl' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorl'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID1'");
		// 					break;
		// 					}
		// 				}
						
		// 			}
		// 		}
		// 	}
		// } 
		// 	if($position == 'Right' ){
		// 		if($cnt == 1 ||$cnt==2 || $cnt == 3 ||$cnt==4){
		// 			$getleftarn    = $this->db->query("select * from biowash_binary_process where level='2' and position ='Right' and placement =1");
		// 			$getlres       = $getleftarn->result();
		// 			$sponsor       = $getlres[0]->directMemberCode;
		// 			$bpID          = $getlres[0]->bpID;
		// 			$flushout      = $getlres[0]->flushout;
		// 		} if($cnt == 5 ||$cnt==6 || $cnt == 7 ||$cnt==8){
		// 			$getleftarn    = $this->db->query("select * from biowash_binary_process where level='2' and position ='Right' and placement =2");
		// 			$getlres       = $getleftarn->result();
		// 			$sponsor       = $getlres[0]->directMemberCode;
		// 			$bpID          = $getlres[0]->bpID;
		// 			$flushout      = $getlres[0]->flushout;
		// 		}
		// 		if($flushout ==0){} else {
		// 		$getright2    = $this->db->query("select * from biowash_binary_process where level='$cntlvl' and position ='Right' ");
		// 		$getrightres2 = $getright2->num_rows();
		// 		if($getrightres2 !=0){
		// 			foreach($getright2->result() as $val=>$row){
		// 				if($cnt ==1){
		// 					if($row->mainLevel==3 && $row->isMatchlvl4_right ==0){
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl4_right=1 where level='$cntlvl' and position ='Right' and placement=3");
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl4_right=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
		// 							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																		  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 							$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
							
		// 					break;
		// 					} else if($row->mainLevel==4 && $row->isMatchlvl4_right ==0){
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl4_right=1 where level='$cntlvl' and position ='Right' and placement=4");
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl4_right=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
		// 							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																		  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 							$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					}
							
		// 				} 
		// 				else if($cnt ==2 ){
		// 					if($row->mainLevel==3 && $row->isMatchlvl4_right ==0){
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl4_right=1 where level='$cntlvl' and position ='Right' and placement=3");
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl4_right=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
		// 							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																		  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 							$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
							
		// 					}  else if($row->mainLevel==4 && $row->isMatchlvl4_right ==0){
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl4_right=1 where level='$cntlvl' and position ='Right' and placement=4");
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl4_right=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
		// 							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																		  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 							$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					}
							
		// 				} 
		// 				else if($cnt ==3 ){
		// 					if($row->mainLevel==1 && $row->isMatchlvl4_right ==0){
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl4_right=1 where level='$cntlvl' and position ='Right' and placement=1");
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl4_right=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
		// 							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																		  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 							$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					} else if($row->mainLevel==2 && $row->isMatchlvl4_right ==0){
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl4_right=1 where level='$cntlvl' and position ='Right' and placement=2");
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl4_right=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
		// 							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																		  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 							$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					}
							
		// 				}
		// 				else if($cnt ==4 ){
		// 					if($row->mainLevel==1 && $row->isMatchlvl4_right ==0){
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl4_right=1 where level='$cntlvl' and position ='Right' and placement=1");
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl4_right=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
		// 							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																		  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 							$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					}  else if($row->mainLevel==2 && $row->isMatchlvl4_right ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4_right=1 where level='$cntlvl' and position ='Right' and placement=2");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4_right=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					} 
							
		// 				}
		// 				else if($cnt ==5 ){
		// 					if($row->mainLevel==7 && $row->isMatchlvl4_right ==0){
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl4_right=1 where level='$cntlvl' and position ='Right' and placement=7");
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl4_right=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
		// 							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																		  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 							$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					}  else if($row->mainLevel==8 && $row->isMatchlvl4_right ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4_right=1 where level='$cntlvl' and position ='Right' and placement=8");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4_right=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					} 
							
		// 				}
		// 				else if($cnt ==6 ){
		// 					if($row->mainLevel==7 && $row->isMatchlvl4_right ==0){
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl4_right=1 where level='$cntlvl' and position ='Right' and placement=7");
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl4_right=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
		// 							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																		  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 							$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					}  else if($row->mainLevel==8 && $row->isMatchlvl4_right ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4_right=1 where level='$cntlvl' and position ='Right' and placement=8");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4_right=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					} 
		// 					// ** EARN FOR RIGHT TOP ** //
		// 					if($row->mainLevel==5 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement=1");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement='6'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorr' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorr'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==6 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement=2");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement='6'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorr' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorr'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==7 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement=3");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement='6'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorr' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorr'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==8 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement=4");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement='6'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorr' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorr'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					}
		// 				}
		// 				else if($cnt ==7 ){
		// 					if($row->mainLevel==5 && $row->isMatchlvl4_right ==0){
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl4_right=1 where level='$cntlvl' and position ='Right' and placement=5");
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl4_right=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
		// 							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																		  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 							$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					}  else if($row->mainLevel==6 && $row->isMatchlvl4_right ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4_right=1 where level='$cntlvl' and position ='Right' and placement=6");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4_right=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					} 
						
		// 				}
		// 				else if($cnt ==8 ){
		// 					if($row->mainLevel==5 && $row->isMatchlvl4_right ==0){
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl4_right=1 where level='$cntlvl' and position ='Right' and placement=5");
		// 							$this->db->query("update biowash_binary_process set  isMatchlvl4_right=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
		// 							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																		  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 							$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					}  else if($row->mainLevel==6 && $row->isMatchlvl4_right ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4_right=1 where level='$cntlvl' and position ='Right' and placement=6");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4_right=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsor' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsor'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID'");
		// 					break;
		// 					} 
						
		// 				}
		// 			}
		// 		}
		// 		}
		// 	}
		// 	if($position == 'Right' ){
		// 		if($flushout2==0){} else {
		// 		$getright2    = $this->db->query("select * from biowash_binary_process where level='$cntlvl' and position ='Right' ");
		// 		$getrightres2 = $getright2->num_rows();
		// 		if($getrightres2 !=0){
		// 			foreach($getright2->result() as $val=>$row){
		// 				if($cnt ==1){
		// 					// ** EARN FOR RIGHT TOP ** //
		// 					if($row->mainLevel==5 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement=5");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement='1'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorr' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorr'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID2'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==6 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement=6");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement='1'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorr' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorr'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID2'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==7 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement=7");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement='1'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorr' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorr'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID2'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==8 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement=8");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement='1'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorr' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorr'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID2'");
		// 					break;
		// 					}
		// 				} 
		// 				else if($cnt ==2 ){
							
		// 					// ** EARN FOR RIGHT TOP ** //
		// 					if($row->mainLevel==5 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement=5");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement='2'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorr' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorr'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID2'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==6 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement=6");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement='2'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorr' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorr'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID2'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==7 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement=7");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement='2'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorr' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorr'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID2'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==8 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement=8");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement='2'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorr' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorr'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID2'");
		// 					break;
		// 					}
		// 				} 
		// 				else if($cnt ==3 ){
							
		// 					// ** EARN FOR RIGHT TOP ** //
		// 					if($row->mainLevel==5 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement=5");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement='3'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorr' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorr'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID2'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==6 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement=6");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement='3'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorr' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorr'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID2'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==7 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement=7");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement='3'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorr' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorr'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID2'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==8 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement=8");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement='3'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorr' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorr'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID2'");
		// 					break;
		// 					}
		// 				}
		// 				else if($cnt ==4 ){
							
		// 					// ** EARN FOR RIGHT TOP ** //
		// 					if($row->mainLevel==5 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement=5");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement='4'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorr' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorr'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID2'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==6 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement=6");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement='4'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorr' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorr'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID2'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==7 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement=7");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement='4'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorr' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorr'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID2'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==8 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement=8");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement='4'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorr' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorr'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID2'");
		// 					break;
		// 					}
		// 				}
		// 				else if($cnt ==5 ){
							
		// 					// ** EARN FOR RIGHT TOP ** //
		// 					if($row->mainLevel==1 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement=1");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement='5'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorr' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorr'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID2'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==2 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement=2");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement='5'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorr' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorr'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID2'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==3 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement=3");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement='5'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorr' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorr'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID2'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==4 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement=4");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement='5'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorr' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorr'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID2'");
		// 					break;
		// 					}
		// 				}
		// 				else if($cnt ==6 ){
							
		// 					// ** EARN FOR RIGHT TOP ** //
		// 					if($row->mainLevel==1 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement=1");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement='6'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorr' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorr'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID2'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==2 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement=2");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement='6'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorr' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorr'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID2'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==3 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement=3");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement='6'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorr' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorr'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID2'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==4 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement=4");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement='6'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorr' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorr'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID2'");
		// 					break;
		// 					}
		// 				}
		// 				else if($cnt ==7 ){
							
		// 					// ** EARN FOR RIGHT TOP ** //
		// 					if($row->mainLevel==1 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement=1");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement='7'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorr' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorr'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID2'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==2 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement=2");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement='7'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorr' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorr'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID2'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==3 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement=3");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement='7'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorr' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorr'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID2'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==4 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement=4");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement='7'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorr' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorr'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID2'");
		// 					break;
		// 					}
		// 				}
		// 				else if($cnt ==8 ){
							
		// 					// ** EARN FOR RIGHT TOP ** //
		// 					if($row->mainLevel==1 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement=1");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement='8'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorr' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorr'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID2'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==2 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement=2");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement='8'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorr' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorr'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID2'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==3 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement=3");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement='8'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorr' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorr'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID2'");
		// 					break;
		// 					}
		// 					else if($row->mainLevel==4 && $row->isMatchlvl4 ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement=4");
		// 								$this->db->query("update biowash_binary_process set  isMatchlvl4=1 where level='$cntlvl' and position ='Right' and placement='8'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('$sponsorr' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$sponsorr'");
		// 								$this->db->query("UPDATE biowash_binary_process set flushout = flushout-1 where bpID='$bpID2'");
		// 					break;
		// 					}
		// 				}
		// 			}
		// 		}
		// 		}
		// 	}
		// 	// ** for top earnings ** //
		// 	if($position == 'Left'){
		// 		$getright    = $this->db->query("select * from biowash_binary_process where level='$cntlvl' and position ='Right' ");
		// 		$getrightres = $getright->num_rows();
		// 		if($getrightres !=0){
		// 			$rigthresult = $getright->result();
		// 			foreach($rigthresult as $val=>$row){
		// 			if($row->mainLevel==1 && $row->isMatch ==0){
		// 				$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement=1");
		// 				$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement='$cnt'");
		// 				$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 															  VALUES ('Empathy-Admin' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 				$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='Empathy-Admin'");
		// 			break;
		// 			} else if($row->mainLevel==2 && $row->isMatch ==0){
		// 					$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement=2");
		// 					$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement='$cnt'");
		// 					$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																  VALUES ('Empathy-Admin' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 					$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='Empathy-Admin'");
		// 				break;
		// 			} else if($row->mainLevel==3 && $row->isMatch ==0){
		// 						$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement=3");
		// 						$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement='$cnt'");
		// 						$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																	  VALUES ('Empathy-Admin' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 						$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='Empathy-Admin'");
		// 				break;
		// 			} else if($row->mainLevel==4 && $row->isMatch ==0){
		// 							$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement=4");
		// 							$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement='$cnt'");
		// 							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																		  VALUES ('Empathy-Admin' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='Empathy-Admin'");
		// 				break;
		// 			} else if($row->mainLevel==5 && $row->isMatch ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement=5");
		// 								$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement='$cnt'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('Empathy-Admin' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='Empathy-Admin'");
		// 				break;
		// 			} else if($row->mainLevel==6 && $row->isMatch ==0){
		// 									$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement=6");
		// 									$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement='$cnt'");
		// 									$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																				  VALUES ('Empathy-Admin' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 									$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='Empathy-Admin'");
		// 				break;
		// 			} else if($row->mainLevel==7 && $row->isMatch ==0){
		// 										$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement=7");
		// 										$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement='$cnt'");
		// 										$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																					  VALUES ('Empathy-Admin' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 										$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='Empathy-Admin'");
		// 				break;
		// 			} else if($row->mainLevel==8 && $row->isMatch ==0){
		// 											$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement=8");
		// 											$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement='$cnt'");
		// 											$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																						  VALUES ('Empathy-Admin' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='Empathy-Admin'");
		// 				break;
		// 			}
		// 		}
		// 		}
		// 	}
		// 	if($position == 'Right'){
		// 		$getleft      = $this->db->query("select * from biowash_binary_process where level='$cntlvl' and position ='Left' ");
		// 		$getleftres   = $getleft->num_rows();
		// 		if($getleftres !=0){
		// 			$leftresult = $getleft->result();
		// 			foreach($leftresult as $val=>$row){
		// 			if($row->mainLevel==1 && $row->isMatch ==0){
		// 				$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement=1");
		// 				$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
		// 				$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 															  VALUES ('Empathy-Admin' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 				$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='Empathy-Admin'");
		// 			break;
		// 			} else if($row->mainLevel==2 && $row->isMatch ==0){
		// 					$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement=2");
		// 					$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
		// 					$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																  VALUES ('Empathy-Admin' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 					$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='Empathy-Admin'");
		// 			break;
		// 			} else if($row->mainLevel==3 && $row->isMatch ==0){
		// 						$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement=3");
		// 						$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
		// 						$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																	  VALUES ('Empathy-Admin' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 						$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='Empathy-Admin'");
		// 					break;
		// 					} else if($row->mainLevel==4 && $row->isMatch ==0){
		// 							$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement=4");
		// 							$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
		// 							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																		  VALUES ('Empathy-Admin' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='Empathy-Admin'");
		// 						break;
		// 						} else if($row->mainLevel==5 && $row->isMatch ==0){
		// 								$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement=5");
		// 								$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
		// 								$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																			  VALUES ('Empathy-Admin' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='Empathy-Admin'");
		// 							break;
		// 							} else if($row->mainLevel==6 && $row->isMatch ==0){
		// 									$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement=6");
		// 									$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
		// 									$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																				  VALUES ('Empathy-Admin' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 									$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='Empathy-Admin'");
		// 								break;
		// 								} else if($row->mainLevel==7 && $row->isMatch ==0){
		// 										$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement=7");
		// 										$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
		// 										$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																					  VALUES ('Empathy-Admin' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 										$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='Empathy-Admin'");
		// 									break;
		// 									}  else if($row->mainLevel==8 && $row->isMatch ==0){
		// 											$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Left' and placement=8");
		// 											$this->db->query("update biowash_binary_process set  isMatch=1 where level='$cntlvl' and position ='Right' and placement='$cnt'");
		// 											$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
		// 																						  VALUES ('Empathy-Admin' ,'$transcode','Pairing Bunos' ,'$pairamount')");
		// 											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='Empathy-Admin'");
		// 										break;
		// 										}  
		// 			}
		// 		}
		// 	}
		// }
			
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
        $package              =  $data['package_id'];
		
		
        $package_code         =  $data['package_code'];
		
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
			'memberType'         => 0
		);
		$this->db->insert('biowash_members',$data1);
		$this->db->query("UPDATE biowash_members set ref_cnt = ref_cnt+1 where member_code ='$refcode'");
		$this->db->query("INSERT INTO biowash_members_wallet (membercode) values ('$code')");
		
		/** PROCESS BINARY */
		$datas = array(
			'membercode'      => $code,
			'uplinecode'      => $refcode,
			'mainuplinecode'  => $referralcode,
			'transactioncode' => $package_code,
			'package_id'      => $package
		);
		$this->binarycode_model->insert($datas);

		$memberid    = $code;
		$package_id  = $package;
		$upline      = $refcode;

		if($package_id == 1){
			$earn    = '0';
			$package = '0';
			$limit   = 0;
		}
		if($package_id == 2){
			$earn = '200';
			$package = '200';
			$limit = 12;
		}
		if($package_id == 3){
			$earn = '400';
			$package = '400';
			$limit = 21;

		}
		if($package_id == 4){
			$earn = '600';
			$package = '600';
			$limit = 30;

		}


		$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,packageamount,earnfrom,earnstatus) VALUES ('$upline','$earn' , '$package' , '$memberid','2')");
		$this->db->query("update biowash_members set  isActive=1 , package_type='$package_id' , flashout = '$limit' where member_code='$memberid'");
		$this->db->query("UPDATE empathy_mega_accounts set status = 1 , date_sold = NOW() where package_code ='$package_code'");

		$emp = $this->empathy_model->process_empathy_bonus($refcode,$referralcode,$package_id,$memberid);
		$email = $this->members_model->get_upline_email($refcode);

		$this->send_mail($datas,$email[0]->emailaddress);


		redirect('/user/packages/mega?=added');
		
		}
	}


	function processBinaryBonus($dcode,$dcodeorig,$cnt,$package_type){
		$getearn    = $this->settings_model->get_settings_data();
		$indirect = 0;
		$dateN = date('Y-m-d h:i:s');
		if($dcode!='Empathy-Admin' && $cnt < 11){
			$dcode_query 	 = $this->db->query("select referral_code,referral_main_code,package_type from biowash_members where member_code ='$dcode' limit 1");
			$dcode_result = $dcode_query->result();
			$dcodenew = $dcode_result[0]->referral_code;
			$referral_main_code = $dcode_result[0]->referral_main_code;	
			$dcodenew_query 	 = $this->db->query("select referral_code,referral_main_code,package_type,member_code from biowash_members where member_code ='$referral_main_code' limit 1");	
			$dcodenew_result = $dcodenew_query->result();
			$dcodenewPackageType = $dcodenew_result[0]->package_type;	
			$referral_code = $dcodenew_result[0]->member_code;	

			if($package_type == ''){
				$package_type = $dcode_result[0]->package_type;
			}
			// $package_type = $dcode_result[0]->package_type;	



				if($package_type == 2){
					$indirect      = $getearn[0]->silver;
				} else if($package_type == 3){
					$indirect      = $getearn[0]->gold;
				} else if($package_type == 4){
					$indirect      = $getearn[0]->premuim;
				}
				else if($package_type == 1){
					$indirect      = 0;
				}else{
					$indirect      = 0;
				}
				if($dcodenewPackageType != 1){
					$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount,EarnFrom,date_added)
					VALUES ('$referral_main_code' ,'12345','Indirect Bonus' ,'$indirect','$dcodeorig','$dateN')");
					$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$indirect' where membercode='$referral_main_code'");
					
				}

				$cnt++;
				$this->processBinaryBonus($dcodenew,$dcodeorig,$cnt,$package_type);   
		}
	}

	function processPairing($dcode,$dcodeorig) {    
		$dcodeorig = $dcodeorig;
		$pairamount = 150;
		$bonusAmount = 0;
		$getearn    = $this->settings_model->get_settings_data();
		$dateN = date('Y-m-d h:i:s');
	    if($dcode!='Empathy-Admin'){   
		    $dcode_query 	 = $this->db->query("select underBy from biowash_binary_process where directMemberCode ='$dcode' limit 1");
			$dcode_result = $dcode_query->result();
			$dcodenew = $dcode_result[0]->underBy;	

			$dcode_new_query 	 = $this->db->query("select * from biowash_binary_process where directMemberCode ='$dcodenew' limit 1");
			$dcode_new_result = $dcode_new_query->result();
			$dateNow = date('Y-m-d');

			if($dcode_new_result[0]->flashout_date != $dateNow){
				$this->db->query("update biowash_binary_process set flushout = 0,flashout_date = '$dateNow' where directMemberCode ='$dcodenew'");
				$flushOut = 0;
			}else{
				$flushOut = $dcode_new_result[0]->flushout;
			}


			$dpackage_new_query 	 = $this->db->query("select package_type from biowash_members where member_code ='$dcodenew' limit 1");
			$dpackage_new_result = $dpackage_new_query->result();

			$dpackage_new_query2 	 = $this->db->query("select package_type,referral_code,referral_main_code from biowash_members where member_code ='$dcodeorig' limit 1");
			$dpackage_new_result2 = $dpackage_new_query2->result();



			if($dpackage_new_result2[0]->package_type != 1 && $dpackage_new_result[0]->package_type != 1 && $flushOut != 12){
				if($dcode_new_result[0]->membercode_left == $dcode){

					// if($dcode_new_result[0]->package_left == 3){
					// 	$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount,date_added)
					// 											  VALUES ('$dcodenew' ,'12345','Pairing Bonus' ,'75','$dateN')");
					// 		$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$dcodenew'");
					// }else if($dcode_new_result[0]->package_left == 4){
					// 	$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount,date_added)
					// 											  VALUES ('$dcodenew' ,'12345','Pairing Bonus' ,'150','$dateN')");
					// 		$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$dcodenew'");
					// }

					if($dcode_new_result[0]->count_left < $dcode_new_result[0]->count_right){
						$this->db->query("update biowash_binary_process set count_pairs=count_pairs+1 where directMemberCode ='$dcodenew'");
						

						if((($dcode_new_result[0]->count_left + 1) % 5) == 0){
							$this->db->query("update biowash_binary_process set gc_count=gc_count+1 where directMemberCode ='$dcodenew'");
						}else{
							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount,date_added)
																  VALUES ('$dcodenew' ,'12345','Pairing Bonus' ,'150','$dateN')");
							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$dcodenew'");

							if($dcodenew != 'Empathy-Admin'){
								$this->db->query("update biowash_binary_process set flushout = flushout+1 where directMemberCode ='$dcodenew'");
							}
						}
					}

					
					$this->db->query("update biowash_binary_process set count_left=count_left+1 where directMemberCode ='$dcodenew'");

					
				}elseif($dcode_new_result[0]->membercode_right == $dcode){

					// if($dcode_new_result[0]->package_right == 3){
					// 	$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount,date_added)
					// 											  VALUES ('$dcodenew' ,'12345','Pairing Bonus' ,'75','$dateN')");
					// 		$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$dcodenew'");
					// }else if($dcode_new_result[0]->package_right == 4){
					// 	$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount,date_added)
					// 											  VALUES ('$dcodenew' ,'12345','Pairing Bonus' ,'150','$dateN')");
					// 		$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$dcodenew'");
					// }

					if($dcode_new_result[0]->count_left > $dcode_new_result[0]->count_right){
						$this->db->query("update biowash_binary_process set count_pairs=count_pairs+1 where directMemberCode ='$dcodenew'");
						if((($dcode_new_result[0]->count_right + 1) % 5) == 0){
							$this->db->query("update biowash_binary_process set gc_count=gc_count+1 where directMemberCode ='$dcodenew'");
						}else{
							$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount,date_added)
																  VALUES ('$dcodenew' ,'12345','Pairing Bonus' ,'150','$dateN')");
							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$pairamount' where membercode='$dcodenew'");

							if($dcodenew != 'Empathy-Admin'){
								$this->db->query("update biowash_binary_process set flushout = flushout+1 where directMemberCode ='$dcodenew'");
							}
						}
					}

					
					$this->db->query("update biowash_binary_process set count_right=count_right+1 where directMemberCode ='$dcodenew'");

					
				}

				// $indirectCode = $dpackage_new_result2[0]->referral_main_code;

				// if($dpackage_new_result2[0]->referral_main_code == $dcodenew){

				// 	if($dpackage_new_result2[0]->package_type == 2){
				// 		$indirect      = $getearn[0]->silver;
				// 	} else if($dpackage_new_result2[0]->package_type == 3){
				// 		$indirect      = $getearn[0]->gold;
				// 	} else if($dpackage_new_result2[0]->package_type == 4){
				// 		$indirect      = $getearn[0]->premuim;
				// 	}
				// 	else if($dpackage_new_result2[0]->package_type == 1){
				// 		$indirect      = 0;
				// 	}

				// 	$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount,date_added)
				// 	VALUES ('$indirectCode' ,'12345','Indirect Bonus' ,'$indirect')");
				// 	$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$indirect' where membercode='$indirectCode'");
				// }
			}


			

			// array_push($dcodearr,$dcodenew);	
			$this->processPairing($dcodenew,$dcodeorig);   
	    }
	}   
    
	
}
	
?>