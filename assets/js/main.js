/**
 * 
 */

// Deep link redirect
if($.address.value().match(/^\/\?file\=/)) {
  var url = $.address.baseURL();
  var query_pos = url.indexOf('?');
  if(query_pos > 0) {
    url = url.substr(0, query_pos); 
  }
  url = url.replace(/\/$/, '');
  url += $.address.value();
  window.location = url;
}
    
// Fix all colons in id
function removeIdColons() {
  $('#doc *[id*=":"]').each(function(){
    $(this).attr('id', $(this).attr('id').replace(':', '--'));
  });
  $('#toc a[href*=":"]').each(function(){
    $(this).attr('href', $(this).attr('href').replace(':', '--'));
  });
}

// On Load
(function($){
  $(document).ready(function(){
    // Remove colons from id
    removeIdColons();
        
    // TOC floating widget
    $('#toc').floatingWidget();
    // TOC smooth scroll
    $('#toc a').smoothScroll();
    
    // Show decoration of TOC
    $('a[href^="#"]').hover(function(){
      var target = $(this).attr('href');
      var decoration = $(target).attr('id') + '-decoration';
      if($('#'+decoration).length === 0) {
        var position = $(target).position();
        var div = document.createElement('div');
        $(div).attr('id', decoration);
        $(div).text('#');
        //console.log($(target));
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
    
    // Ajax load
    $('#menu a').click(function(e){
      e.preventDefault();
      var url = $(this).attr('href');
      
      // Add deep link
      $.address.value(url);  
      
      // Scroll to top
      $.smoothScroll(0);
            
      // Show loaders
      $('#doc, #toc').wrapInner('<div />');
      $('#doc > div, #toc > div').fadeOut(function(){
        $(this).parent().addClass('loading');
        
        // Load
        $.ajax({
          url: url,
          dataType: 'json',
          success: function(response) {
            // Invalid data -> just redirect
            if(!response.title, !response.doc, !response.toc) { 
              window.location = url;
            }
            
            // Change title and load data
            document.title = response.title;
            $('#doc > div').html(response.doc);
            $('#toc > div').html(response.toc);
            
            // Remove colons from ids
            removeIdColons();
            
            // Remove loading and show
            $('#doc, #toc').removeClass('loading');
            $('#doc > div,#toc > div').fadeIn(function(){
              $(this).parent().html($(this).html());
            });          
          },
          // Just redirect on error
          error: function(){
            window.location = url;
          }
        });
      });
    });
    
  });
})(jQuery);
