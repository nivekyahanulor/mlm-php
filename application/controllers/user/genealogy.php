<?php 
error_reporting(0);
class Genealogy extends CI_Controller {	
	public function __construct() {
        parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
        $this->load->model('user_model');
        $this->load->database();
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
			$session 		    = $this->session();
			$data['genealogy']  =  $this->user_model->get_genealogy_data();
			$data['orders']     =  $this->user_model->get_orders_data();
			$data['cntorders']  =  $this->user_model->get_cnt_orders_data();
			$this->load->view('user/header');
			$this->load->view('user/nav',$data);
			$this->load->view('user/genealogy',$data);
			$this->load->view('user/footer');
	}
	public function binary() {
			if(!isset($this->session->userdata['logged_in']['userid'])){
				redirect("welcome");
			}
			$session 		    = $this->session();
			$data['genealogy']  =  $this->user_model->get_genealogy_data();
			$data['orders']     =  $this->user_model->get_orders_data();
			$data['cntorders']  =  $this->user_model->get_cnt_orders_data();
			$this->load->view('user/header');
			$this->load->view('user/nav',$data);
			$this->load->view('user/binary',$data);
			$this->load->view('user/footer');
	}
	public function binary_tree() {
			if(!isset($this->session->userdata['logged_in']['userid'])){
				redirect("welcome");
			}
			$session 		    = $this->session();
			$data['genealogy']  =  $this->user_model->get_genealogy_data();
			$data['orders']     =  $this->user_model->get_orders_data();
			$data['cntorders']  =  $this->user_model->get_cnt_orders_data();
			$this->load->view('user/header');
			$this->load->view('user/binary_tree',$data);
			$this->load->view('user/footer');
	}
	public function binary_tree2() {
			
			$session 		    = $this->session();
			$data['genealogy']  =  $this->user_model->get_genealogy_data();
			$data['orders']     =  $this->user_model->get_orders_data();
			$data['cntorders']  =  $this->user_model->get_cnt_orders_data();
			$this->load->view('user/header');
			$this->load->view('user/binary2',$data);
			$this->load->view('user/footer');
	}
	
 
}