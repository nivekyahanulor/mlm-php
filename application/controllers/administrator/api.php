<?php
class Api extends CI_Controller {	
	public function __construct() {
        parent::__construct();
		$this->load->helper('url');
        $this->load->library('phpmailer_library');
        $this->load->model('product_model');
        $this->load->model('package_model');
        $this->load->model('expenses_model');
        $this->load->model('members_model');
        $this->load->model('paymentoption_model');
        $this->load->model('settings_model');
        $this->load->model('payment_model');
        $this->load->model('withdrawal_model');
        $this->load->model('admin_model');
        $this->load->model('binarycode_model');
        $this->load->model('empathy_model');
    }

public function binaryCode() {
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array(); 
		$alphaLength = strlen($alphabet) - 1; 
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		static $result;
		if ( $result !== null ) 
			return $result;
		$result = implode($pass);
		return $result;
}
public function get_product_data(){
		header('Content-Type: application/json');
		$userinfo =  $this->product_model->get_product_data();
		$data = array();
        foreach ($userinfo as $user) {
			if($user->complan==1){
				$complan = 'BINARY';
			} else {
				$complan = 'UNILEVEL';
			}
            $row = array();
            $row[] ='<img src="'.base_url().'assets/products/'. $user->product_image.'" width="100">';
            $row[] = $user->productID;
            $row[] = $user->product_name;
            $row[] = number_format($user->product_price,2);
            $row[] = $user->product_qty;
            $row[] = $user->qtySold;
            $row[] = $user->date_added;
            $row[] =' <button class="btn btn-primary btn-sm" id="btn-product-data"><i class="fas fa-info-circle"></i> </button>
						&nbsp;&nbsp;
                    <button class="btn btn-warning btn-sm" id="btn-product-delete"><i class="fas fa-trash-alt"></i> </button>';
            $data[] = $row;
        }
        $output = array(
                        "draw" =>intval(0),
                        "recordsTotal" => intval(100),
                        "recordsFiltered" =>intval(100),
                        "data" => $data,
                );
        echo json_encode($output);
}
public function get_package_data(){
        header('Content-Type: application/json');
        $userinfo =  $this->package_model->get_package_data();
        $data = array();
        foreach ($userinfo as $user) {
            if($user->complan==1){
                $complan = 'BINARY';
            } else {
                $complan = 'UNILEVEL';
            }
            $row = array();
            $row[] ='<img src="'.base_url().'assets/packages/'. $user->package_image.'" width="100">';
            $row[] = $user->packageID;
            $row[] = $user->package_name;
            $row[] = number_format($user->package_price,2);
            $row[] = $user->date_added;
            $row[] =' <button class="btn btn-primary btn-sm" id="btn-package-data"><i class="fas fa-info-circle"></i> </button>
                    &nbsp;&nbsp;
                    <button class="btn btn-warning btn-sm" id="btn-package-delete"><i class="fas fa-trash-alt"></i> </button>';
            $data[] = $row;
        }
        $output = array(
                        "draw" =>intval(0),
                        "recordsTotal" => intval(100),
                        "recordsFiltered" =>intval(100),
                        "data" => $data,
                );
        echo json_encode($output);
}
public function get_admin_data(){
		header('Content-Type: application/json');
		$userinfo =  $this->admin_model->get_admin_data();
		$data = array();
        foreach ($userinfo as $user) {
            $row = array();
            $row[] = $user->adminID;
            $row[] = $user->firstname;
            $row[] = $user->lastname;
            $row[] = $user->password;
            $row[] = $user->username;
            $row[] = '<center>'.$user->firstname .' '.$user->lastname.'</center>';
            $row[] = '<center>'.$user->username.'</center>';
            $row[] = '<center>'.$user->lastLogin.'</center>';
            $row[] ='<center>
					<button class="btn btn-primary btn-sm" id="btn-admin-update-data"><i class="fas fa-info-circle"></i> </button>
                    &nbsp;&nbsp;
                    <button class="btn btn-warning btn-sm" id="btn-admin-delete"><i class="fas fa-trash-alt"></i> </button>
					</center>';
            $data[] = $row;
        }
        $output = array(
                        "draw" =>intval(0),
                        "recordsTotal" => intval(100),
                        "recordsFiltered" =>intval(100),
                        "data" => $data,
                );
        echo json_encode($output);
}
public function get_payment_data(){
		header('Content-Type: application/json');
		$userinfo =  $this->payment_model->get_payment_data();
		$data = array();
        foreach ($userinfo as $user) {
			if($user->deliveryoption =='cod') { 
				$dp = 'Cash On Delivery'; 
				$deladd = $user->deliveryaddress;
			} else { 
				$dp = 'For Delivery'; 
				$deladd = $user->deliveryaddress;
				}
            $row = array();
            $row[] = $user->transcode;
            $row[] = '<center><button class="btn btn-primary btn-sm" id="btn-payment-data" style="width:100%"><i class="far fa-list-alt"></i> '. $user->transcode.' </button></center>';
            $row[] = $user->firstname . ' ' . $user->lastname;
            $row[] = $user->contactnumber;
            $row[] = $user->product_name .' x '.$user->purchasedQty;
            $row[] =  '<center>'. number_format($user->purchasedTotal,2).'</center>';
			$row[] = 'Method : <br> <b>'. $dp . ' </b><br> Delivery Address :  <br><b>'. $deladd .'</b>';
            $row[] = '<center>'.$user->paydate .'</center>';
            $row[] = '<center>
			<button class="btn btn-primary  btn-sm" id="btn-approve-order"><i class="fas fa-check-circle"></i> CONFIRM  </button>
			<br><br>
			<button class="btn btn-warning btn-sm" id="btn-decline-order"><i class="fas fa-circle"></i> DECLINE  </button></div>
			</center>';
            $data[]= $row;
        }
        $output = array(
                        "draw" =>intval(0),
                        "recordsTotal" => intval(100),
                        "recordsFiltered" =>intval(100),
                        "data" => $data,
                );
        echo json_encode($output);
}

public function get_package_payment_data(){
        header('Content-Type: application/json');
        $payment_package =  $this->package_model->getAllPackagePayments();
        $data = array();
        foreach ($payment_package as $pp) {
           
            $row = array();
            $row[] = $pp->transcode;
            $row[] = '<center><button class="btn btn-primary btn-sm" id="btn-payment-data" style="width:100%"><i class="far fa-list-alt"></i> '. $pp->transcode.' </button></center>';
            $row[] = $pp->firstname . ' ' . $pp->lastname;
            $row[] = $pp->contactnumber;
            $row[] = $pp->package_name ;
            $row[] =  '<center>'. number_format($pp->package_price,2).'</center>';
            $row[] = '<center>'.$pp->date_added .'</center>';
            $row[] = '<center>
            <button class="btn btn-primary  btn-sm" id="btn-approve-packagepayment"><i class="fas fa-check-circle"></i> CONFIRM  </button>
            <br><br>
            <button class="btn btn-warning btn-sm" id="btn-decline-packagepayment"><i class="fas fa-circle"></i> DECLINE  </button></div>
            </center>';
            $data[]= $row;
        }
        $output = array(
                        "draw" =>intval(0),
                        "recordsTotal" => intval(100),
                        "recordsFiltered" =>intval(100),
                        "data" => $data,
                );
        echo json_encode($output);
}
public function get_package_upgrade_data(){
        header('Content-Type: application/json');
        $payment_package =  $this->package_model->getAllPackageUpgrades();
        $data = array();
        foreach ($payment_package as $pp) {
           
            $row = array();
            $row[] = $pp->transcode;
            $row[] = '<center><button class="btn btn-primary btn-sm" id="btn-upgrade-data" style="width:100%"><i class="far fa-list-alt"></i> '. $pp->transcode.' </button></center>';
            $row[] = $pp->firstname . ' ' . $pp->lastname;
            $row[] = $pp->contactnumber;
            $row[] = $pp->package_name ;
            $row[] =  '<center>'. number_format($pp->package_price,2).'</center>';
            $row[] = '<center>'.$pp->date_added .'</center>';
            $row[] = '<center>
				<button class="btn btn-primary  btn-sm" id="btn-approve-upgrade"><i class="fas fa-check-circle"></i> CONFIRM  </button>
            </center>';
            $data[]= $row;
        }
        $output = array(
                        "draw" =>intval(0),
                        "recordsTotal" => intval(100),
                        "recordsFiltered" =>intval(100),
                        "data" => $data,
                );
        echo json_encode($output);
}
public function get_expenses_data(){
		header('Content-Type: application/json');
		$userinfo =  $this->expenses_model->get_expenses_data();
		$data = array();
        foreach ($userinfo as $user) {
            $row = array();
            $row[] = $user->expensesID;
            $row[] = $user->expenses_amount;
            $row[] = $user->expenses_details;
			$row[] = $user->quantity;
            $row[] = number_format($user->expenses_amount,2);
            $row[] = $user->expenses_by;
            $row[] = $user->expenses_date;
            $row[] = $user->date_added;
            $row[] =' <button class="btn btn-primary btn-sm" id="btn-expenses-data"><i class="fas fa-info-circle"></i> </button>
                    &nbsp;&nbsp;
                    <button class="btn btn-warning btn-sm" id="btn-expenses-delete"><i class="fas fa-trash-alt"></i> </button>';
            $data[] = $row;
        }
        $output = array(
                        "draw" =>intval(0),
                        "recordsTotal" => intval(100),
                        "recordsFiltered" =>intval(100),
                        "data" => $data,
                );
        echo json_encode($output);
}
public function get_members_data(){
		header('Content-Type: application/json');
		$userinfo =  $this->members_model->get_members_data();
		$data = array();
        foreach ($userinfo as $user) {
            $row = array();
            $row[] = $user->memberID;
            $row[] = $user->firstname .' '. $user->lastname;
            $row[] = $user->emailaddress;
            $row[] = $user->contactnumber;
            $row[] = $user->username;
            $row[] = $user->datgeregistered;
            $row[] = $user->isActive;
            $row[] =' <button class="btn btn-primary btn-sm" id="btn-members-data"><i class="fas fa-info-circle"></i> </button>';
            $data[] = $row;
        }
        $output = array(
                        "draw" =>intval(0),
                        "recordsTotal" => intval(100),
                        "recordsFiltered" =>intval(100),
                        "data" => $data,
                );
        echo json_encode($output);
}
public function get_paymentmethod_data(){
		header('Content-Type: application/json');
		$userinfo =  $this->paymentoption_model->get_paymentmethod_data();
		$data = array();
        foreach ($userinfo as $user) {
            $row = array();
            $row[] = $user->payID;
            $row[] = $user->payment_type;
            $row[] = $user->payment_procedure;
            $row[] = $user->date_added;
            $row[] ='<button class="btn btn-primary btn-sm" id="btn-edit-data"><i class="fas fa-info-circle"></i> </button>
						&nbsp;&nbsp;
					  <button class="btn btn-warning btn-sm" id="btn-delete-data"><i class="fas fa-trash"></i> </button>';
            $data[] = $row;
        }
        $output = array(
                        "draw" =>intval(0),
                        "recordsTotal" => intval(100),
                        "recordsFiltered" =>intval(100),
                        "data" => $data,
                );
        echo json_encode($output);
}
public function get_withdrawal_request_data(){
		header('Content-Type: application/json');
		$userinfo =  $this->withdrawal_model->get_withdrawal_request_data();
		$data = array();
        foreach ($userinfo as $user) {
            $row = array();
            $row[] = $user->withdrawalID;
            $row[] = $user->firstname .' '. $user->lastname;
            $row[] = $user->methodname;
            $row[] = number_format($user->totalget,2);
            $row[] = $user->date_requested;
            $row[] ='<center><button class="btn btn-primary btn-sm" id="btn-process-data"><i class="fas fa-info-circle"></i> PROCESS </button><center>';
            $data[] = $row;
        }
        $output = array(
                        "draw" =>intval(0),
                        "recordsTotal" => intval(100),
                        "recordsFiltered" =>intval(100),
                        "data" => $data,
                );
        echo json_encode($output);
}
public function get_withdrawal_reports_data(){
		header('Content-Type: application/json');
		$userinfo =  $this->withdrawal_model->get_withdrawal_reports_data();
		$data = array();
        foreach ($userinfo as $user) {
            $row = array();
			if($user->approval_status == 1){
				$status = 'APPROVED';
			} else {
				$status = 'DECLINE';
			}
            $row[] = $user->withdrawalID;
            $row[] = $user->firstname .' '. $user->lastname;
            $row[] = $user->methodname;
            $row[] = number_format($user->totalget,2);
            $row[] = $user->date_requested;
            $row[] = $user->date_approved;
            $row[] = '<center>' . $status . '</center>';
            $row[] ='<center><button class="btn btn-primary btn-sm" id="btn-view-data"><i class="fas fa-info-circle"></i> VIEW </button><center>';
            $data[] = $row;
        }
        $output = array(
                        "draw" =>intval(0),
                        "recordsTotal" => intval(100),
                        "recordsFiltered" =>intval(100),
                        "data" => $data,
                );
        echo json_encode($output);
}
public function saveproduct(){
	$this->product_model->saveproduct($_POST);
}
public function updatepackageimage(){
	$this->package_model->updatepackageimage($_POST);
}
public function savepackage(){
    $this->package_model->savepackage($_POST);
}
public function saveadduser(){
	$this->admin_model->saveadduser($_POST);
}
public function updateadminuser(){
	$this->admin_model->updateadminuser($_POST);
}
public function updateexpenses(){
	$this->expenses_model->updateexpenses($_POST);
}
public function deleteadminaccount(){
	$this->admin_model->deleteadminaccount($_POST);
}
public function saveexpenses(){
	$this->expenses_model->saveexpenses($_POST);
}
public function deleteexpenses(){
	$this->expenses_model->deleteexpenses($_POST);
}
public function savepaymentoption(){
	$this->paymentoption_model->savepaymentoption($_POST);
}
public function updatepaymentoption(){
	$this->paymentoption_model->updatepaymentoption($_POST);
}
public function deletepaymentoption(){
	$this->paymentoption_model->deletepaymentoption($_POST);
}
public function updateproduct(){
    $this->product_model->updateproduct($_POST);
}
public function updatepackage(){
    $this->package_model->updatepackage($_POST);
}
public function updateproductimage(){
    $this->product_model->updateproductimage($_POST);
}
public function updatesettings(){
    $this->settings_model->updatesettings($_POST);
}
public function approvewithdrawal(){
    $this->withdrawal_model->approvewithdrawal($_POST);
}
public function declinewithdrawal(){
    $this->withdrawal_model->declinewithdrawal($_POST);
}
public function declinepurchase(){
    $this->payment_model->declinepurchase($_POST);
}
public function deleteproduct(){
    $this->product_model->deleteproduct($_POST);
}
public function deletepackage(){
    $this->package_model->deletepackage($_POST);
}
public function updatememberinfo(){
    $this->members_model->updatememberinfo($_POST);
}
public function savetop5endorser(){
    $this->admin_model->savetop5endorser($_POST);
}
public function updatetopfivestatus(){
    $this->admin_model->updatetopfivestatus($_POST);
}
public function testemail(){
	$mail = $this->phpmailer_library->load();
    $mail->isSMTP();
    $mail->Host     = 'smtp.hostinger.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'admin@empathybl3nd.com';
    $mail->Password = '@Empathy2021';
    $mail->SMTPSecure = 'ssl'; // tls
    $mail->Port     = 465; // 587
    $mail->setFrom('admin@empathybl3nd.com', 'EmpathyBl3nd');
		$mail->addAddress('admin@empathybl3nd.com');		
		$mail->addAddress('randysignar529@gmail.com');
    $mail->addBCC('jeffrybordeos@gmail.com');
    $mail->addBCC('kevinjayroluna@gmail.com');
    $mail->Subject = 'SAMPLE TEST EMAIL';
    $mail->isHTML(true);

   

    $mail->Body = "SAMPLE";

    if ($mail->send()) {
        $message = 'success';
    } else {
        $message = 'failed';
    }

    return $message;
}
public function send_mail($data,$toemail)
{
    $mail = $this->phpmailer_library->load();
    $mail->isSMTP();
    $mail->Host     = 'smtp.hostinger.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'admin@empathybl3nd.com';
    $mail->Password = '@Empathy2021';
    $mail->SMTPSecure = 'ssl'; // tls
    $mail->Port     = 465; // 587
    $mail->setFrom('admin@empathybl3nd.com', 'EmpathyBl3nd');
		$mail->addAddress('admin@empathybl3nd.com');		
		$mail->addAddress('geraldine.cooper@e-blends.com');		
		$mail->addAddress('randy.signar@e-blends.com');		
		$mail->addAddress('randysignar529@gmail.com');
   	    $mail->addAddress($toemail);
    $mail->addBCC('jeffrybordeos@gmail.com');
    $mail->addBCC('kevinjayroluna@gmail.com');
    $mail->Subject = 'Package Approval';
    $mail->isHTML(true);


    $mail->Body = "<html>
                        <body>
                            <h1>Package Approved</h1>
                            <p>This Member's package has been approved:
                            <br><br>
                            Member's Code: ".$data['membercode']."
                            <br><br>
                            Binary Code:  ".$data['transactioncode']."   </p>
                        </body>
                    </html>";

    if ($mail->send()) {
        $message = 'success';
    } else {
        $message = 'failed';
    }

    return $message;
}

public function confirmpupgradepayment (){
	
	$member_code = $_POST['membercode'];
	$package_id  = $_POST['package_id'];
  
	$this->db->query("UPDATE biowash_members SET package_type='$package_id' , isActive=1 where member_code='$member_code'");
	$this->db->query("UPDATE biowash_member_package SET is_approved='1' where member_code='$member_code'");
	
	redirect('administrator/payments/paymentpackageupgrades/'. $_POST['transactioncode'].'/approved');

}


public function confirmpackagepayment(){
	$datas = array(
			'membercode' => $_POST['membercode'],
			'uplinecode' => $_POST['uplinecode'],
			'mainuplinecode' => $_POST['mainuplinecode'],
			'transactioncode' => $_POST['transactioncode'],
			'package_id' => $_POST['package_id']
	);
    $this->binarycode_model->insert($datas);

	$memberid    = $_POST['membercode'];
	$package_id  = $_POST['package_id'];
	$id          = $_POST['id'];
    $upline      = $_POST['uplinecode'];
	if($package_id == 1){
		$earn = '0';
		$limit = 0;	
	} else {
	if($package_id == 2){
		$earn = '200';
		$package = '200';
		$limit = 12;
	}
	if($package_id == 3){
		$earn = '475';
		$package = '400';
		$limit = 21;

	}
	if($package_id == 4){
		$earn = '750';
		$package = '600';
		$limit = 30;

	}
		$date = date('Y-m-d H:i:s');
		$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,packageamount,earnfrom,earnstatus,dateearn) VALUES ('$upline','$earn' , '$package' , '$memberid','2','$date')");
	}
	$this->db->query("update biowash_members set  isActive=1 , package_type='$package_id' , flashout = '$limit' where member_code='$memberid'");
	$this->db->query("update biowash_member_package set  is_approved = 1 where id='$id'");

    
    $emp = $this->empathy_model->process_empathy_bonus($_POST['uplinecode'],$_POST['mainuplinecode'],$package_id,$_POST['membercode']);

    $email = $this->members_model->get_upline_email($_POST['uplinecode']);
    $this->send_mail($_POST,$email[0]->emailaddress);

	redirect('administrator/payments/paymentpackagedetails/'. $_POST['transactioncode'].'/approved');

}


public function confirmpurchase(){
		$code         = $_POST['code'];
		$this->db->query("update biowash_product_orders set approval_status =1 where transcode='$code'");
		$this->db->query("update biowash_orders_checkout set order_status =1 where transcode='$code'");
		$getpurchase = $this->db->query("select * from biowash_product_orders where transcode='$code'");
		foreach($getpurchase->result() as $a => $b){
			$prodid                  = $b->productID;
			$pqty                   += $b->purchasedQty;
			$memberid                = $b->memberID;
			
			$getproduct             = $this->db->query("select * from biowash_products where productID='$prodid'");
			foreach($getproduct->result() as $c => $d){
				$productID          =  $d->productID;
				$points             =  $d->points * $pqty;
			}
		}
		
		$this->db->query("UPDATE biowash_members set buy_product='$pqty' where memberID='$memberid'");
		
		$getmember = $this->db->query("select * from biowash_members where memberID='$memberid'");
		foreach($getmember->result() as $cc => $dd){
				$membercode   =  $dd->member_code;
		}
		$this->db->query("INSERT INTO biowash_members_earning (membercode,earnamount,earnstatus) VALUE ('$membercode','$points','3')");
		$this->db->query("UPDATE biowash_members_wallet set points =points + '$points' where membercode='$membercode'");
			
		redirect('administrator/payments/paymentdetails/'. $code.'/approved');
}

public function authentication_register_v(){
	$this->admin_model->save_member_details($_POST);
}


}


?>
