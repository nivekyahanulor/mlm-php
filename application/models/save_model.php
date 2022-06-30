<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Save_Model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('csvimport');
		$this->load->library('email');
    }
	
	public function saveretailerinventory($data){
		$prodid =  $data['productid'];
		foreach($prodid as $a => $b){
			$datas = array(
            'productID'         => $b,
            'retailerID'        => $data['retailer'],
            'quantity'          => 100,
            'currentinventory'  => 100,
			);
	    $this->db->insert('del2home_retailer_inventory',$datas);
		}
		redirect('admin?page=retailer-assign-inventory&id='.$data['retailer'].'&name='.$data['name'].'&processed');
	}
	public function transactionCode() {
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
	public function saveproduct($data) {
		$image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
        $image_name = addslashes($_FILES['image']['name']);
        $image_size = getimagesize($_FILES['image']['tmp_name']);
		move_uploaded_file($_FILES["image"]["tmp_name"], "assets/webp/" . $_FILES["image"]["name"]);
        $location 	=  $_FILES["image"]["name"];
		
		$datas = array(
            'product_name'         => $data['productname'],
            'product_sku'          => $data['sku'],
            'product_price'        => $data['productprice'],
            'product_description'  => $data['description'],
            'product_qty'          => $data['qty'],
            'product_brand'        => $data['brand'],
            'product_stocks'       => $data['availability'],
            'product_category'     => $data['category'],
            'product_sub_category' => $data['subcategory'],
            'product_code'         => $data['code'],
            'product_image'        => $location,
        );
	    $this->db->insert('del2home_products',$datas);
		redirect('admin?page=products&added');
	}
	public function savecategory($data) {
		$datas = array(
            'category_name'         => $data['category'],
        );
	    $this->db->insert('del2home_category',$datas);
		redirect('admin?page=categories&added');
	}
	
	public function savesubcategory($data) {
		$datas = array(
            'subcat_name'   => $data['category'],
            'catID'         => $data['catID'],
        );
	    $this->db->insert('del2home_sub_category',$datas);
		redirect('admin?page=subcategory&data='.$data['catID'].'&added');
	}
	public function processinventoryrequest($data) {
		$datas = array(
            'retailerID'     => $data['retailerid'],
            'distributorID'  => $data['distributorid'],
            'requestcode'    => $this->transactionCode(),
        );
	    $this->db->insert('del2home_retailer_request_invetory',$datas);
		return $datas['requestcode'];
	}
	public function confirmorder($data) {
		$code = $data['code'];
	    $this->db->query("UPDATE del2home_retailer_orders set isOpen=1 where transcode='$code'");
	    $this->db->query("UPDATE del2home_orders set orderStatus=1 where transactionCode='$code'");
	    $this->db->query("UPDATE del2home_checkout_orders set deliveryStatus=1 where transcode='$code'");
		$this->db->query("INSERT into del2home_order_process_history (transcode , process_perform) VALUES ('$code' , 'Retailer Confirm Your Order')");
	}	
	public function prepareorder($data) {
		$code     =  $data['code'];
		$orders   =  $this->db->query("select * from del2home_orders where transactionCode='$code'");
		$result   = $orders->result();
		foreach( $result as $row => $val){
				$products = $val->productID;
				$quantity = $val->qty;
				$inventory = $this->db->query("select * from del2home_retailer_inventory where productID='$products'");
				$chekavail = $inventory->num_rows();
				if($chekavail == 1){
				   $update = $this->db->query("update del2home_retailer_inventory set quantitySold=quantitySold+'$quantity' , quantity=quantity-'$quantity' where productID='$products'");
				}
		}
	    $this->db->query("UPDATE del2home_retailer_orders set isOpen=2 where transcode='$code'");
	    $this->db->query("UPDATE del2home_orders set orderStatus=2 where transactionCode='$code'");
	    $this->db->query("UPDATE del2home_checkout_orders set deliveryStatus=2 where transcode='$code'");
		$this->db->query("INSERT into del2home_order_process_history (transcode , process_perform) VALUES ('$code' , 'Retailer Prepare Your Order')");
	}
	public function addtocart($data) {
	    $this->db->insert('del2home_orders',$data);
	}
	public function register_retailer($data) {
			$email  = $data['emailaddress'];
			$config = array(
				'protocol'  => 'smtp',
				'smtp_host' => 'ssl://giowm7.siteground.biz',
				'smtp_port' => 465,
				'smtp_user' => 'admin@souq.car',
				'smtp_pass' => '@souq123*#',
				'mailtype'  => 'html',
				'charset'   => 'utf-8'
			);
			$this->email->initialize($config);
			$this->email->set_mailtype("html");
			$this->email->set_newline("\r\n");
			//Email content
		    $message  = '<strong> Welcome to Del2home.com  </strong> ';
		    $message .= '<br><br>';
		    $message .= 'Thank You!';
			$this->email->to($email);
			$this->email->from('admin@souq.car','Del2home.com');
			$this->email->subject('Success Registration');
			$this->email->message($message);
			//Send email
			$this->email->send();
			//Save to database
			$this->db->insert('del2home_retailers',$data);
		
	}
	public function register_distributor($data) {
			$email  = $data['emailaddress'];
			$config = array(
				'protocol'  => 'smtp',
				'smtp_host' => 'ssl://giowm7.siteground.biz',
				'smtp_port' => 465,
				'smtp_user' => 'admin@souq.car',
				'smtp_pass' => '@souq123*#',
				'mailtype'  => 'html',
				'charset'   => 'utf-8'
			);
			$this->email->initialize($config);
			$this->email->set_mailtype("html");
			$this->email->set_newline("\r\n");
			//Email content
		    $message  = '<strong> Welcome to Del2home.com  </strong> ';
		    $message .= '<br><br>';
		    $message .= 'Thank You!';
			$this->email->to($email);
			$this->email->from('admin@souq.car','Del2home.com');
			$this->email->subject('Success Registration');
			$this->email->message($message);
			//Send email
			$this->email->send();
			//Save to database
			$this->db->insert('del2home_distributor',$data);
	}
	public function register_delivery($data) {
	    $this->db->insert('del2home_delivery_driver',$data);
	}
	public function register_customer($data) {
			$email  = $data['emailaddress'];
			$config = array(
				'protocol'  => 'smtp',
				'smtp_host' => 'ssl://giowm7.siteground.biz',
				'smtp_port' => 465,
				'smtp_user' => 'admin@souq.car',
				'smtp_pass' => '@souq123*#',
				'mailtype'  => 'html',
				'charset'   => 'utf-8'
			);
			$this->email->initialize($config);
			$this->email->set_mailtype("html");
			$this->email->set_newline("\r\n");
			//Email content
		    $message  = '<strong> Welcome to Del2home.com  </strong> ';
		    $message .= '<br><br>';
		    $message .= 'Thank You!';
			$this->email->to($email);
			$this->email->from('admin@souq.car','Del2home.com');
			$this->email->subject('Success Registration');
			$this->email->message($message);
			//Send email
			$this->email->send();
			$this->db->insert('del2home_customers',$data);
	}
	public function register_riders($data) {
			$email  = $data['emailaddress'];
			$config = array(
				'protocol'  => 'smtp',
				'smtp_host' => 'ssl://giowm7.siteground.biz',
				'smtp_port' => 465,
				'smtp_user' => 'admin@souq.car',
				'smtp_pass' => '@souq123*#',
				'mailtype'  => 'html',
				'charset'   => 'utf-8'
			);
			$this->email->initialize($config);
			$this->email->set_mailtype("html");
			$this->email->set_newline("\r\n");
			//Email content
		    $message  = '<strong> Welcome to Del2home.com  </strong> ';
		    $message .= '<br><br>';
		    $message .= 'Thank You!';
			$this->email->to($email);
			$this->email->from('admin@souq.car','Del2home.com');
			$this->email->subject('Success Registration');
			$this->email->message($message);
			//Send email
			$this->email->send();
			$this->db->insert('del2home_riders',$data);
	}
	public function retailerinventory($data) {
	    $this->db->insert('del2home_retailer_inventory',$data);
	}
	public function updateproductimage($data) {
		$image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
        $image_name = addslashes($_FILES['image']['name']);
        $image_size = getimagesize($_FILES['image']['tmp_name']);
		move_uploaded_file($_FILES["image"]["tmp_name"], "assets/webp/" . $_FILES["image"]["name"]);
        $location 	=  $_FILES["image"]["name"];
		$id         =  $data['productID'];
		$product    =  $data['product'];
		$data       =  $data['data'];
	    $this->db->query("update del2home_products set product_image='$location' where productID='$id'");
		redirect('admin?page=productdata&data='.$data.'&product='.$product);
	}
	public function checkoutorder($data) {
	    $this->db->insert('del2home_checkout_orders',$data);
		$province    =  $data['province'];
		$city        =  $data['city'];
		$transcode   =  $data['transcode'];
		$getretailer = $this->db->query("select * from del2home_retailers where province='$province' and city ='$city'");
		$count       = $getretailer->num_rows();
		if($count == 0){
			$getavailretailer    = $this->db->query("select * from del2home_retailers where province='$province' order by rand() limit 1 ");
			$getavailretailerres = $getavailretailer->result();
			$retailerID          = $getavailretailerres[0]->retailerID;
			$this->db->query("insert into del2home_retailer_orders (transcode , retailerID) VALUES ('$transcode' , '$retailerID')");
			$this->db->query("update del2home_checkout_orders set retailerID='$retailerID' where transcode='$transcode'");
		} else {
			$getavailretailerres = $getretailer->result();
			$retailerID          = $getavailretailerres[0]->retailerID;
			$this->db->query("insert into del2home_retailer_orders (transcode , retailerID) VALUES ('$transcode' , '$retailerID')");
			$this->db->query("update del2home_checkout_orders set retailerID='$retailerID' where transcode='$transcode'");
		}
		$this->db->query("update del2home_orders set checkoutStatus = 1 where transactionCode='$transcode'");
	}
	public function processpayment($data) {
	    $this->db->insert('del2home_order_payment',$data);
		$transcode       =  $data['transcode'];
		$getretailer     = $this->db->query("update del2home_checkout_orders set paymentStatus=1 where transcode='$transcode'");
		$session_data    = array(
							'userid'          => $this->session->userdata['logged_in']['userid'],
							'username'        => $this->session->userdata['logged_in']['username'],
							'transcode'       => $this->transactionCode(),
							'name'            => $this->session->userdata['logged_in']['name'],
							'contactnumber'   => $this->session->userdata['logged_in']['contactnumber'],
							'emailaddress'    => $this->session->userdata['logged_in']['emailaddress'],
							);
		$this->session->set_userdata('logged_in', $session_data);
	}
	public function removetocart($data) {
		$this->db->where('orderID', $data['orderID']);
		$this->db->delete('del2home_orders'); 
	}
	public function importproduct($record) {
		$imported = array(
          "product_sku"          => trim($record[0]),
          "product_code"         => trim($record[5]),
          "product_name"         => trim($record[3]),
          "product_price"        => '0',
          "product_brand"        => trim($record[2]),
          "product_bu"           => trim($record[1]),
          "product_sub_category" => trim($record[4]),
          "product_description"  => trim($record[3]),
          "product_qty"          => '1000',
          "product_stocks"       => 'ON STOCKS',
          "product_case_config"  => trim($record[6]),
          "product_per_case"     => trim($record[7]),
          "product_srp"          => trim($record[8]),
        );
        $this->db->insert('del2home_products', $imported);
	}
	public function updateprod($data){
        $this->db->where('productID', $data['productID']);
        $this->db->update('del2home_products', $data);
	}
	public function updatecategory($data){
		$datas = array( 'category_name' => $data['category'],);
        $this->db->where('catID', $data['categoryID']);
        $this->db->update('del2home_category', $datas);
		redirect('admin?page=categories&updated');
	}
	public function plusorder($data){
		$id = $data['orderID'];
		$this->db->query("update del2home_orders set qty = qty +1 where orderID='$id'");
	}
	public function retailerprocessorder($data){
		$code = $data['code'];
		$this->db->query("update del2home_checkout_orders set deliveryStatus = 1 where transcode='$code'");
		$this->db->query("update del2home_orders set orderStatus = 1 where transactionCode='$code'");
	}
	public function minusorder($data){
		$id = $data['orderID'];
		$this->db->query("update del2home_orders set qty = qty -1 where orderID='$id'");
	}
	public function updatepng(){
		$this->db->query("UPDATE del2home_products SET product_image = REPLACE(product_image, '.webp', '.png')");
	}
	public function approvedreatiler($data){
		$datas = array( 'isactive' => 1);
        $this->db->where('retailerID', $data['retailerID']);
        $this->db->update('del2home_retailers', $datas);
	}
	
	public function updatesubcategory($data){
		$datas = array( 'subcat_name' => $data['category']);
        $this->db->where('subcatID', $data['subcatID']);
        $this->db->update('del2home_sub_category', $datas);
		redirect('admin?page=subcategory&data='.$data['catID']);
	}

	public function deleteprod($post) {
        $this->db->where('product_code', $post['code']);
        $result = $this->db->delete('del2home_products');
		redirect('admin?page=products&deleted');
    }

}