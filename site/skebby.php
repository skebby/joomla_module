<?php
/*
 * @package for Joomla 2.5 Native
 * @component SMS by Skebby.it
 * @copyright 2013 Copyright (C) Neonevis Srl www.neonevis.it
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
 

defined('_JEXEC') or die('Restricted access');

require_once(JPATH_COMPONENT.DS.'controller.php');
$option = JRequest::getCmd('option');

$document =& JFactory::getDocument();
$document->addStyleSheet( JURI::base().'administrator'.'/'.'components'.'/'.$option.'/'.'assets'.'/'.'css'.'/'.$option.'_fe.css' );
$document->addScript( JURI::base().'administrator'.'/'.'components'.'/'.$option.'/'.'assets'.'/'.'js'.'/function.js' );

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
// Legeg il task
$controller->execute( JRequest::getCmd( 'task' ) );

// Redirect se settato nel controller
$controller->redirect();


?>