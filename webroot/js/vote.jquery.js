$(function(){
  $(".cake-votes a").click( function(){
    var _this = $(this);
    $.ajax({
      url: _this.attr( 'href'),
      success: function( data){
        var div = _this.parent( '.cake-votes');
        $(div).find( '.vote-positive').html( data.positives);
        $(div).find( '.vote-negative').html( data.negatives);
        $(div).find( 'a').remove();
      }
    })
    return false;
  })
})