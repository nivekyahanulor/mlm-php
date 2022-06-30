<?php 
error_reporting(0);
class Index extends CI_Controller {	
	public function __construct() {
        parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->model('payment_model');
        $this->load->model('withdrawal_model');
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
			$session            =  $this->session();
			$data['paycount']   =  $this->payment_model->get_payment_counts();
			$data['wrcount']    =  $this->withdrawal_model->get_witdhrawal_request_count();
			$data['purchased']  =  $this->admin_model->get_purchased_data();
			$data['members']    =  $this->admin_model->get_members_data();
			$data['products']   =  $this->admin_model->get_products_data();
			$data['topfive']    =  $this->admin_model->get_top_five_endorser();
			$data['settings']   =  $this->settings_model->get_settings_data();
			$this->load->view('admin/controls/header');
			$this->load->view('admin/controls/nav',$data);
			$this->load->view('admin/controls/home',$data);
			$this->load->view('admin/controls/footer');
	}
	
 
}