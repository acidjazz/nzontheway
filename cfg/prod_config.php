<?

define('G_PATH', '/var/www/nzo/');
define('LIB_PATHS', G_PATH.'klib/,'.G_PATH.'mdl/,'.G_PATH.'ctl/,'.G_PATH.'lib/');
define('G_URL', 'http://nzontheway.com/');

/* kdebug */
define('KDEBUG', false);
define('KDEBUG_HANDLER', true);
define('KDEBUG_EGPCS', true);
define('KDEBUG_SQL', true);

/* facebook */
define('FB_APPID', '484586431591177');
define('FB_SECRET', '61dcd9d2fb5aa1f7055c15e051051607');
define('FB_URL', 'https://www.facebook.com/pages/Draftfcb-labs/487462011308540?sk=app_'.FB_APPID);

/* instagram */
define('INSTAGRAM_APPID', 'b099cb5137f643969a1f9dfa57da6a37');
define('INSTAGRAM_SECRET', '8ec156066340461ba80ebd76999f04c4');

/* mysql config */
define('DB_HOST', 'localhost');
define('DB_USER', 'nzo');
define('DB_PASSWORD', 'nzo');
define('DB_DATABASE', 'nzo');

/* ignore past this line */

/* set our include path(s) */
set_include_path(get_include_path().PATH_SEPARATOR.G_PATH);


/* autoload libs/classes in their specific folders */
spl_autoload_register(function($class) { 

	foreach (explode(',', LIB_PATHS) as $libdir) {
  	foreach (array('.class.php','.interface.php') as $file) {
			if (is_file($libdir.$class.$file)) {
				return require_once $libdir.$class.$file;
			}
		}
	}

	return false;

});


/* load our debuger if turned on */
if (defined('KDEBUG') && KDEBUG == true && php_sapi_name() != 'cli') {
	if (!defined('KDEBUG_JSON') || KDEBUG_JSON == false) {
		register_shutdown_function(array('kdebug', 'init'));
		if (defined('KDEBUG_HANDLER') && KDEBUG_HANDLER == true) {
			set_error_handler(array('kdebug', 'handler'), E_ALL);
		}
	}
}


/* debuger function wrappers */
function hpr() { return call_user_func_array(array('k','hpr'), func_get_args()); }
function cpr() { return call_user_func_array(array('k','cpr'), func_get_args()); }
function highlight() { return call_user_func_array(array('k','highlight'), func_get_args()); }
function xmlindent() { return call_user_func_array(array('k','xmlindent'), func_get_args()); }

