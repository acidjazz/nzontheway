<?

class media_ctl {

  public function index() {

    $data = array();
    foreach (cache::gets('ORDER BY rand() DESC LIMIT 20') as $cache) {
      $data[] = $cache->data();
    }

    echo json_encode(['html' => jade::c('_media', ['data' => $data], true)]);

  }

}
