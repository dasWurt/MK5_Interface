/*set up variables*/
var notifications = [];
var notification_interval;
var tile_updaters = [];

/*
Function called by index.php on load.
Loads all components and sets up the interface
*/

function init(){
  notification_handler();
  setup_key_handerls();
  setup_window_listeners();    
  load_tiles();
  populate_hidden_tiles();
}



/*
Function to set notifications.
*/
function notify(message, sender, color){
  var message = [message, sender, color];
  notifications.push(message);
  return true;
}


/*
Function to handle notifications
and update the status bar.
*/
function notification_handler(){
  clearInterval(notification_interval);
  notification_interval = setInterval(function(){
    if(notifications.length == 0){
      $.get("/includes/api/statusbar_handler.php", {action: "get_status_bar"}, function(data){
        $(".statusBar_content").html(data);
      });      
    }else{
      var notification = notifications.shift();
      if(notification[1] != null){
        if(notification[2] != null){
          $("div[id='"+notification[1]+"']").css('box-shadow', '2px 2px 50px 2px '+notification[2]+' inset');
        }else{
          $("div[id='"+notification[1]+"']").css('box-shadow', '2px 2px 50px 2px green inset');  
        }
      }
      $(".statusBar_content").html(notification[0]);
    }
  }, 2800);
}


/*
Function to get all time details.
*/
function load_tiles(){

  $.get("/includes/api/tile_handler.php", {action: "get_tiles"})
  .done(function( data ) {
    if(data != "none"){
      var tiles = jQuery.parseJSON(data);
      tiles.forEach(function(tile){
        draw_small_tile(tile['name'], tile['type']);
      });    
    }
  })
  .fail(function(){load_tiles();});
}


/*
Function to draw small tiles by name.
This also sets up click handlers and updaters.
*/
function draw_small_tile(name, type){
  var present = false;
  $(".tile").each(function(){
    if($(this).attr('id') == name) present = true;
  });
  if(present) return false;
  $(".tiles_wrapper").append('<div class="tile" id="'+name+'"></div>');

  $.get('/components/'+type+'/'+name+'/handler.php', {action: "get_small_tile"}, function(data){
    var data = jQuery.parseJSON(data);

    $("div[id='"+name+"']").append('<div class="tile_title_wrapper"><span class="tile_title" id="'+name+'_title"><b>'+data['title']+'</b></span><span class="tile_remove" id="'+name+'_remove">[-]</span></div>');
    $("div[id='"+name+"']").append('<div class="tile_content"></div>');
    update_tile(name, type);

    $("[id='"+name+"_remove']").bind('click', function() {
      hide_small_tile(name, true);
    });

    $("[id='"+name+"_title']").bind('click', function() {
      if($('.tile_expanded').css('visibility') == 'hidden'){
        draw_large_tile(name, type);
      }
    });

    //Setup updaters
    clearInterval(tile_updaters[name]);
    if(data['update'] == 'true'){
      $("div[id='"+name+"']").bind('focusin', function(){
        var updater = tile_updaters[name];
        window.clearInterval(updater);
      });

      $("div[id='"+name+"']").bind('focusout', function(){
        clearInterval(tile_updaters[name]);
        tile_updaters[name] = setInterval(function(){
          update_tile(name, type);
        }, 5000);
      });
      
      clearInterval(tile_updaters[name]);
      tile_updaters[name] = setInterval(function(){
        update_tile(name, type);
      }, 5000);
    }
  });
}


/*
Function to hide the small tiles.
Also adds the tile to the bottom bar.
*/
function hide_small_tile(name, persistent){
  clearInterval(tile_updaters[name]);
  $("#"+name).remove();
  if(persistent == true){
    add_hidden_tile(name);
    $.get("/includes/api/tile_handler.php?action=hide_tile&tile="+name);
  }
}


/*
Populate the hidden bar with hidden tiles.
*/
function populate_hidden_tiles(){

  $.get("/includes/api/tile_handler.php", {action: "get_hidden_tiles"})
  .done(function( data ) {
    if(data != "none"){
      var tiles = jQuery.parseJSON(data);
      tiles.forEach(function(tile){
        add_hidden_tile(tile);
      });  
    }
  })
  .fail(function(){populate_hidden_tiles();});
}


/*
TODO
*/
function add_hidden_tile(tile){
  if($("#"+tile+"_hidden").length != 0){
    return false;
  }
  $(".hidden_bar").append("<div class='hidden_bar_item' id='"+tile+"_hidden'>"+tile+"</div>");
  $("[id='"+tile+"_hidden']").bind('click', function() {
    $.ajaxSetup({async:false});
    $.get("/includes/api/tile_handler.php?action=unhide_tile&tile="+tile);
    $.ajaxSetup({async:true});
    $("[id='"+tile+"_hidden']").remove();
    load_tiles();
  });
}


/*
Function to load and update a tiles content
*/
function update_tile(name, type, data){
  $.get('/components/'+type+'/'+name+'/handler.php', {action: "update_small_tile"}, function(data){
    $("div[id='"+name+"'] .tile_content").html(data);
  });
}

/*
TODO
*/
function refresh_small(name, type){
  update_tile(name, (type == 'sys' ? "system" : "infusions"), "");
}


/*
TODO
*/
function popup(message){
  $('.popup_content').html(message);
  $('.popup').css('visibility', 'visible');
}


/*
TODO
*/
function close_popup(){
  $('.popup').css('visibility', 'hidden');
  $('.popup_content').html('');
}


/*
TODO
*/
function draw_large_tile(name, type, data){
  $("div[id='"+name+"']").css('box-shadow', 'none');
  $('.tile_expanded').css('visibility', 'visible');
  $('.tile_expanded').html('<center><div class="entropy">Entropy bunny is working..</div><div class="entropy" id="1"><pre>(\\___/)\n(=\'.\'=)\n(")_(")</div><div class="entropy" id="2" style="display: none"><pre> /)___(\\ \n(=\'.\'=)\n(")_(")</div><script type="text/javascript">$(function (){interval = setInterval(function(){$(".entropy#1").toggle(); $(".entropy#2").toggle();}, 200);});</script>');
  $.get('/components/'+type+'/'+name+'/handler.php?'+data, {action: "get_large_tile"}, function(data){
    clearInterval(interval);
    $('.tile_expanded').html('<a id="close" href="JAVASCRIPT: hide_large_tile()">[X]</a>'+data);
  });
}

/*
TODO
*/
function hide_large_tile(){
  $('.tile_expanded').html(' ');
  $('.tile_expanded').css('visibility', 'hidden');
}


/*
TODO
*/
function setup_key_handerls(){
  //This handler listens for the escape key
  $(document).keyup(function(e){
    if(e.keyCode == 27){
      if($(".popup").css('visibility') !== 'hidden'){
        close_popup();
      }else{
        hide_large_tile();
      }
    }
  });
}


/*
TODO
*/
function setup_window_listeners(){
  //This handler listens for any change in the URLs hash values
  handle_hash_change(window.location.hash);
  $(window).on('hashchange', function() {
    handle_hash_change(window.location.hash);
  });
}


/*
TODO
*/
function handle_hash_change(hashValue){
  //[0]:type - [1]:infusion_name - [2]:action - [3]:data - [4]:callback_function 
  var hash_array = hashValue.replace(/#/g, '').split('/');
  if(hash_array.length == 5){
    //Correct size, carry on
    $.ajaxSetup({async:false});
    if(hash_array[0] == "usr"){
      $.get('/components/infusions/'+hash_array[1]+'/functions.php?'+hash_array[2]+'='+hash_array[3], function(data){
        try{
          window[hash_array[4]](data);
        }catch(err){
          console.log("Function not found");
        }
      });
    }else if(hash_array[0] == "sys"){
      $.get('/components/system/'+hash_array[1]+'/functions.php?'+hash_array[2]+'='+hash_array[3], function(data){
        try{
          window[hash_array[4]](data);
        }catch(err){
          console.log("Function not found");
        }
      });
    }
    $.ajaxSetup({async:true});
  }

  //reset url so that we can call the same link again.
  window.location='#';
}


/*
Function to AJAXify any Forms over POST.
Handles any normal input, files, checkboxes appropriately.
*/
$.fn.AJAXifyForm = function(funct){
  this.each(function(i,el){
    var formData = new FormData();
    var checkbox_array = new Array();

    $("input,select,textarea",el).each(function(i,formEl){
      if(formEl.type == "file"){
        for(x=0; x<formEl.files.length; x++){
          formData.append(formEl.name,formEl.files[x]);
        }
      }
      else if(formEl.type == "checkbox"){
        if(typeof checkbox_array[formEl.name] === "undefined"){
          if(formEl.checked){
            checkbox_array[formEl.name] = new Array();
            checkbox_array[formEl.name].push(formEl.value);
          }
        }else{
          if(formEl.checked){
            checkbox_array[formEl.name].push(formEl.value);
          }
        }
      }else{
        formData.append(formEl.name, formEl.value);
      }
    });

    if(Object.keys(checkbox_array).length != 0){
      for (var key in checkbox_array) {
        formData.append(key,checkbox_array[key]);
      }
    }

    function ajaxify(url, data, type, success){
      $.ajax({
        statusCode: {
          502: function() {
            setTimeout(function () {
              ajaxify(url, data, type, success);
            }, 750);
          }
        },
        url: url,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        async: false,
        type: type,
        success: funct
      });
    }

    ajaxify(el.action, formData, el.method, funct);

  });

return this;
}


/*
Function overriding jQuery's GET function. Handles 502 automatically.
*/
$.get=function ( url, data, callback, type ) {

if ( jQuery.isFunction( data ) ) {
  type = type || callback;
  callback = data;
  data = undefined;
}

return jQuery.ajax({
  statusCode: {
    502: function() {
      setTimeout(function () {
        $.get(url, data, callback, type);
      }, 750);
    }
  },
  url: url,
  type: 'GET',
  dataType: type,
  data: data,
  success: callback,
});
}

