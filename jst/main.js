var _ = {

  last: false,
  moreing: false,

  i: function() {
    _.load();
    _.handlers();
  },

  handlers: function() {
    $('.body').scroll(_.scrolled);
  },

  thandlers: function() {

    $('.body .thumbnails .thumbnail').unbind('click', _.modal.i).click(_.modal.i);

    if ($('.fade').hasClass('fadeon')) {
      $('.fade').css('height', _.totalHeight($('.body')) + 'px');
    }

  },

  totalHeight: function(el) {
    return  el[0].scrollHeight
      + parseInt(el.css('padding-top'), 10) 
      + parseInt(el.css('padding-bottom'), 10)
      + parseInt(el.css('border-top-width'), 10)
      + parseInt(el.css('border-bottom-width'), 10);
  },

  scrolled: function(event) {

    var scrollPosition = $(this).scrollTop() + $(this).outerHeight();
    var divTotalHeight = _.totalHeight($(this));

    if (scrollPosition >= divTotalHeight) {
      _.more();
    }

  },

  load: function() {

    $.get('/media', function(response) {
      $('.body .thumbnails').html(response.html);
      _.last = response.last;
      _.thandlers();
    }, 'json');

  },

  more: function() {

    if (_.moreing == true) {
      return true;
    }

    _.moreing = true;

    $.get('/media', {last: _.last}, function(response) {
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
      $('.fade').css('height', _.totalHeight($('.body')) + 'px');
    } else {
      $('.fade').removeClass('fadeon');
      $('.modal').removeClass('modalon');
      $('.fade').css('height', '0px');
    }

  },

  modal: {

    i: function() {

      _.fade(true);


      $.get('/media/single/' + $(this).data('id'), function(response) {

        $('.modal').html(response.html).addClass('modalpop');
        $('.fade, .close').click(_.modal.d);

      }, 'json');

    },

    d: function() {
      $('.modal').removeClass('modalpop').html('');
      $('.fade, .close').unbind('click', _.modal.d);
      _.fade(false);
    }

  }

}
