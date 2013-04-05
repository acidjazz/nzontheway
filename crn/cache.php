<?

require_once '../cfg/config.php';

$ic = new instacache(24*60*4);
$ic->cache(['thenextbigthing']);

