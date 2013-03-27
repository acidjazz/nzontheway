<?

class cache extends ktbl {
  
  public function __construct($id=false) {
    parent::__construct(array('id' => $id));
  }

  public function __set($name, $value) {

    switch ($name) {

      case 'created' :
        return parent::__set($name, gmdate('Y-m-d H:i:s', $value));
        break;
    }

    return parent::__set($name, $value);
  }

}
