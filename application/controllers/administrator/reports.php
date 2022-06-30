<?php 
error_reporting(0);
class Reports extends CI_Controller {	
	public function __construct() {
        parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->model('payment_model');
        $this->load->model('withdrawal_model');
        $this->load->model('reports_model');
    }
	public function session(){
		if(isset($this->session->userdata['logged_in']['name'])){
				$data['user'] = $this->session->userdata['logged_in']['userid'];
				return $data;
		}
	}
	public function sales() {
			if(!isset($this->session->userdata['logged_in']['userid'])){
				redirect("welcome");
			}
			$session          = $this->session();
			$data['paycount'] =  $this->payment_model->get_payment_counts();
			$data['wrcount']  =  $this->withdrawal_model->get_witdhrawal_request_count();
			$data['sales']    =  $this->reports_model->get_sales_reports_approved();
			$this->load->view('admin/controls/header');
			$this->load->view('admin/controls/nav',$data);
			$this->load->view('admin/controls/sales',$data);
			$this->load->view('admin/controls/footer');
	}
	
	public function packages() {
			if(!isset($this->session->userdata['logged_in']['userid'])){
				redirect("welcome");
			}
			$session          = $this->session();
			$data['paycount'] =  $this->payment_model->get_payment_counts();
			$data['wrcount']  =  $this->withdrawal_model->get_witdhrawal_request_count();
			$data['sales']    =  $this->reports_model->get_package_sales_reports_approved();
			$this->load->view('admin/controls/header');
			$this->load->view('admin/controls/nav',$data);
			$this->load->view('admin/controls/packages-sales',$data);
			$this->load->view('admin/controls/footer');
	}
	public function withdrawals() {
			if(!isset($this->session->userdata['logged_in']['userid'])){
				redirect("welcome");
			}
			$session          = $this->session();
			$data['paycount'] =  $this->payment_model->get_payment_counts();
			$data['wrcount']  =  $this->withdrawal_model->get_witdhrawal_request_count();
			$this->load->view('admin/controls/header');
			$this->load->view('admin/controls/nav',$data);
			$this->load->view('admin/controls/withdrawal_reports');
			$this->load->view('admin/controls/footer');
	}
	public function declined() {
			$session          = $this->session();
			$data['paycount'] =  $this->payment_model->get_payment_counts();
			$data['wrcount']  =  $this->withdrawal_model->get_witdhrawal_request_count();
			$data['sales']    =  $this->reports_model->get_sales_reports_declined();
			$this->load->view('admin/controls/header');
			$this->load->view('admin/controls/nav',$data);
			$this->load->view('admin/controls/decline_purchased',$data);
			$this->load->view('admin/controls/footer');
	}
	
 
}