<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Verify_Model extends CI_Model {

    public function __construct()
    {
		header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        parent::__construct();
        $this->load->database();
		$this->load->library('session');
    }
	
	public function verify_email($data) {
		$mail = 	base64_decode(urldecode($data));
		$this->db->query("UPDATE biowash_members set isVerified = 2 where emailaddress='$mail'");
	}
   

}
	
?>