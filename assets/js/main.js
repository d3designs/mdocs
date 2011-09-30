/**
 * 
 */

(function($){
  $(document).ready(function(){
    
    // TOC floating widget
    $('#toc').floatingWidget();
    
    // Fix all colons in id
    $('#doc *[id*=":"]').each(function(){
      $(this).attr('id', $(this).attr('id').replace(':', '--'));
    });
    $('#toc a[href*=":"]').each(function(){
      $(this).attr('href', $(this).attr('href').replace(':', '--'));
    });
    
    // Show decoration of TOC
    $('a[href^="#"]').hover(function(){
      var target = $(this).attr('href');
      var decoration = $(target).attr('id') + '-decoration';
      if($('#'+decoration).length === 0) {
        var position = $(target).position();
        var div = document.createElement('div');
        $(div).attr('id', decoration);
        $(div).text('#');
        console.log($(target));
        $(div).css({
          position: 'absolute',
          top: position.top,
          left: position.left - 15,
          marginTop: $(target).css('margin-top'),
          padding: $(target).css('padding'),
          fontSize: $(target).css('font-size')
        });
        $(div).addClass('document-decoration');
        $(div).addClass('pound');
        $(div).appendTo($('#doc'));
      }
      else {
        $('#'+decoration).show();
      }
    }, function(){
      var target = $(this).attr('href');
      $('#' + $(target).attr('id') + '-decoration').hide();
    });
    
  });
})(jQuery);
