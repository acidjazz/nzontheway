<?

$path = dirname(realpath($argv[0]));
require_once $path.'/../cfg/config.php';

$ic = new instacache(24*60*4);
$ic->cache(['maricondia','nzontheway']);

