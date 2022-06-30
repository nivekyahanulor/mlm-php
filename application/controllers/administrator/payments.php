<?php 
error_reporting(0);
class Payments extends CI_Controller {	
	public function __construct() {
        parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
        $this->load->model('payment_model');
        $this->load->model('withdrawal_model');
        $this->load->model('package_model');
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
			$session          = $this->session();
			$data['paycount'] =  $this->payment_model->get_payment_counts();
			$data['wrcount']  =  $this->withdrawal_model->get_witdhrawal_request_count();
			$this->load->view('admin/controls/header');
			$this->load->view('admin/controls/nav' , $data);
			$this->load->view('admin/controls/payments');
			$this->load->view('admin/controls/footer');
	}

	public function package() {
			if(!isset($this->session->userdata['logged_in']['userid'])){
				redirect("welcome");
			}
			$session          = $this->session();
			$data['packpay'] =  $this->package_model->getAllPackagePayments();
			$data['wrcount']  =  $this->withdrawal_model->get_witdhrawal_request_count();
			$this->load->view('admin/controls/header');
			$this->load->view('admin/controls/nav' , $data);
			$this->load->view('admin/controls/payment_package');
			$this->load->view('admin/controls/footer');
	}
	
	public function upgrades() {
			if(!isset($this->session->userdata['logged_in']['userid'])){
				redirect("welcome");
			}
			$session          = $this->session();
			$data['packpay'] =  $this->package_model->getAllPackageUpgrades();
			$data['wrcount']  =  $this->withdrawal_model->get_witdhrawal_request_count();
			$this->load->view('admin/controls/header');
			$this->load->view('admin/controls/nav' , $data);
			$this->load->view('admin/controls/payment_upgrades');
			$this->load->view('admin/controls/footer');
	}
	
	public function paymentdetails() {
			if(!isset($this->session->userdata['logged_in']['userid'])){
				redirect("welcome");
			}
			$session          = $this->session();
			$transcode        =  $this->uri->segment(4);
			$data['product']  =  $this->payment_model->get_payment_data_info($transcode);
			$data['purchase'] =  $this->payment_model->get_purchased_data_info($transcode);
			$data['paycount'] =  $this->payment_model->get_payment_counts();
			$data['wrcount']  =  $this->withdrawal_model->get_witdhrawal_request_count();
			$this->load->view('admin/controls/header');
			$this->load->view('admin/controls/nav' , $data);
			$this->load->view('admin/controls/paymentdetails' , $data);
			$this->load->view('admin/controls/footer');
	}

	public function paymentpackagedetails() {
			if(!isset($this->session->userdata['logged_in']['userid'])){
				redirect("welcome");
			}
			$session          = $this->session();
			$transcode        =  $this->uri->segment(4);
			$data['packagepayment']  =  $this->package_model->getAllPackagePaymentsByTranscode($transcode);
			$this->load->view('admin/controls/header');
			$this->load->view('admin/controls/nav' , $data);
			$this->load->view('admin/controls/paymentpackagedetails' , $data);
			$this->load->view('admin/controls/footer');
	}
	
	public function paymentpackageupgrades() {
			if(!isset($this->session->userdata['logged_in']['userid'])){
				redirect("welcome");
			}
			$session          = $this->session();
			$transcode        =  $this->uri->segment(4);
			$data['packagepayment']  =  $this->package_model->getAllPackagePaymentsByTranscode($transcode);
			$this->load->view('admin/controls/header');
			$this->load->view('admin/controls/nav' , $data);
			$this->load->view('admin/controls/upgradedetails.php' , $data);
			$this->load->view('admin/controls/footer');
	}
	


 
}