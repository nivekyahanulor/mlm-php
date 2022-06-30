<?php 
error_reporting(0);
class Index extends CI_Controller {	
	public function __construct() {
        parent::__construct();
		ob_start(); 
		$this->load->library('session');
		$this->load->helper('url');
        $this->load->model('user_model');
        $this->load->model('admin_model');
        $this->load->model('settings_model');
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
			$session            = $this->session();
			$data['userinfo']   =  $this->user_model->get_user_data();
			$data['membercnt']  =  $this->user_model->get_members_data();
			$data['orders']     =  $this->user_model->get_orders_data();
			$data['cntorders']  =  $this->user_model->get_cnt_orders_data();
			$data['wallet']     =  $this->user_model->get_wallet_data();
			$data['floating']   =  $this->user_model->get_wallet_floating_data();
			$data['purchased']  =  $this->user_model->get_product_purchased_data();
			$data['withdrawal'] =  $this->user_model->get_withdrawal_request_data();
			$data['topfive']    =  $this->admin_model->get_top_five_endorser();
			$data['settings']   =  $this->settings_model->get_settings_data();
			$this->load->view('user/header');
			$this->load->view('user/nav' ,$data);
			$this->load->view('user/home',$data);
			$this->load->view('user/footer');
	}
	
 
}