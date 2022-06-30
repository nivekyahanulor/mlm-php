<?php 
class Logout extends CI_Controller {	
	public function __construct() {
        parent::__construct();
		ob_start(); 
		$this->load->library('session');
		$this->load->helper('url');
    }
	function index() {
		$this->load->driver('cache');
		$this->session->sess_destroy();
		$this->cache->clean();
		ob_clean();
		redirect('welcome');
	}
	
 
}