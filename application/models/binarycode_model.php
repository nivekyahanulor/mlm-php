<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Binarycode_Model extends CI_Model {

    public function __construct()
    {
		header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        parent::__construct();
        $this->load->database();
		$this->load->library('session');
    }
	
	public function insert($data){
        $this->db->insert('biowash_binary_codes',$data);
    }

}
	
?>