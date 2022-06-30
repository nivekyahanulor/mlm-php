<?php 
error_reporting(0);
class Checkout extends CI_Controller {	
	public function __construct() {
        parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
        $this->load->model('user_model');
    }
	public function session(){
		if(isset($this->session->userdata['logged_in']['name'])){
				$data['user'] = $this->session->userdata['logged_in']['userid'];
				return $data;
		}
	}
	public function index() {
			if(!isset($this->session->userdata['logged_in']['userid'])){
				redirect("welcome");
			}
			$session           = $this->session();
			$data['orders']    =  $this->user_model->get_orders_data();
			$data['cntorders'] =  $this->user_model->get_cnt_orders_data();
			$data['paymethod'] =  $this->user_model->get_paymethod_data();
			$this->load->view('user/header');
			$this->load->view('user/nav' ,$data);
			$this->load->view('user/checkout',$data);
			$this->load->view('user/footer');
	}
	
 
}