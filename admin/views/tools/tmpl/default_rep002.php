<?php
/*
 * @package for Joomla 2.5 Native
 * @component SMS by Skebby.it
 * @copyright 2013 Copyright (C) Neonevis Srl www.neonevis.it
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

  defined('_JEXEC') or die('Restricted access');
  $item =& $this->items[0];
  $option = JRequest::getCmd('option');
  $bar= JToolBar::getInstance( 'toolbar' );
  $alt = JText::_( 'STAMPA' );
  $alt2 = JText::_( 'TOOLS' );
	$bar->appendButton( 'Link', 'back', $alt2, 'index.php?option='.$option.'&task=tools');
  $bar->appendButton( 'Popup', 'print', $alt, 'index.php?option='.$option.'&task=report&id=rep002&pop=1&tmpl=component', 640, 480 );

?>

<form action="index.php" method="post" name="adminForm" id="adminForm">

  <table width="98%" class="admintable">
		<tr>
			<td width="35%" align="left">&nbsp;</td>
			<td width="30%" align="center">&nbsp;</td>
			<td width="35%" align="right">
       <?php
        $print_link = JRoute::_('index.php?option='.$option.'&task=tools&id=rep001&pop=1&tmpl=component');
        $pop = JRequest::getVar( 'pop', 0, 'get', 'int' );
        if ($pop!=0){?>
        <a href="#" title="<?php echo JText::_( 'Stampa' ); ?>" onclick="window.print();return false;">
        <img src="<?php echo JURI::base().'components'.'/'.$option.'/'.'assets'.'/'.'icons'.'/'; ?>icon-16-stampa.png" alt="<?php echo JText::_( 'Stampa' ); ?>" />
        </a>
        <?php } ?>
			</td>
		</tr>
		<tr>
			<td width="35%" align="left">
        &nbsp;
			</td>
			<td width="30%" align="center">
					<?php echo JText::_( 'DATA_EMISS' ); ?> : <?php echo date("d-m-Y"); ?>
			</td>
			<td width="35%" align="right">
					<?php echo JText::_( 'COD_REP' ); ?> : <?php echo 'REP002'; ?>
			</td>
		</tr>
		<tr>
		  <td colspan="3" style="text-align: center;"><h2><?php echo JText::_( 'REP_002' ); ?></h2></td>
		</tr>
	</table>

  <table class="adminlist">
  <thead>
  <tr>
    <th width="5">#</th>
		<th width="5%"><?php echo JText::_( 'method' ); ?></th>
		<th width="10%"><?php echo JText::_( 'recipients' ); ?></th>
		<th width="20%"><?php echo JText::_( 'text' ); ?></th>
		<th width="5%"><?php echo JText::_( 'sender_number' ); ?></th>
		<th width="5%"><?php echo JText::_( 'sender_string' ); ?></th>
		<th width="5%"><?php echo JText::_( 'charset' ); ?></th>
		<th width="5%"><?php echo JText::_( 'user_reference' ); ?></th>
		<th width="5%"><?php echo JText::_( 'skebby_dispatch_id' ); ?></th>
		<th width="5%"><?php echo JText::_( 'status' ); ?></th>
		<th width="5%"><?php echo JText::_( 'error_code' ); ?></th>
		<th width="25%"><?php echo JText::_( 'error_message' ); ?></th>
		<th width="5%"><?php echo JText::_( 'created' ); ?></th>		
  </tr>
  </thead>
	<tfoot>
		<tr>
			<td colspan="13"> &nbsp;</td>
		</tr>
	</tfoot>  
  <tbody>
  <?php $k = 0;
    for( $i=0, $c = count( $this->items ); $i < $c; $i++ ) {
      $item =& $this->items[$i]; 
  ?>
    <tr class="row<?php echo $k; ?>">
        <td align="left"><?php echo $item->id; ?></td>
        <td align="left"><?php echo $item->method; ?></td>
        <td align="left"><?php echo $item->recipients; ?></td>
        <td align="left"><?php echo $item->text; ?></td>
        <td align="left"><?php echo $item->sender_number; ?></td>
        <td align="left"><?php echo $item->sender_string; ?></td>
        <td align="left"><?php echo $item->charset; ?></td>
        <td align="left"><?php echo $item->user_reference; ?></td>
        <td align="left"><?php echo $item->skebby_dispatch_id; ?></td>
				<td align="left"><?php echo $item->status; ?></td>
        <td align="left"><?php echo $item->error_code; ?></td>
        <td align="left"><?php echo JText::_($item->error_message); ?></td>
        <td align="left"><?php echo date_format(date_create($item->created),"d/m/Y"); ?></td>		
    </tr>  
  <?php $k = 1 - $k;  } ?>
  </tbody>
  </table>             



<div>&nbsp; </div>
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="controller" value="tools" />
	<input type="hidden" name="option" value="<?php echo $option; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
