<?

class media_ctl {

  public $admin = false;

  public function __construct() {

    define('KDEBUG_JSON', true);

    if (isset($_REQUEST['signed_request'])) {
      $fb = new fb();
      if (isset($fb->session['page']) && isset($fb->session['page']['admin'])) {
        $this->admin = true;
      }
    }


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
      'html' => jade::c('_media', ['data' => $data, 'admin' => $this->admin], true),
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

  public function flag($id) {

    if ($this->admin != true) {
      echo json_encode(['error' => true, 'message' => 'not an admin']);
      return true;
    }

    $single = new cache($id);

    if (!$single->exists()) {
      echo json_encode(['error' => true]);
      return true;
    }

    $single->flagged = !$single->flagged;
    $single->save();

    echo json_encode(['error' => false]);
    return true;

  }

}

