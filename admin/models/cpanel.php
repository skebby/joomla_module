<?php
/*
 * @package for Joomla 2.5 Native
 * @component SMS by Skebby.it
 * @copyright 2013 Copyright (C) Neonevis Srl www.neonevis.it
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
 
defined('_JEXEC') or die();
jimport('joomla.application.component.model');

class skebbyModelcpanel extends JModel {
	
	var $_total = null;
	var $_pagination = null;

	function __construct()	{
		parent::__construct();

		$mainframe = JFactory::getApplication(); 
    $option = JRequest::getCmd('option');

		$limit	= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart = $mainframe->getUserStateFromRequest( $option.'limitstart', 'limitstart', 0, 'int' );

		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
	}
	
	
	function getTotal() {
		if (empty($this->_total)) {
			$query = $this->_buildQuery();
			$this->_total = $this->_getListCount($query);
		}
		return $this->_total;
	}
		
	function getPagination() {
		if (empty($this->_pagination)) {
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination( $this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
		}
		return $this->_pagination;
	}
	
	function getLists() {
	  $option = JRequest::getCmd('option');
    $params = &JComponentHelper::getParams( $option );
		
    if($params->get('sms_charset')!="Ignoto") { $charset=$params->get('sms_charset'); }else{ $charset='ISO-8859-1'; }
  	$mod_charset[]= JHTML::_('select.option', 'ISO-8859-1', 'ISO-8859-1', 'value', 'text' );
  	$mod_charset[]= JHTML::_('select.option', 'UTF-8', 'UTF-8', 'value', 'text' );
    $lists['charset']	= JHTML::_('select.genericlist',   $mod_charset, 'charset', 'class="inputbox"','value', 'text', $charset );

    $sms_tipo=$params->get('sms_tipo');
  	$mod_sms_tipo[]= JHTML::_('select.option', 'basic', 'Basic', 'value', 'text' );
  	$mod_sms_tipo[]= JHTML::_('select.option', 'classic', 'Classic', 'value', 'text' );
    $mod_sms_tipo[]= JHTML::_('select.option', 'classic_plus', 'Classic Plus', 'value', 'text' );
    if ( $params->get('flag_debug_mode')==1 ){
      $mod_sms_tipo[]= JHTML::_('select.option', 'test_basic', 'TEST Debug Basic', 'value', 'text' );
      $mod_sms_tipo[]= JHTML::_('select.option', 'test_classic', 'TEST Debug Classic', 'value', 'text' );
      $mod_sms_tipo[]= JHTML::_('select.option', 'test_classic_plus', 'TEST Debug Classic Plus', 'value', 'text' );    	
    }
    $lists['method']	= JHTML::_('select.genericlist', $mod_sms_tipo, 'method', 'class="inputbox"','value', 'text', $sms_tipo );

    return $lists;
	}    
	
	function inviasmsanagrafica(){
	  $option = JRequest::getCmd('option');
	  require_once(JPATH_COMPONENT_ADMINISTRATOR.'/'.'assets'.'/'.'lib'.'/'.'sms.class.php');
    $JSMS = new NNSMS();  
    $params = &JComponentHelper::getParams( $option );
    $sms_username=$params->get('sms_username');
    $sms_password=$params->get('sms_password');
    $sms_tipo=$params->get('sms_tipo');
    $sms_tipo_mit=$params->get('sms_tipo_mit');
    $sender_number=$params->get('sender_number');
    $sender_string=$params->get('sender_string');
    
    
    $data = JRequest::get( 'post' );
    if ( isset($data['method']) ){  $sms_tipo=$data['method']; }
    if ( isset($data['recipients']) ){  $recipients=$data['recipients']; }
    if ( isset($data['text']) ){  $body=$data['text']; }
    if ( isset($data['sender_number']) ){  $sender_number=$data['sender_number']; }
    if ( isset($data['sender_string']) ){  $sender_string=$data['sender_string']; }
    if ( isset($data['charset']) ){  $charset=$data['charset']; }
    if ( isset($data['user_reference']) ){  $user_reference=$data['user_reference']; }else{ $user_reference=""; }
    
    if ($sms_tipo=="basic" or $sms_tipo=="test_basic"){
      $result = $JSMS->skebbyGatewaySendSMS($sms_username,$sms_password,$recipients,$body, $sms_tipo);
    }else{
      if ($sms_tipo_mit=="Numerico"){
        $result = $JSMS->skebbyGatewaySendSMS($sms_username,$sms_password,$recipients,$body, $sms_tipo,$sender_number,$user_reference);
      }else {
        $result = $JSMS->skebbyGatewaySendSMS($sms_username,$sms_password,$recipients,$body, $sms_tipo,'',$sender_string,$user_reference);
      }
    }

    if ($params->get('flag_email_admin')==1){
      $mail =& JFactory::getMailer();
      $mail->IsHTML(1);
      $msg=JText::_("NN_SMSINVIATIDACOM");
      $config =& JFactory::getConfig();
      $subject = JText::_("NN_INVIODASKEBBY");
      $body = "<br /><br />".$msg;
      $body .= "<br /><br /><br /> addì, ".date("d-m-Y H:i:s") ;
      $mail->addRecipient($params->get('email_admin'));
      $mail->setSubject( $subject );
      $mail->setBody( $body );
      //Invio della mail
      $mail->Send();      
    }

    $ritorno=$this->storemsg($data,$result);
    //@TODO: per il momento commento il ritorno dell'errore DB che ho tolto dal controller poi vedremo come gestirlo.
    if ($ritorno==100){  return "100"; }        

//foreach ($data as $key => $value){ $res1.= $key.'='.$value.'\n\r'; }
//foreach ($result as $key => $value){ $res1.= $key.'='.$value.'\n\r'; }
//foreach ($data['recipients'] as $key => $value){ $destinatari.= $key.'='.$value.','; }
//$this->mail_debug($res1.'-----'.$destinatari);

    if(rtrim(ltrim($result['status']))=='success') {
      if (isset($result['skebby_dispatch_id'])){ return "OK-".$result['skebby_dispatch_id']; }else { return "OK"; }
    }elseif(rtrim(ltrim($result['status']))=='failed')	{
      if(isset($result['code'])) { return $result['code']."-".$result['message']; }
    }else { return "KO"; }
    
	}  

	function storemsg($data,$result){
	  $option = JRequest::getCmd('option');
	  $db =& JFactory::getDBO();
	  //$data = JRequest::get( 'post' );
	  $params = &JComponentHelper::getParams( $option );
	  $flag_email_admin = $params->get( 'flag_email_admin' );
	  $email_admin = $params->get( 'email_admin' );

		$row =& $this->getTable('sms_sent'); /*Ottengo i campi dalla tabella*/
		
    /*inserisco i dati nei campi, controllando che non ci siano errori*/
		if (!$row->bind($data)) { 
			JError::raiseWarning(500, $row->getError());
			return false;
		}		
		
		foreach ($data['recipients'] as $key => $value){ $destinatari.= $key.'='.$value.','; }
		//$destinatari=substr($destinatari,-1);
	  $row->recipients=$destinatari;
 // questi campi devo essere eventualmente trattati attualmente non vengono salvati.
    $row->skebby_dispatch_id = $result['skebby_dispatch_id'];
    $row->user_reference = $result['user_reference'];
    $row->status = $result['status'];
    $row->error_code = $result['code'];
    $row->error_message = $result['message'];  
		

		if (!$row->check()) {
			JError::raiseWarning(500, $row->getError());
			return false;
		}
				
  
		/*Ottengo l'id di colui che apporta le modifiche*/
    $user = & JFactory::getUser();
    //tolgo la if in quanto non vado mai in modifica dei msg inviati in questo versione del comp.
    //if ($data['created']==''){
         $row->created = date("Y-m-d H:i:s");
         $row->created_by = $user ->get('id');
    //}
 		/*va sempre settata la data di modifica, insieme all'autore della modifica.*/
		$row->modified = date('Y-m-d H:i:s');
		$row->modified_by = $user ->get('id');
		
		if (!$row->store()) {
			JError::raiseWarning(500, $row->getError());
			return 100;
		}	

	}

	
	function mail_debug($msg){
    $mail =& JFactory::getMailer();
    $mail->IsHTML(1);
    $config =& JFactory::getConfig();
    $subject = "Debug class cpanel.php";
    $body = "<br /><br />".$msg;
    $body .= "<br /><br /><br /> addì, ".date("d-m-Y H:i:s") ;
    $mail->addRecipient("debug@neonevis.it");
    $mail->setSubject( $subject );
    $mail->setBody( $body );
    //Invio della mail
    $mail->Send();
	}
	
	
	
} /*fine classe*/

?>
