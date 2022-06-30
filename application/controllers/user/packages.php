<?php 
error_reporting(0);
date_default_timezone_set('Asia/Manila');
class Packages extends CI_Controller {	
	public function __construct() {
        parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
        $this->load->model('package_model');
        $this->load->model('user_model');
        $this->load->model('paymentoption_model');
		$this->load->model('admin_model');

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
			$data['package']   =  $this->package_model->get_package_data();
			$data['orders']    =  $this->user_model->get_orders_data();
			$data['cntorders'] =  $this->user_model->get_cnt_orders_data();
			$this->load->view('user/header');
			$this->load->view('user/nav' 	  ,$data);
			$this->load->view('user/packages' ,$data);
			$this->load->view('user/footer');
	}
	
	public function upgrade() {
			if(!isset($this->session->userdata['logged_in']['userid'])){
				redirect("welcome");
			}
			$session 		   = $this->session();
			$data['package']   =  $this->package_model->get_package_data();
			$data['orders']    =  $this->user_model->get_orders_data();
			$data['cntorders'] =  $this->user_model->get_cnt_orders_data();
			$this->load->view('user/header');
			$this->load->view('user/nav' 	  ,$data);
			$this->load->view('user/upgrade' ,$data);
			$this->load->view('user/footer');
	}
	
	
	public function mega() {
		if(!isset($this->session->userdata['logged_in']['userid'])){
			redirect("welcome");
		}
		$session 		   = $this->session();
		$data['package']   =  $this->package_model->empathy_mega_accounts($this->session->userdata['logged_in']['code']);
		$data['orders']    =  $this->user_model->get_orders_data();
		$data['cntorders'] =  $this->user_model->get_cnt_orders_data();
		$data['members'] =  $this->admin_model->get_members_data_v();
		$this->load->view('user/header');
		$this->load->view('user/nav' 	  ,$data);
		$this->load->view('user/mega_package' ,$data);
		$this->load->view('user/footer');
    }

	public function sold() {
		if(!isset($this->session->userdata['logged_in']['userid'])){
			redirect("welcome");
		}
		$session 		   = $this->session();
		$data['package']   =  $this->package_model->empathy_mega_accounts_sold($this->session->userdata['logged_in']['code']);
		$data['orders']    =  $this->user_model->get_orders_data();
		$data['cntorders'] =  $this->user_model->get_cnt_orders_data();
		$data['members'] =  $this->admin_model->get_members_data_v();
		$this->load->view('user/header');
		$this->load->view('user/nav' 	  ,$data);
		$this->load->view('user/sold_package' ,$data);
		$this->load->view('user/footer');
    }


	public function getPaymentMethods(){
		$result = $this->paymentoption_model->get_paymentmethod_data();
		echo json_encode($result);
	}

	public function submitPakagePayment(){
		$upload_path = './assets/packages/proof';
		$upload_path_file = $upload_path.'/'.$_POST['member_id'];
          if (!file_exists($upload_path_file)) {
              mkdir($upload_path_file, 0777, true);
          }
		 $config['upload_path']   = $upload_path_file; 
	     $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf'; 
	     $config['max_size']      = 200000;  
	     $this->load->library('upload', $config);
			
	     if ( ! $this->upload->do_upload('proof_inp')) {
	        $error = array('error' => $this->upload->display_errors()); 
	        echo json_encode($error);
	     }
			
	     else { 
	        $data = array('upload_data' => $this->upload->data()); 
	        $_POST['status'] = 1; 
	        $result = $this->package_model->savePackagePayment($_POST);
			echo json_encode($_POST);
	     } 
		
	}

	public function getPaymentPackageData(){
		$result = $this->package_model->getPaymentPackageData();
		echo json_encode($result);
	}
 
}