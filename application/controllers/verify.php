<?php 
class Verify extends CI_Controller {	
	public function __construct() {
        parent::__construct();
		$this->load->helper('url');
		$this->load->model('verify_model');

    }
	
	public function request() {
		$email    =  $this->uri->segment(3);
		$data     =  $this->verify_model->verify_email($email);
		redirect('verify/success');
	}
	public function success() {
		$this->load->view('verify-success');
	}
	
	
}