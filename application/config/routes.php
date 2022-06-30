<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller']        = "welcome";

// ** AUTH ROUTES **//

$route['auth']                      = "api/authentication";
$route['auth_register']       		= "api/authentication_register";
$route['auth_fb']       		    = "api/authentication_facebook";
$route['auth_fb_register']       	= "api/authentication_register_facebook";
$route['points']                 	= "api/process_points";

// ** ADMIN ROUTES **//

$route['savetop5endorser']          = "administrator/api/savetop5endorser";
$route['saveproduct']               = "administrator/api/saveproduct";
$route['savepackage']               = "administrator/api/savepackage";
$route['updateproduct']             = "administrator/api/updateproduct";
$route['updatepackage']             = "administrator/api/updatepackage";
$route['updateproductimage']        = "administrator/api/updateproductimage";
$route['saveexpenses']       		= "administrator/api/saveexpenses";
$route['savepaymentoption']       	= "administrator/api/savepaymentoption";
$route['updatepaymentoption']       = "administrator/api/updatepaymentoption";
$route['deletepaymentoption']       = "administrator/api/deletepaymentoption";
$route['updatesettings']            = "administrator/api/updatesettings";
$route['confirmpurchase']           = "administrator/api/confirmpurchase";
$route['approvewithdrawal']         = "administrator/api/approvewithdrawal";
$route['declinewithdrawal']         = "administrator/api/declinewithdrawal";
$route['declinepurchase']           = "administrator/api/declinepurchase";
$route['deleteproduct']             = "administrator/api/deleteproduct";
$route['deletepackage']             = "administrator/api/deletepackage";
$route['updatememberinfo']          = "administrator/api/updatememberinfo";
$route['saveadduser']               = "administrator/api/saveadduser";
$route['updateadminuser']           = "administrator/api/updateadminuser";
$route['updateexpenses']            = "administrator/api/updateexpenses";
$route['deleteexpenses']            = "administrator/api/deleteexpenses";
$route['deleteadminaccount']        = "administrator/api/deleteadminaccount";
$route['status-top-five-endorser']  = "administrator/api/updatetopfivestatus";
$route['auth_register_v']           = "administrator/api/authentication_register_v";
$route['updatepackageimage']        = "administrator/api/updatepackageimage";
// ** USER ROUTES **//

$route['process-pruchase-product']  = "user/api/processpurchase";
$route['get-paymethod-info']        = "user/api/getpaymethod";
$route['checkoutprocess']           = "user/api/checkoutprocess";
$route['updateprofiledetails']      = "user/api/updateprofiledetails";
$route['updateprofilepicture']      = "user/api/updateprofilepicture";
$route['savefinancialmethod']       = "user/api/savefinancialmethod";
$route['processwithdrawal']         = "user/api/processwithdrawal";
$route['verify-email']              = "user/api/verifyemail";
$route['remove-purchased']          = "user/api/deletepurchased";
$route['process-binary']            = "user/api/processbinary";
$route['process-binary-left']       = "user/api/processbinary_left";
$route['process-binary-right']      = "user/api/processbinary_right";
$route['process-binary-auto']       = "user/api/processbinary_auto";
$route['mega_register_v']           = "user/api/mega_register_v";

$route['404_override']         = '';
//$route['translate_uri_dashes'] = FALSE;

/* End of file routes.php */
/* Location: ./application/config/routes.php */