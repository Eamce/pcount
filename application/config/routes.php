<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'PagesController/view';
// $route['(:any)'] = 'PagesController/view/$1';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//$route['login/validate_login'] = 'AdminController/validate_login';
$route['login/validate_login']              = 'PagesController/validate_login';
$route['user/add_user_data']                = 'AdminController/add_user_data';
$route['user/get_all_user_data']            = 'AdminController/get_all_user_data';
$route['user/change_user_status']           = 'AdminController/change_user_status';


//////////////////////////////////store conso/////////////////////////////////

$route['request/upload_exel_file']          = 'AdminController/upload_exel_file';
$route['request/data_report']               = 'AdminController/data_report';
$route['request/pdf_report']                = 'AdminController/pdf_report';
$route['request/master_file']               = 'AdminController/master_file';
$route['request/upload_cyclic']             = 'AdminController/upload_cyclic';
$route['request/report_monthly']            = 'AdminController/report_monthly';
$route['request/cyclic_report']             = 'AdminController/cyclic_report';
$route['request/update_monthly']            = 'AdminController/update_monthly';
$route['request/get_bunit']                 = 'AdminController/get_bunit';
$route['request/get_dept']                  = 'AdminController/get_dept';
$route['request/get_section']               = 'AdminController/get_section';
$route['request/tbl_cyclic_report']         = 'AdminController/tbl_cyclic_report';
$route['request/cyclic_pdf_report']         = 'AdminController/cyclic_pdf_report';
$route['request/tbl_update_monthly']        = 'AdminController/tbl_update_monthly';
$route['request/update_monthly_data']       = 'AdminController/update_monthly_data';
$route['request/monthly_updated_report']    = 'AdminController/monthly_updated_report';
$route['request/for_count']                 = 'AdminController/for_count';
$route['request/get_dept_']                 = 'AdminController/get_dept_';
$route['request/upload_nav']                = 'AdminController/upload_nav';
$route['request/nav_report']                = 'AdminController/nav_report';
$route['request/variance_pdf_reportt']      = 'AdminController/variance_pdf_report';
$route['request/file_nav']                  = 'AdminController/file_nav';
$route['request/nav_file_report']           = 'AdminController/nav_file_report';
$route['request/display_temp_report']       = 'AdminController/display_temp_report';
$route['request/pcount']                    = 'AdminController/pcount';
$route['request/pcount_report']             = 'AdminController/pcount_report';
$route['request/excel_report']              = 'AdminController/excel_report';
$route['request/physical_report']           = 'AdminController/physical_report';
$route['request/generate_variance']         = 'AdminController/generate_variance';



// pcount app
$route['mapi/getFilteredItemMasterfile']    = 'Appc/getFilteredItemMasterfile';
$route['mapi/getItemMasterfileCount']       = 'Appc/getItemMasterfileCount';
$route['mapi/getItemMasterfileOffset']      = 'Appc/getItemMasterfileOffset';
$route['mapi/getUserMasterfile']            = 'Appc/getUserMasterfile';
$route['mapi/getAuditMasterifle']           = 'Appc/getAuditMasterifle';
$route['mapi/getLocationMasterfile']        = 'Appc/getLocationMasterfile';
$route['mapi/insertCountData']              = 'Appc/insertCountData';
$route['mapi/insertCountDataList']          = 'Appc/insertCountDataList_ctrl';
$route['mapi/insertNFItemList']             = 'Appc/insertNFItemList';
$route['mapi/checkIfFloorPlanIsCreated']    = 'Appc/checkIfFloorPlanIsCreated';
$route['mapi/updateFloorPlanStatus']        = 'Appc/updateFloorPlanStatus';
$route['mapi/insertFloorPlanData']          = 'Appc/insertFloorPlanData';
$route['mapi/getFloorPlanData']             = 'Appc/getFloorPlanData';
$route['mapi/getUnit']                      = 'Appc/getUnit';
