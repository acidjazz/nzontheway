<?

class instacache {

  public $oldest = 300;

  // pass the oldest image to grab in minutes
  public function __construct($oldest) {
    $this->oldest = $oldest*60;
  }

  public function cache($filters) {

    $insta = new instagram();

    foreach ($filters as $filter) {

      $max_tag_id = null;

      $i = 0;

      while (true) {

        if ($max_tag_id == null) {
          $media = $insta->media($filter);
        } else {
          $media = $insta->media($filter, array('max_tag_id' => $max_tag_id));
        }

        $max_tag_id = $media['pagination']['next_max_tag_id'];

        foreach ($media['data'] as $data) {

          $cache = new cache($data['id']);

          if (!$cache->exists()) {
            $cache->filter = $filter;
            $cache->created = $data['created_time'];
            $cache->link = $data['link'];
            $cache->tags = count($data['tags']);
            $cache->likes = $data['likes']['count'];
            $cache->comments = $data['comments']['count'];
            $cache->thumbnail = $data['images']['thumbnail']['url'];
            $cache->image = $data['images']['standard_resolution']['url'];
            $cache->caption = $data['caption']['text'];
            $cache->username = $data['user']['username'];
            $cache->profile = $data['user']['profile_picture'];
            $cache->user_id = $data['user']['id'];
            $cache->save();
            echo 'saved '.$data['id']."\r\n";
          }

          $gap = time()-strtotime($cache->created);

          if ($gap >= $this->oldest) {
            return true;
          }

        }

      }

    }

  }

}
