/**
 * @author jake
 */
$(document).ready(function(){
 //alert("S")
    $("#notification_container").hide(0);
     
})

function gotoLocation(pagename) {
    window.location.href = pagename;
}

// if (navigator.geolocation) {
// navigator.geolocation.getCurrentPosition(function(position) {
// var latLng = new google.maps.LatLng(
// position.coords.latitude, position.coords.longitude);
// var marker = new google.maps.Marker({position: latLng, map: map});
// map.setCenter(latLng);
// }, errorHandler);
// }

/*
* All functions related to make_circles.php
*/
// Function for displaying circles with a post request
$.ajax({
    type : 'POST',
    url : 'user_circles_model.php',
    data : {
        'request' : 'getcircle'
    },
    success : function(output) {
        var obj = JSON.parse(output);

        for(var i = 0, j = obj.length; i < j; i++) {
            //  var b =

            $('#user-circles-container').append(($('#user-circle-placeholder').clone().attr({
                "id" : "user-circle-" + i,
                "class" : "user-circles"
            }).html(obj[i])));
        };
        $('#user-friends-container').hide();
    //$('#user_actions_container').hide();
    }
});

// remove selected friends on click of remove button
$("#user-action-remove-friends-btn").live("click", function() {
    var result = [];
    var i = 0;
    $(".ui-selected").each(function() {
        var index = $(this).html();
        result[i] = index;
        i++;
        $(this).fadeOut(300, function() {
            $(this).remove();
        });
    //    result.append( " #" + ( index + 1 ) );
    });
    if(result.length == 0){
        notify("Please Select some friends to remove");
    }else{
        removeFriendFromCircle(result);
    }//  alert(result);
});
function removeFriendFromCircle(result) {
    //alert("a"+result);
    $.ajax({
        type : 'POST',
        url : 'user_circles_model.php',
        data : {
            'request' : 'removeFriendFromCircle',
            'friendList' : result,
            'circlename':window.circlename
        },
        success : function(output) {
            //     $('#user-friend_placeholder').hide();
            //   $('#user-friends-container').effect('explode').hide();
            // replace this with a nice div tag
       //     alert(output);
            if(output){
                notify("Friend removed Successfully");
            }else{
                notify("Error removing friends");
            }
        }
    })
}


$(".user-circles").live("click", function() {
    $('#user_actions_container').fadeIn("slow");
    $('div[id^="user-friend-"]').remove();
    var circleName = $(this).html();
    window.circlename = circleName;
    $('#user-friends-container').hide();
    getFriendsInCircle(circleName);
    var text = "";
    $('#user-friends-container').removeData();
    $('#user-friends-container h2').html("Friends in Circle "+circleName);
    $('#user-friend_placeholder').show();
    $("#user-friends-container").selectable({
        stop : function() {
            var result = [];
            var i = 0;
            $(".ui-selected", this).each(function() {
                var index = $(this).html();
                //   alert(index);
                result[i] = index;
                i++;
            //    result.append( " #" + ( index + 1 ) );
            });
        // alert(result);
        }
    });

});
function getFriendsInCircle(circlename) {
    $.ajax({
        type : 'POST',
        url : 'user_circles_model.php',
        data : {
            'request' : 'getFriends',
           'circle':circlename
        },
        success : function(output) {

            //     $('#user-friend_placeholder').hide();
            //   $('#user-friends-container').effect('explode').hide();
            //alert(output);
            var obj = JSON.parse(output);
          //  alert(obj);
            for(var i = 0, j = obj.length; i < j; i++) {
                 //        alert(obj[i]);
                $('#user-friends-container').append(($('#user-friend_placeholder').clone().attr({
                    "id" : "user-friend-" + i,
                    "class" : "user-friend"
                }).html(obj[i])));
            };
            $('#user-friends-container').show("normal");

        }
    })
}

// add friends to circle 

$("#user-action-add-friends-btn").live("click",function(){
    $(".user-friend").remove();
    var circlename  = window.circlename;
    if(circlename == null){
        notify("Please Select a circle to add friends to");
        return;
    }
    $("#user-friends-container h2").html("Add more Friends in Circle " + circlename);
   
   
    //$("#user-action-remove-friends-btn").hide();
    // $(this).parent().parent().hide();
    $.ajax({
        type : 'POST',
        url : 'user_circles_model.php',
        data : {
            'request' : 'getFriendsNotInCircle',
            'circle':circlename
        },
        success : function(output) {
       //   alert(output);
            var addBtn = document.createElement('button');            
            addBtn.setAttribute("class","add-friend-btn");            
            var obj = JSON.parse(output);
            for(var i = 0, j = obj.length; i < j; i++) {
                //          alert(obj[i]);
                var btnid =  "user-friend-btn-"+i ;
                addBtn.setAttribute("id",btnid);
                var addBtnDup = $(addBtn).clone();
                var placeholder = $("#user-friend_placeholder").clone();
                //placeholder.html("");
                $('#user-friends-container').append(($(placeholder).clone().attr({
                    "id" : "user-friend-" + i,
                    "class" : "user-friend"
                }).html(obj[i]).append(addBtnDup)));
            }
            $('#user-friends-container').show("normal");

        }
    })
   
});


// add friend when u click on him
$('.add-friend-btn').live("click",function(){    
    var frndName = $(this).parent().text();
    var circlename  = window.circlename;
    var success ;
 //   alert(circlename);
    //  alert(frndName);
    $.ajax({
        type : 'POST',
        url : 'user_circles_model.php',
        data : {
            'request' : 'addfriend' ,
            'friend':frndName,
            'circle':circlename
        },
        success : function(output) {
       //     alert(output);
            notify("Successfully added " + frndName +" to circle "+circlename);
            success = true;
        //      $('div[id^="user-friend-"]').parent().hide();
        }
    })
    //  if(success){
    $(this).parent().hide();
//   }
    
    
})



function notify(data){
    //$("#notification_container").removeData();
    $("#notification_container").hide();
    $("#notification_container").html(data).fadeIn(1000);      
    
    $("#notification_container").html(data).fadeOut(1000);    
}


// Script for dialog in circles 

$(function() {
    // a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
    $( "#dialog:ui-dialog" ).dialog( "destroy" );
		
    var name = $( "#new-circle-name" ),			
     allFields = $( [] ).add( name ),
    tips = $( ".validateTips" );
// 
     function updateTips( t ) {
        tips.text( t )
        .addClass( "ui-state-highlight" );
        setTimeout(function() {
            tips.removeClass( "ui-state-highlight", 1500 );
        }, 500 );
     }

    function checkLength( o, n, min, max ) {
        if ( o.val().length > max || o.val().length < min ) {
            o.addClass( "ui-state-error" );
            updateTips( "Length of " + n + " must be between " +
                min + " and " + max + "." );
            return false;
        } else {
            return true;
        }
    }
     
    $( "#dialog-form" ).dialog({
        autoOpen: false,
        height: 300,
        width: 350,
        modal: true,
        
        buttons: {
            
            "Create Circle": function() {
                var bValid = true;
                allFields.removeClass( "ui-state-error" );
               //  alert();
               // bValid = bValid && checkLength( name, "new-circle-name", 3, 40 );
                //bValid = true;			
          //  name = $("#new-circle-name");
        //        if ( name.val() > 0 ) {
           //   window.newCircleName = name;
                      addNewCircle(name.val()); 
                   
                      $( this ).dialog( "close" );
                     
                  
              //  }
            },
            Cancel: function() {
                $( this ).dialog( "close" );
            }
        },
        close: function() {
            allFields.val( "" ).removeClass( "ui-state-error" );
        }
    });

    $( "#user-action-new-circle-btn" )
    .button()
    .click(function() {
        $( "#dialog-form" ).dialog( "open" );
    });
});


function addNewCircle(name){
   //var name = $("#new-circle-name").text();
   // alert(name);
    $.ajax({
        type : 'POST',
        url : 'user_circles_model.php',
        data : {
            'request' : 'createCircle' ,
            'circlename':name
        },
        success : function(output) {
            alert(output)
            notify("Successfully created circle " + name + output);
           // success = true;
        //      $('div[id^="user-friend-"]').parent().hide();
        }
    })
    
    
    
}


// function to send a post request
function post_to_url(path, params, method) {
    method = method || "post"; // Set method to post by default, if not specified.

    // The rest of this code assumes you are not using a library.
    // It can be made less wordy if you use one.
    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);

    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);

            form.appendChild(hiddenField);
         }
    }
    document.body.appendChild(form);
    form.submit();
};



// search button onclick function 

$("#search_btn").live("click",function(){
    var searchFor = $( "#search_box" ).val();
    var data = new Array() ;
    data["searchFor"] = searchFor;
//    alert(searchFor);
  //  alert("asdf");  
  if(searchFor!=null && searchFor != ""){
  post_to_url("search_results.php",data,"get");
  }
});



//function prettyDate(date_str){
//    var time_formats = [
//    [60, 'just now', 1], // 60
//    [120, '1 minute ago', '1 minute from now'], // 60*2
//    [3600, 'minutes', 60], // 60*60, 60
//    [7200, '1 hour ago', '1 hour from now'], // 60*60*2
//    [86400, 'hours', 3600], // 60*60*24, 60*60
//    [172800, 'yesterday', 'tomorrow'], // 60*60*24*2
//    [604800, 'days', 86400], // 60*60*24*7, 60*60*24
//    [1209600, 'last week', 'next week'], // 60*60*24*7*4*2
//    [2419200, 'weeks', 604800], // 60*60*24*7*4, 60*60*24*7
//    [4838400, 'last month', 'next month'], // 60*60*24*7*4*2
//    [29030400, 'months', 2419200], // 60*60*24*7*4*12, 60*60*24*7*4
//    [58060800, 'last year', 'next year'], // 60*60*24*7*4*12*2
//    [2903040000, 'years', 29030400], // 60*60*24*7*4*12*100, 60*60*24*7*4*12
//    [5806080000, 'last century', 'next century'], // 60*60*24*7*4*12*100*2
//    [58060800000, 'centuries', 2903040000] // 60*60*24*7*4*12*100*20, 60*60*24*7*4*12*100
//    ];
//   // var time = ('' + date_str).replace(/-/g,"/").replace(/[TZ]/g," ").replace(/^\s\s*/, '').replace(/\s\s*$/, '');
//   // if(time.substr(time.length-4,1)==".") time =time.substr(0,time.length-4);
//    var seconds = (new Date - new Date(date_str)) / 1000;
//    var token = 'ago', list_choice = 1;
//    if (seconds < 0) {
//        seconds = Math.abs(seconds);
//        token = 'from now';
//        list_choice = 2;
//    }
//    var i = 0, format;
//    while (format = time_formats[i++])
//        if (seconds < format[0]) {
//            if (typeof format[2] == 'string')
//                return format[list_choice];
//            else
//                return Math.floor(seconds / format[2]) + ' ' + format[1] + ' ' + token;
//        }
//    return time;
//};
function prettyDate(time){
	//var date = new Date((time || "").replace(/-/g,"/").replace(/[TZ]/g," ")),
        var date = time ;	
	diff = (((new Date()).getTime() - date.getTime()) / 1000),
		day_diff = Math.floor(diff / 86400);
			
	if ( isNaN(day_diff) || day_diff < 0 || day_diff >= 31 )
		return;
			
	return day_diff == 0 && (
			diff < 60 && "just now" ||
			diff < 120 && "1 minute ago" ||
			diff < 3600 && Math.floor( diff / 60 ) + " minutes ago" ||
			diff < 7200 && "1 hour ago" ||
			diff < 86400 && Math.floor( diff / 3600 ) + " hours ago") ||
		day_diff == 1 && "Yesterday" ||
		day_diff < 7 && day_diff + " days ago" ||
		day_diff < 31 && Math.ceil( day_diff / 7 ) + " weeks ago";
}

$("#friend_requests").live("click",function(){
    gotoLocation("friend_requests.php");
})
