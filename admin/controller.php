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
  $option = JRequest::getCmd('option');
  $params = &JComponentHelper::getParams( $option );
  $user = JFactory::getUser();
  
  $l[] = array('PANNELLO_DI_CONTROLLO', '');
  // Submenu view
  $view	= JRequest::getVar( 'view', '', '', 'string', JREQUEST_ALLOWRAW );
  
  foreach ($l as $k => $v) {
  	
  	if ($v[1] == '') {
  		$link = 'index.php?option=com_skebby';
  	} else {
  		$link = 'index.php?option=com_skebby&view=';
  	}
  
  	if ($view == $v[1]) {
  		JSubMenuHelper::addEntry(JText::_($v[0]), $link.$v[1], true );
  	} else {
  		JSubMenuHelper::addEntry(JText::_($v[0]), $link.$v[1]);
  	}
  
  }

class skebbyController extends JController {
	
	function __construct( $default = array())
	{
		parent::__construct( $default );
    
    $this->registerTask( 'cpanel', 		'cpanel');
    $this->registerTask( 'tools', 		'display');    
    $this->registerTask( 'inviasmsanagrafica', 		'inviasmsanagrafica');
	}


//generali
	function display( )	{
	  $user = JFactory::getUser();
		$option = JRequest::getCmd('option');
		switch($this->getTask())		{
			case 'tools'     :			{
				JRequest::setVar( 'view', 'tools'  );
			} break;		
			default:
			  JRequest::setVar( 'view', 'cpanel'  );
		}
		//Set the default view, just in case
		$view = JRequest::getCmd('view');
		if(empty($view)) {
			JRequest::setVar('view', 'cpanel');
		};
		parent::display();
	}

  //generali 
  function cpanel() {
    $option = JRequest::getCmd('option');
		$this->setRedirect( 'index.php?option='.$option);
	}
	
  function inviasmsanagrafica() {
    $user = JFactory::getUser();
    $option = JRequest::getCmd('option');
    $model =& $this->getModel( 'cpanel' );
    $res=$model->inviasmsanagrafica();
    $res1=explode('-',$res);
    if ($res1[0]=="100"){
      $msg=JText::_( 'NN_E_ERROREDB').$res1[1];    
      $this->setRedirect( 'index.php?option='.$option.'&task=cpanel&tmpl=component', $msg, "ERROR"  );   
    }elseif( $res1[0]=="OK" ) {
      $msg=JText::_( 'NN_INVIATOOK' ).$res1[1];    
      $this->setRedirect( 'index.php?option='.$option.'&task=cpanel&tmpl=component', $msg );
    } else {
        switch ($res1[0]) {
        case '11':
        	$msg1=JText::_('NN_E_CHARSETNOVALID');
        	break;
        case '12':
        	$msg1=JText::_('NN_E_MANCAPARAMETRI');
        	break;
        case '20':
        	$msg1=JText::_('NN_E_PARAMNOVALID');
        	break;
        case '21':
        	$msg1=JText::_('NN_E_USENOVALID');
        	break;
        case '22':
        	$msg1=JText::_('NN_E_MITNOVALID');
        	break;
        case '23':
        	$msg1=JText::_('NN_E_MITLUNGO');
        	break;
        case '24':
        	$msg1=JText::_('NN_E_TESTOLUNGO');
        	break;
        case '25':
        	$msg1=JText::_('NN_E_DESTNOVALID');
        	break;
        case '26':
        	$msg1=JText::_('NN_E_NOMIT');
        	break;
        case '27':
        	$msg1=JText::_('NN_E_TROPPIDEST');
        	break;
        case '29':
        	$msg1=JText::_('NN_E_GATEWAYNONCONFIG');
        	break;
        case '30':
        	$msg1=JText::_('NN_E_NOABBASTAZNACREDITO');
        	break;
        case '31':
        	$msg1=JText::_('NN_E_SOLOHATTPPOST');
        	break;
        case '32':
        	$msg1=JText::_('NN_E_FORMATONONVALIDO');
        	break;
        case '33':
        	$msg1=JText::_('NN_E_ENCORDINNOVALID');
        	break;
        case '34':
        	$msg1=JText::_('NN_E_PERIDONOVALID');
        	break;
        case '35':
        	$msg1=JText::_('NN_E_USERREFNOVALID');
        	break;
        case '36':
        	$msg1=JText::_('NN_E_NOUSERREFER');
        	break;
        case '37':
        	$msg1=JText::_('NN_E_CHARSETERRATO');
          break;
        default:
            $msg1=$res1[0];
            break;
    }      
      $msg='<strong>'.JText::_( 'NN_E_ERRORESMS').$res1[0].': '.JText::_( 'NN_IMPOSSIBILEINVIARE').'</strong>'. $msg1;    
      $this->setRedirect( 'index.php?option='.$option.'&task=cpanel&tmpl=component', $msg, "ERROR" );
    }
  } 

 
}//Fine Classe
?>
