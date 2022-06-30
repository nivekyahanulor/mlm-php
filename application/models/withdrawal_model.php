<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Withdrawal_model extends CI_Model {

    public function __construct()
    {
		header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        parent::__construct();
        $this->load->database();
		$this->load->library('session');
    }
	
	public function get_withdrawal_request_data() {
		$this->db->select('*');
		$this->db->from('biowash_member_withdrawal');
		$this->db->join('biowash_members', 'biowash_member_withdrawal.memberID = biowash_members.memberID');
		$this->db->join('biowash_membesr_financial_method', 'biowash_membesr_financial_method.methodID = biowash_member_withdrawal.methodID');
		$this->db->where('biowash_member_withdrawal.approval_status', '0');
		$query = $this->db->get();
		return $query->result();
	}
	public function get_withdrawal_reports_data() {
		$this->db->select('*');
		$this->db->from('biowash_member_withdrawal');
		$this->db->join('biowash_members', 'biowash_member_withdrawal.memberID = biowash_members.memberID');
		$this->db->join('biowash_membesr_financial_method', 'biowash_membesr_financial_method.methodID = biowash_member_withdrawal.methodID');
		$this->db->where('biowash_member_withdrawal.approval_status !=', '0');
		$query = $this->db->get();
		return $query->result();
	}
    public function get_withdrawal_info_data($data) {
		$this->db->select('*');
		$this->db->from('biowash_member_withdrawal');
		$this->db->join('biowash_members', 'biowash_member_withdrawal.memberID = biowash_members.memberID');
		$this->db->join('biowash_membesr_financial_method', 'biowash_membesr_financial_method.methodID = biowash_member_withdrawal.methodID');
		$this->db->where('biowash_member_withdrawal.withdrawalID', $data);
		$query = $this->db->get();
		return $query->result();
	}
	public function get_witdhrawal_request_count() {
		$this->db->select('*');
		$this->db->from('biowash_member_withdrawal');
		$this->db->where('approval_status', '0');
		$query = $this->db->get();
		return $query->num_rows();
	}
   	public function approvewithdrawal($data) {
		$date      = date('Y-m-d H:i:s');
		$memberID  = $data['memberID'];
		$amount    = $data['amount'];
		$datas     = array( 'approval_status'   => 1, 'date_approved' =>$date );
        $this->db->where('withdrawalID', $data['withdrawalID']);
        $this->db->update('biowash_member_withdrawal', $datas);
		
		$getcode   = $this->db->query("select member_code from biowash_members where memberID='$memberID'");
		$getresult = $getcode->result();
		
		$memcode   = $getresult[0]->member_code;
		$this->db->query("UPDATE biowash_members_wallet set balance=balance-'$amount' , withdrawals = withdrawals + '$amount' where membercode='$memcode'");
		$this->db->query("UPDATE biowash_members set withdrawal_status=0 where memberID='$memberID'");
        redirect('administrator/withdrawal/process/'.$data['withdrawalID'].'/approved');
	}
	
  	public function declinewithdrawal($data) {
		$date     = date('Y-m-d H:i:s');
		$memberID = $data['memberID'];
		$datas    = array( 'approval_status'   => 2, 'reason' => $data['reason'] ,'date_approved' =>$date  );
        $this->db->where('withdrawalID', $data['withdrawalID']); 
        $this->db->update('biowash_member_withdrawal', $datas);
		$this->db->query("UPDATE biowash_members set withdrawal_status=0 where memberID='$memberID'");
        redirect('administrator/withdrawal/process/'.$data['withdrawalID'].'/declined');
	}
	
 

}
	
?>