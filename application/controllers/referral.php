<?php 
error_reporting(0);
class Referral extends CI_Controller {	
	public function __construct() {
        parent::__construct();
		$this->load->helper('url');
		$this->load->model('referral_model');

    }
	
	public function code() {
		$refcode  =  $this->uri->segment(3);
		$data     =  $this->referral_model->get_referral_code($refcode);
		if($data[0]->isActive == 0){ redirect('register/error');} else { redirect('register?code='.$refcode); }
		var_dump($refcode);
	}
	
	
}