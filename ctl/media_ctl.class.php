<?

class media_ctl {

  public $admin = false;

  public function __construct() {

    define('KDEBUG_JSON', true);

    if (isset($_REQUEST['signed_request']) && !empty($_REQUEST['signed_request'])) {

      $fb = new fb();

      if (
        isset($fb->session['page']) && 
        isset($fb->session['page']['admin']) && 
        isset($fb->session['app_data']) && 
        $fb->session['page']['admin'] == true &&
        $fb->session['app_data'] == 'admin'
        ) {
        $this->admin = true;
      }

    }

  }

  public function index($date) {

    if ($this->admin == true) {
      $filter = ' WHERE (flagged = 1 OR flagged = 0)';
    } else {
      $filter = ' WHERE flagged = 0';
    }

    $order = ' ORDER BY created DESC LIMIT 20';

    if (isset($_REQUEST['last']) && !empty($_REQUEST['last'])) {
      $filter .= ' AND created < "'.$_REQUEST['last'].'" ';
    }

    $data = array();
    foreach (cache::gets($filter.$order) as $cache) {
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

  public function stick($id) {

    if ($this->admin != true) {
      echo json_encode(['error' => true, 'message' => 'not an admin']);
      return true;
    }

    $single = new cache($id);

    if (!$single->exists()) {
      echo json_encode(['error' => true]);
      return true;
    }

    $single->stuck = !$single->stuck;
    $single->save();

    echo json_encode(['error' => false]);
    return true;

  }

}

