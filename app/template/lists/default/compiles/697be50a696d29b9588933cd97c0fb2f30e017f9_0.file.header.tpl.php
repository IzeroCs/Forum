<?php
/* Smarty version 3.1.31, created on 2017-07-26 05:54:38
  from "C:\xampp\htdocs\izerocs.mobi\app\template\lists\default\views\includes\header.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5978127e98a256_00687160',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '697be50a696d29b9588933cd97c0fb2f30e017f9' => 
    array (
      0 => 'C:\\xampp\\htdocs\\izerocs.mobi\\app\\template\\lists\\default\\views\\includes\\header.tpl',
      1 => 1501041275,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5978127e98a256_00687160 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_function_env')) require_once 'C:\\xampp\\htdocs\\izerocs.mobi\\app\\template\\plugins\\function.env.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=false">
        <link rel="stylesheet" href="<?php echo smarty_function_env(array('name'=>"http.res.default.app_css"),$_smarty_tpl);?>
" media="all"/>
        <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo smarty_function_env(array('name'=>"http.res.default.app_js"),$_smarty_tpl);?>
"><?php echo '</script'; ?>
>
    </head>

    <body>
        <div id="container-full">
            <ul id="header">
                <li id="logo">
                    <h1>Logo</h1>
                </li>

                <li id="action">
                    <ul>
                        <li><a href="#"><span>Home</span></li>
                        <li><a href="#"><span>Forum</span></li>
                    </ul>
                </li>
            </ul>
<?php }
}
