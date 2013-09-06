<?php
/*
 * @package for Joomla 2.5 Native
 * @component SMS by Skebby.it
 * @copyright 2013 Copyright (C) Neonevis Srl www.neonevis.it
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
 
defined('_JEXEC') or die();
jimport('joomla.application.component.model');

class skebbyModelfpanel extends JModel {
	
	function __construct()	{
		parent::__construct();

		$mainframe = JFactory::getApplication(); 
    $option = JRequest::getCmd('option');
	}

	function returnsmsclassicplus(){
	  $option = JRequest::getCmd('option');
	  $data = JRequest::get( 'post' );
	  $params = &JComponentHelper::getParams( $option );
	  $flag_email_admin = $params->get( 'flag_email_admin' );
	  $email_admin = $params->get( 'email_admin' );
	  
    $status=$data['status'];
    $error_code=$data['error_code'];
    $user_reference=$data['user_reference'];

    //questo e' inutile ma mi serve per ricordarmi.
    switch ($status) {
        case 'DELIVERED':	
          $msg=JText::_('NN_CONSEGNATO');
          break;
        case 'EXPIRED':	
          $msg=JText::_('NN_E_MSGSCADUTO');
          break;
        case 'DELETED':	
          $msg=JText::_('NN_E_RETE');
          break;
        case 'UNDELIVERABLE':	
          $msg=JText::_('NN_E_NONSPEDITO');
          break;
        case 'UNKNOWN':	
          $msg=JText::_('NN_E_GENERICO');
          break;
        case 'REJECTD':	
          $msg=JText::_('NN_E_RIFIUTOOPE');
          break;
    }

    switch ($error_code) {
        case '401':
        	$msg1=JText::_('NN_E_MSGSCADUTO');
          break;
        case '201':
        	$msg1=JText::_('NN_E_MAFUNZOPERRETE');
        	break;
        case '203':
        	$msg1=JText::_('NN_E_DESTNORAG');
        	break;
        case '301':
        	$msg1=JText::_('NN_E_DESTNOVALID');
        	break;
        case '302':
        	$msg1=JText::_('NN_E_NUMERRATO');
        	break;
        case '303':
        	$msg1=JText::_('NN_E_SMSNOABIL');
        	break;
        case '304':
        	$msg1=JText::_('NN_E_SPAM');
        	break;
        case '501':
        	$msg1=JText::_('NN_E_TELNOSUP');
        	break;
        case '502':
        	$msg1=JText::_('NN_E_MEMPIENA');
        	break;
        case '901':
        	$msg1=JText::_('NN_E_MAPPAERRATA');
        	break;
        case '902':
        	$msg1=JText::_('NN_E_SERNODISP');
        	break;
        case '903':
        	$msg1=JText::_('NN_E_NOOPEDISPO');
        	break;
        case '904':
        	$msg1=JText::_('NN_E_NOTESTO');
        	break;
        case '905':
        	$msg1=JText::_('NN_E_DESTNOVALID');
        	break;
        case '906':
        	$msg1=JText::_('NN_E_DESTDUPLICATI');
        	break;
        case '907':
        	$msg1=JText::_('NN_E_MSGNONCORRETTO');
        	break;
        case '909':
        	$msg1=JText::_('NN_E_USERREFER');
        	break;
        case '910':
        	$msg1=JText::_('NN_E_TESTOLUNGO');
        	break;
        case '101':
        	$msg1=JText::_('NN_E_MAFUNZOPERGEN');
        	break;
        case '202':
        	$msg1=JText::_('NN_E_RIFIUTOOPE');
        	break;
        default:
            $msg1=JText::_('NN_INVIATOOK');
            break;
    }    
    $data['error_message']=$msg1;  

    $ritorno=$this->storereturn($data);

    if ($status=="DELIVERED"){
      if ($ritorno==100){  $msg.= JText::_('NN_E_ERROREDB'); }
      return 'OK-'.$status.'-'.$user_reference.'-'.$msg ;
    }else {
      if ($ritorno==100){  $msg.= JText::_('NN_E_ERROREDB'); }
      return 'KO-'.$status.'-'.$error_code.'-'.$msg1.' '.$msg ;
    }


     
    return $status.'';
	}

	
	function storereturn($data){
	  $option = JRequest::getCmd('option');
	  $db =& JFactory::getDBO();
	  $params = &JComponentHelper::getParams( $option );
	  $flag_email_admin = $params->get( 'flag_email_admin' );
	  $email_admin = $params->get( 'email_admin' );

		$row =& $this->getTable('sms_returnplus'); /*Ottengo i campi dalla tabella*/
		
    /*inserisco i dati nei campi, controllando che non ci siano errori*/
		if (!$row->bind($data)) { 
			JError::raiseWarning(500, $row->getError());
			return false;
		}		
		
		if (!$row->check()) {
			JError::raiseWarning(500, $row->getError());
			return false;
		}
				
    $row->created = date("Y-m-d H:i:s");
    $row->created_by = '62';
 		/*va sempre settata la data di modifica, insieme all'autore della modifica.*/
		$row->modified = date('Y-m-d H:i:s');
		$row->modified_by = '62';   
		
		if (!$row->store()) {
			JError::raiseWarning(500, $row->getError());
			return 100;
		}	

	}
		
	function mail_debug($msg){
    $mail =& JFactory::getMailer();
    $mail->IsHTML(1);
    $config =& JFactory::getConfig();
    $subject = "Debug model fpanel.php";
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
