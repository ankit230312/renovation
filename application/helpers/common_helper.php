<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

function __construct()
{
  $this->load->model("home_m");
  $this->load->model("webservice_m");
  $ci = &get_instance();
  $ci->load->database();
}




if (!function_exists('slugify')) {
  function slugify($text)
  {
    $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
    $text = trim($text, '-');
    $text = strtolower($text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    if (empty($text))
      return 'n-a';
    return $text;
  }
}

// Sanitize input fields
if (!function_exists('sanitizer')) {
  function sanitizer($string = "")
  {
    //$sanitized_string = preg_replace("/[^@ -.a-zA-Z0-9]+/", "", html_escape($string));
    $sanitized_string = html_escape($string);
    return $sanitized_string;
  }
}

if (!function_exists('convert_url')) {
  function convert_url($text)
  {
    $text = trim($text, '-');
    $text = preg_replace('~-~', ' ', $text);
    $text = ucfirst($text);
    return $text;
  }
}

if (!function_exists('my_profile')) {
  function my_profile($userID)
  {
    $ci = &get_instance();
    $ci->load->database();
    $user_info = $ci->db->get_where('users', array('ID' => $userID))->row_array();

    return $user_info;
  }
}
if (!function_exists('get_product_by_id')) {
  function get_product_by_id($product_id)
  {
    $ci = &get_instance();
    $ci->load->database();
    $product_info = $ci->db->get_where('products', array('id' => $product_id))->row_array();

    return $product_info;
  }
}

// ------------------------------------------------------------------------
/* End of file user_helper.php */
/* Location: ./system/helpers/common.php */
