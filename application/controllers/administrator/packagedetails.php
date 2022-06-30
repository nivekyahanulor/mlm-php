<?php 
error_reporting(0);
class Packagedetails extends CI_Controller {	
	public function __construct() {
        parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->model('package_model');
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
			$session    	  = $this->session();
			$data['package']  =  $this->package_model->get_package_data_info(array("packageID"=>$_GET['package']));
			$data['paycount'] =  $this->payment_model->get_payment_counts();
			$data['wrcount']  =  $this->withdrawal_model->get_witdhrawal_request_count();
			$this->load->view('admin/controls/header');
			$this->load->view('admin/controls/nav',$data);
			$this->load->view('admin/controls/packagedata',$data);
			$this->load->view('admin/controls/footer');
	}
	
 
}