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
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route['about-us'] = 'home/about';
$route['faq'] = 'home/faq';
$route['contact-us'] = 'home/contact';
$route['privacy-policy'] = 'home/privacy';
$route['terms-and-condition'] = 'home/terms';

$route['all-products'] = 'home/products/all';


if ( ! function_exists('slugify'))
{
  function slugify($text) {
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        $text = trim($text, '-');
        $text = strtolower($text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        if (empty($text))
            return 'n-a';
        return $text;
    }
}

require_once( BASEPATH .'database/DB.php' );
$db =& DB();
$query = $db->get('category');
$result = $query->result();
foreach( $result as $row )
{

    $route[slugify($row->title)] = 'home/products/'.$row->categoryID;

}

$query1 = $db->get('products');
$result1 = $query1->result();
foreach( $result1 as $row1 )
{

    $route[slugify($row1->product_name)] = 'home/product_details/'.$row1->productID;

}


// $route['fruits'] = 'home/products/1';
// $route['vegetables'] = 'home/products/2';
// $route['food-grains-oil-spices'] = 'home/products/3';
// $route['beverages'] = 'home/products/4';
// $route['snacks-branded-foods'] = 'home/products/5';
// $route['egg-dairy-products'] = 'home/products/6';
// $route['personal-care'] = 'home/products/7';
// $route['cleaning-household'] = 'home/products/8';
// $route['baby-health-store'] = 'home/products/9';

