<?

class cache extends ktbl {
  
  public function __construct($id=false) {
    parent::__construct(array('id' => $id));
  }

  public $__gets = array('status', 'duration');

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

        $status = '';

        date_default_timezone_set('UTC');
        $diff = time()-strtotime(parent::__get('created'));

        if ($diff < 60*60*48) {
          $status = 'newer ';
        }

        if (parent::__get('flagged') == 1) {
          return $status.'flagged';
        }

        if (parent::__get('stuck') == 1) {
          return $status.'stuck';
        }

        return str_replace(' ','',$status);
        break;

      case 'duration' :
        return clock::duration(parent::__get('created'));
        break;
    }

    return parent::__get($name);

  }

}
