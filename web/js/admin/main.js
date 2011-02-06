$(document).ready(function() {
  $('table').addClass('ui-widget');
  $('thead').addClass('ui-widget-header');
  
  $('#menu li').hover(
    function () {
      $(this).addClass('ui-state-hover');
    },
    function () {
      $(this).removeClass('ui-state-hover');
    }
  );
});
