<?php 
error_reporting(0);
class Withdrawal extends CI_Controller {	
	public function __construct() {
        parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->model('payment_model');
		$this->load->model('withdrawal_model');

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
			$session          = $this->session();
			$data['paycount'] =  $this->payment_model->get_payment_counts();
			$data['wrcount']  =  $this->withdrawal_model->get_witdhrawal_request_count();
			$this->load->view('admin/controls/header');
			$this->load->view('admin/controls/nav',$data);
			$this->load->view('admin/controls/withdrawal');
			$this->load->view('admin/controls/footer');
	}
	public function process() {
			if(!isset($this->session->userdata['logged_in']['userid'])){
				redirect("welcome");
			}
			$session                = $this->session();
			$process                = $this->uri->segment(4);
			$data['paycount']		=  $this->payment_model->get_payment_counts();
			$data['wrcount'] 		=  $this->withdrawal_model->get_witdhrawal_request_count();
			$data['withdrawalinfo'] = $this->withdrawal_model->get_withdrawal_info_data($process);
			$this->load->view('admin/controls/header');
			$this->load->view('admin/controls/nav',$data);
			$this->load->view('admin/controls/withdrawal_process',$data);
			$this->load->view('admin/controls/footer');
	}

	
 
}