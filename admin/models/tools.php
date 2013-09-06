<?php
/*
 * @package for Joomla 2.5 Native
 * @component SMS by Skebby.it
 * @copyright 2013 Copyright (C) Neonevis Srl www.neonevis.it
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

defined('_JEXEC') or die();
jimport('joomla.application.component.model');

class skebbyModeltools extends JModel {

	function tabpref(){
    require_once(JPATH_COMPONENT_ADMINISTRATOR.'/'.'assets'.'/'.'lib'.'/'.'version.class.php');
    $tab_prefix = new NNVersion;
    return $tab_prefix->tab_prefix;
  }

	function __construct()	{
		parent::__construct();

		$option = JRequest::getCmd('option');
    $mainframe = JFactory::getApplication();

	}

	function _buildQuery() {
    $option = JRequest::getCmd('option');
    $mainframe = JFactory::getApplication();
 	  $db=& JFactory::getDBO();
	  $post = JRequest::get( 'post' );

    $dfp = JRequest::getVar( 'data_fine_plus', 0, 'post', 'date' );
    /*gestione delle date*/
    if(strpos($dfp, '-') == false){
      $arr_orari = explode(' ',$dfp);
      $arr_datainizio = explode('/',substr($arr_orari[0],0,10));
      if ( empty($arr_orari[1]) ){  $orari = '23:59:59'; }else{ $orari = $arr_orari[1];  }
      $new_datainizio = $arr_datainizio[2].'/'.$arr_datainizio[1].'/'.$arr_datainizio[0].' '.$orari;
      $data_fine_search = $new_datainizio;
    }else{
      $data_fine_search = $dfp;
    }
	  
	  
	  $dfs = JRequest::getVar( 'data_fine_sms', 0, 'post', 'date' );
    if(strpos($dfs, '-') == false){
      $arr_orari = explode(' ',$dfs);
      $arr_datainizio = explode('/',substr($arr_orari[0],0,10));
      if ( empty($arr_orari[1]) ){  $orari = '23:59:59'; }else{ $orari = $arr_orari[1];  }
      $new_datainizio = $arr_datainizio[2].'/'.$arr_datainizio[1].'/'.$arr_datainizio[0].' '.$orari;
      $data_fine_search = $new_datainizio;
    }else{
      $data_fine_search = $dfs;
    }

    $task_id=$post['task_id'];
    
    switch ($task_id)
    {
    	case 'rep001':
    	  $query="SELECT *  "
            ." FROM #_".$this->tabpref()."sms_returnplus"
            ." ORDER BY created"            
            .";";
    		break;

    	case 'rep002':
    	  $query="SELECT *  "
            ." FROM #_".$this->tabpref()."sms_sent"
            ." ORDER BY created"            
            .";";
    		break;
      default:
        $query="";
    }

		return $query;
	}
	
	function getData() {
	  $query = $this->_buildQuery();
	  if($query!=""){
		  $data = $this->_getList($query);  
		}
		return $data;
	}

	function getLists() {
	  
	  $task_id=JRequest::getVar( 'task_id', '', 'get', 'text' );
    if($task_id==''){ $task_id=JRequest::getVar( 'task_id', '', 'post', 'text' ); }
    $lists['mytask']=$task_id;   
    
    return $lists;
	}



	function delete_returnplus(){
    $db =& JFactory::getDBO();
		$post = JRequest::get( 'post' );

    $dfp = JRequest::getVar( 'data_fine_plus', 0, 'post', 'date' );
    /*gestione delle date*/
    if(strpos($dfp, '-') == false){
      $arr_orari = explode(' ',$dfp);
      $arr_datainizio = explode('/',substr($arr_orari[0],0,10));
      if ( empty($arr_orari[1]) ){  $orari = '23:59:59'; }else{ $orari = $arr_orari[1];  }
      $new_datainizio = $arr_datainizio[2].'/'.$arr_datainizio[1].'/'.$arr_datainizio[0].' '.$orari;
      $data_fine_search = $new_datainizio;
    }else{
      $data_fine_search = $dfp;
    }
	   
    $query = "DELETE FROM #_".$this->tabpref()."sms_returnplus WHERE created<='".$data_fine_search."'";
    $db->setQuery( $query );
    if(!$db->Query()){
      return 100;
    }else{
      return 0;
    }
	}

	function delete_sent(){
    $db =& JFactory::getDBO();
    $post = JRequest::get( 'post' );

    $dfs = JRequest::getVar( 'data_fine_sms', 0, 'post', 'date' );
    if(strpos($dfs, '-') == false){
      $arr_orari = explode(' ',$dfs);
      $arr_datainizio = explode('/',substr($arr_orari[0],0,10));
      if ( empty($arr_orari[1]) ){  $orari = '23:59:59'; }else{ $orari = $arr_orari[1];  }
      $new_datainizio = $arr_datainizio[2].'/'.$arr_datainizio[1].'/'.$arr_datainizio[0].' '.$orari;
      $data_fine_search = $new_datainizio;
    }else{
      $data_fine_search = $dfs;
    }    
    
    $query = "DELETE FROM #_".$this->tabpref()."sms_sent WHERE created<='".$data_fine_search."'";
    $db->setQuery( $query );
    if(!$db->Query()){
      return 100;
    }else{
      return 0;
    }
	}


  function mail_debug($msg){
    $mail =& JFactory::getMailer();
    $config =& JFactory::getConfig();
    $subject = "Debug model tools";
    $body = "\n\n".$msg;
    $mail->addRecipient("debug@neonevis.it");
    $mail->setSubject( $subject );
    $mail->setBody( $body );
    //Invio della mail
    $mail->Send();
	}

}

?>

