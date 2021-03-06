<?php
session_start();

define('VIEWPATH',  ROOT . 'app/views/');
define('CTRLSPATH', ROOT . 'app/controllers/');
define('LAYOUTS',   ROOT . 'app/views/layouts/');
define('CONFPATH',  ROOT . 'config/');
define('SYSROOT',   ROOT . 'system/');
define('ACTVIEW',   SYSROOT . 'action_view/');

require SYSROOT . 'system.php';
require SYSROOT . 'config/config.php';
require SYSROOT . 'config/config_system.php';
require SYSROOT . 'database/initialize.php';
require SYSROOT . 'load_functions.php';
require SYSROOT . 'request.php';
require SYSROOT . 'action_controller.php';
require ACTVIEW . 'action_view.php';
require SYSROOT . 'status_codes.php';
require SYSROOT . 'active_record.php';
require ROOT . 'config/config.php';
require ROOT . 'config/routes.php';

System::start();

/**
 * NOTE: in the case an action file needs to do "return;" (like post#show),
 * it must NOT return false, else it will be taken like the file wasn't found,
 * causing a missunderstanding.
 * (This also applies when including partials)
 * 
 * If an action returns an int, the system will exit with such HTTP status.
 */
$include = include CTRLSPATH . Request::$controller . '/' . Request::$action . '.php';
if ($include === false) {
  ActionController::exit_with_error(500, 'Could not find action file.');
  
} elseif (is_int($include) && $include !== 1) {
  exit_with_status($include);
}
unset($include);

ActionController::run_after_filters();

include ACTVIEW . 'render.php';
?>