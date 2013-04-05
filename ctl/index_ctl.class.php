<?

class index_ctl {

  public $admin = false;
  public $capable = false;

  public function index() {

    $fb = new fb();
    $admin = false;

    if (
      isset($fb->session['page']) && 
      isset($fb->session['page']['admin']) && 
      isset($fb->session['app_data']) && 
      $fb->session['page']['admin'] == true &&
      $fb->session['app_data'] == 'admin'
      ) {
      $this->admin = true;
    }

    if (
      isset($fb->session['page']) && 
      isset($fb->session['page']['admin']) && 
      $fb->session['page']['admin'] == true
      ) {
      $this->capable = true;
    }

    jade::c('index', ['admin' => $this->admin, 'capable' => $this->capable]); 

  }

}
