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
  $.get("/components/system/karma/includes/content/"+id+".php", function(data){
    $(".tabContainer").html(data);
  });
  $.ajaxSetup({async:true});
}

function karma_reload_config(){
  selectTabContent('config');
}

function karma_handle_form(data){
  $('#karma_message').html(data);
}

function karma_change_log_location(data){
  $('#karma_message').html(data);
}

function refresh_log(){
  $.get('/components/system/karma/functions.php?action=get_log', function(data){
    $('#karma_log').html(data);
    karma_log = $("#karma_log_content").text().split("\n");
    apply_filters();
  });
}

function filter_log(log, filters, remove_duplicates){
  var filtered_log = log.slice(0);
  if(remove_duplicates){
    var unique_lines = [];
    var deduped_log = [];
    filtered_log.forEach(function(line){
      if(line){
        regex_line = line.substr(line.match("..:..:..").index+9);
        if($.inArray(regex_line, unique_lines) === -1){
          unique_lines.push(regex_line);
          deduped_log.push(line);
        }
      }
    });
    filtered_log = deduped_log.slice(0);
  }
  $("#karma_log_content").html("\n");

  var final_log = [];
  filters.forEach(function(filter){
    var temp_log = [];
    filtered_log.forEach(function(line){
      if(line.indexOf(filter) >= 0){
        temp_log.push(line);
      }
    });
    filtered_log = temp_log.slice(0);
  });

  filtered_log.forEach(function(line){
    $("#karma_log_content").append(line+"\n");
  });
}

function refresh_report(){

  $.get('/components/system/karma/functions.php?action=get_report', function(data){

    data = JSON.parse(data);
    var clients = new Array();

    var dhcp = data[0].split('\n');
    for (var i = dhcp.length - 1; i >= 0; i--) {
      dhcp[i] = dhcp[i].split(' ');
    }

    var karma = data[2];
    for (var i = karma.length - 1; i >= 0; i--) {
      if(karma[i].indexOf("Successful") !== -1){
        var client = new Array();
        client[0] = karma[i].split(' ')[3];
        client[1] = karma[i-1].slice(53);
        var exists = false;
        for (var j = clients.length - 1; j >= 0; j--) {
          if(clients[j][0] == client[0]){
            exists = true;
          }
        }
        if(!exists){
          clients.push(client);
        }
      }
    }

    for (var i = clients.length - 1; i >= 0; i--) {
      for (var i2 = dhcp.length - 1; i2 >= 0; i2--) {
        if(dhcp[i2][1] == clients[i][0]){
          clients[i][2] = dhcp[i2][2];
          clients[i][3] = dhcp[i2][3];
        }
      }
    }


    if(clients.length != 0){
      var html = "<table style='border-spacing: 15px 2px'><tr><th>HW Address</th><th>IP Address</th><th>hostname</th><th>SSID</th></tr>";

      for (var i = clients.length - 1; i >= 0; i--) {
        if(clients[i][2] != undefined){
          html += "<tr><td>"+clients[i][0]+"</td><td text-align='center'>"+clients[i][2]+"</td><td text-align='center'>"+clients[i][3]+"</td><td>"+clients[i][1]+"</td></tr>"
        }
      }

      html += "</table>";     
    }else{
      var html = "No clients found.";
    }

    $('#karma_report').html(html);
  });
}