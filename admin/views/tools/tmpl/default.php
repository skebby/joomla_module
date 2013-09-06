<?php
/*
 * @package for Joomla 2.5 Native
 * @component SMS by Skebby.it
 * @copyright 2013 Copyright (C) Neonevis Srl www.neonevis.it
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
 
defined('_JEXEC') or die('Restricted access');
  $option = JRequest::getCmd('option');
  require_once(JPATH_COMPONENT_ADMINISTRATOR.'/'.'assets'.'/'.'lib'.'/'.'lib.class.php');
  require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'assets'.DS.'lib'.DS.'version.class.php');
  $ver = new NNVersion;
  $version=$ver->getShortVersion();

  $alt1 = JText::_( 'CPANEL' );
	$file= JURI::base().'components'.'/'.$option.'/'.'assets'.'/'.'help'.'/'."tools.html";
  $bar=& JToolBar::getInstance( 'toolbar' );
	$bar->appendButton( 'Link', 'back', $alt1, 'index.php?option='.$option);
  
	$params = &JComponentHelper::getParams( $option );
  $mostracredit=$params->get( 'crediti' );
  
?>
		<script language="javascript" type="text/javascript">
		<!--
		Joomla.controlla_1 = function() {
			var form1 = document.adminForm1;
			var conf1= confirm("<?php echo JText::_( 'TO_CONTROLLO', true ); ?>");
			if (conf1==0){
			 form1.data_fine_plus.focus();
			 return false;
			}
		}
		 		
		Joomla.controlla_2 = function() {
			var form2 = document.adminForm2;
			var conf2= confirm("<?php echo JText::_( 'TO_CONTROLLO', true ); ?>");
			if (conf2==0){
				 form2.data_fine_sms.focus();
				 return false;
				}
		}
		-->
		</script>
		
		<fieldset class="adminform">
	  <legend><?php echo JText::_( 'SKEBBY' ); ?></legend>
    <table class="adminlist">
      <tr>
        <td width="25%">
          <form action="<?php echo $this->action; ?>" method="post" name="adminForm1" id="adminForm1">
          <img src="<?php echo JURI::base().'components'.'/'.$option.'/'.'assets'.'/'.'images'.'/'; ?>icon-32-remove.png" alt="<?php echo JText::_('IMG') ?>" />
          <br />
          <?php 
             $datep = new NNlib; 
				     echo $datep->GetDatePiker('data_fine_plus','','dmy',0);
				  ?><br /> 
          <input class="button" type="submit" value="<?php echo JText::_( 'ESEGUI' ); ?>"  onClick="return Joomla.controlla_1();" />
          <input type="hidden" name="option" value="<?php echo $option; ?>" />
          <input type="hidden" name="controller" value="tools" />
          <input type="hidden" name="task" value="delete_returnplus" />
          <?php echo JHTML::_( 'form.token' ); ?>
          </form>
        </td>
        <td width="25%">
          <form action="<?php echo $this->action; ?>" method="post" name="adminForm2" id="adminForm2">
          <img src="<?php echo JURI::base().'components'.'/'.$option.'/'.'assets'.'/'.'images'.'/'; ?>icon-32-remove.png" alt="<?php echo JText::_('IMG') ?>" />
          <br />
          <?php 
             $datep = new NNlib; 
				     echo $datep->GetDatePiker('data_fine_sms','','dmy',0);
				  ?><br /> 
          <input class="button" type="submit" value="<?php echo JText::_( 'ESEGUI' ); ?>" onClick="return Joomla.controlla_2();" />
          <input type="hidden" name="option" value="<?php echo $option; ?>" />
          <input type="hidden" name="controller" value="tools" />
          <input type="hidden" name="task" value="delete_sent" />
          <?php echo JHTML::_( 'form.token' ); ?>
          </form>
        </td>
        <td width="25%">
          <form action="<?php echo $this->action; ?>" method="post" name="adminForm3" id="adminForm3">
          <img src="<?php echo JURI::base().'components'.'/'.$option.'/'.'assets'.'/'.'images'.'/'; ?>icon-32-print.png" alt="<?php echo JText::_('IMG') ?>" />
          <br />
          <input class="button" type="submit" value="<?php echo JText::_( 'ESEGUI' ); ?>" />
          <input type="hidden" name="option" value="<?php echo $option; ?>" />
          <input type="hidden" name="controller" value="tools" />
          <input type="hidden" name="task" value="tools" />
          <input type="hidden" name="task_id" value="rep001" />
          <?php echo JHTML::_( 'form.token' ); ?>
          </form>
        </td>
        <td width="25%">
          <form action="<?php echo $this->action; ?>" method="post" name="adminForm4" id="adminForm4">
          <img src="<?php echo JURI::base().'components'.'/'.$option.'/'.'assets'.'/'.'images'.'/'; ?>icon-32-print.png" alt="<?php echo JText::_('IMG') ?>" />
          <br />
          <input class="button" type="submit" value="<?php echo JText::_( 'ESEGUI' ); ?>" />
          <input type="hidden" name="option" value="<?php echo $option; ?>" />
          <input type="hidden" name="controller" value="tools" />
          <input type="hidden" name="task" value="tools" />
          <input type="hidden" name="task_id" value="rep002" />
          <?php echo JHTML::_( 'form.token' ); ?>
          </form>
        </td>
      </tr>
      <tr>
        <td width="25%"><?php echo JText::_( 'TO_ELIMINARIC' ); ?> </td>
        <td width="25%"><?php echo JText::_( 'TO_ELIMINAINV' ); ?></td>
        <td width="25%"><?php echo JText::_( 'TO_PRNRICEVUTE' ); ?></td>
        <td width="25%"><?php echo JText::_( 'TO_PRNINVIATI' ); ?></td>
      </tr>
    </table>
	</fieldset>
	
<div>&nbsp;</div>
<div>&nbsp;</div>
<?php if ($mostracredit==1) { ?>
      <table width="100%" class="nn_tabnorm">
      <tr>	
        <td style="text-align:center;">
          Componente  <?php echo $version; ?> - implementazioni ed assistenza su <a href="www.neonevis.it">www.neonevis.it</a>      
        </td>	
	    </tr>
      </table>	
<?php } ?>	
	