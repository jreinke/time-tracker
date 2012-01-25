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
  
  $('.ui-widget-overlay').live('click', function() {
     //$('#assignment-form-dialog').dialog('close');
     $('.ui-dialog-content').dialog('close');
  });
  
  $('#new-assignment-link').click(function(e) {
    e.preventDefault();
    $('#assignment-form-dialog').load($(this).attr('href'), function() {
      $(this).dialog({
        modal: true,
        minWidth: 300
      });
    });
  });
  
  $('.assignment-list .sf_admin_action_edit a').live('click', function(e) {
    e.preventDefault();
    $('#assignment-form-dialog').load($(this).attr('href'), function() {
      $(this).dialog({
        modal: true,
        minWidth: 300
      });
    });
  });
  
  $('.comment-icon').click(function(e) {
    e.preventDefault();
    var id = this.id.replace(/[^0-9\.]/g, '');
    $('#comment-dialog-' + id).dialog({
      modal: true,
      minWidth: 300
    });
  });
  
  $('.assignment-list .sf_admin_action_delete a').live('click', function(e) {
    e.preventDefault();
    $('#assignment-list-errors').html('');
    if (confirm($('#confirm-message').val())) {
      $.getJSON($(this).attr('href'), function(data) {
        if (data.result) {
          $(this).css({ visibility: 'hidden' });
          $('#task-assignments').load($('#task-assignments-url').val());
        } else {
          $('#assignment-list-errors').html(data.message);
        }
      });
    }
  });
  
  $('#assignment-form-dialog form').live('submit', function(e) {
    e.preventDefault();
    var data = $(this).serializeArray();
    $(this).css({ visibility: 'hidden' });
    $('#assignment-form-dialog').load($(this).attr('action'), data, function() {
      $('#task-assignments').load($('#task-assignments-url').val());
    });
  });
  
  $('#input-datepicker').datepicker({
    defaultDate: $('#input-date').val(),
    dateFormat: 'yy-mm-dd',
    beforeShowDay: function (date) {
      var day = date.getDay();
      if (day == 0 || day == 6) {
        return [false, '']; // no weekends
      }
      var $class = '';
      var $legend = '';
      var $dateStr = $.datepicker.formatDate('yy-mm-dd', date);
      if ($inputs[$dateStr]) {
        $class = ($inputs[$dateStr] == 1) ? 'input-complete' : 'input-partial';
        $legend = $inputs[$dateStr];
      }
      return [true, $class, rtrim($legend, '0.')];
    },
    onSelect: function(dateText, inst) {
      $(location).attr('href', $('#input-url').val() + '/' + dateText);
    }
  });
  
  $('table.sortable tbody').sortable({
    axis: 'y',
    items: 'tr',
    handle: '.sf_admin_action_move a',
    helper: function(e, tr)
    {
      var $originals = tr.children();
      var $helper = tr.clone();
      $helper.children().each(function(index)
      {
        // Set helper cell sizes to match the original sizes
        $(this).width($originals.eq(index).width())
      });
      return $helper;
    },
    start: function(event, ui) {
      $('#ajax-sort-error').slideUp();
    },
    stop: function(event, ui) {
      $(this).find('tr:even').removeClass('even').addClass('odd');
      $(this).find('tr:odd').removeClass('odd').addClass('even');
    },
    update: function(event, ui) {
      var $data = $(this).sortable('serialize');
      $.ajax({
        url: $('#ajax-sort-url').val(),
        data: $data,
        error: function() {
          $('#ajax-sort-error').slideDown();
        }
      });
    }
  });
});

function rtrim(str, charlist) {
  // Removes trailing whitespace  
  // 
  // version: 1006.1915
  // discuss at: http://phpjs.org/functions/rtrim
  // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // +      input by: Erkekjetter
  // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // +   bugfixed by: Onno Marsman
  // +   input by: rem    // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
  // *     example 1: rtrim('    Kevin van Zonneveld    ');
  // *     returns 1: '    Kevin van Zonneveld'
  charlist = !charlist ? ' \\s\u00A0' : (charlist+'').replace(/([\[\]\(\)\.\?\/\*\{\}\+\$\^\:])/g, '\\$1');
  var re = new RegExp('[' + charlist + ']+$', 'g');
  
  return (str+'').replace(re, '');
}