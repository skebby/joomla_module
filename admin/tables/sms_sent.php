<?php
/*
 * @package for Joomla 2.5 Native
 * @component Skebby
 * @copyright 2009 Copyright (C) Neonevis Srl www.neonevis.it
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );


/**
 * @package		Joomla
 * @subpackage	sms sent
 */
class Tablesms_sent extends JTable
{

  var $id = null;
  
  var $method = null;
  var $recipients = null;
  var $text = null;
  var $sender_number = null;
  var $sender_string = null;
  var $charset = null;
  var $user_reference = null;
  
  var $skebby_dispatch_id = null;
  var $status = null;
  var $error_code = null;
  var $error_message = null;  

  var $created = null;
  var $created_by = null;
  var $created_by_alias = null;  
  var $modified = null;
  var $modified_by = null;

  function tabpref(){
    require_once(JPATH_COMPONENT_ADMINISTRATOR.'/'.'assets'.'/'.'lib'.'/'.'version.class.php');
    $tab_prefix = new NNVersion;
    return $tab_prefix->tab_prefix;    
  } 
  
	/**
	* @param database A database connector object
	*/
	function __construct(&$db)
	{
		parent::__construct( '#_'.$this->tabpref().'sms_sent', 'id', $db );
	}
	
	
}
?>
