<?php
/*
 * @package for Joomla 2.5 Native
 * @component SMS by Skebby.it
 * @copyright 2013 Copyright (C) Neonevis Srl www.neonevis.it
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_skebby')) {
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

// Require the base controller

require_once( JPATH_COMPONENT.'/'.'controller.php' );
$option = JRequest::getCmd('option');

$document =& JFactory::getDocument();
$document->addStyleSheet( JURI::base().'/'.'components'.'/'.$option.'/'.'assets'.'/'.'css'.'/'.$option.'.css' );
$document->addScript( JURI::base().'/'.'components'.'/'.$option.'/'.'assets'.'/'.'js'.'/function.js' );
$document->addScript( JURI::base().'/'.'components'.'/'.$option.'/'.'assets'.'/'.'js'.'/send.js' );

// Require specific controller if requested
if($controller = JRequest::getWord('controller')) {
    $path = JPATH_COMPONENT.'/'.'controllers'.'/'.$controller.'.php';
    if (file_exists($path)) {
        require_once $path;
    } else {
        $controller = '';
    }
}

// Create the controller
$compname=rtrim(substr($option,4,strlen($option)));
$classname    = $compname.'Controller'.$controller;
$controller   = new $classname( );

// Perform the Request task
$controller->execute( JRequest::getVar( 'task' ) );

// Redirect if set by the controller
$controller->redirect();



?>
