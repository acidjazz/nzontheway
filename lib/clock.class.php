<?php 

class clock {

  public static function duration($date) {

    $now = new DateTime('now', new DateTimeZone('UTC'));
    $diff = $now->diff(new DateTime($date, new DateTimeZone('UTC')));

    if ($diff->days > 32) { 
      $months = round($diff->days/30);
      return $months.' month'.($months > 1 ? 's' : ''); 
    }

    if ($diff->days > 7) { 
      $weeks = round($diff->days/7);
      return $weeks.' week'.($weeks > 1 ? 's' : ''); 
    }

    if ($diff->days > 0) { 
      return $diff->days.' day'.($diff->days > 1 ? 's' : ''); 
    }

    if ($diff->days == 0 && $diff->h > 0) { 
      return $diff->h.' hour'.($diff->h > 1 ? 's' : ''); 
    }

    if ($diff->days == 0 && $diff->h == 0) {
      return $diff->i.' min'.($diff->i > 1 ? 's' : '').' '.$diff->s.'s';
    }

    return 'clock::duration bug';

  }


}
