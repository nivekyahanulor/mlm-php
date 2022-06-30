<?php 
error_reporting(0);
class Register extends CI_Controller {	
	public function __construct() {
        parent::__construct();
		$this->load->helper('url');
    }
	
	public function index() {
		if(isset($_GET['error'])){
			$data['error']='<div class="alert alert-warning">  Not Valid Referral Code! Please Try Again!  </div>';
		} else if(isset($_GET['errorusername']) ){
			$data['error_username']='<div class="alert alert-warning"> User Name already exist!  </div>';
		} else if(isset($_GET['erroremail']) ){
			$data['error_username']='<div class="alert alert-warning"> Email Address already exist!  </div>';
		}  else {
			$data['error']='';
		}
		$this->load->view('auth-register',$data);
	}
	public function success() {
		$this->load->view('register-success');
	}
	public function error() {
		$this->load->view('register-error');
	}
	
	
}