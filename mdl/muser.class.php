<?

class muser extends ktbl {
  
  public function __construct($id=false) {
    parent::__construct(array('id' => $id));
  }

  public function __set($name, $value) {

    switch ($name) {

      case 'datas' :

        if (!is_string($value)) {
          return parent::__set($name, json_encode($value));
        }

        break;

    }

    return parent::__set($name, $value);
  }

  public function __get($name) {

    switch ($name) {

      case 'datas' :
        return  json_decode(parent::__get($name), true);
        break;
    }

    return parent::__get($name);
  }

  public function save() {

    // registration
    if (!$this->exists()) {

      $this->created = 'now()';
      $this->last_login = 'now()';
      $this->logins = 1;

    } else {

      // if its been longer than 22 hours..
      if ( (time() - strtotime($this->last_login)) / 60 / 60 > 22) {
        $this->last_login = 'now()';
        $this->logins += 1;
      }

    }

    parent::save();

  }

}
