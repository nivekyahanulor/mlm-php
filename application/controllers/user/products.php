<?php 
error_reporting(0);
class Products extends CI_Controller {	
	public function __construct() {
        parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
        $this->load->model('product_model');
        $this->load->model('user_model');
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
			$session 		   =  $this->session();
			$data['product']   =  $this->product_model->get_product_data();
			$data['orders']    =  $this->user_model->get_orders_data();
			$data['cntorders'] =  $this->user_model->get_cnt_orders_data();
			$data['settings']  =  $this->settings_model->get_settings_data();
			$this->load->view('user/header');
			$this->load->view('user/nav' 	  ,$data);
			$this->load->view('user/products' ,$data);
			$this->load->view('user/footer',$data);
	}
	
 
}