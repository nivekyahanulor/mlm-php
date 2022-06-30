<?php
class Api extends CI_Controller {	
	public function __construct() {
        parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
        $this->load->model('user_model');
    }


public function processpurchase(){
	$this->user_model->processpurchase($_POST);
}
public function updateprofiledetails(){
	$this->user_model->updateprofiledetails($_POST);
}
public function updateprofilepicture(){
	$this->user_model->updateprofilepicture($_POST);
}
public function savefinancialmethod(){
	$this->user_model->savefinancialmethod($_POST);
}
public function processwithdrawal(){
	$this->user_model->processwithdrawal($_POST);
}
public function getpaymethod(){
	$res = $this->user_model->getpaymethod($_POST);
	echo $res[0]->payment_procedure;
}
public function checkoutprocess(){
	$res = $this->user_model->checkoutprocess($_POST);
}
public function verifyemail(){
	$res = $this->user_model->verifyemail($_POST);
}
public function deletepurchased(){
	$res = $this->user_model->deletepurchased($_POST);
}
public function processbinary(){
	$res = $this->user_model->processbinary($_POST);
}
public function processbinary_left(){
	$res = $this->user_model->processbinary_left($_POST);
}
public function processbinary_auto(){
	$res = $this->user_model->processbinary_auto($_POST);
}
public function mega_register_v(){
	$this->user_model->save_member_details($_POST);

}
}
?>
