<?php

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );  

// Load Some Needed Files     
$splex = getSplexInstance();
$splex->loader->load_include('jpog_param.php');

// ------------------------------------------------------------------------

/**
 * Jpog abstraction class.
 * 
 * @note Inside of simplex we need to be able to have agnostic storage solutions for the parameters.
 * To accomplish this we create an abstract class and then load the methods of needed storage class into the core class.
 *    
 * @package     simplex
 * @subpackage  libraries.jpog
 * @version     1.0 beta 
 * @author      Ken Erickson AKA Bookworm http://www.bookwormproductions.net
 * @copyright   Copyright 2009 - 2011 Design BreakDown, LLC.
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2       
 * please visit the Simplex site http://www.simplex.designbreakdown.com  for support. 
 * Do not e-mail (or god forbid IM or call) me directly.
 */
Abstract class Jpog_Abstract
{ 
  /**
   * @var array Holds extended class
   **/
  private $_exts = array();     
  
  /**
   * @var object Holds $this
   **/
  public $_this;    
 
  /**
   * Empty Constructor
   *
   * @return void
   **/   
  function __construct() { $_this = $this; }

// ------------------------------------------------------------------------
  
  /**
   * Extends this class.
   *
   * @return void
   **/
  public function addExt($object)
  {
    $this->_exts[] = $object;
  }
 
// ------------------------------------------------------------------------
  
  /**
   * Overload method function.
   *
   * @note Looks inb the $_exts array for the relevant method and calls it returning its value.
   *
   * @return mixed
   **/
  public function __call($method, $args)
  {
    foreach($this->_exts as $ext) 
    {
      if(method_exists($ext,$method))
        return  call_user_func_array(array($ext, $method), $args);    
    }     
    
    throw new Exception("This Method {$method} doesn't exist");
  } 
   
// ------------------------------------------------------------------------
  
  /**
   * Overload Get. Only supports the paramsdump.
   *
   * @return array
   **/
  public function __get($name)
  {
    if($name == 'paramsdump') {
      return Jpog_Storage::$paramsdump;
    }
    else 
    {
      $trace = debug_backtrace();
      trigger_error(
          'Undefined property via __get(): ' . $name .
          ' in ' . $trace[0]['file'] .
          ' on line ' . $trace[0]['line'],
          E_USER_NOTICE);
      return null;
    }
  }  
}