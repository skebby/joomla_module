<?php
/*
 * @package for Joomla 2.5 Native
 * @component SMS by Skebby.it
 * @copyright 2013 Copyright (C) Neonevis Srl www.neonevis.it
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.controller' );
//tutti i controller ad esclusione del principale devo avere [nome componente]Controller[nome nuovo controller] e devono estendere
//o JController oppure un controller esistente
class skebbyControllertools extends skebbyController {



//generali
    	function __construct( $default = array())
	{
		parent::__construct( $default );

		$this->registerTask( 'tools', 		'display');
		$this->registerTask( 'cpanel', 		'cpanel');		
		$this->registerTask( 'delete_returnplus', 		'delete_returnplus');
		$this->registerTask( 'delete_sent', 		'delete_sent');
		$this->registerTask( 'rep001', 		'display');
		$this->registerTask( 'rep002', 		'display');
	}

  function display( )	{
		switch($this->getTask())		{
      case 'tools'     :			{
				JRequest::setVar( 'view', 'tools'  );
			} break;			
			case 'rep001'     :			{
			  JRequest::setVar( 'hidemainmenu', 1 );
				JRequest::setVar( 'mytask', 'rep001'  );
			  JRequest::setVar( 'view', 'tools'  );
			} break;
			case 'rep002'     :			{
				JRequest::setVar( 'hidemainmenu', 1 );
				JRequest::setVar( 'mytask', 'rep002'  );
        JRequest::setVar( 'view', 'tools'  );
			} break;
		}
		//Set the default view, just in case
		$view = JRequest::getCmd('view');
		if(empty($view)) {
			JRequest::setVar('view', 'cpanel');
		};
		parent::display();
	}

  function cpanel() {
    $option = JRequest::getCmd('option');
		$this->setRedirect( 'index.php?option='.$option);
	}
	
  function delete_returnplus() {
    $option = JRequest::getCmd('option');
    $model = $this->getModel('tools');
    $res=$model->delete_returnplus();
    if( $res==0 ){
      $msg=JText::_( 'NN_ELIMINATIOK' );
      $this->setRedirect( 'index.php?option='.$option.'&task=tools', $msg );
    } else {
      $msg=JText::_( 'NN_E_NOELIMINATI' );
      $this->setRedirect( 'index.php?option='.$option.'&task=tools', $msg, "ERROR" );
    }
  }
  
  function delete_sent() {
    $option = JRequest::getCmd('option');
    $model = $this->getModel('tools');
    $res=$model->delete_sent();
    if( $res==0 ){
      $msg=JText::_( 'NN_ELIMINATIOK' );
      $this->setRedirect( 'index.php?option='.$option.'&task=tools', $msg );
    } else {
      $msg=JText::_( 'NN_E_NOELIMINATI' );
      $this->setRedirect( 'index.php?option='.$option.'&task=tools', $msg, "ERROR" );
    }
  }
  
}
?>
