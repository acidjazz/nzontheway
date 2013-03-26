<?

require_once 'cfg/config.php';

echo $suzy;
echo $charlie;


/* create 20 random musers
for ($i = 0; $i != 20; $i++) {
  $muser = new muser();
  $muser->name = kdebug::string_generate();
  $muser->datas = ['this' => 'that', 5 => [1,2,3]];
  $muser->save();
}
*/

foreach (muser::gets() as $user) { /*hpr($user->name);*/ }
foreach (muser::gets('LIMIT 10') as $user) { /*hpr($user->name);*/ }
foreach (muser::gets('LIMIT 15') as $user) { /*hpr($user->name);*/ }


(new kctl($_SERVER['REQUEST_URI']))->start();

$_GET['test'] = [1 => range(5,20), 3 => ['a','b','c'], 'this is a test of length' => range(10,20)];
