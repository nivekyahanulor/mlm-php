<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Empathy_Model extends CI_Model {

    public function __construct()
    {
		header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        parent::__construct();
        $this->load->database();
		$this->load->library('session');
    }
	
	public function process_empathy_bonus($ref,$mainref,$package_id,$membercode) {


		$refcnt = 0;
		$temprefcnt = 0;
		$empathyamount = 0;
		$this->db->select('*');
		$this->db->from('biowash_member_package');
		$this->db->where('referralID', $mainref);
		$this->db->where('is_approved', '1');
		// $this->db->where('package_id !=', '1');
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get();

		foreach ($query->result() as $key => $value) {
			# code...
			$temprefcnt++;
			if($value->member_code == $ref){
				$refcnt = $temprefcnt;
			}
		}



		if($refcnt > 0 && $refcnt < 3){
			if($this->get_referral_count($ref) > 2){
				$empathyamount = 0;
			}
		}else if($refcnt > 2){
			if($this->get_referral_count($ref) > 0 && $this->get_referral_count($ref) < 3){
				if($this->get_ref_package_id($mainref) > 1){
					$empathyamount = $this->get_empathy_bonus_amount_b($package_id);

					$this->db->query("update biowash_member_package set  empathymainID = '$mainref' where member_code='$membercode'");
				}
				
			}
		}


		if($empathyamount > 0){
			$data = array(
				'membercode' => $mainref,
				'earnamount' => $empathyamount,
				'earnfrom' => $membercode
			);

			$this->db->insert('biowash_members_earning',$data);

			$data1 = array(
				'balance' => $this->get_wallet_balance($mainref) + $empathyamount
			);

			$this->db->where('membercode', $mainref);
			$this->db->update('biowash_members_wallet', $data1);
		}

		$empmainid = $this->check_empathy_b_bonus($ref)[0]->empathymainID;

		if($empmainid != ''){
			
			if($this->get_ref_package_id($empmainid) > 1){
				if($this->get_referral_count($ref) > 0 && $this->get_referral_count($ref) < 3){
					$empathymainamount = $this->get_empathy_bonus_amount_b($package_id);
					$this->db->query("update biowash_member_package set  empathymainID = '$empmainid' where member_code='$membercode'");

					$data = array(
						'membercode' => $empmainid,
						'earnamount' => $empathymainamount,
						'earnfrom' => $membercode
					);

					$this->db->insert('biowash_members_earning',$data);

					$data1 = array(
						'balance' => $this->get_wallet_balance($empmainid) + $empathymainamount
					);

					$this->db->where('membercode', $empmainid);
					$this->db->update('biowash_members_wallet', $data1);
				}

				// if($this->get_referral_count($ref) > 2){
				// 	$empathymainamount = $this->get_empathy_bonus_amount_a($package_id);

				// 	$data = array(
				// 		'membercode' => $empmainid,
				// 		'earnamount' => $empathymainamount,
				// 		'earnfrom' => $membercode
				// 	);

				// 	$this->db->insert('biowash_members_earning',$data);

				// 	$data1 = array(
				// 		'balance' => $this->get_wallet_balance($empmainid) + $empathymainamount
				// 	);

				// 	$this->db->where('membercode', $empmainid);
				// 	$this->db->update('biowash_members_wallet', $data1);
				// }
			}

		}

		$empinfmainid = $this->check_empathy_infinity_bonus($ref)[0]->empathyinfinitymainID;

		if($empinfmainid != ''){
			if($this->get_ref_package_id($empinfmainid) > 1){
				if($this->get_referral_count($ref) > 2){
						$empathyamount = $this->get_empathy_bonus_amount_a($package_id);
						$this->db->query("update biowash_member_package set  empathyinfinitymainID = '$empinfmainid' where member_code='$membercode'");

						$data = array(
							'membercode' => $empinfmainid,
							'earnamount' => $empathyamount,
							'earnfrom' => $membercode
						);

						$this->db->insert('biowash_members_earning',$data);

						$data1 = array(
							'balance' => $this->get_wallet_balance($empinfmainid) + $empathyamount
						);

						$this->db->where('membercode', $empinfmainid);
						$this->db->update('biowash_members_wallet', $data1);
				}
			}
		}else{
			if($this->get_ref_package_id($mainref) > 1){
				$this->db->select('referral_cnt_level');
				$this->db->from('biowash_members');
				$this->db->where('member_code', $ref);
				$this->db->limit(1);
				$query = $this->db->get();
				if($query->result()[0]->referral_cnt_level == 1 || $query->result()[0]->referral_cnt_level == 2){
					if($this->get_referral_count($ref) > 2 && $this->get_ref_package_id($mainref) > 1){
							$empmainid = "test2";
							$empathyamount = $this->get_empathy_bonus_amount_a($package_id);
							$this->db->query("update biowash_member_package set  empathyinfinitymainID = '$mainref' where member_code='$membercode'");

							$data = array(
								'membercode' => $mainref,
								'earnamount' => $empathyamount,
								'earnfrom' => $membercode
							);

							$this->db->insert('biowash_members_earning',$data);

							$data1 = array(
								'balance' => $this->get_wallet_balance($mainref) + $empathyamount
							);

							$this->db->where('membercode', $mainref);
							$this->db->update('biowash_members_wallet', $data1);
					}
				}
			}
		}
		

		return 1;
		

	}

	private function get_wallet_balance($code){
		$this->db->select('balance');
		$this->db->from('biowash_members_wallet');
		$this->db->where('membercode', $code);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->result()[0]->balance;

		
	}

	private function get_empathy_bonus_amount_a($package_id){
		$this->db->select('amount');
		$this->db->from('empathy_bonus_a');
		$this->db->where('package_id', $package_id);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->result()[0]->amount;

	}

	private function get_empathy_bonus_amount_b($package_id){
		$this->db->select('amount');
		$this->db->from('empathy_bonus_b');
		$this->db->where('package_id', $package_id);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->result()[0]->amount;
	}

	private function get_referral_count($ref){

		$this->db->select('id');
		$this->db->from('biowash_member_package');
		$this->db->where('referralID', $ref);
		$this->db->where('is_approved', '1');
		// $this->db->where('package_id !=', '1');
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get();
		return $query->num_rows();
	}

	private function get_ref_package_id($mainref){
		$this->db->select('package_type');
		$this->db->from('biowash_members');
		$this->db->where('member_code', $mainref);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->result()[0]->package_type;
	}
	
	private function check_empathy_b_bonus($ref){
		$this->db->select('empathymainID');
		$this->db->from('biowash_member_package');
		$this->db->where('member_code', $ref);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->result();
	}

	private function check_empathy_infinity_bonus($ref){
		$this->db->select('empathyinfinitymainID');
		$this->db->from('biowash_member_package');
		$this->db->where('member_code', $ref);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->result();
	}
    
}
	
?>