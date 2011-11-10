<?php /* Smarty version Smarty-3.1.3, created on 2011-11-10 23:46:36
         compiled from "views/report.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20360633214ebc557ea05a78-14332380%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '41f01af36ec59cc28e59349077888068da599553' => 
    array (
      0 => 'views/report.tpl',
      1 => 1320968796,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20360633214ebc557ea05a78-14332380',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.3',
  'unifunc' => 'content_4ebc557ea54b2',
  'variables' => 
  array (
    'messages' => 0,
    'item' => 0,
    'report' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4ebc557ea54b2')) {function content_4ebc557ea54b2($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>SocietasPro Bug Scanner</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<link rel="stylesheet" type="text/css" href="style/screen.css" />
</head>
<body>

	<h1>Bug Scanner</h1>
	
	<table border="1">
		<tr>
			<th>Line</th>
			<th>Notice</th>
			<th>Code</th>
			<th>&nbsp;</td>
		</tr>
		<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['messages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
		<tr>
			<td colspan="4"><?php echo $_smarty_tpl->tpl_vars['item']->value[0];?>
</td>
		</tr>
		<?php  $_smarty_tpl->tpl_vars['report'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['report']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['item']->value[1]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['report']->key => $_smarty_tpl->tpl_vars['report']->value){
$_smarty_tpl->tpl_vars['report']->_loop = true;
?>
		<tr>
			<td><?php echo $_smarty_tpl->tpl_vars['report']->value[2];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['report']->value[1];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['report']->value[3];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['report']->value[0];?>
</td>
		</tr>
		<?php } ?>
		<?php } ?>
	</table>

</body>
</html><?php }} ?>