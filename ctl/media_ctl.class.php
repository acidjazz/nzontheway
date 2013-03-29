<?

class media_ctl {

  public function __construct() {

    define('KDEBUG_JSON', true);

  }

  public function index($date) {

    $query = 'ORDER BY created DESC LIMIT 20';

    if (isset($_REQUEST['last']) && !empty($_REQUEST['last'])) {
      $query = 'WHERE created < "'.$_REQUEST['last'].'" '.$query;
    }

    $data = array();
    foreach (cache::gets($query) as $cache) {
      $data[] = $cache->data();
    }

    echo json_encode([
      'html' => jade::c('_media', ['data' => $data], true),
      'last' => $data[count($data)-1]['created']
    ]);

  }

  public function single($id) {

    $single = new cache($id);

    if (!$single->exists()) {
      echo json_encode(['error' => true]);
      return true;
    } 

    echo json_encode(['error' => false, 'html' => jade::c('_single', $single->data(), true)]);

  }

}
