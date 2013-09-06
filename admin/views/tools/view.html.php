<?php
/*
 * @package for Joomla 2.5 Native
 * @component SMS by Skebby.it
 * @copyright 2013 Copyright (C) Neonevis Srl www.neonevis.it
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
 
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class skebbyViewtools extends JView {
    
  function display($tpl = null) {
  	JToolBarHelper::title('Tools', 'skebby.png');
    $post = JRequest::get( 'post' );

    $items =& $this->get('Data');
    $lists =& $this->get('Lists');
    $this->assignRef('items', $items);
    $this->assignRef('lists', $lists);
    $this->assignRef('post', $post);

   
    // Check for errors.
    if (count($errors = $this->get('Errors'))) {
      JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');
      return false;
    }    
    
    if ($lists['mytask']=='rep001'  ){
      $tpl=$lists['mytask'];
    }   
    if ($lists['mytask']=='rep002'  ){
      $tpl=$lists['mytask'];
    }   
    
    parent::display($tpl);
  }
}
?>
