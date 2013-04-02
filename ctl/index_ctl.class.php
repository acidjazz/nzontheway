<?

class index_ctl {

  public function index() {

    $fb = new fb();
    $admin = false;

    if (isset($fb->session['page']) && isset($fb->session['page']['admin'])) {
      $admin = true;
    }

    jade::c('index', ['admin' => $admin]); 

  }

}
