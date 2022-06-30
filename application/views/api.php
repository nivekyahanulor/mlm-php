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
            $row[] = $complan;
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
            $row[] = $complan;
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
public function get_expenses_data(){
		header('Content-Type: application/json');
		$userinfo =  $this->expenses_model->get_expenses_data();
		$data = array();
        foreach ($userinfo as $user) {
            $row = array();
            $row[] = $user->expensesID;
            $row[] = $user->expenses_details;
            $row[] = number_format($user->expenses_amount,2);
            $row[] = $user->expenses_by;
            $row[] = $user->expenses_date;
            $row[] = $user->date_added;
            // $row[] =' <button class="btn btn-primary btn-sm" id="btn-product-data"><i class="fas fa-info-circle"></i> </button>
                    // &nbsp;&nbsp;
                    // <button class="btn btn-warning btn-sm" id="btn-product-delete"><i class="fas fa-trash-alt"></i> </button>';
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
public function savepackage(){
    $this->package_model->savepackage($_POST);
}
public function saveadduser(){
	$this->admin_model->saveadduser($_POST);
}
public function updateadminuser(){
	$this->admin_model->updateadminuser($_POST);
}
public function deleteadminaccount(){
	$this->admin_model->deleteadminaccount($_POST);
}
public function saveexpenses(){
	$this->expenses_model->saveexpenses($_POST);
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

public function send_mail($data,$toemail)
{
    $mail = $this->phpmailer_library->load();
    $mail->isSMTP();
    $mail->Host     = 'smtp.hostinger.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'admin@empathybl3nd.com';
    $mail->Password = '@EmpathyBl3nd2021';
    $mail->SMTPSecure = 'ssl'; // tls
    $mail->Port     = 465; // 587
    $mail->setFrom('admin@empathybl3nd.com', 'EmpathyBl3nd');
    $mail->addAddress($toemail);
    $mail->addBCC('jeffrybordeos@gmail.com');
    $mail->addBCC('kevinjayroluna@gmail.com');
    $mail->Subject = 'Package Approval';
    $mail->isHTML(true);

    // $data['contact_person'] = $contact_person;
    // $data['username'] = $username;
    // $data['password'] = $password;
    // $mailContent = $this->load->view($template, $data, true);

    $mail->Body = "<html>
                        <body>
                            <h1>Package Approved</h1>
                            <p>This Member's package has been approved:
                            <br><br>
                            Member's Code: ".$data['membercode']."
                            <br><br>
                            Binary Vode:  ".$data['transactioncode']."   </p>
                        </body>
                    </html>";

    if ($mail->send()) {
        $message = 'success';
    } else {
        $message = 'failed';
    }

    return $message;
}

public function confirmpackagepayment(){

    $this->binarycode_model->insert($_POST);

	$memberid = $_POST['membercode'];
	$package_id = $_POST['package_id'];

	$this->db->query("update biowash_members set  isActive=1 , package_type='$package_id' where member_code='$memberid'");
	$this->db->query("update biowash_member_package set  is_approved = 1 where package_id='$package_id'");

    $this->empathy_model->process_empathy_bonus($_POST['uplinecode'],$_POST['mainuplinecode'],$package_id);

    $email = $this->members_model->get_upline_email($_POST['uplinecode']);
    $this->send_mail($_POST,$email[0]->emailaddress);

	redirect('administrator/payments/paymentpackagedetails/'. $_POST['transactioncode'].'/approved');
}


public function confirmpurchase(){
		$getearn      = $this->settings_model->get_settings_data();
		$code         = $_POST['code'];
		$this->db->query("update biowash_product_orders set approval_status =1 where transcode='$code'");
		$this->db->query("update biowash_orders_checkout set order_status =1 where transcode='$code'");
		$getpurchase                = $this->db->query("select * from biowash_product_orders where transcode='$code'");
		foreach($getpurchase->result() as $a => $b){
			$prodid                 = $b->productID;
			$pqty                   = $b->purchasedQty;
			$memberid               = $b->memberID;
			$earnlevel   			= $pqty;
			$earnlevels   			= $getearn[0]->earn_limit * $pqty;
			$getproduct             = $this->db->query("select * from biowash_products where productID='$prodid'");
			foreach($getproduct->result() as $c => $d){
				$productID          =  $d->productID;
				$getmemberinfo      = $this->db->query("select * from biowash_members where memberID='$memberid'");
				$getmemberres       = $getmemberinfo->result();
				$complan            =  $d->complan;
				$earning_lvl_one    =  $d->earning_lvl_one;
				$earning_lvl_two    =  $d->earning_lvl_two;
				$earning_lvl_three  =  $d->earning_lvl_three;
				$earning_lvl_four   =  $d->earning_lvl_four;
				$earning_lvl_five   =  $d->earning_lvl_five;
				$earning_lvl_six    =  $d->earning_lvl_six;
				$earning_lvl_seven  =  $d->earning_lvl_seven;
				$earning_lvl_eight  =  $d->earning_lvl_eight;
				$earning_lvl_nine   =  $d->earning_lvl_nine;
				$earning_lvl_ten    =  $d->earning_lvl_ten;
				$referral_main_code =  $getmemberres[0]->referral_main_code;
				$referral_code      =  $getmemberres[0]->referral_code;
				$member_code        =  $getmemberres[0]->member_code;
				$earn_lvl           =  $getmemberres[0]->earn_level;
				$earn_lvls          =  $getmemberres[0]->earn_level + 1;
				$earnamount1        =  $earning_lvl_one    * $pqty;
				$earnamount2        =  $earning_lvl_two    * $pqty;
				$earnamount3        =  $earning_lvl_three  * $pqty;
				$earnamount4        =  $earning_lvl_four   * $pqty;
				$earnamount5        =  $earning_lvl_five   * $pqty;
				$earnamount6        =  $earning_lvl_six    * $pqty;
				$earnamount7        =  $earning_lvl_seven  * $pqty;
				$earnamount8        =  $earning_lvl_eight  * $pqty;
				$earnamount9        =  $earning_lvl_nine   * $pqty;
				$earnamount10       =  $earning_lvl_ten    * $pqty;
				$this->db->query("update biowash_members set  isActive=1 where memberID='$memberid'");
				if($complan ==1){
				if($earn_lvl!='1101'){
					$this->db->query("UPDATE biowash_members set earn_level =earn_level+'$pqty' where member_code='$member_code'");
					if($earn_lvls ==1 || $earn_lvls ==0){
						$this->db->query("UPDATE biowash_earnings_progress set earninglimit = '$earnlevels' where membercode='$member_code'");
					} else{
						$this->db->query("UPDATE biowash_earnings_progress set earninglimit =earninglimit+'$earnlevels' where membercode='$member_code'");
					}
				} 
				if($getmemberres[0]->line_level ==1){
						 $getearnlimit       =  $this->db->query("select earn_level from biowash_members where member_code='$referral_main_code' ");
						 $researnlimit       =  $getearnlimit->result();
						 if($researnlimit[0]->earn_level=='1101'){
							$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus , earnfrom,earncount) VALUES ('$referral_main_code' , '$earnamount1',1 ,'$member_code','$pqty')");
							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount1' where membercode='$referral_main_code'");
							$this->db->query("UPDATE biowash_earnings_progress set used_earnings =used_earnings+'$earnlevel' where membercode='$referral_main_code' and earningfrom ='$member_code'");
						} else {
							if($researnlimit[0]->earn_level!=''|| $researnlimit[0]->earn_level!=0){
							$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus , earnfrom,earncount) VALUES ('$referral_main_code' , '$earnamount1',1,'$member_code','$pqty')");
							$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount1' where membercode='$referral_main_code'");
							} else {
							$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus , earnfrom,earncount) VALUES ('$referral_main_code' , '$earnamount1',0,'$member_code','$pqty')");
							}
						 }
				}
				if($getmemberres[0]->line_level ==2){
						 // ** Get Earn Limit for main ref code **//
						 $getearnlimit       =  $this->db->query("select earn_level from biowash_members where member_code='$referral_main_code'");
						 $researnlimit       =  $getearnlimit->result();
						 if($researnlimit[0]->earn_level=='1101'){
								$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$referral_main_code' , '$earnamount2',1,'$member_code','$pqty')");
								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount2' where membercode='$referral_main_code'");
								$this->db->query("UPDATE biowash_earnings_progress set used_earnings =used_earnings+'$earnlevel' where membercode='$referral_main_code' and earningfrom ='$member_code'");
						 }
						 
						 // ** Get Earn Limit for  ref code **//
						 $getearnlimit2       =  $this->db->query("select earn_level from biowash_members where member_code='$referral_code'");
						 $researnlimit2       =  $getearnlimit2->result();
							if($researnlimit2[0]->earn_level!=''&& $researnlimit2[0]->earn_level!=0){
									$validate 		=   $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$referral_code' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus, earnfrom,floatcount) VALUES ('$referral_code' , '$earnamount1',0,'$member_code','$pqty')");
									} else {
										$gt2          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt2 <= 0){
											$getearn2 = $earning_lvl_one * $validateres[0]->earninglimit;
											$float2   = $earnamount1 - $getearn2;
											$abs      = abs($gt2);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$referral_code'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn2',floating=floating+'$float2' where membercode='$referral_code'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$referral_code' , '$getearn2','$float2',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel' where membercode='$referral_code'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount1' where membercode='$referral_code'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$referral_code' , '$earnamount1',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus, earnfrom,floatcount) VALUES ('$referral_code' , '$earnamount1',0,'$member_code','$pqty')");
							}
						 
				}
				if($getmemberres[0]->line_level ==3){
					
						 $getthirdlevel      =  $this->db->query("SELECT referral_code from biowash_members where member_code='$referral_code'");
						 $thirdlevel         =  $getthirdlevel->result();
						 $thirdlevelref      =  $thirdlevel[0]->referral_code;

						// ** 3rd Level **//
						 $getearnlimit       =  $this->db->query("select earn_level from biowash_members where member_code='$referral_main_code'");
						 $researnlimit       =  $getearnlimit->result();
						 if($researnlimit[0]->earn_level=='1101'){
								$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus,earnfrom,earncount) VALUES ('$referral_main_code' , '$earnamount3',1,'$member_code','$pqty')");
								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount3' where membercode='$referral_main_code'");
								$this->db->query("UPDATE biowash_earnings_progress set used_earnings =used_earnings+'$earnlevel' where membercode='$referral_main_code' and earningfrom ='$member_code'");
						 }
						 
						 // ** 2nd Level **//
						 $getearnlimit2       =  $this->db->query("select earn_level from biowash_members where member_code='$thirdlevelref'");
						 $researnlimit2       =  $getearnlimit2->result();
							if($researnlimit2[0]->earn_level!=''&& $researnlimit2[0]->earn_level!=0){
									$validate 		=   $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$thirdlevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$thirdlevelref' , '$earnamount2',0,'$member_code','$pqty')");
									} else {
										$gt2          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt2 <= 0){
											$getearn2 = $earning_lvl_two * $validateres[0]->earninglimit;
											$float2   = $earnamount2 - $getearn2;
											$abs      = abs($gt2);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$thirdlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn2',floating=floating+'$float2' where membercode='$thirdlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$thirdlevelref' , '$getearn2','$float2',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$thirdlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount2' where membercode='$thirdlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$thirdlevelref' , '$earnamount2',1,'$member_code','$pqty')");
										}
									}
							} else {

									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$thirdlevelref' , '$earnamount2',0,'$member_code','$pqty')");
							} 
						// ** 1st Level **//
						 $getearnlimit1       =  $this->db->query("select earn_level from biowash_members where member_code='$referral_code'");
						 $researnlimit1       =  $getearnlimit1->result();
							if($researnlimit1[0]->earn_level!=''&& $researnlimit1[0]->earn_level!=0){
									$validate 		=   $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$referral_code' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$referral_code' , '$earnamount1',0,'$member_code','$pqty')");
									}else {
										$gt1          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt1 <= 0){
											$getearn1 = $earning_lvl_one * $validateres[0]->earninglimit;
											$float1   = $earnamount1 - $getearn1;
											$abs      = abs($gt1);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$referral_code'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn1',floating=floating+'$float1' where membercode='$referral_code'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$referral_code' , '$getearn1','$float1',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$referral_code'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount1' where membercode='$referral_code'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$referral_code' , '$earnamount1',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$referral_code' , '$earnamount1',0,'$member_code','$pqty')");
							}
				}
				if($getmemberres[0]->line_level ==4){
					
						 $getthirdlevel      =  $this->db->query("SELECT referral_code from biowash_members where member_code='$referral_code'");
						 $thirdlevel         =  $getthirdlevel->result();
						 $thirdlevelref      =  $thirdlevel[0]->referral_code;
						 
						 $getfourthlevel     =  $this->db->query("SELECT referral_code from biowash_members where member_code='$thirdlevelref'");
						 $fourthlevel        =  $getfourthlevel->result();
						 $fourthlevelref     =  $fourthlevel[0]->referral_code;
					
						// ** 4th Level **//
						 $getearnlimit       =  $this->db->query("select earn_level from biowash_members where member_code='$referral_main_code'");
						 $researnlimit       =  $getearnlimit->result();
						 if($researnlimit[0]->earn_level=='1101'){
								$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus,earnfrom,earncount) VALUES ('$referral_main_code' , '$earnamount4',1,'$member_code','$pqty')");
								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount4' where membercode='$referral_main_code'");
								$this->db->query("UPDATE biowash_earnings_progress set used_earnings =used_earnings+'$earnlevel' where membercode='$referral_main_code' and earningfrom ='$member_code'");
						 }
						 
						  // ** 3rd Level **//
						 $getearnlimit3       =  $this->db->query("select earn_level from biowash_members where member_code='$fourthlevelref'");
						 $researnlimit3       =  $getearnlimit3->result();
							if($researnlimit3[0]->earn_level!=''&& $researnlimit3[0]->earn_level!=0){
									$validate 		=  $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$fourthlevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$fourthlevelref' , '$earnamount3',0,'$member_code','$pqty')");
									} else {
										$gt3          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt3 <= 0){
											$getearn3 = $earning_lvl_three * $validateres[0]->earninglimit;
											$float3   = $earnamount3 - $getearn3;
											$abs      = abs($gt3);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$fourthlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn3',floating=floating+'$float3' where membercode='$fourthlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$fourthlevelref' , '$getearn3','$float3',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$fourthlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount3' where membercode='$fourthlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$fourthlevelref' , '$earnamount3',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$fourthlevelref' , '$earnamount3',0,'$member_code','$pqty')");
							} 
						 
						 // ** 2nd Level **//
						 $getearnlimit2       =  $this->db->query("select earn_level from biowash_members where member_code='$thirdlevelref'");
						 $researnlimit2       =  $getearnlimit2->result();
							if($researnlimit2[0]->earn_level!=''&& $researnlimit2[0]->earn_level!=0){
									$validate 		=   $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$thirdlevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$thirdlevelref' , '$earnamount2',0,'$member_code','$pqty')");
									} else {
										$gt2          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt2 <= 0){
											$getearn2 = $earning_lvl_two * $validateres[0]->earninglimit;
											$float2   = $earnamount2 - $getearn2;
											$abs      = abs($gt2);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$thirdlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn2',floating=floating+'$float2' where membercode='$thirdlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$thirdlevelref' , '$getearn2','$float2',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$thirdlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount2' where membercode='$thirdlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$thirdlevelref' , '$earnamount2',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$thirdlevelref' , '$earnamount2',0,'$member_code','$pqty')");
							} 
						// ** 1st Level **//
						 $getearnlimit1       =  $this->db->query("select earn_level from biowash_members where member_code='$referral_code'");
						 $researnlimit1       =  $getearnlimit1->result();
							if($researnlimit1[0]->earn_level!=''&& $researnlimit1[0]->earn_level!=0){
									$validate 		=   $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$referral_code' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$referral_code' , '$earnamount1',0,'$member_code','$pqty')");
									} else {
										$gt1          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt1 <= 0){
											$getearn1 = $earning_lvl_one * $validateres[0]->earninglimit;
											$float1   = $earnamount2 - $getearn2;
											$abs      = abs($gt1);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$referral_code'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn1',floating=floating+'$float1' where membercode='$referral_code'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$referral_code' , '$getearn1','$float1',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$referral_code'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount1' where membercode='$referral_code'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$referral_code' , '$earnamount1',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$referral_code' , '$earnamount1',0,'$member_code','$pqty')");
							}
				}
				if($getmemberres[0]->line_level ==5){
						
						 $getthirdlevel      =  $this->db->query("SELECT referral_code from biowash_members where member_code='$referral_code'");
						 $thirdlevel         =  $getthirdlevel->result();
						 $thirdlevelref      =  $thirdlevel[0]->referral_code;
						 
						 $getfourthlevel     =  $this->db->query("SELECT referral_code from biowash_members where member_code='$thirdlevelref'");
						 $fourthlevel        =  $getfourthlevel->result();
						 $fourthlevelref     =  $fourthlevel[0]->referral_code;
						 
						 $getfifthlevel      =  $this->db->query("SELECT referral_code from biowash_members where member_code='$fourthlevelref'");
						 $fithlevel          =  $getfifthlevel->result();
						 $fithlevelref       =  $fithlevel[0]->referral_code;
						 
						 	// ** 5th Level **//
						 $getearnlimit       =  $this->db->query("select earn_level from biowash_members where member_code='$referral_main_code'");
						 $researnlimit       =  $getearnlimit->result();
						 if($researnlimit[0]->earn_level=='1101'){
								$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus,earnfrom,earncount) VALUES ('$referral_main_code' , '$earnamount5',1,'$member_code','$pqty')");
								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount5' where membercode='$referral_main_code'");
								$this->db->query("UPDATE biowash_earnings_progress set used_earnings =used_earnings+'$earnlevel' where membercode='$referral_main_code' and earningfrom ='$member_code'");
						 }
						 
					
						// ** 4th Level **//
						 $getearnlimit4       =  $this->db->query("select earn_level from biowash_members where member_code='$fithlevelref'");
						 $researnlimit4       =  $getearnlimit4->result();
						if($researnlimit4[0]->earn_level!=''&& $researnlimit4[0]->earn_level!=0){
									$validate 		=  $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$fithlevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$fithlevelref' , '$earnamount4',0,'$member_code','$pqty')");
									} else {
										$gt4          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt4 <= 0){
											$getearn4 = $earning_lvl_four * $validateres[0]->earninglimit;
											$float4   = $earnamount4 - $getearn4;
											$abs      = abs($gt4);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$fithlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn4',floating=floating+'$float4' where membercode='$fithlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$fithlevelref' , '$getearn4','$float4',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$fithlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount4' where membercode='$fithlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$fithlevelref' , '$earnamount4',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$fithlevelref' , '$earnamount4',0,'$member_code','$pqty')");
							} 
						 
						  // ** 3rd Level **//
						 $getearnlimit3       =  $this->db->query("select earn_level from biowash_members where member_code='$fourthlevelref'");
						 $researnlimit3       =  $getearnlimit3->result();
							if($researnlimit3[0]->earn_level!=''&& $researnlimit3[0]->earn_level!=0){
									$validate 		=  $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$fourthlevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$fourthlevelref' , '$earnamount3',0,'$member_code','$pqty')");
									} else {
										$gt3          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt3 <= 0){
											$getearn3 = $earning_lvl_three * $validateres[0]->earninglimit;
											$float3   = $earnamount3 - $getearn3;
											$abs      = abs($gt3);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$fourthlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn3',floating=floating+'$float3' where membercode='$fourthlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$fourthlevelref' , '$getearn3','$float3',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$fourthlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount3' where membercode='$fourthlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$fourthlevelref' , '$earnamount3',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$fourthlevelref' , '$earnamount3',0,'$member_code','$pqty')");
							} 
						 
						 // ** 2nd Level **//
						 $getearnlimit2       =  $this->db->query("select earn_level from biowash_members where member_code='$thirdlevelref'");
						 $researnlimit2       =  $getearnlimit2->result();
							if($researnlimit2[0]->earn_level!=''&& $researnlimit2[0]->earn_level!=0){
									$validate 		=   $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$thirdlevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$thirdlevelref' , '$earnamount2',0,'$member_code','$pqty')");
									} else {
										$gt2          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt2 <= 0){
											$getearn2 = $earning_lvl_two * $validateres[0]->earninglimit;
											$float2   = $earnamount2 - $getearn2;
											$abs      = abs($gt2);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$thirdlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn2',floating=floating+'$float2' where membercode='$thirdlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$thirdlevelref' , '$getearn2','$float2',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$thirdlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount2' where membercode='$thirdlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$thirdlevelref' , '$earnamount2',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$thirdlevelref' , '$earnamount2',0,'$member_code','$pqty')");
							} 
						// ** 1st Level **//
						 $getearnlimit1       =  $this->db->query("select earn_level from biowash_members where member_code='$referral_code'");
						 $researnlimit1       =  $getearnlimit1->result();
							if($researnlimit1[0]->earn_level!=''&& $researnlimit1[0]->earn_level!=0){
									$validate 		=   $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$referral_code' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$referral_code' , '$earnamount1',0,'$member_code','$pqty')");
									} else {
										$gt1          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt1 <= 0){
											$getearn1 = $earning_lvl_one * $validateres[0]->earninglimit;
											$float1   = $earnamount2 - $getearn2;
											$abs      = abs($gt1);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$referral_code'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn1',floating=floating+'$float1' where membercode='$referral_code'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$referral_code' , '$getearn1','$float1',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$referral_code'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount1' where membercode='$referral_code'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$referral_code' , '$earnamount1',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$referral_code' , '$earnamount1',0,'$member_code','$pqty')");
							}
				}
				if($getmemberres[0]->line_level ==6){
						
						 $getthirdlevel      =  $this->db->query("SELECT referral_code from biowash_members where member_code='$referral_code'");
						 $thirdlevel         =  $getthirdlevel->result();
						 $thirdlevelref      =  $thirdlevel[0]->referral_code;
						 
						 $getfourthlevel     =  $this->db->query("SELECT referral_code from biowash_members where member_code='$thirdlevelref'");
						 $fourthlevel        =  $getfourthlevel->result();
						 $fourthlevelref     =  $fourthlevel[0]->referral_code;
						 
						 $getfifthlevel      =  $this->db->query("SELECT referral_code from biowash_members where member_code='$fourthlevelref'");
						 $fithlevel          =  $getfifthlevel->result();
						 $fithlevelref       =  $fithlevel[0]->referral_code;
						 
						 $getsixlevel        =  $this->db->query("SELECT referral_code from biowash_members where member_code='$fithlevelref'");
						 $sixlevel           =  $getsixlevel->result();
						 $sixlevelref        =  $sixlevel[0]->referral_code;
						 
						 // ** 6th Level **//
						 $getearnlimit       =  $this->db->query("select earn_level from biowash_members where member_code='$referral_main_code'");
						 $researnlimit       =  $getearnlimit->result();
						 if($researnlimit[0]->earn_level=='1101'){
								$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus,earnfrom,earncount) VALUES ('$referral_main_code' , '$earnamount6',1,'$member_code','$pqty')");
								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount6' where membercode='$referral_main_code'");
								$this->db->query("UPDATE biowash_earnings_progress set used_earnings =used_earnings+'$earnlevel' where membercode='$referral_main_code' and earningfrom ='$member_code'");
						 }
						 
						// ** 5th Level **//
						 $getearnlimit5       =  $this->db->query("select earn_level from biowash_members where member_code='$sixlevelref'");
						 $researnlimit5       =  $getearnlimit5->result();
						if($researnlimit5[0]->earn_level!=''&& $researnlimit5[0]->earn_level!=0){
									$validate 		=  $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$sixlevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$sixlevelref' , '$earnamount5',0,'$member_code','$pqty')");
									} else {
										$gt5          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt5 <= 0){
											$getearn5 = $earning_lvl_five * $validateres[0]->earninglimit;
											$float5   = $earnamount4 - $getearn5;
											$abs      = abs($gt5);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$sixlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn5',floating=floating+'$float5' where membercode='$sixlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$sixlevelref' , '$getearn5','$float5',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$sixlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount5' where membercode='$sixlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$sixlevelref' , '$earnamount5',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$sixlevelref' , '$earnamount4',0,'$member_code','$pqty')");
							} 
						 
												// ** 4th Level **//
						 $getearnlimit4       =  $this->db->query("select earn_level from biowash_members where member_code='$fithlevelref'");
						 $researnlimit4       =  $getearnlimit4->result();
						if($researnlimit4[0]->earn_level!=''&& $researnlimit4[0]->earn_level!=0){
									$validate 		=  $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$fithlevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$fithlevelref' , '$earnamount4',0,'$member_code','$pqty')");
									} else {
										$gt4          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt4 <= 0){
											$getearn4 = $earning_lvl_four * $validateres[0]->earninglimit;
											$float4   = $earnamount4 - $getearn4;
											$abs      = abs($gt4);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$fithlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn4',floating=floating+'$float4' where membercode='$fithlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$fithlevelref' , '$getearn4','$float4',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$fithlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount4' where membercode='$fithlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$fithlevelref' , '$earnamount4',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$fithlevelref' , '$earnamount4',0,'$member_code','$pqty')");
							} 
						 
						  // ** 3rd Level **//
						 $getearnlimit3       =  $this->db->query("select earn_level from biowash_members where member_code='$fourthlevelref'");
						 $researnlimit3       =  $getearnlimit3->result();
							if($researnlimit3[0]->earn_level!=''&& $researnlimit3[0]->earn_level!=0){
									$validate 		=  $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$fourthlevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$fourthlevelref' , '$earnamount3',0,'$member_code','$pqty')");
									} else {
										$gt3          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt3 <= 0){
											$getearn3 = $earning_lvl_three * $validateres[0]->earninglimit;
											$float3   = $earnamount3 - $getearn3;
											$abs      = abs($gt3);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$fourthlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn3',floating=floating+'$float3' where membercode='$fourthlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$fourthlevelref' , '$getearn3','$float3',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$fourthlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount3' where membercode='$fourthlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$fourthlevelref' , '$earnamount3',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$fourthlevelref' , '$earnamount3',0,'$member_code','$pqty')");
							} 
						 
						 // ** 2nd Level **//
						 $getearnlimit2       =  $this->db->query("select earn_level from biowash_members where member_code='$thirdlevelref'");
						 $researnlimit2       =  $getearnlimit2->result();
							if($researnlimit2[0]->earn_level!=''&& $researnlimit2[0]->earn_level!=0){
									$validate 		=   $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$thirdlevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$thirdlevelref' , '$earnamount2',0,'$member_code','$pqty')");
									} else {
										$gt2          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt2 <= 0){
											$getearn2 = $earning_lvl_two * $validateres[0]->earninglimit;
											$float2   = $earnamount2 - $getearn2;
											$abs      = abs($gt2);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$thirdlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn2',floating=floating+'$float2' where membercode='$thirdlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$thirdlevelref' , '$getearn2','$float2',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$thirdlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount2' where membercode='$thirdlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$thirdlevelref' , '$earnamount2',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$thirdlevelref' , '$earnamount2',0,'$member_code','$pqty')");
							} 
						// ** 1st Level **//
						 $getearnlimit1       =  $this->db->query("select earn_level from biowash_members where member_code='$referral_code'");
						 $researnlimit1       =  $getearnlimit1->result();
							if($researnlimit1[0]->earn_level!=''&& $researnlimit1[0]->earn_level!=0){
									$validate 		=   $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$referral_code' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$referral_code' , '$earnamount1',0,'$member_code','$pqty')");
									} else {
										$gt1          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt1 <= 0){
											$getearn1 = $earning_lvl_one * $validateres[0]->earninglimit;
											$float1   = $earnamount2 - $getearn2;
											$abs      = abs($gt1);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$referral_code'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn1',floating=floating+'$float1' where membercode='$referral_code'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$referral_code' , '$getearn1','$float1',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$referral_code'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount1' where membercode='$referral_code'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$referral_code' , '$earnamount1',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$referral_code' , '$earnamount1',0,'$member_code','$pqty')");
							}
				}
				if($getmemberres[0]->line_level ==7){
						
						 $getthirdlevel      =  $this->db->query("SELECT referral_code from biowash_members where member_code='$referral_code'");
						 $thirdlevel         =  $getthirdlevel->result();
						 $thirdlevelref      =  $thirdlevel[0]->referral_code;
						 
						 $getfourthlevel     =  $this->db->query("SELECT referral_code from biowash_members where member_code='$thirdlevelref'");
						 $fourthlevel        =  $getfourthlevel->result();
						 $fourthlevelref     =  $fourthlevel[0]->referral_code;
						 
						 $getfifthlevel      =  $this->db->query("SELECT referral_code from biowash_members where member_code='$fourthlevelref'");
						 $fithlevel          =  $getfifthlevel->result();
						 $fithlevelref       =  $fithlevel[0]->referral_code;
						 
						 $getsixlevel        =  $this->db->query("SELECT referral_code from biowash_members where member_code='$fithlevelref'");
						 $sixlevel           =  $getsixlevel->result();
						 $sixlevelref        =  $sixlevel[0]->referral_code;
						 
						 $getsevenlevel      =  $this->db->query("SELECT referral_code from biowash_members where member_code='$sixlevelref'");
						 $sevenlevel         =  $getsevenlevel->result();
						 $sevenlevelref      =  $sevenlevel[0]->referral_code;
						 
						 // ** 7th Level **//
						 $getearnlimit       =  $this->db->query("select earn_level from biowash_members where member_code='$referral_main_code'");
						 $researnlimit       =  $getearnlimit->result();
						 if($researnlimit[0]->earn_level=='1101'){
								$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus,earnfrom,earncount) VALUES ('$referral_main_code' , '$earnamount7',1,'$member_code','$pqty')");
								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount7' where membercode='$referral_main_code'");
								$this->db->query("UPDATE biowash_earnings_progress set used_earnings =used_earnings+'$earnlevel' where membercode='$referral_main_code' and earningfrom ='$member_code'");
						 }
						 
						 // ** 6th Level **//
						 $getearnlimit6       =  $this->db->query("select earn_level from biowash_members where member_code='$sevenlevelref'");
						 $researnlimit6       =  $getearnlimit6->result();
						if($researnlimit6[0]->earn_level!=''&& $researnlimit6[0]->earn_level!=0){
									$validate 		=  $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$sevenlevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$sevenlevelref' , '$earnamount6',0,'$member_code','$pqty')");
									} else {
										$gt6          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt6 <= 0){
											$getearn6 = $earning_lvl_six * $validateres[0]->earninglimit;
											$float6   = $earnamount6 - $getearn6;
											$abs      = abs($gt6);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$sevenlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn6',floating=floating+'$float6' where membercode='$sevenlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$sevenlevelref' , '$getearn6','$float6',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$sevenlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount6' where membercode='$sevenlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$sevenlevelref' , '$earnamount6',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$sevenlevelref' , '$earnamount6',0,'$member_code','$pqty')");
							} 
						 
						// ** 5th Level **//
						 $getearnlimit5       =  $this->db->query("select earn_level from biowash_members where member_code='$sixlevelref'");
						 $researnlimit5       =  $getearnlimit5->result();
						if($researnlimit5[0]->earn_level!=''&& $researnlimit5[0]->earn_level!=0){
									$validate 		=  $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$sixlevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$sixlevelref' , '$earnamount5',0,'$member_code','$pqty')");
									} else {
										$gt5          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt5 <= 0){
											$getearn5 = $earning_lvl_five * $validateres[0]->earninglimit;
											$float5   = $earnamount4 - $getearn5;
											$abs      = abs($gt5);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$sixlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn5',floating=floating+'$float5' where membercode='$sixlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$sixlevelref' , '$getearn5','$float5',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$sixlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount5' where membercode='$sixlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$sixlevelref' , '$earnamount5',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$sixlevelref' , '$earnamount4',0,'$member_code','$pqty')");
							} 
						 
												// ** 4th Level **//
						 $getearnlimit4       =  $this->db->query("select earn_level from biowash_members where member_code='$fithlevelref'");
						 $researnlimit4       =  $getearnlimit4->result();
						if($researnlimit4[0]->earn_level!=''&& $researnlimit4[0]->earn_level!=0){
									$validate 		=  $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$fithlevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$fithlevelref' , '$earnamount4',0,'$member_code','$pqty')");
									} else {
										$gt4          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt4 <= 0){
											$getearn4 = $earning_lvl_four * $validateres[0]->earninglimit;
											$float4   = $earnamount4 - $getearn4;
											$abs      = abs($gt4);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$fithlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn4',floating=floating+'$float4' where membercode='$fithlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$fithlevelref' , '$getearn4','$float4',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$fithlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount4' where membercode='$fithlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$fithlevelref' , '$earnamount4',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$fithlevelref' , '$earnamount4',0,'$member_code','$pqty')");
							} 
						 
						  // ** 3rd Level **//
						 $getearnlimit3       =  $this->db->query("select earn_level from biowash_members where member_code='$fourthlevelref'");
						 $researnlimit3       =  $getearnlimit3->result();
							if($researnlimit3[0]->earn_level!=''&& $researnlimit3[0]->earn_level!=0){
									$validate 		=  $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$fourthlevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$fourthlevelref' , '$earnamount3',0,'$member_code','$pqty')");
									} else {
										$gt3          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt3 <= 0){
											$getearn3 = $earning_lvl_three * $validateres[0]->earninglimit;
											$float3   = $earnamount3 - $getearn3;
											$abs      = abs($gt3);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$fourthlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn3',floating=floating+'$float3' where membercode='$fourthlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$fourthlevelref' , '$getearn3','$float3',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$fourthlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount3' where membercode='$fourthlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$fourthlevelref' , '$earnamount3',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$fourthlevelref' , '$earnamount3',0,'$member_code','$pqty')");
							} 
						 
						 // ** 2nd Level **//
						 $getearnlimit2       =  $this->db->query("select earn_level from biowash_members where member_code='$thirdlevelref'");
						 $researnlimit2       =  $getearnlimit2->result();
							if($researnlimit2[0]->earn_level!=''&& $researnlimit2[0]->earn_level!=0){
									$validate 		=   $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$thirdlevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$thirdlevelref' , '$earnamount2',0,'$member_code','$pqty')");
									} else {
										$gt2          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt2 <= 0){
											$getearn2 = $earning_lvl_two * $validateres[0]->earninglimit;
											$float2   = $earnamount2 - $getearn2;
											$abs      = abs($gt2);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$thirdlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn2',floating=floating+'$float2' where membercode='$thirdlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$thirdlevelref' , '$getearn2','$float2',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$thirdlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount2' where membercode='$thirdlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$thirdlevelref' , '$earnamount2',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$thirdlevelref' , '$earnamount2',0,'$member_code','$pqty')");
							} 
						// ** 1st Level **//
						 $getearnlimit1       =  $this->db->query("select earn_level from biowash_members where member_code='$referral_code'");
						 $researnlimit1       =  $getearnlimit1->result();
							if($researnlimit1[0]->earn_level!=''&& $researnlimit1[0]->earn_level!=0){
									$validate 		=   $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$referral_code' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$referral_code' , '$earnamount1',0,'$member_code','$pqty')");
									} else {
										$gt1          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt1 <= 0){
											$getearn1 = $earning_lvl_one * $validateres[0]->earninglimit;
											$float1   = $earnamount2 - $getearn2;
											$abs      = abs($gt1);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$referral_code'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn1',floating=floating+'$float1' where membercode='$referral_code'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$referral_code' , '$getearn1','$float1',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel' where membercode='$referral_code'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount1' where membercode='$referral_code'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$referral_code' , '$earnamount1',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$referral_code' , '$earnamount1',0,'$member_code','$pqty')");
							}
				}
				if($getmemberres[0]->line_level ==8){
						
						 $getthirdlevel      =  $this->db->query("SELECT referral_code from biowash_members where member_code='$referral_code'");
						 $thirdlevel         =  $getthirdlevel->result();
						 $thirdlevelref      =  $thirdlevel[0]->referral_code;
						 
						 $getfourthlevel     =  $this->db->query("SELECT referral_code from biowash_members where member_code='$thirdlevelref'");
						 $fourthlevel        =  $getfourthlevel->result();
						 $fourthlevelref     =  $fourthlevel[0]->referral_code;
						 
						 $getfifthlevel      =  $this->db->query("SELECT referral_code from biowash_members where member_code='$fourthlevelref'");
						 $fithlevel          =  $getfifthlevel->result();
						 $fithlevelref       =  $fithlevel[0]->referral_code;
						 
						 $getsixlevel        =  $this->db->query("SELECT referral_code from biowash_members where member_code='$fithlevelref'");
						 $sixlevel           =  $getsixlevel->result();
						 $sixlevelref        =  $sixlevel[0]->referral_code;
						 
						 $getsevenlevel      =  $this->db->query("SELECT referral_code from biowash_members where member_code='$sixlevelref'");
						 $sevenlevel         =  $getsevenlevel->result();
						 $sevenlevelref      =  $sevenlevel[0]->referral_code; 
						 
						 $geteightlevel      =  $this->db->query("SELECT referral_code from biowash_members where member_code='$sevenlevelref'");
						 $eightlevel         =  $geteightlevel->result();
						 $eightlevelref      =  $eightlevel[0]->referral_code;
 
						 
						 // ** 8th Level **//
						 $getearnlimit       =  $this->db->query("select earn_level from biowash_members where member_code='$referral_main_code'");
						 $researnlimit       =  $getearnlimit->result();
						 if($researnlimit[0]->earn_level=='1101'){
								$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus,earnfrom,earncount) VALUES ('$referral_main_code' , '$earnamount8',1,'$member_code','$pqty')");
								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount8' where membercode='$referral_main_code'");
								$this->db->query("UPDATE biowash_earnings_progress set used_earnings =used_earnings+'$earnlevel' where membercode='$referral_main_code' and earningfrom ='$member_code'");
						 }
						  // ** 7th Level **//
						 $getearnlimit7       =  $this->db->query("select earn_level from biowash_members where member_code='$eightlevelref'");
						 $researnlimit7       =  $getearnlimit7->result();
						if($researnlimit7[0]->earn_level!=''&& $researnlimit7[0]->earn_level!=0){
									$validate 		=  $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$eightlevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$eightlevelref' , '$earnamount7',0,'$member_code','$pqty')");
									} else {
										$gt7          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt7 <= 0){
											$getearn7 = $earning_lvl_seven * $validateres[0]->earninglimit;
											$float7   = $earnamount7 - $getearn7;
											$abs      = abs($gt7);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$eightlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn7',floating=floating+'$float7' where membercode='$eightlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$eightlevelref' , '$getearn7','$float7',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$eightlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount7' where membercode='$eightlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$eightlevelref' , '$earnamount7',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$eightlevelref' , '$earnamount7',0,'$member_code','$pqty')");
							} 
						  // ** 6th Level **//
						 $getearnlimit6       =  $this->db->query("select earn_level from biowash_members where member_code='$sevenlevelref'");
						 $researnlimit6       =  $getearnlimit6->result();
						if($researnlimit6[0]->earn_level!=''&& $researnlimit6[0]->earn_level!=0){
									$validate 		=  $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$sevenlevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$sevenlevelref' , '$earnamount6',0,'$member_code','$pqty')");
									} else {
										$gt6          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt6 <= 0){
											$getearn6 = $earning_lvl_six * $validateres[0]->earninglimit;
											$float6   = $earnamount6 - $getearn6;
											$abs      = abs($gt6);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$sevenlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn6',floating=floating+'$float6' where membercode='$sevenlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$sevenlevelref' , '$getearn6','$float6',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$sevenlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount6' where membercode='$sevenlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$sevenlevelref' , '$earnamount6',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$sevenlevelref' , '$earnamount6',0,'$member_code','$pqty')");
							} 
						 
						// ** 5th Level **//
						 $getearnlimit5       =  $this->db->query("select earn_level from biowash_members where member_code='$sixlevelref'");
						 $researnlimit5       =  $getearnlimit5->result();
						if($researnlimit5[0]->earn_level!=''&& $researnlimit5[0]->earn_level!=0){
									$validate 		=  $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$sixlevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$sixlevelref' , '$earnamount5',0,'$member_code','$pqty')");
									} else {
										$gt5          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt5 <= 0){
											$getearn5 = $earning_lvl_five * $validateres[0]->earninglimit;
											$float5   = $earnamount4 - $getearn5;
											$abs      = abs($gt5);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$sixlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn5',floating=floating+'$float5' where membercode='$sixlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$sixlevelref' , '$getearn5','$float5',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$sixlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount5' where membercode='$sixlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$sixlevelref' , '$earnamount5',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$sixlevelref' , '$earnamount4',0,'$member_code','$pqty')");
							} 
						 
												// ** 4th Level **//
						 $getearnlimit4       =  $this->db->query("select earn_level from biowash_members where member_code='$fithlevelref'");
						 $researnlimit4       =  $getearnlimit4->result();
						if($researnlimit4[0]->earn_level!=''&& $researnlimit4[0]->earn_level!=0){
									$validate 		=  $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$fithlevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$fithlevelref' , '$earnamount4',0,'$member_code','$pqty')");
									} else {
										$gt4          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt4 <= 0){
											$getearn4 = $earning_lvl_four * $validateres[0]->earninglimit;
											$float4   = $earnamount4 - $getearn4;
											$abs      = abs($gt4);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$fithlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn4',floating=floating+'$float4' where membercode='$fithlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$fithlevelref' , '$getearn4','$float4',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$fithlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount4' where membercode='$fithlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$fithlevelref' , '$earnamount4',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$fithlevelref' , '$earnamount4',0,'$member_code','$pqty')");
							} 
						 
						  // ** 3rd Level **//
						 $getearnlimit3       =  $this->db->query("select earn_level from biowash_members where member_code='$fourthlevelref'");
						 $researnlimit3       =  $getearnlimit3->result();
							if($researnlimit3[0]->earn_level!=''&& $researnlimit3[0]->earn_level!=0){
									$validate 		=  $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$fourthlevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$fourthlevelref' , '$earnamount3',0,'$member_code','$pqty')");
									} else {
										$gt3          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt3 <= 0){
											$getearn3 = $earning_lvl_three * $validateres[0]->earninglimit;
											$float3   = $earnamount3 - $getearn3;
											$abs      = abs($gt3);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$fourthlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn3',floating=floating+'$float3' where membercode='$fourthlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$fourthlevelref' , '$getearn3','$float3',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$fourthlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount3' where membercode='$fourthlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$fourthlevelref' , '$earnamount3',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$fourthlevelref' , '$earnamount3',0,'$member_code','$pqty')");
							} 
						 
						 // ** 2nd Level **//
						 $getearnlimit2       =  $this->db->query("select earn_level from biowash_members where member_code='$thirdlevelref'");
						 $researnlimit2       =  $getearnlimit2->result();
							if($researnlimit2[0]->earn_level!=''&& $researnlimit2[0]->earn_level!=0){
									$validate 		=   $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$thirdlevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$thirdlevelref' , '$earnamount2',0,'$member_code','$pqty')");
									} else {
										$gt2          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt2 <= 0){
											$getearn2 = $earning_lvl_two * $validateres[0]->earninglimit;
											$float2   = $earnamount2 - $getearn2;
											$abs      = abs($gt2);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$thirdlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn2',floating=floating+'$float2' where membercode='$thirdlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$thirdlevelref' , '$getearn2','$float2',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$thirdlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount2' where membercode='$thirdlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$thirdlevelref' , '$earnamount2',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$thirdlevelref' , '$earnamount2',0,'$member_code','$pqty')");
							} 
						// ** 1st Level **//
						 $getearnlimit1       =  $this->db->query("select earn_level from biowash_members where member_code='$referral_code'");
						 $researnlimit1       =  $getearnlimit1->result();
							if($researnlimit1[0]->earn_level!=''&& $researnlimit1[0]->earn_level!=0){
									$validate 		=   $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$referral_code' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$referral_code' , '$earnamount1',0,'$member_code','$pqty')");
									} else {
										$gt1          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt1 <= 0){
											$getearn1 = $earning_lvl_one * $validateres[0]->earninglimit;
											$float1   = $earnamount2 - $getearn2;
											$abs      = abs($gt1);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$referral_code'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn1',floating=floating+'$float1' where membercode='$referral_code'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$referral_code' , '$getearn1','$float1',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$referral_code'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount1' where membercode='$referral_code'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$referral_code' , '$earnamount1',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$referral_code' , '$earnamount1',0,'$member_code','$pqty')");
							}
				}
				if($getmemberres[0]->line_level ==9){
						
						 $getthirdlevel      =  $this->db->query("SELECT referral_code from biowash_members where member_code='$referral_code'");
						 $thirdlevel         =  $getthirdlevel->result();
						 $thirdlevelref      =  $thirdlevel[0]->referral_code;
						 
						 $getfourthlevel     =  $this->db->query("SELECT referral_code from biowash_members where member_code='$thirdlevelref'");
						 $fourthlevel        =  $getfourthlevel->result();
						 $fourthlevelref     =  $fourthlevel[0]->referral_code;
						 
						 $getfifthlevel      =  $this->db->query("SELECT referral_code from biowash_members where member_code='$fourthlevelref'");
						 $fithlevel          =  $getfifthlevel->result();
						 $fithlevelref       =  $fithlevel[0]->referral_code;
						 
						 $getsixlevel        =  $this->db->query("SELECT referral_code from biowash_members where member_code='$fithlevelref'");
						 $sixlevel           =  $getsixlevel->result();
						 $sixlevelref        =  $sixlevel[0]->referral_code;
						 
						 $getsevenlevel      =  $this->db->query("SELECT referral_code from biowash_members where member_code='$sixlevelref'");
						 $sevenlevel         =  $getsevenlevel->result();
						 $sevenlevelref      =  $sevenlevel[0]->referral_code; 
						 
						 $geteightlevel      =  $this->db->query("SELECT referral_code from biowash_members where member_code='$sevenlevelref'");
						 $eightlevel         =  $geteightlevel->result();
						 $eightlevelref      =  $eightlevel[0]->referral_code;
						 
						 $getninelevel       =  $this->db->query("SELECT referral_code from biowash_members where member_code='$eightlevelref'");
						 $ninelevel          =  $getninelevel->result();
						 $ninelevelref       =  $ninelevel[0]->referral_code;
 
						 
						 // ** 9th Level **//
						 $getearnlimit       =  $this->db->query("select earn_level from biowash_members where member_code='$referral_main_code'");
						 $researnlimit       =  $getearnlimit->result();
						 if($researnlimit[0]->earn_level=='1101'){
								$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus,earnfrom,earncount) VALUES ('$referral_main_code' , '$earnamount9',1,'$member_code','$pqty')");
								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount9' where membercode='$referral_main_code'");
								$this->db->query("UPDATE biowash_earnings_progress set used_earnings =used_earnings+'$earnlevel' where membercode='$referral_main_code' and earningfrom ='$member_code'");
						 }
						  // ** 8th Level **//
						 $getearnlimit8       =  $this->db->query("select earn_level from biowash_members where member_code='$ninelevelref'");
						 $researnlimit8       =  $getearnlimit8->result();
						 if($researnlimit8[0]->earn_level!=''&& $researnlimit8[0]->earn_level!=0){
									$validate 		=  $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$ninelevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$ninelevelref' , '$earnamount8',0,'$member_code','$pqty')");
									}  else {
										$gt8          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt8 <= 0){
											$getearn8 = $earning_lvl_eight * $validateres[0]->earninglimit;
											$float8   = $earnamount8 - $getearn8;
											$abs      = abs($gt8);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$ninelevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn8',floating=floating+'$float8' where membercode='$ninelevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$ninelevelref' , '$getearn8','$float8',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$ninelevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount8' where membercode='$ninelevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$ninelevelref' , '$earnamount8',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$ninelevelref' , '$earnamount8',0,'$member_code','$pqty')");
							} 
						 // ** 7th Level **//
						 $getearnlimit7       =  $this->db->query("select earn_level from biowash_members where member_code='$eightlevelref'");
						 $researnlimit7       =  $getearnlimit7->result();
						if($researnlimit7[0]->earn_level!=''&& $researnlimit7[0]->earn_level!=0){
									$validate 		=  $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$eightlevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$eightlevelref' , '$earnamount7',0,'$member_code','$pqty')");
									} else {
										$gt7          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt7 <= 0){
											$getearn7 = $earning_lvl_seven * $validateres[0]->earninglimit;
											$float7   = $earnamount7 - $getearn7;
											$abs      = abs($gt7);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$eightlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn7',floating=floating+'$float7' where membercode='$eightlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$eightlevelref' , '$getearn7','$float7',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$eightlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount7' where membercode='$eightlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$eightlevelref' , '$earnamount7',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$eightlevelref' , '$earnamount7',0,'$member_code','$pqty')");
							} 
						  // ** 6th Level **//
						 $getearnlimit6       =  $this->db->query("select earn_level from biowash_members where member_code='$sevenlevelref'");
						 $researnlimit6       =  $getearnlimit6->result();
						if($researnlimit6[0]->earn_level!=''&& $researnlimit6[0]->earn_level!=0){
									$validate 		=  $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$sevenlevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$sevenlevelref' , '$earnamount6',0,'$member_code','$pqty')");
									} else {
										$gt6          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt6 <= 0){
											$getearn6 = $earning_lvl_six * $validateres[0]->earninglimit;
											$float6   = $earnamount6 - $getearn6;
											$abs      = abs($gt6);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$sevenlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn6',floating=floating+'$float6' where membercode='$sevenlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$sevenlevelref' , '$getearn6','$float6',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$sevenlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount6' where membercode='$sevenlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$sevenlevelref' , '$earnamount6',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$sevenlevelref' , '$earnamount6',0,'$member_code','$pqty')");
							} 
						 
						// ** 5th Level **//
						 $getearnlimit5       =  $this->db->query("select earn_level from biowash_members where member_code='$sixlevelref'");
						 $researnlimit5       =  $getearnlimit5->result();
						if($researnlimit5[0]->earn_level!=''&& $researnlimit5[0]->earn_level!=0){
									$validate 		=  $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$sixlevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$sixlevelref' , '$earnamount5',0,'$member_code','$pqty')");
									} else {
										$gt5          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt5 <= 0){
											$getearn5 = $earning_lvl_five * $validateres[0]->earninglimit;
											$float5   = $earnamount4 - $getearn5;
											$abs      = abs($gt5);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$sixlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn5',floating=floating+'$float5' where membercode='$sixlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$sixlevelref' , '$getearn5','$float5',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$sixlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount5' where membercode='$sixlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$sixlevelref' , '$earnamount5',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$sixlevelref' , '$earnamount4',0,'$member_code','$pqty')");
							} 
						 
												// ** 4th Level **//
						 $getearnlimit4       =  $this->db->query("select earn_level from biowash_members where member_code='$fithlevelref'");
						 $researnlimit4       =  $getearnlimit4->result();
						if($researnlimit4[0]->earn_level!=''&& $researnlimit4[0]->earn_level!=0){
									$validate 		=  $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$fithlevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$fithlevelref' , '$earnamount4',0,'$member_code','$pqty')");
									} else {
										$gt4          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt4 <= 0){
											$getearn4 = $earning_lvl_four * $validateres[0]->earninglimit;
											$float4   = $earnamount4 - $getearn4;
											$abs      = abs($gt4);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$fithlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn4',floating=floating+'$float4' where membercode='$fithlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$fithlevelref' , '$getearn4','$float4',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$fithlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount4' where membercode='$fithlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$fithlevelref' , '$earnamount4',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$fithlevelref' , '$earnamount4',0,'$member_code','$pqty')");
							} 
						 
						  // ** 3rd Level **//
						 $getearnlimit3       =  $this->db->query("select earn_level from biowash_members where member_code='$fourthlevelref'");
						 $researnlimit3       =  $getearnlimit3->result();
							if($researnlimit3[0]->earn_level!=''&& $researnlimit3[0]->earn_level!=0){
									$validate 		=  $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$fourthlevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$fourthlevelref' , '$earnamount3',0,'$member_code','$pqty')");
									} else {
										$gt3          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt3 <= 0){
											$getearn3 = $earning_lvl_three * $validateres[0]->earninglimit;
											$float3   = $earnamount3 - $getearn3;
											$abs      = abs($gt3);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$fourthlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn3',floating=floating+'$float3' where membercode='$fourthlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$fourthlevelref' , '$getearn3','$float3',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$fourthlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount3' where membercode='$fourthlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$fourthlevelref' , '$earnamount3',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$fourthlevelref' , '$earnamount3',0,'$member_code','$pqty')");
							} 
						 
						 // ** 2nd Level **//
						 $getearnlimit2       =  $this->db->query("select earn_level from biowash_members where member_code='$thirdlevelref'");
						 $researnlimit2       =  $getearnlimit2->result();
							if($researnlimit2[0]->earn_level!=''&& $researnlimit2[0]->earn_level!=0){
									$validate 		=   $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$thirdlevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$thirdlevelref' , '$earnamount2',0,'$member_code','$pqty')");
									} else {
										$gt2          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt2 <= 0){
											$getearn2 = $earning_lvl_two * $validateres[0]->earninglimit;
											$float2   = $earnamount2 - $getearn2;
											$abs      = abs($gt2);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$thirdlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn2',floating=floating+'$float2' where membercode='$thirdlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$thirdlevelref' , '$getearn2','$float2',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$thirdlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount2' where membercode='$thirdlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$thirdlevelref' , '$earnamount2',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$thirdlevelref' , '$earnamount2',0,'$member_code','$pqty')");
							} 
						// ** 1st Level **//
						 $getearnlimit1       =  $this->db->query("select earn_level from biowash_members where member_code='$referral_code'");
						 $researnlimit1       =  $getearnlimit1->result();
							if($researnlimit1[0]->earn_level!=''&& $researnlimit1[0]->earn_level!=0){
									$validate 		=   $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$referral_code' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$referral_code' , '$earnamount1',0,'$member_code','$pqty')");
									} else {
										$gt1          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt1 <= 0){
											$getearn1 = $earning_lvl_one * $validateres[0]->earninglimit;
											$float1   = $earnamount2 - $getearn2;
											$abs      = abs($gt1);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$referral_code'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn1',floating=floating+'$float1' where membercode='$referral_code'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$referral_code' , '$getearn1','$float1',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$referral_code'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount1' where membercode='$referral_code'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$referral_code' , '$earnamount1',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$referral_code' , '$earnamount1',0,'$member_code','$pqty')");
							}
				}
				if($getmemberres[0]->line_level ==10){
						
						 $getthirdlevel      =  $this->db->query("SELECT referral_code from biowash_members where member_code='$referral_code'");
						 $thirdlevel         =  $getthirdlevel->result();
						 $thirdlevelref      =  $thirdlevel[0]->referral_code;
						 
						 $getfourthlevel     =  $this->db->query("SELECT referral_code from biowash_members where member_code='$thirdlevelref'");
						 $fourthlevel        =  $getfourthlevel->result();
						 $fourthlevelref     =  $fourthlevel[0]->referral_code;
						 
						 $getfifthlevel      =  $this->db->query("SELECT referral_code from biowash_members where member_code='$fourthlevelref'");
						 $fithlevel          =  $getfifthlevel->result();
						 $fithlevelref       =  $fithlevel[0]->referral_code;
						 
						 $getsixlevel        =  $this->db->query("SELECT referral_code from biowash_members where member_code='$fithlevelref'");
						 $sixlevel           =  $getsixlevel->result();
						 $sixlevelref        =  $sixlevel[0]->referral_code;
						 
						 $getsevenlevel      =  $this->db->query("SELECT referral_code from biowash_members where member_code='$sixlevelref'");
						 $sevenlevel         =  $getsevenlevel->result();
						 $sevenlevelref      =  $sevenlevel[0]->referral_code; 
						 
						 $geteightlevel      =  $this->db->query("SELECT referral_code from biowash_members where member_code='$sevenlevelref'");
						 $eightlevel         =  $geteightlevel->result();
						 $eightlevelref      =  $eightlevel[0]->referral_code;
						 
						 $getninelevel       =  $this->db->query("SELECT referral_code from biowash_members where member_code='$eightlevelref'");
						 $ninelevel          =  $getninelevel->result();
						 $ninelevelref       =  $ninelevel[0]->referral_code;
						 
						 $gettenlevel        =  $this->db->query("SELECT referral_code from biowash_members where member_code='$ninelevelref'");
						 $tenlevel           =  $gettenlevel->result();
						 $tenlevelref        =  $tenlevel[0]->referral_code;
 
						 
						 // ** 10th Level **//
						 $getearnlimit       =  $this->db->query("select earn_level from biowash_members where member_code='$referral_main_code'");
						 $researnlimit       =  $getearnlimit->result();
						 if($researnlimit[0]->earn_level=='1101'){
								$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus,earnfrom,earncount) VALUES ('$referral_main_code' , '$earnamount10',1,'$member_code','$pqty')");
								$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount10' where membercode='$referral_main_code'");
								$this->db->query("UPDATE biowash_earnings_progress set used_earnings =used_earnings+'$earnlevel' where membercode='$referral_main_code' and earningfrom ='$member_code'");
						 }
						  // ** 9th Level **//
						 $getearnlimit9       =  $this->db->query("select earn_level from biowash_members where member_code='$tenlevelref'");
						 $researnlimit9       =  $getearnlimit9->result();
						if($researnlimit9[0]->earn_level!=''&& $researnlimit9[0]->earn_level!=0){
									$validate 		=  $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$tenlevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$tenlevelref' , '$earnamount9',0,'$member_code','$pqty')");
									} else {
										$gt9          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt9 <= 0){
											$getearn9 = $earning_lvl_nine * $validateres[0]->earninglimit;
											$float9   = $earnamount9 - $getearn9;
											$abs      = abs($gt9);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$tenlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn9',floating=floating+'$float9' where membercode='$tenlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$tenlevelref' , '$getearn9','$float9',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$tenlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount9' where membercode='$tenlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$tenlevelref' , '$earnamount9',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$tenlevelref' , '$earnamount9',0,'$member_code','$pqty')");
							} 
						  // ** 8th Level **//
						 $getearnlimit8       =  $this->db->query("select earn_level from biowash_members where member_code='$ninelevelref'");
						 $researnlimit8       =  $getearnlimit8->result();
						 if($researnlimit8[0]->earn_level!=''&& $researnlimit8[0]->earn_level!=0){
									$validate 		=  $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$ninelevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$ninelevelref' , '$earnamount8',0,'$member_code','$pqty')");
									}  else {
										$gt8          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt8 <= 0){
											$getearn8 = $earning_lvl_eight * $validateres[0]->earninglimit;
											$float8   = $earnamount8 - $getearn8;
											$abs      = abs($gt8);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$ninelevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn8',floating=floating+'$float8' where membercode='$ninelevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$ninelevelref' , '$getearn8','$float8',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$ninelevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount8' where membercode='$ninelevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$ninelevelref' , '$earnamount8',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$ninelevelref' , '$earnamount8',0,'$member_code','$pqty')");
							} 
						 // ** 7th Level **//
						 $getearnlimit7       =  $this->db->query("select earn_level from biowash_members where member_code='$eightlevelref'");
						 $researnlimit7       =  $getearnlimit7->result();
						if($researnlimit7[0]->earn_level!=''&& $researnlimit7[0]->earn_level!=0){
									$validate 		=  $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$eightlevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$eightlevelref' , '$earnamount7',0,'$member_code','$pqty')");
									} else {
										$gt7          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt7 <= 0){
											$getearn7 = $earning_lvl_seven * $validateres[0]->earninglimit;
											$float7   = $earnamount7 - $getearn7;
											$abs      = abs($gt7);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$eightlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn7',floating=floating+'$float7' where membercode='$eightlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$eightlevelref' , '$getearn7','$float7',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$eightlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount7' where membercode='$eightlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$eightlevelref' , '$earnamount7',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$eightlevelref' , '$earnamount7',0,'$member_code','$pqty')");
							} 
						  // ** 6th Level **//
						 $getearnlimit6       =  $this->db->query("select earn_level from biowash_members where member_code='$sevenlevelref'");
						 $researnlimit6       =  $getearnlimit6->result();
						if($researnlimit6[0]->earn_level!=''&& $researnlimit6[0]->earn_level!=0){
									$validate 		=  $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$sevenlevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$sevenlevelref' , '$earnamount6',0,'$member_code','$pqty')");
									} else {
										$gt6          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt6 <= 0){
											$getearn6 = $earning_lvl_six * $validateres[0]->earninglimit;
											$float6   = $earnamount6 - $getearn6;
											$abs      = abs($gt6);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$sevenlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn6',floating=floating+'$float6' where membercode='$sevenlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$sevenlevelref' , '$getearn6','$float6',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$sevenlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount6' where membercode='$sevenlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$sevenlevelref' , '$earnamount6',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$sevenlevelref' , '$earnamount6',0,'$member_code','$pqty')");
							} 
						 
						// ** 5th Level **//
						 $getearnlimit5       =  $this->db->query("select earn_level from biowash_members where member_code='$sixlevelref'");
						 $researnlimit5       =  $getearnlimit5->result();
						if($researnlimit5[0]->earn_level!=''&& $researnlimit5[0]->earn_level!=0){
									$validate 		=  $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$sixlevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$sixlevelref' , '$earnamount5',0,'$member_code','$pqty')");
									} else {
										$gt5          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt5 <= 0){
											$getearn5 = $earning_lvl_five * $validateres[0]->earninglimit;
											$float5   = $earnamount4 - $getearn5;
											$abs      = abs($gt5);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$sixlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn5',floating=floating+'$float5' where membercode='$sixlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$sixlevelref' , '$getearn5','$float5',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$sixlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount5' where membercode='$sixlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$sixlevelref' , '$earnamount5',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$sixlevelref' , '$earnamount4',0,'$member_code','$pqty')");
							} 
						 
						// ** 4th Level **//
						 $getearnlimit4       =  $this->db->query("select earn_level from biowash_members where member_code='$fithlevelref'");
						 $researnlimit4       =  $getearnlimit4->result();
						if($researnlimit4[0]->earn_level!=''&& $researnlimit4[0]->earn_level!=0){
									$validate 		=  $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$fithlevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$fithlevelref' , '$earnamount4',0,'$member_code','$pqty')");
									} else {
										$gt4          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt4 <= 0){
											$getearn4 = $earning_lvl_four * $validateres[0]->earninglimit;
											$float4   = $earnamount4 - $getearn4;
											$abs      = abs($gt4);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$fithlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn4',floating=floating+'$float4' where membercode='$fithlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$fithlevelref' , '$getearn4','$float4',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$fithlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount4' where membercode='$fithlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$fithlevelref' , '$earnamount4',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$fithlevelref' , '$earnamount4',0,'$member_code','$pqty')");
							} 
						 
						  // ** 3rd Level **//
						 $getearnlimit3       =  $this->db->query("select earn_level from biowash_members where member_code='$fourthlevelref'");
						 $researnlimit3       =  $getearnlimit3->result();
							if($researnlimit3[0]->earn_level!=''&& $researnlimit3[0]->earn_level!=0){
									$validate 		=  $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$fourthlevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$fourthlevelref' , '$earnamount3',0,'$member_code','$pqty')");
									} else {
										$gt3          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt3 <= 0){
											$getearn3 = $earning_lvl_three * $validateres[0]->earninglimit;
											$float3   = $earnamount3 - $getearn3;
											$abs      = abs($gt3);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$fourthlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn3',floating=floating+'$float3' where membercode='$fourthlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$fourthlevelref' , '$getearn3','$float3',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$fourthlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount3' where membercode='$fourthlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$fourthlevelref' , '$earnamount3',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$fourthlevelref' , '$earnamount3',0,'$member_code','$pqty')");
							} 
						 
						 // ** 2nd Level **//
						 $getearnlimit2       =  $this->db->query("select earn_level from biowash_members where member_code='$thirdlevelref'");
						 $researnlimit2       =  $getearnlimit2->result();
							if($researnlimit2[0]->earn_level!=''&& $researnlimit2[0]->earn_level!=0){
									$validate 		=   $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$thirdlevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$thirdlevelref' , '$earnamount2',0,'$member_code','$pqty')");
									} else {
										$gt2          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt2 <= 0){
											$getearn2 = $earning_lvl_two * $validateres[0]->earninglimit;
											$float2   = $earnamount2 - $getearn2;
											$abs      = abs($gt2);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$thirdlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn2',floating=floating+'$float2' where membercode='$thirdlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$thirdlevelref' , '$getearn2','$float2',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$thirdlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount2' where membercode='$thirdlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$thirdlevelref' , '$earnamount2',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$thirdlevelref' , '$earnamount2',0,'$member_code','$pqty')");
							} 
						// ** 1st Level **//
						 $getearnlimit1       =  $this->db->query("select earn_level from biowash_members where member_code='$referral_code'");
						 $researnlimit1       =  $getearnlimit1->result();
							if($researnlimit1[0]->earn_level!=''&& $researnlimit1[0]->earn_level!=0){
									$validate 		=   $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$referral_code' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$referral_code' , '$earnamount1',0,'$member_code','$pqty')");
									} else {
										$gt1          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt1 <= 0){
											$getearn1 = $earning_lvl_one * $validateres[0]->earninglimit;
											$float1   = $earnamount2 - $getearn2;
											$abs      = abs($gt1);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$referral_code'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn1',floating=floating+'$float1' where membercode='$referral_code'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$referral_code' , '$getearn1','$float1',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$referral_code'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount1' where membercode='$referral_code'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$referral_code' , '$earnamount1',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$referral_code' , '$earnamount1',0,'$member_code','$pqty')");
							}
				}
				if($getmemberres[0]->line_level >=11){
						
					 $getthirdlevel      =  $this->db->query("SELECT referral_code from biowash_members where member_code='$referral_code'");
					 $thirdlevel         =  $getthirdlevel->result();
					 $thirdlevelref      =  $thirdlevel[0]->referral_code;
					 
					 $getfourthlevel     =  $this->db->query("SELECT referral_code from biowash_members where member_code='$thirdlevelref'");
					 $fourthlevel        =  $getfourthlevel->result();
					 $fourthlevelref     =  $fourthlevel[0]->referral_code;
					 
					 $getfifthlevel      =  $this->db->query("SELECT referral_code from biowash_members where member_code='$fourthlevelref'");
					 $fithlevel          =  $getfifthlevel->result();
					 $fithlevelref       =  $fithlevel[0]->referral_code;
					 
					 $getsixlevel        =  $this->db->query("SELECT referral_code from biowash_members where member_code='$fithlevelref'");
					 $sixlevel           =  $getsixlevel->result();
					 $sixlevelref        =  $sixlevel[0]->referral_code;
					 
					 $getsevenlevel      =  $this->db->query("SELECT referral_code from biowash_members where member_code='$sixlevelref'");
					 $sevenlevel         =  $getsevenlevel->result();
					 $sevenlevelref      =  $sevenlevel[0]->referral_code; 
					 
					 $geteightlevel      =  $this->db->query("SELECT referral_code from biowash_members where member_code='$sevenlevelref'");
					 $eightlevel         =  $geteightlevel->result();
					 $eightlevelref      =  $eightlevel[0]->referral_code;
					 
					 $getninelevel       =  $this->db->query("SELECT referral_code from biowash_members where member_code='$eightlevelref'");
					 $ninelevel          =  $getninelevel->result();
					 $ninelevelref       =  $ninelevel[0]->referral_code;
					 
					 $gettenlevel        =  $this->db->query("SELECT referral_code from biowash_members where member_code='$ninelevelref'");
					 $tenlevel           =  $gettenlevel->result();
					 $tenlevelref        =  $tenlevel[0]->referral_code;
					 
					 $getelevenlevel     =  $this->db->query("SELECT referral_code from biowash_members where member_code='$tenlevelref'");
					 $elevenlevel        =  $getelevenlevel->result();
					 $elevenlevelref     =  $elevenlevel[0]->referral_code;
 
						  // ** 10 Level **//
						 $getearnlimit10       =  $this->db->query("select earn_level from biowash_members where member_code='$elevenlevelref'");
						 $researnlimit10       =  $getearnlimit10->result();
						if($researnlimit10[0]->earn_level!=''&& $researnlimit10[0]->earn_level!=0){
									$validate 		=  $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$elevenlevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$elevenlevelref' , '$earnamount10',0,'$member_code','$pqty')");
									} else {
										$gt10          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings  = $validateres[0]->earninglimit;
										if($gt10 <= 0){
											$getearn10  = $earning_lvl_ten * $validateres[0]->earninglimit;
											$float10    = $earnamount10 - $getearn10;
											$abs        = abs($gt10);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$elevenlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn10',floating=floating+'$float10' where membercode='$elevenlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$elevenlevelref' , '$getearn10','$float10',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$elevenlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount10' where membercode='$elevenlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$elevenlevelref' , '$earnamount10',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$elevenlevelref' , '$earnamount10',0,'$member_code','$pqty')");
							} 
						 
						   // ** 9th Level **//
						 $getearnlimit9       =  $this->db->query("select earn_level from biowash_members where member_code='$tenlevelref'");
						 $researnlimit9       =  $getearnlimit9->result();
						if($researnlimit9[0]->earn_level!=''&& $researnlimit9[0]->earn_level!=0){
									$validate 		=  $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$tenlevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$tenlevelref' , '$earnamount9',0,'$member_code','$pqty')");
									} else {
										$gt9          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt9 <= 0){
											$getearn9 = $earning_lvl_nine * $validateres[0]->earninglimit;
											$float9   = $earnamount9 - $getearn9;
											$abs      = abs($gt9);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$tenlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn9',floating=floating+'$float9' where membercode='$tenlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$tenlevelref' , '$getearn9','$float9',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$tenlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount9' where membercode='$tenlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$tenlevelref' , '$earnamount9',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$tenlevelref' , '$earnamount9',0,'$member_code','$pqty')");
							} 
						  // ** 8th Level **//
						 $getearnlimit8       =  $this->db->query("select earn_level from biowash_members where member_code='$ninelevelref'");
						 $researnlimit8       =  $getearnlimit8->result();
						 if($researnlimit8[0]->earn_level!=''&& $researnlimit8[0]->earn_level!=0){
									$validate 		=  $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$ninelevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$ninelevelref' , '$earnamount8',0,'$member_code','$pqty')");
									}  else {
										$gt8          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt8 <= 0){
											$getearn8 = $earning_lvl_eight * $validateres[0]->earninglimit;
											$float8   = $earnamount8 - $getearn8;
											$abs      = abs($gt8);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$ninelevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn8',floating=floating+'$float8' where membercode='$ninelevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$ninelevelref' , '$getearn8','$float8',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$ninelevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount8' where membercode='$ninelevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$ninelevelref' , '$earnamount8',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$ninelevelref' , '$earnamount8',0,'$member_code','$pqty')");
							} 
						 // ** 7th Level **//
						 $getearnlimit7       =  $this->db->query("select earn_level from biowash_members where member_code='$eightlevelref'");
						 $researnlimit7       =  $getearnlimit7->result();
						if($researnlimit7[0]->earn_level!=''&& $researnlimit7[0]->earn_level!=0){
									$validate 		=  $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$eightlevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$eightlevelref' , '$earnamount7',0,'$member_code','$pqty')");
									} else {
										$gt7          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt7 <= 0){
											$getearn7 = $earning_lvl_seven * $validateres[0]->earninglimit;
											$float7   = $earnamount7 - $getearn7;
											$abs      = abs($gt7);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$eightlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn7',floating=floating+'$float7' where membercode='$eightlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$eightlevelref' , '$getearn7','$float7',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$eightlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount7' where membercode='$eightlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$eightlevelref' , '$earnamount7',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$eightlevelref' , '$earnamount7',0,'$member_code','$pqty')");
							} 
						  // ** 6th Level **//
						 $getearnlimit6       =  $this->db->query("select earn_level from biowash_members where member_code='$sevenlevelref'");
						 $researnlimit6       =  $getearnlimit6->result();
						if($researnlimit6[0]->earn_level!=''&& $researnlimit6[0]->earn_level!=0){
									$validate 		=  $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$sevenlevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$sevenlevelref' , '$earnamount6',0,'$member_code','$pqty')");
									} else {
										$gt6          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt6 <= 0){
											$getearn6 = $earning_lvl_six * $validateres[0]->earninglimit;
											$float6   = $earnamount6 - $getearn6;
											$abs      = abs($gt6);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$sevenlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn6',floating=floating+'$float6' where membercode='$sevenlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$sevenlevelref' , '$getearn6','$float6',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$sevenlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount6' where membercode='$sevenlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$sevenlevelref' , '$earnamount6',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$sevenlevelref' , '$earnamount6',0,'$member_code','$pqty')");
							} 
						 
						// ** 5th Level **//
						 $getearnlimit5       =  $this->db->query("select earn_level from biowash_members where member_code='$sixlevelref'");
						 $researnlimit5       =  $getearnlimit5->result();
						if($researnlimit5[0]->earn_level!=''&& $researnlimit5[0]->earn_level!=0){
									$validate 		=  $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$sixlevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$sixlevelref' , '$earnamount5',0,'$member_code','$pqty')");
									} else {
										$gt5          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt5 <= 0){
											$getearn5 = $earning_lvl_five * $validateres[0]->earninglimit;
											$float5   = $earnamount4 - $getearn5;
											$abs      = abs($gt5);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$sixlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn5',floating=floating+'$float5' where membercode='$sixlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$sixlevelref' , '$getearn5','$float5',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$sixlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount5' where membercode='$sixlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$sixlevelref' , '$earnamount5',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$sixlevelref' , '$earnamount4',0,'$member_code','$pqty')");
							} 
						 
							// ** 4th Level **//
						 $getearnlimit4       =  $this->db->query("select earn_level from biowash_members where member_code='$fithlevelref'");
						 $researnlimit4       =  $getearnlimit4->result();
						if($researnlimit4[0]->earn_level!=''&& $researnlimit4[0]->earn_level!=0){
									$validate 		=  $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$fithlevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$fithlevelref' , '$earnamount4',0,'$member_code','$pqty')");
									} else {
										$gt4          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt4 <= 0){
											$getearn4 = $earning_lvl_four * $validateres[0]->earninglimit;
											$float4   = $earnamount4 - $getearn4;
											$abs      = abs($gt4);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$fithlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn4',floating=floating+'$float4' where membercode='$fithlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$fithlevelref' , '$getearn4','$float4',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$fithlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount4' where membercode='$fithlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$fithlevelref' , '$earnamount4',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$fithlevelref' , '$earnamount4',0,'$member_code','$pqty')");
							} 
						 
						  // ** 3rd Level **//
						 $getearnlimit3       =  $this->db->query("select earn_level from biowash_members where member_code='$fourthlevelref'");
						 $researnlimit3       =  $getearnlimit3->result();
							if($researnlimit3[0]->earn_level!=''&& $researnlimit3[0]->earn_level!=0){
									$validate 		=  $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$fourthlevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$fourthlevelref' , '$earnamount3',0,'$member_code','$pqty')");
									} else {
										$gt3          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt3 <= 0){
											$getearn3 = $earning_lvl_three * $validateres[0]->earninglimit;
											$float3   = $earnamount3 - $getearn3;
											$abs      = abs($gt3);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$fourthlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn3',floating=floating+'$float3' where membercode='$fourthlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$fourthlevelref' , '$getearn3','$float3',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$fourthlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount3' where membercode='$fourthlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$fourthlevelref' , '$earnamount3',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$fourthlevelref' , '$earnamount3',0,'$member_code','$pqty')");
							} 
						 
						 // ** 2nd Level **//
						 $getearnlimit2       =  $this->db->query("select earn_level from biowash_members where member_code='$thirdlevelref'");
						 $researnlimit2       =  $getearnlimit2->result();
							if($researnlimit2[0]->earn_level!=''&& $researnlimit2[0]->earn_level!=0){
									$validate 		=   $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$thirdlevelref' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$thirdlevelref' , '$earnamount2',0,'$member_code','$pqty')");
									} else {
										$gt2          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt2 <= 0){
											$getearn2 = $earning_lvl_two * $validateres[0]->earninglimit;
											$float2   = $earnamount2 - $getearn2;
											$abs      = abs($gt2);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$thirdlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn2',floating=floating+'$float2' where membercode='$thirdlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$thirdlevelref' , '$getearn2','$float2',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$thirdlevelref'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount2' where membercode='$thirdlevelref'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$thirdlevelref' , '$earnamount2',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$thirdlevelref' , '$earnamount2',0,'$member_code','$pqty')");
							} 
						// ** 1st Level **//
						 $getearnlimit1       =  $this->db->query("select earn_level from biowash_members where member_code='$referral_code'");
						 $researnlimit1       =  $getearnlimit1->result();
							if($researnlimit1[0]->earn_level!=''&& $researnlimit1[0]->earn_level!=0){
									$validate 		=   $this->db->query("select earninglimit from biowash_earnings_progress where membercode='$referral_code' and earningfrom ='$member_code'");
									$validateres    =  $validate->result();
									if($validateres[0]->earninglimit == 0){
										$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$referral_code' , '$earnamount1',0,'$member_code','$pqty')");
									} else {
										$gt1          = $validateres[0]->earninglimit - $earnlevel ;
										$usedearnings = $validateres[0]->earninglimit;
										if($gt1 <= 0){
											$getearn1 = $earning_lvl_one * $validateres[0]->earninglimit;
											$float1   = $earnamount1 - $getearn1;
											$abs      = abs($gt1);
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = 0 , used_earnings = used_earnings+'$usedearnings',float_earnings = float_earnings+'$abs' where membercode='$referral_code'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$getearn1',floating=floating+'$float1' where membercode='$referral_code'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount,floatamount , earnstatus, earnfrom,earncount,floatcount) VALUES ('$referral_code' , '$getearn1','$float1',0,'$member_code','$usedearnings','$abs')");

										} else {
											$this->db->query("UPDATE biowash_earnings_progress set earninglimit = earninglimit-'$earnlevel' , used_earnings = used_earnings+'$earnlevel'where membercode='$referral_code'  and earningfrom ='$member_code'");
											$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamount1' where membercode='$referral_code'");
											$this->db->query("INSERT INTO biowash_members_earning (membercode , earnamount , earnstatus, earnfrom,earncount) VALUES ('$referral_code' , '$earnamount1',1,'$member_code','$pqty')");
										}
									}
							} else {
									$this->db->query("INSERT INTO biowash_members_earning (membercode , floatamount , earnstatus,earnfrom,floatcount) VALUES ('$referral_code' , '$earnamount1',0,'$member_code','$pqty')");
							}
				}
				} if($complan ==2){
					$getflash   = $this->db->query("SELECT * FROM biowash_members  where member_code='$member_code'");
					$getflashre = $getflash->result();
					if($getflashre[0]->flashOut =='' || $getflashre[0]->flashOut==0){
						$folimit =  $getearn[0]->daily_limit;
						$this->db->query("UPDATE biowash_members set flashOut = '$folimit' where member_code='$member_code'");
					}
					for ($x = 1; $x <= $pqty   ; $x++) {
						$binaryCode =  $this->binaryCode();
						$this->db->query("INSERT INTO biowash_binary_codes(uplinecode , membercode , transactioncode) values ('$referral_code','$member_code' , '$binaryCode$x')");
						
						//** Adding Earnings **//			
						$earnamoumt = $getearn[0]->binary_direct_earn;
						$this->db->query("INSERT into biowash_binary_earning (memberCode,binaryTransactionCode,EarnDesc,EarnAmount)
																			  VALUES ('$referral_code' ,'$binaryCode$x','Direct Invite' ,'$earnamoumt')");
						$this->db->query("UPDATE biowash_members_wallet set balance = balance+'$earnamoumt' where membercode='$referral_code'");
						// echo "UPDATE biowash_members_wallet set balance = balance+'$earnamoumt' where membercode='$referral_code'";
						$getuplineemail  = $this->db->query("select * from biowash_members where member_code='$referral_code'");
						$getuplineresult = $getuplineemail->result();
						
						// mellph@yahoo.com
						$email    = $getuplineresult[0]->emailaddress;
						$message  = '<b>BioWASH System Binary Pin Code</b>';
						$message .= '<br><br> Hello  , '.$getuplineresult[0]->firstname .' '. $getuplineresult[0]->lastname;
						$message .= '<br> <br> Use for Binary Tree Transaction</a>';
						$message .= '<br> <br> User Binary Pin Code ' . $binaryCode.''.$x;
						$message .= '<br> <br> <br> Thank You!</a>';
						$subject  = 'Binary Pin Code';
						$to       = $email;
						$headers  = 'MIME-Version: 1.0' . "\r\n";
						$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						$headers .= 'From: BioWASH System <support@biowash.system>' . "\r\n";
						mail($to, $subject, $message, $headers);
					}
				}
			}
				
		  }
				
				//** AUTO GET FLOATING EARNINGS **//
				// echo "start";
				// echo "select * from biowash_earnings_progress where membercode='$member_code' and earninglimit!=0  ";
				if($complan ==2){
				$earnget     = $getearn[0]->earn_limit;
				$getearnby   = $this->db->query("select * from biowash_earnings_progress where membercode='$member_code' and earninglimit!=0  ");
				foreach($getearnby->result() as $aa =>$bb){
					$earningfrom  = $bb->earningfrom;
					$getearnfloat = $this->db->query("select * from biowash_members_earning where membercode='$member_code' and earnfrom='$earningfrom' and earnstatus=0 ");
					foreach($getearnfloat->result() as $cc =>$dd){
						$floatcount  = $dd->floatcount;
						$earncnt     = $dd->earncount;
						$earnfrom    = $dd->earnfrom;
						$earnamount  = $dd->earnamount;
						$floatamount = $dd->floatamount;
						$floatamount = $dd->floatamount;
						$earningID   = $dd->earningID;
						$earns       =  $getearn[0]->earn_limit;
						if($floatcount !=0){
							$getef   = $getearn[0]->earn_limit - $floatcount;
							$abs1    = abs($getef);
							if($getef < 0){
								// echo "$getef < 0";
								$divided   =  $floatamount /  $floatcount;
								$totalearn =  $divided * $getearn[0]->earn_limit;
								$this->db->query("update biowash_members_wallet set balance =balance+'$totalearn',floating=floating+'$divided' where membercode='$member_code'");
								$this->db->query("update biowash_members_earning set earnamount =earnamount+'$totalearn',floatamount=floatamount-'$totalearn', earnstatus=0,earncount=earncount+'$earns', floatcount=floatcount-'$earns' where earningID='$earningID' ");
								$this->db->query("update biowash_earnings_progress set earninglimit=earninglimit-'$earns' , used_earnings=used_earnings+'$earns',float_earnings=float_earnings+'$abs1' where membercode='$member_code' and earningfrom='$earnfrom'");
							} else {
								// echo "$getef > 0";
								$this->db->query("update biowash_members_wallet set balance =balance+'$floatamount',floating=floating-'$floatamount' where membercode='$member_code'");
								$this->db->query("update biowash_members_earning set earnamount =earnamount+'$floatamount',floatamount=floatamount-'$floatamount',earnstatus=1 ,floatcount=floatcount-'$abs1'  where earningID='$earningID' ");
								$this->db->query("update biowash_earnings_progress set earninglimit=earninglimit-'$floatcount' , used_earnings=used_earnings+'$floatcount',float_earnings=float_earnings-'$abs1' where membercode='$member_code' and earningfrom='$earnfrom'");
							}
						} else {
							// echo "LAST ELSE";
							$this->db->query("update biowash_members_earning set earnstatus='1'  where earningID='$earningID' ");
							$this->db->query("update biowash_earnings_progress set earninglimit=earninglimit-'$earncnt' , used_earnings=used_earnings+'$earncnt' where membercode='$member_code' and earningfrom='$earnfrom'");
						}
					}
				}
				}
			redirect('administrator/payments/paymentdetails/'. $code.'/approved');
		}
}
?>
