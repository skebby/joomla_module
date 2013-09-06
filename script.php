<?php
/*
 * @package for Joomla 2.5 Native
 * @component SMS by Skebby.it
 * @copyright 2013 Copyright (C) Neonevis Srl www.neonevis.it
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

 // No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
//the name of the class must be the name of your component + InstallerScript
//for example: com_contentInstallerScript for com_content.
class com_skebbyInstallerScript
{
	/*
	 * The release value to be displayed and check against throughout this file.
	 */
	private $release = '1.0';
 
        /*
         * Find mimimum required joomla version for this extension. It will be read from the version attribute (install tag) in the manifest file
         */
       // private $minimum_joomla_release = '1.6.0';    
 
	/*
	 * $parent is the class calling this method.
	 * $type is the type of change (install, update or discover_install, not uninstall).
	 * preflight runs before anything else and while the extracted files are in the uploaded temp folder.
	 * If preflight returns false, Joomla will abort the update and undo everything already done.
	 */
	function preflight( $type, $parent ) {
		
	}
 
	/*
	 * $parent is the class calling this method.
	 * install runs after the database scripts are executed.
	 * If the extension is new, the install method is run.
	 * If install returns false, Joomla will abort the install and undo everything already done.
	 */
	function install( $parent ) {		
		// You can have the backend jump directly to the newly installed component configuration page
		// $parent->getParent()->setRedirectURL('index.php?option=com_democompupdate');	
	$this->caricatabelle();		
	}
 
	/*
	 * $parent is the class calling this method.
	 * update runs after the database scripts are executed.
	 * If the extension exists, then the update method is run.
	 * If this returns false, Joomla will abort the update and undo everything already done.
	 */
	function update( $parent ) {
		$this->aggiornadb();
	}
 
	/*
	 * $parent is the class calling this method.
	 * $type is the type of change (install, update or discover_install, not uninstall).
	 * postflight is run after the extension is registered in the database.
	 */
	function postflight( $type, $parent ) {
		$this->AddUserMenu();
		$this->savePermission();
		$this->updateComponents();
	}
 
	/*
	 * $parent is the class calling this method
	 * uninstall runs before any other action is taken (file removal or database processing).
	 */
	function uninstall( $parent ) {

	}
 
	/*
	 * get a variable from the manifest file (actually, from the manifest cache).
	 */
	function getParam( $name ) {
		
	}
 
	/*
	 * sets parameter values in the component's row of the extension table
	 */
	function setParams($param_array) {
		
	}
	
	//Funzione che carica i permessi del componente nella tabella assets
	function savePermission(){
	  $db =& JFactory::getDBO();
	  
	  $query = "SELECT rules FROM #__assets WHERE name = 'com_skebby'";
	  $db->setQuery( $query );
	  $empty = $db->loadResult();
	  if(strcmp($empty, '{}') == 0){
		  $query = 'UPDATE #__assets SET rules = \'{"core.admin":[],"core.manage":[],"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[]}\' WHERE name = \'com_skebby\' ';
		  $db->setQuery( $query );
		  if( !$db->query() ) {
		    echo "<br /><br /><span style='color: #FF0000;'>Permessi NON Caricati</span><br /><br />";
		  }
	  }
	}
	
	function AddUserMenu() {

	}//end function
	
  function updateComponents() {
		$db =& JFactory::getDBO();
		
		/*Aggiorno la tabella #__extensions per settare i parametri di default del componente*/ 
		$query = "SELECT params FROM #__extensions WHERE name = 'com_skebby'";
		$db->setQuery( $query );
		$param = $db->loadResult();
		if ($param == '' || $param == '{}' ) {
		  /*Aggiorno la tabella #__extensions per settare i parametri di default del componente*/ 
		  $query = "UPDATE #__extensions SET params =
      '{£sms_username£:££,
      	£sms_password£:££,
      	£sms_tipo£:£basic£,
      	£sms_charset£:££,
      	£sms_tipo_mit£:£Numerico£,
      	£sender_number£:££,
      	£sender_string£:££,
      	£crediti£:£0£,
      	£flag_email_admin£:£0£,
      	£email_admin£:££,
      	£flag_debug_mode£:£0£}' 
      	WHERE element = 'com_skebby'";
		  $query = str_replace('£', '"', $query);
		    $db->setQuery( $query );
		    
		    if( !$db->query() ) {
		      echo "<br /><br /><span style='color: #FF0000;'>Non posso modificare i parametri.</span><br />";
		    }
		}
		else echo "<br /><br /><span style='color: #006A00;'>SONO STATI AGGIUNTI DEI PARAMETRI, SI CONSIGLIA DI CONTROLLARE LA CONFIGURAZIONE DEL COMPONENTE SKEBBY</span><br />";
	}
	
	function aggiornadb() {
	
	}
	function caricatabelle(){
  	$db =& JFactory::getDBO();
    $query = "CREATE TABLE IF NOT EXISTS `#__sk_sms_returnplus` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `skebby_dispatch_id` int(11) NOT NULL DEFAULT '0',
      `skebby_message_id` int(11) NOT NULL DEFAULT '0',
      `recipient` text,
      `status` varchar(50) NOT NULL DEFAULT '',
      `error_code` int(11) NOT NULL DEFAULT '0',
      `error_message` varchar(255) NOT NULL DEFAULT '',
      `user_reference` varchar(40) NOT NULL DEFAULT '',
      `skebby_date_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
      `operator_date_time` varchar(20) NOT NULL DEFAULT '',
      `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
      `created_by` int(11) NOT NULL DEFAULT '0',
      `created_by_alias` varchar(255) NOT NULL DEFAULT '',
      `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
      `modified_by` int(11) NOT NULL DEFAULT '0',
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM AUTO_INCREMENT=0 ;";
    $db->setQuery( $query );
  	if( !$db->query() ) { echo "<br /><span style='color: #FF0000;'>Creazione tabella #__sk_sms_returnplus fallita.</span><br />"; }  
	
    $query = "CREATE TABLE IF NOT EXISTS `#__sk_sms_sent` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `method` varchar(50) NOT NULL DEFAULT '',
      `recipients` text,
      `text` text,
      `sender_number` varchar(20) NOT NULL DEFAULT '',
      `sender_string` varchar(20) NOT NULL DEFAULT '',
      `charset` varchar(10) NOT NULL DEFAULT '',
      `user_reference` varchar(40) NOT NULL DEFAULT '',
      `skebby_dispatch_id` int(11) NOT NULL DEFAULT '0',
      `status` varchar(30) NOT NULL DEFAULT '',
      `error_code` int(11) NOT NULL DEFAULT '0',
      `error_message` varchar(255) NOT NULL DEFAULT '',
      `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
      `created_by` int(11) NOT NULL DEFAULT '0',
      `created_by_alias` varchar(255) NOT NULL DEFAULT '',
      `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
      `modified_by` int(11) NOT NULL DEFAULT '0',
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM AUTO_INCREMENT=0 ;";
    $db->setQuery( $query );
  	if( !$db->query() ) { echo "<br /><span style='color: #FF0000;'>Creazione tabella #__sk_sms_sent fallita.</span><br />"; }  
  	
	}
	
}