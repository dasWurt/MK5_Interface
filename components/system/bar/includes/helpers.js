function create_infusion(data){
  $('#messages').html(data);
  load_tiles();
}

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
  $.get("/components/system/bar/includes/content/"+id+".php", function(data){
    $(".tabContainer").html(data);
  });
}

function remove_infusion(name){
  hide_small_tile(name);
  $.ajaxSetup({async:false});
  $.get("/includes/api/tile_handler.php?action=unhide_tile&tile="+name);
  $.ajaxSetup({async:true});
  $("[id='"+name+"_hidden']").remove();
  notify("The infusion '"+name+"' has been removed.");
  $('#'+name+'_tr').remove();
}

function edit_infusion(data){
  $(".tabContainer").html(data);
}

function edit_infusion_form(data){
  $('#edit_message').html(data);
}

function update_small(data){
  if(data != ""){
    $("#bar_updates").html(data); 
  }
}

function infusion_toggle(){
  if($("#infusion_toggle").text() == "Show"){
    $("#infusion_toggle").text("Hide");
  }else{
    $("#infusion_toggle").text("Show");
  }
  $("#available_infusions").toggle();
}

function cli_infusion_toggle(){
  if($("#cli_infusion_toggle").text() == "Show"){
    $("#cli_infusion_toggle").text("Hide");
  }else{
    $("#cli_infusion_toggle").text("Show");
  }
  $("#available_cli_infusions").toggle();
}