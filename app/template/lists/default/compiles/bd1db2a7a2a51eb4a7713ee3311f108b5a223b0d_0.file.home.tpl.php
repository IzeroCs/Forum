<?php
/* Smarty version 3.1.31, created on 2017-07-26 05:08:12
  from "C:\xampp\htdocs\izerocs.mobi\app\template\lists\default\views\home.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5978079c349fc3_88022579',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bd1db2a7a2a51eb4a7713ee3311f108b5a223b0d' => 
    array (
      0 => 'C:\\xampp\\htdocs\\izerocs.mobi\\app\\template\\lists\\default\\views\\home.tpl',
      1 => 1501037418,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:includes/header.tpl' => 1,
    'file:includes/footer.tpl' => 1,
  ),
),false)) {
function content_5978079c349fc3_88022579 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_function_lng')) require_once 'C:\\xampp\\htdocs\\izerocs.mobi\\app\\template\\plugins\\function.lng.php';
ob_start();
echo smarty_function_lng(array('name'=>"home.title"),$_smarty_tpl);
$_prefixVariable1=ob_get_clean();
$_smarty_tpl->_subTemplateRender("file:includes/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('title'=>$_prefixVariable1), 0, false);
?>


<?php $_smarty_tpl->_subTemplateRender("file:includes/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
