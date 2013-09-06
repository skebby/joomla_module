<?php
/*
 * @package for Joomla 2.5 Native
 * @component SMS by Skebby.it
 * @copyright 2013 Copyright (C) Neonevis Srl www.neonevis.it
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
 
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class skebbyViewcpanel extends JView {
    
  function display($tpl = null) {
    $option = JRequest::getCmd('option');
    JToolBarHelper::title(JText::_('NN_GESTSMS'), 'skebby.png');
  	JToolBarHelper::preferences($option, '500','1000', JText::_('NN_COFIGURAZIONE'));
  	//JToolBarHelper::customX('skebby.tools', 'print.png', 'print_f2.png', 'Tools',false );  	
  	JToolBarHelper::divider();

    $lists =& $this->get('Lists');     
    $this->assignRef('lists', $lists);

    // Check for errors.
    if (count($errors = $this->get('Errors'))) {
      JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');
      return false;
    }    
        
    parent::display($tpl);
  }
}
?>
