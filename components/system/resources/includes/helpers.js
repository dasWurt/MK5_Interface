$(document).ready(function () {

  $('#tabs li a:not(:first)').addClass('inactive');
  selectTabContent($('#tabs li a:first').attr('id'));
  $('#tabs li a').click(function () {
    var t = $(this).attr('id');
    if ($(this).hasClass('inactive')) {
      $('#tabs li a').addClass('inactive');
      $(this).removeClass('inactive');
      selectTabContent(t);
    }else{
      selectTabContent(t);
    }
  });

});

function selectTabContent(id){
  $.ajaxSetup({async:false});
  $.get("/components/system/resources/includes/content/"+id+".php", function(data){
    $(".tabContainer").html(data);
  });
  $.ajaxSetup({async:true});
}

function kill_proc(data){
  selectTabContent('taskmgr');
}

function update_fstab(message){
    $('#usb_message').text(message);
}

function dropCaches(message){
  $('#cache_message').text(message);
}

function clearCaches(message){
  $('#cache_message').text(message);
}