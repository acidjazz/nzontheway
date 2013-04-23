var _ = {

  last: false,
  moreing: false,
  offset: 650,
  fb_offset: 720,
  min_height: 370,
  mobile: false,
  id: false,

  i: function() {


    _.load();
    _.handlers();

    if (_.sr == '' && _.mobile == false) {

      var height = $(window).height()-_.offset;
      if (height > _.min_height) {
        $('.body').css('height', height + 'px');
      }

    } else {
      FB.Canvas.getPageInfo(
        function(info) {

          var height = info.clientHeight-_.fb_offset;
          if (height > _.min_height) {
            $('.body').css('height', height + 'px');
          }

        }
      );
    }

    if (_.mobile == true) {
      _.mhandlers();
    }

    if (_.id != false && _.id != 'false') {
      _.modal.i(_.id);
    }

  },

  handlers: function() {

    if (_.mobile == true) {
      $(window).scroll(_.wscrolled);
    } else {
      $('.body').scroll(_.scrolled);
    }

  },

  thandlers: function() {

    $('.body .thumbnails .thumbnail, .fpic').unbind('click', _.modal.i).click(_.modal.i);

    if (_.admin == true) {
      $('.tools .flag, .tools .flagged').unbind('click', _.flag).click(_.flag);
      $('.tools .stick, .tools .stuck').unbind('click', _.stick).click(_.stick);
    }

    if ($('.fade').hasClass('fadeon')) {
      $('.fade').css('height', $(document).height() + 'px');
    }

  },

  mhandlers: function() {
    $(window).resize(_.fixedfix);
  },

  fixedfix: function() {
//    $('.header, .footer').css('width', $(document).width() + 'px');
  },

  totalHeight: function(el) {
  
    return  el[0].scrollHeight
      + 1*(el.css('padding-top'), 10) 
      + 1*(el.css('padding-bottom'), 10)
      + 1*(el.css('border-top-width'), 10)
      + 1*(el.css('border-bottom-width'), 10);
  },

  scrolled: function(event) {

    var scrollPosition = $(this).scrollTop() + $(this).outerHeight();
    var divTotalHeight = _.totalHeight($(this));

    if (divTotalHeight-scrollPosition<=20) {
      _.more();
    }

  },

  wscrolled: function(event) {

    if ($(window).scrollTop() + $(window).height() == $(document).height()) {
      _.more();
    }

  },

  flag: function(e) {

    var t = $(this);

    t.html('...');

    $.get('/media/flag/' + t.data('id'), {signed_request: _.sr}, function(response) {

      if (t.hasClass('flagged')) {
        t.removeClass('flagged').addClass('flag');
        t.html('flag');
        t.parent().parent().removeClass('flagged');
      } else {
        t.removeClass('flag').addClass('flagged');
        t.parent().parent().addClass('flagged');
        t.html('unflag');
      }

    }, 'json');

    e.stopPropagation();

  },

 stick: function(e) {

    var t = $(this);

    t.html('...');

    $.get('/media/stick/' + t.data('id'), {signed_request: _.sr}, function(response) {

      if (t.hasClass('stuck')) {
        t.removeClass('stuck').addClass('stick');
        t.html('stick');
        t.parent().parent().removeClass('stuck');
      } else {
        t.removeClass('stick').addClass('stuck');
        t.parent().parent().addClass('stuck');
        t.html('unstick');
      }

    }, 'json');

    e.stopPropagation();

  },


  load: function() {

    $.get('/media', {signed_request: _.sr}, function(response) {
      $('.body .thumbnails').html(response.html);
      _.last = response.last;
      _.thandlers();
      if (_.mobile == true) {
        _.more();
      }
    }, 'json');

    if ($('.fpics').is(':visible')) {
      $.get('/media/stucks', function(response) {
        $('.footer .fpics').html(response.html);
        _.thandlers();
      }, 'json');
    }

  },

  more: function() {

    if (_.moreing == true) {
      return true;
    }

    _.moreing = true;

    $.get('/media', {last: _.last, signed_request: _.sr}, function(response) {
      _.last = response.last;

      if (response.html == '') {
        console.log('EOL');
        $('.body .bloader').html('End of Line&nbsp;&nbsp;&nbsp;').css('background', 'none');
        return true;
      }
      $('.body .thumbnails').append(response.html);
      _.moreing = false;
      _.thandlers();
    }, 'json');

  },

  fade: function(open) {

    if (open) {
      $('.fade').addClass('fadeon');
      $('.modal').addClass('modalon');
      $('.fade').css('height', ($(document).height()-250) + 'px');

      if (_.mobile == true) {
        $('body').css('overflow', 'hidden');
        //$('.modal').css('height', ($(window).height()*.95) + 'px');
      }

    } else {
      $('.fade').removeClass('fadeon');
      $('.modal').removeClass('modalon');
      $('.fade').css('height', '0px');
      if (_.mobile == true) {
        //$('.modal').css('height', '0px');
        $('body').css('overflow', 'auto');
      }
    }

  },

  modal: {

    i: function(id) {

      if (typeof id != 'string') {
        var id = $(this).data('id');
      }

      _.fade(true);

      $.get('/media/single/' + id, function(response) {

        $('.modal').html(response.html).addClass('modalpop');
        $('.fade, .close').click(_.modal.d);
        $('.share').unbind('click', _.share).click(_.share);

        setTimeout(function() { $('.modal .totals').addClass('totalson'); }, 100);

      }, 'json');

    },

    d: function() {
      $('.modal').removeClass('modalpop').html('');
      $('.fade, .close').unbind('click', _.modal.d);
      _.fade(false);
    }

  },

  share: function() {

    FB.ui(
      {
        method: 'feed',
        name: 'Air New Zealand &#8210; #nzontheway',
        description: 'Your pic could win you 2 free tickets to Australia via New Zealand! Click the link to learn more.',
        link: _.g_url + '?id=' + $(this).data('id'),
        picture: $(this).data('image')
      },
      function (response) {

      });

  }

}
