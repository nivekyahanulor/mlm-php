<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Referral_Model extends CI_Model {

    public function __construct()
    {
		header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        parent::__construct();
        $this->load->database();
		$this->load->library('session');
    }
	
	public function get_referral_code($data) {
		$this->db->select('*');
		$this->db->from('biowash_members');
		$this->db->where('member_code', $data);
		$query = $this->db->get();
		return $query->result();
	}
   
	public function getDirectReferrals(){
		$this->db->select('*');
		$this->db->from('biowash_binary_codes');
		$this->db->where('uplinecode', 'mell');
		$query = $this->db->get();
		return $query->result();
	}
}
	
?>