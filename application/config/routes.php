<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
 */
$route['default_controller'] = 'home';
$route['courses'] = 'home/courses';
$route['membership'] = 'home/membership';
$route['user/certificate/(:num)'] = 'certificate/$1';
$route['forgot_password'] = 'home/forgot_password';
$route['corporate/(:num)/dashboard'] = 'corporate/dashboard/$1';
$route['corporate/(:num)/designation'] = 'corporate/designation/$1';
$route['corporate/(:num)/department'] = 'corporate/department/$1';
$route['corporate/(:num)/users'] = 'corporate/users/$1';
$route['corporate/(:num)/courses'] = 'corporate/courses/$1';
$route['course/(:any)'] = 'home/course/$1';
$route['home/course/(:any)/(:any)'] = 'home/course/$2';
$route['home/sign_up'] = 'login';
$route['home/login'] = 'login';
$route['home/certificate'] = 'home/certificate';
$route['home/handleCartItems'] = 'home/shopping_cart';
$route['home/refreshShoppingCart'] = 'home/shopping_cart';
$route['generatepdf'] = "user/convertpdf";
$route['user'] = 'user/my_courses';
$route['user/course/(:num)/(:any)/lesson'] = 'user/lesson/$1';
$route['user/course/(:num)/(:any)/lesson/(:any)'] = 'user/lesson/$1/$3';
$route['user/certificate/(:num)/'] = 'user/certificate/$1';
$route['404_override'] = 'home/page_not_found';
$route['translate_uri_dashes'] = FALSE;
