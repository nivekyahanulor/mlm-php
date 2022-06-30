<?php 
error_reporting(0);
class Wallet extends CI_Controller {	
	public function __construct() {
        parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
        $this->load->model('user_model');
        $this->load->model('settings_model');
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
			$data['orders']     =  $this->user_model->get_orders_data();
			$data['cntorders']  =  $this->user_model->get_cnt_orders_data();
			$data['wallet']     =  $this->user_model->get_wallet_data();
			$data['withdrawal'] =  $this->user_model->get_withdrawal_request_data();
			$this->load->view('user/header');
			$this->load->view('user/nav',$data);
			$this->load->view('user/wallet',$data);
			$this->load->view('user/footer');
	}
	public function earnhistory() {
			if(!isset($this->session->userdata['logged_in']['userid'])){
				redirect("welcome");
			}
			$session 		     = $this->session();
			$data['orders']      =  $this->user_model->get_orders_data();
			$data['cntorders']   =  $this->user_model->get_cnt_orders_data();
			$data['earnhistory'] =  $this->user_model->get_earnhistory_data();
			$this->load->view('user/header');
			$this->load->view('user/nav',$data);
			$this->load->view('user/earnhistory',$data);
			$this->load->view('user/footer');
	}

	public function indirect() {
		if(!isset($this->session->userdata['logged_in']['userid'])){
			redirect("welcome");
		}
		$session 		     = $this->session();
		$data['orders']      =  $this->user_model->get_orders_data();
		$data['cntorders']   =  $this->user_model->get_cnt_orders_data();
		$data['earnhistory'] =  $this->user_model->get_binary_indrect_data();
		$this->load->view('user/header');
		$this->load->view('user/nav',$data);
		$this->load->view('user/indirect',$data);
		$this->load->view('user/footer');
    }

	public function empathy() {
		if(!isset($this->session->userdata['logged_in']['userid'])){
			redirect("welcome");
		}
		$session 		     = $this->session();
		$data['orders']      =  $this->user_model->get_orders_data();
		$data['cntorders']   =  $this->user_model->get_cnt_orders_data();
		$data['earnhistory'] =  $this->user_model->get_empathy_bunos_data();
		$this->load->view('user/header');
		$this->load->view('user/nav',$data);
		$this->load->view('user/empathy',$data);
		$this->load->view('user/footer');
    }

	public function binary() {
			if(!isset($this->session->userdata['logged_in']['userid'])){
				redirect("welcome");
			}
			$session 		     = $this->session();
			$data['orders']      =  $this->user_model->get_orders_data();
			$data['cntorders']   =  $this->user_model->get_cnt_orders_data();
			$data['earnhistory'] =  $this->user_model->get_binary_earnhistory_data();
			$this->load->view('user/header');
			$this->load->view('user/nav',$data);
			$this->load->view('user/earnhistory_binary',$data);
			$this->load->view('user/footer');
	}
	public function gc() {
		if(!isset($this->session->userdata['logged_in']['userid'])){
			redirect("welcome");
		}
		$session 		     = $this->session();
		$data['orders']      =  $this->user_model->get_orders_data();
		$data['cntorders']   =  $this->user_model->get_cnt_orders_data();
		$data['gc'] =  $this->user_model->get_gc_amount();
		$this->load->view('user/header');
		$this->load->view('user/nav',$data);
		$this->load->view('user/gc',$data);
		$this->load->view('user/footer');
}
	public function withdrawal() {
			if(!isset($this->session->userdata['logged_in']['userid'])){
				redirect("welcome");
			}
			$session 		    = $this->session();
			$data['userinfo']   =  $this->user_model->get_user_data();
			$data['orders']     =  $this->user_model->get_orders_data();
			$data['cntorders']  =  $this->user_model->get_cnt_orders_data();
			$data['wallet']     =  $this->user_model->get_wallet_data();
			$data['settings']   =  $this->settings_model->get_settings_data();
			$data['financial']  =  $this->user_model->get_financial_data();
			$data['withdrawal'] =  $this->user_model->get_withdrawal_request_data();
			$this->load->view('user/header');
			$this->load->view('user/nav',$data);
			$this->load->view('user/withdrawal',$data);
			$this->load->view('user/footer');
	}
	
 
}