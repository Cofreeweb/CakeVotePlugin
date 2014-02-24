$(function(){
  $(".vote-box a").click( function(){
    var _this = $(this);
    $.ajax({
      url: _this.attr( 'href'),
      beforeSend: function(){
        $(".vote-box").fadeTo( 100, .3);
      },
      success: function( data){
        var div = _this.parents( '.vote-box');
        $(div).find( '.vote-positive').html( data.positives);
        $(div).find( '.vote-negative').html( data.negatives);
        $(div).find( 'a').each( function(){
		      var el = $(this);
		      $(this).replaceWith( '<span class="vote-icon vote-inactive">' + el.html() + '</span>');
        });
        $(".vote-box").fadeTo( 100, 1);
      }
    })
    return false;
  })
})