<?

class instagram {

  const version = '1.0';
  public static $apiurl = 'https://api.instagram.com/v1';

  private $appid = false;
  private $secret = false;

  public function __construct($appid=INSTAGRAM_APPID, $secret=INSTAGRAM_SECRET) {
    $this->appid = $appid;
    $this->secret = $secret;
  }

  public static function get($url, $params, $type='get') {

    $handler = curl_init();

    curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handler, CURLOPT_USERAGENT, 'instagram-php-'.self::version);

    if ($type == 'post') {
      curl_setopt($handler, CURLOPT_POST, true);
      curl_setopt($handler, CURLOPT_POSTFIELDS, $params);
    } elseif ($type == 'delete') {
      curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "DELETE");
      curl_setopt($handler, CURLOPT_POSTFIELDS, $params);
    } else {
      $url .= '?'.http_build_query($params, null, '&');
    }

    curl_setopt($handler, CURLOPT_URL, $url);

    return curl_exec($handler);

  }

  public function api($url, $params=array(), $type='get') {

    return json_decode(self::get(self::$apiurl.$url, array_merge(
      array('client_id' => $this->appid), $params), $type), true);

  }

  public function media($tag, $params=array()) {

    return $this->api('/tags/'.$tag.'/media/recent/', $params);

  }

}
