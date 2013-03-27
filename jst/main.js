
var _ = {

  i: function() {

    _.load();

  },

  load: function() {

    $.get('/media', function(response) {
      $('.body').html(response.html);
    }, 'json');

  }

}
