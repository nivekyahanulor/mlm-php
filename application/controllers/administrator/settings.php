<?php 
error_reporting(0);
class Settings extends CI_Controller {	
	public function __construct() {
        parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
        $this->load->model('settings_model');
		$this->load->model('payment_model');
        $this->load->model('withdrawal_model');
    }
	public function session(){
		if(isset($this->session->userdata['logged_in']['name'])){
				$data['user'] = $this->session->userdata['logged_in']['userid'];
				return $data;
		}
	}
	public function payment_options() {
			if(!isset($this->session->userdata['logged_in']['userid'])){
				redirect("welcome");
			}
			$session          = $this->session();
			$data['paycount'] =  $this->payment_model->get_payment_counts();
			$data['wrcount']  =  $this->withdrawal_model->get_witdhrawal_request_count();
			$this->load->view('admin/controls/header');
			$this->load->view('admin/controls/nav',$data);
			$this->load->view('admin/controls/payment_option');
			$this->load->view('admin/controls/modals');
			$this->load->view('admin/controls/footer');
	}
	public function system_settings() {
			if(!isset($this->session->userdata['logged_in']['userid'])){
				redirect("welcome");
			}
			$session          =  $this->session();
			$data['settings'] =  $this->settings_model->get_settings_data();
			$data['paycount'] =  $this->payment_model->get_payment_counts();
			$data['wrcount']  =  $this->withdrawal_model->get_witdhrawal_request_count();
			$this->load->view('admin/controls/header');
			$this->load->view('admin/controls/nav',$data);
			$this->load->view('admin/controls/system_settings',$data);
			$this->load->view('admin/controls/footer');
	}
	public function admin_accounts() {
			if(!isset($this->session->userdata['logged_in']['userid'])){
				redirect("welcome");
			}
			$session          =  $this->session();
			$data['settings'] =  $this->settings_model->get_settings_data();
			$data['paycount'] =  $this->payment_model->get_payment_counts();
			$data['wrcount']  =  $this->withdrawal_model->get_witdhrawal_request_count();
			$this->load->view('admin/controls/header');
			$this->load->view('admin/controls/nav',$data);
			$this->load->view('admin/controls/admin_accounts',$data);
			$this->load->view('admin/controls/modals');
			$this->load->view('admin/controls/footer');
	}
	
 
}