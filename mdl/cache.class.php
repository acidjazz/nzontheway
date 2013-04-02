<?

class cache extends ktbl {
  
  public function __construct($id=false) {
    parent::__construct(array('id' => $id));
  }

  public $__gets = array('status');

  public function __set($name, $value) {

    switch ($name) {

      case 'created' :
        return parent::__set($name, gmdate('Y-m-d H:i:s', $value));
        break;
    }

    return parent::__set($name, $value);
  }

  public function __get($name) {

    switch ($name) {
      case 'caption' :
        return utf8_encode(parent::__get($name));
        break;
      case 'status' :
        if (parent::__get('flagged') == 1) {
          return 'flagged';
        }
        return '';
        break;
    }

    return parent::__get($name);

  }

}
