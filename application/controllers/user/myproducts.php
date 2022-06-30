<?php 
error_reporting(0);
class Myproducts extends CI_Controller {	
	public function __construct() {
        parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
        $this->load->model('product_model');
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
			$session 		   = $this->session();
			$data['product']   =  $this->product_model->get_product_data();
			$data['orders']    =  $this->user_model->get_orders_data();
			$data['cntorders'] =  $this->user_model->get_cnt_orders_data();
			$this->load->view('user/header');
			$this->load->view('user/nav' 	  ,$data);
			$this->load->view('user/myproducts' ,$data);
			$this->load->view('user/footer');
	}
	public function purchased() {
			if(!isset($this->session->userdata['logged_in']['userid'])){
				redirect("welcome");
			}
			$session 		   = $this->session();
			$data['product']   =  $this->user_model->get_purchased_product_data($transcode='');
			$data['orders']    =  $this->user_model->get_orders_data();
			$data['cntorders'] =  $this->user_model->get_cnt_orders_data();
			$this->load->view('user/header');
			$this->load->view('user/nav' 	  ,$data);
			$this->load->view('user/purchased' ,$data);
			$this->load->view('user/footer');
	}
	public function view_purchased() {
			if(!isset($this->session->userdata['logged_in']['userid'])){
				redirect("welcome");
			}
			$transcode         =  $this->uri->segment(4);
			$session 		   =  $this->session();
			$data['product']   =  $this->user_model->get_purchased_product_data($transcode);
			$data['purchased'] =  $this->user_model->get_purchased_orders_product_data($transcode);
			$data['orders']    =  $this->user_model->get_orders_data();
			$data['cntorders'] =  $this->user_model->get_cnt_orders_data();
			$this->load->view('user/header');
			$this->load->view('user/nav' 	  ,$data);
			$this->load->view('user/view_purchase' ,$data);
			$this->load->view('user/footer');
	}
	
 
}