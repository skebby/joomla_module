<?php
/*
 * @package for Joomla 2.5 Native
 * @component SMS by Skebby.it
 * @copyright 2013 Copyright (C) Neonevis Srl www.neonevis.it
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
 

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

class skebbyController extends JController {
	
  function tabpref(){
    require_once(JPATH_COMPONENT_ADMINISTRATOR.'/'.'assets'.'/'.'lib'.'/'.'version.class.php');
    $tab_prefix = new NNVersion;
    return $tab_prefix->tab_prefix;    
  }    
  
  function __construct( $default = array())
  {
      parent::__construct( $default );
      $this->registerTask( 'fpanel', 		'fpanel');
      $this->registerTask( 'returnsmsclassicplus', 		'returnsmsclassicplus');

  }

	function display( )	{
		switch($this->getTask())		{

		}//switch end
		//Set the default view, just in case
		$view = JRequest::getCmd('view');
		if(empty($view)) {
			JRequest::setVar('view', 'fpanel');
		};
		parent::display();
  }
  
  function fpanel() {
    $option = JRequest::getCmd('option');
    $this->setRedirect( 'index.php');
  }

  function returnsmsclassicplus() {
    $option = JRequest::getCmd('option');
    $model =& $this->getModel( 'fpanel' );
    $res=$model->returnsmsclassicplus();
    $res1=explode('-',$res);
    if( $res1[0]=="OK" ) {
      $msg=JText::_( 'NN_INVIATOOK' ).$res;
      $this->setRedirect( 'index.php', $msg );
    }else{
      $msg=$res;
      $this->setRedirect( 'index.php', $msg, "ERROR" );
    }
  }  
    
  
  function mail_debug($msg){
    $mail =& JFactory::getMailer();
    $config =& JFactory::getConfig();
    $subject = "Debug controller fpanel";
    $body = "\n\n".$msg;
    $mail->addRecipient("debug@neonevis.it");
    $mail->setSubject( $subject );
    $mail->setBody( $body );
    //Invio della mail
    $mail->Send();
  }

}

?>