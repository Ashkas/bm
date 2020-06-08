export default {
  init() {
    // JavaScript to be fired on all pages
    var isOpen = 0;
    $('#menu-trigger').click(function () {
      if (isOpen == 0) {
        $('body').addClass('mm-wrapper_opened');
        $('.nav-primary').fadeIn(500);
        isOpen = 1;
      } else {
        $('body').removeClass('mm-wrapper_opened');
        $('.nav-primary').fadeOut(500);
        isOpen = 0;
      }
    });
    $(document).keyup(function(e) {
      if (e.keyCode == 27) { // escape key maps to keycode `27`
        if ($('body').hasClass('mm-wrapper_opened')) {
          $('body').removeClass('mm-wrapper_opened');
        }
        $('.nav-primary').fadeOut(500);
        isOpen = 0;
      }
    });
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
