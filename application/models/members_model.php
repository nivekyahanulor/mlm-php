<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Members_Model extends CI_Model {

    public function __construct()
    {
		header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        parent::__construct();
        $this->load->database();
		$this->load->library('session');
    }
	
	public function get_members_data() {
		$this->db->select('*');
		$this->db->from('biowash_members');
		$query = $this->db->get();
		return $query->result();
	}
	public function hash($password){
       $hash = password_hash($password,PASSWORD_DEFAULT);
       return $hash;
    }
    public function updatememberinfo($data) {
		$datas = array( 'password' => $this->hash($data['password']));
        $this->db->where('memberID', $data['memberid']);
        $this->db->update('biowash_members', $datas);
        redirect('administrator/members?updated');
	}
   
    public function get_upline_email($code) {
		$this->db->select('emailaddress');
		$this->db->from('biowash_members');
		$this->db->where('member_code', $code);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->result();
	}
}
	
?>