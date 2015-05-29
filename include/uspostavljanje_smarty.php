<?php
require_once SMARTY_DIR . 'Smarty.class.php';
class HomePage extends Smarty
{
function __construct()
{
$this->Smarty();
$this->template_dir = TEMPLATE_DIR;
$this->compile_dir = COMPILE_DIR;
$this->config_dir = CONFIG_DIR;

$this->plugins_dir[0] = SMARTY_DIR . 'plugins';
$this->plugins_dir[1] = SITE_ROOT . "/smarty_plugins";
}
}
?>