jQuery(document).ready(function($) {

  if (typeof ClipboardJS !== "undefined") {

    var clipboard = new ClipboardJS('#copy-shortcode');
    var copyShortcode = $('#copy-shortcode');

    clipboard.on('success', function(e) {
      copyShortcode.attr('aria-label', 'Copié !');
    });

    copyShortcode.mouseover(function() {
      $(this).attr('aria-label', 'Copier dans le presse papier');
    });
  }

});

