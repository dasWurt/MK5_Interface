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
  $.get("/components/system/configuration/includes/content/"+id+".php", function(data){
    $(".tabContainer").html(data);
  });
  $.ajaxSetup({async:true});
}

function update_message(data){
  $('#config_message').html(data);
}

function update_execute(data){
  $('#config_execute').html(data);
}


function update_dips(data){

  selectTabContent('dip');
  update_message(data);

}

function update_tz(data){
  update_message("<font color='lime'>Timezone changed.</font>");
  $.get("/components/system/configuration/functions.php?get_tz", function(data){
    $("#config_tz").text(data);
    $("input[name=custom_zone]").val("");
  });
}
