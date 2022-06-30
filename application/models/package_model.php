<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

date_default_timezone_set('Asia/Manila');

class Package_Model extends CI_Model {

    public function __construct()
    {
		header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        parent::__construct();
        $this->load->database();
		$this->load->library('session');
    }
	
	public function get_package_data() {
		$this->db->select('*');
		$this->db->from('biowash_packages');
		$query = $this->db->get();
		return $query->result();
	}
    public function get_package_data_info($data) {
        $this->db->select('*');
        $this->db->from('biowash_packages');
        $this->db->where($data);
        $query = $this->db->get();
        return $query->result();
    } 
    public function empathy_mega_accounts($data) {
        $this->db->select('*');
        $this->db->from('empathy_mega_accounts');
        $this->db->join('biowash_packages', 'empathy_mega_accounts.package_id = biowash_packages.packageID', 'left');
        $this->db->where(array('empathy_mega_accounts.member_code'=>$data,'empathy_mega_accounts.status' => 0));
        $query = $this->db->get();
        return $query->result();
    } 
    public function empathy_mega_accounts_sold($data) {
        $this->db->select('*');
        $this->db->from('empathy_mega_accounts');
        $this->db->join('biowash_packages', 'empathy_mega_accounts.package_id = biowash_packages.packageID', 'left');
        $this->db->where(array('empathy_mega_accounts.member_code'=>$data,'empathy_mega_accounts.status' => 1));
        $query = $this->db->get();
        return $query->result();
    } 
	public function deletepackage($data) {
        $this->db->where('packageID', $data['packageID']);
		$this->db->delete('biowash_packages');
        redirect('administrator/packages?deleted');
    }
    public function updatepackage($data) {
        $datas = array(
            'package_name'         => $data['packagename'],
            'package_price'        => $data['packageprice'],
            'package_description'  => $data['packagedescription'],
            'isActive'             => 1,
            );
        $this->db->where('packageID', $data['packageID']);
        $this->db->update('biowash_packages', $datas);
        redirect('administrator/packagedetails?package='.$data['packageID']);
    }
    public function updatepackageimage($data) {
        unlink(FCPATH."assets\packages". "\\". $data['packageimage']);
        $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
        $image_name = addslashes($_FILES['image']['name']);
        $image_size = getimagesize($_FILES['image']['tmp_name']);
        move_uploaded_file($_FILES["image"]["tmp_name"], "assets/packages/" . $_FILES["image"]["name"]);
        $location   =  $_FILES["image"]["name"];
        $id         =  $data['packageID'];
       
        $this->db->query("update biowash_packages set package_image='$location' where packageID='$id'");
        redirect('administrator/packagedetails?package='.$data['packageID']);
    }
	public function savepackage($data) {
		$image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
        $image_name = addslashes($_FILES['image']['name']);
        $image_size = getimagesize($_FILES['image']['tmp_name']);
		move_uploaded_file($_FILES["image"]["tmp_name"], "assets/packages/" . $_FILES["image"]["name"]);
        $location 	=  $_FILES["image"]["name"];
		$datas = array(
            'package_name'         => $data['packagename'],
            'package_price'        => $data['packageprice'],
            'package_description'  => $data['packagedescription'],
            // 'package_qty'          => $data['packageqty'],
            'package_image'   	   => $location,
            
            // 'earnlimit'      	   => $data['earn_limit'],
            'isActive'  		   => 1,
			);
	    $this->db->insert('biowash_packages',$datas);
		redirect('administrator/packages?=added');
	}

    public function savePackagePayment($data){
		
		if($data['is_upgrade'] ==1){
			$member_code =  $data['member_code'];
			$this->db->query("update biowash_members set isActive='0' where member_code='$member_code'");	
			$this->db->query("DELETE from biowash_member_package where member_code='$member_code'");	
		} 
		
        $this->db->insert('biowash_member_package',$data);
    }

    public function getPaymentPackageData(){
        $this->db->select('biowash_member_package.*,biowash_members.isActive,biowash_packages.package_name,biowash_packages.package_description,biowash_packages.package_image');
        $this->db->from('biowash_member_package');
        $this->db->where(['biowash_member_package.member_id' => $this->session->userdata['logged_in']['userid']]);
        $this->db->join('biowash_members', 'biowash_member_package.member_id = biowash_members.memberID', 'left');
        $this->db->join('biowash_packages', 'biowash_member_package.package_id = biowash_packages.packageID', 'left');
        $this->db->order_by('biowash_member_package.id','DESC');
        $this->db->limit('1');
        $query = $this->db->get();
        return $query->result();
    }

    public function getAllPackagePayments(){
        $this->db->select('biowash_member_package.*,biowash_members.isActive,biowash_members.firstname,biowash_members.lastname,biowash_members.contactnumber,biowash_packages.package_name,biowash_packages.package_description,biowash_packages.package_image,biowash_packages.package_price');
        $this->db->from('biowash_member_package');
        $this->db->where(['biowash_member_package.is_approved' => '0','biowash_member_package.is_upgrade'=>'0']);
        $this->db->join('biowash_members', 'biowash_member_package.member_id = biowash_members.memberID', 'left');
        $this->db->join('biowash_packages', 'biowash_member_package.package_id = biowash_packages.packageID', 'left');
        $this->db->order_by('biowash_member_package.id','DESC');
        // $this->db->limit('1');
        $query = $this->db->get();
        return $query->result();
    }
	
	public function getAllPackageUpgrades(){
        $this->db->select('biowash_member_package.*,biowash_members.isActive,biowash_members.firstname,biowash_members.lastname,biowash_members.contactnumber,biowash_packages.package_name,biowash_packages.package_description,biowash_packages.package_image,biowash_packages.package_price');
        $this->db->from('biowash_member_package');
        $this->db->where(['biowash_member_package.is_approved' => '0','biowash_member_package.is_upgrade'=>'1']);
        $this->db->join('biowash_members', 'biowash_member_package.member_id = biowash_members.memberID', 'left');
        $this->db->join('biowash_packages', 'biowash_member_package.package_id = biowash_packages.packageID', 'left');
        $this->db->order_by('biowash_member_package.id','DESC');
        // $this->db->limit('1');
        $query = $this->db->get();
        return $query->result();
    }

    public function getAllPackagePaymentsByTranscode($transcode){
        $this->db->select('biowash_member_package.*,biowash_members.isActive,biowash_members.firstname,biowash_members.lastname,biowash_members.contactnumber,biowash_members.member_code,biowash_packages.package_name,biowash_packages.package_description,biowash_packages.package_image,biowash_packages.package_price');
        $this->db->from('biowash_member_package');
        $this->db->where(['biowash_member_package.approved_by' => '0','biowash_member_package.transcode' => $transcode]);
        $this->db->join('biowash_members', 'biowash_member_package.member_id = biowash_members.memberID', 'left');
        $this->db->join('biowash_packages', 'biowash_member_package.package_id = biowash_packages.packageID', 'left');
        $this->db->limit('1');
        $query = $this->db->get();
        return $query->result();
    }
}
	
?>