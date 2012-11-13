<?php
include "header.php";
if (isset($_GET["otheruname"])) {
	$otheruname = $_GET["otheruname"];
}
?>

<style type="text/css" media="screen">
	#photo-container, #message-container {
		border-color: #89c3eb;
		border-style: solid;
		border-width: 1px;
		border-radius: 4px;
		/*        min-height: 300px;*/
		padding: 4px;
		width: auto;
		margin-top: 3px;
		margin-bottom: 3px;
		margin-left: -4%;
		margin-right: -4%;
	}
	.messagebox {
		background-color: whitesmoke;
		width: auto;
		height: 40px;
		border-radius: 8px;
		border-style: solid;
		border-width: 1px;
		border-color: #D4D1BF;
		overflow: hidden;
		transition: height 1s;
		-moz-transition: height 1s; /* Firefox 4 */
		-webkit-transition: height 1s; /* Safari and Chrome */
		-o-transition: height 1s; /* Opera */
		-ms-transition: height 1s; /* IE9 (maybe) */
	}
	.messagebox:hover {
		border-color: #0e224a;
		background-color: threedhighlight;
		height: 120px;
	}
	.photobox {
		background-color: whitesmoke;
		width: auto;
		height: 40px;
		border-radius: 8px;
		border-style: solid;
		border-width: 1px;
		border-color: #D4D1BF;
		overflow: hidden;
		transition: height 1s;
		-moz-transition: height 1s; /* Firefox 4 */
		-webkit-transition: height 1s; /* Safari and Chrome */
		-o-transition: height 1s; /* Opera */
		-ms-transition: height 1s; /* IE9 (maybe) */
	}
	.photobox:hover {
		border-color: #0e224a;
		background-color: threedhighlight;
		height: 300px;
	}
	#refresh-icon {
		width: 32px;
		height: 32px;
		display: block;
		margin-left: -4%;
		background: transparent url('../img/refresh.png') center no-repeat;
	}
	#refresh-icon:hover {
		width: 32px;
		height: 32px;
		display: block;
		margin-left: -4%;
		background: transparent url('../img/refresh_red.png') center no-repeat;
		cursor: pointer;
	}
	.photo-username, .message-username {
		display: inline-block;
		font-family: Arial, Helvetica, sans-serif;
		color: tomato;
		text-align: left;
		padding-right: 3px;
		padding-left: 15px;
		padding-bottom: 3px;
		padding-top: 15px;
	}
	.updates-photo-pname, .message-caption {
		font-family: Arial, Helvetica, sans-serif;
		color: threeddarkshadow;
		text-align: left;
		padding-right: 3px;
		padding-left: 15px;
		padding-bottom: 3px;
		padding-top: 5px;
	}
	.photo-caption, .updates-message {
		font-family: Arial, Helvetica, sans-serif;
		color: #6699ff;
		text-align: left;
		padding-right: 3px;
		padding-left: 15px;
		padding-bottom: 3px;
		padding-top: 5px;
	}
	.updates-photo-map, .updates-map {
		display: inline-block;
		font-family: Arial, Helvetica, sans-serif;
		color: #0e224a;
		text-align: left;
		padding-right: 3px;
		padding-left: 15px;
		padding-bottom: 3px;
		padding-top: 5px;
	}
	.updates-time {
		display: inline-block;
		font-family: Arial, Helvetica, sans-serif;
		color: #0e224a;
		text-align: left;
		padding-right: 3px;
		padding-left: 15px;
		padding-bottom: 3px;
		padding-top: 5px;
	}
	.updates-image {
		background-image: url("");
		background-position: center center;
		height: 150px;
		width: 150px;
		display: block;
	}

       #addFriendBtn2,#addFriendBtn{
            display: inline-block;
            text-align: center;
        vertical-align: middle;
/*    border-style: solid;
    border-width: 1px;
    border-color: #333333;*/
    border-radius:4px;
        font-size: 10px;

}
</style>
<script>
    Date.createFromMysql = function(mysql_string) {
        if( typeof mysql_string === 'string') {
            var t = mysql_string.split(/[- :]/);

            //when t[3], t[4] and t[5] are missing they defaults to zero
            return new Date(t[0], t[1] - 1, t[2], t[3] || 0, t[4] || 0, t[5] || 0);
        }

        return null;
    }

    $(document).ready(function() {
        //alert("S")
        gettopPhotos();
        gettopMessages();
        // $("#loader").hide();
        $('.updates-image').live("mouseover", function() {
            $(this).css("cursor", "pointer");
            $(this).animate({
                width : "100%",
                height : "100%"
            }, 'slow');
        });

        $('.updates-image').live("mouseout", function() {
            $(this).animate({
                width : "200px",
                height : "200px"
            }, 'slow');
        });
    })

    $("#refresh-icon").live("click", function() {
        gettopPhotos();
        gettopMessages();

    });
    function gettopMessages() {
        //  $("#loader").show();
        $("#message-container").hide("slow");
        $(".messagebox").remove();
        // $("#updates-placeholder-message").hide();
        //  $("#updates-placeholder-message").append("");
        $.ajax({
            type : 'POST',
            url : 'home_model.php',
            data : {
                'request' : 'gettopMessagesOther',
                'otherUser': <?php echo "\"$otheruname\"";
                ?>
                
            },
            success : function(output) {
                $('#updates-placeholder-message').show();
                //     $('#message-container').fadeOut("slow");
                var obj = JSON.parse(output);
                //      alert(obj);

                for(var i = 0, j = obj.length; i < j; i++) {
                    //        alert(obj[i]);
                    var row = obj[i];
                    //  var data = row[5]+ " posted a message " + row[2] +"  " + row[3] + " on " + row[1] + " at " + row[4] ;
                    var times = Date.createFromMysql(row[1]);
                    times = prettyDate(times);
                    var name = $('#updates-name').clone().attr({
                        "class" : "message-username",
                        "id" : "message-username" + i
                    }).html(row[5] + " posted a message ");

                    var caption = $('#updates-caption').clone().attr({
                        "class" : "message-caption",
                        "id" : "message-caption" + i
                    }).html(row[2]);

                    var post = $('#updates-message').clone().attr({
                        "class" : "updates-message",
                        "id" : "updates-message" + i
                    }).html(row[3]);

                    var map = $('#updates-map').clone().attr({
                        "class" : "updates-map",
                        "id" : "updates-map" + i
                    }).html("From - " + row[4]);

                    var time = $('#updates-time').clone().attr({
                        "class" : "updates-time",
                        "id" : "updates-time" + i
                    }).html(" about " + times);

                    var clone = $('#updates-placeholder-message').clone().attr({
                        "id" : "update-message-box" + i,
                        "class" : "info-container messagebox"
                    }).append(name).append(map).append(time).append(caption).append(post);
                    $(".loader").fadeOut("slow");
                    $('#message-container').append(clone);
                    $("#message-container").show("slow");
                };

                $('#updates-placeholder-message').hide();
            }
        })
    }

    function gettopPhotos() {
        //  $("#loader").show();
        $("#photo-container").hide("slow");
        $(".photobox").remove();
        // $("#updates-placeholder-message").hide();
        //  $("#updates-placeholder-message").append("");
        $.ajax({
            type : 'POST',
            url : 'home_model.php',
            data : {
                'request' : 'gettopPhotosOther',
                'otherUser': <?php echo "\"$otheruname\"";?>
            },
            success : function(output) {
                $('#updates-placeholder-photo').show();
                //     $('#message-container').fadeOut("slow");
                var obj = JSON.parse(output);
                //    alert(obj);
                for(var i = 0, j = obj.length; i < j; i++) {
                    //        alert(obj[i]);
                    var row = obj[i];
                    //  var data = row[5]+ " posted a message " + row[2] +"  " + row[3] + " on " + row[1] + " at " + row[4] ;
                    //                    array_push($outputrow,$row['pid']);0
                    //     array_push($outputrow,$row['uname']);1 done
                    //     array_push($outputrow,$row['pname']);2 done
                    //     array_push($outputrow,$row['caption']);3
                    //     array_push($outputrow,$row['photopath']);4
                    //     array_push($outputrow,$row['time']);5 done
                    //     array_push($outputrow,$row['address']);6

                    var times = Date.createFromMysql(row[5]);
                    times = prettyDate(times);
                    var name = $('#updates-photo-username').clone().attr({
                        "class" : "photo-username",
                        "id" : "photo-username" + i
                    }).html(row[1] + " uploaded a photo ");

                    var caption = $('#updates-photo-caption').clone().attr({
                        "class" : "photo-caption",
                        "id" : "photo-caption" + i
                    }).html(row[3]);

                    var pname = $('#updates-photo-pname').clone().attr({
                        "class" : "updates-photo-pname",
                        "id" : "updates-photo-pname" + i
                    }).html("Photo name :" + row[2]);

                    var map = $('#updates-photo-map').clone().attr({
                        "class" : "updates-photo-map",
                        "id" : "updates-photo-map" + i
                    }).html("From - " + row[6]);

                    var time = $('#updates-photo-time').clone().attr({
                        "class" : "updates-time",
                        "id" : "updates-time" + i
                    }).html(" about " + times);
                    var url = "url(" + row[4] + ") ";
                    var path = $('#updates-photo-image').clone().attr({
                        "class" : "updates-image",
                        "id" : "updates-image" + i
                    }).css({
                        "background-image" : url,
                        "background-size" : "100%",
                        "background-repeat" : "no-repeat"

                    });

                    var clone = $('#updates-placeholder-photo').clone().attr({
                        "id" : "update-photo-box" + i,
                        "class" : "info-container photobox"
                    }).append(name).append(map).append(time).append(pname).append(caption).append(path);
                    $(".loader").fadeOut("slow");
                    $('#photo-container').append(clone);
                    $("#photo-container").show("slow");
                };
                $('#updates-placeholder-photo').hide();
            }
        })
    }
    
    
    $("#addFriendBtn").live("click",function(){
    	//alert("hi");
    	$.ajax({
    type : 'POST',
    url : 'home_model.php',
    data : {
        'request' : 'addFriendRequest',
        'otherUser': <?php echo "\"$otheruname\"";?>
    },
    success : function(output) {
        var obj = JSON.parse(output);
        notify("Friend request successfully sent")
        $("#addFriendBtn").hide("slow");
    }
});
    });
    
    
    
</script>
<div id="updates-name"></div>
<div id="updates-caption"></div>
<div id="updates-message"></div>
<div id="updates-map"></div>
<div id="updates-time"></div>
<div id="updates-photo-username"></div>
<div id="updates-photo-map"></div>
<div id="updates-photo-time"></div>
<div id="updates-photo-caption"></div>
<div id="updates-photo-pname"></div>
<div id="central_container">
	<center>
		<h2>Profile of user
		<div id="otheruname-div" style="display: inline-block">
			<?php echo "$otheruname";?>
                    <?php if(!isFriend($uname,$otheruname) && !requestSent($uname,$otheruname) ){?>
                    <input type="button" id="addFriendBtn" value="Add Friend"/>
                    <?php }else if(!isFriend($uname,$otheruname) && requestSent($uname,$otheruname)){?>
                   <input type="button" id="addFriendBtn2" value="Friend Request Sent" disabled="true"/>
                    <?php } ?>
                </div></h2>
	</center>
	<div id="refresh-icon"></div>
	<div id="photo-container">
		<center>
			<h3>Photos</h3>
		</center>
		
		<div id="updates-placeholder-photo" class="info-container"></div>
	</div>
	<div id="message-container">
		<center>
			<h3>Messages</h3>
		</center>
	
		<div id="updates-placeholder-message" class="info-container">
			<div id="updates-photo-image"/>
		</div>
	</div>
	<div id="updates-placeholder-location" class="info-container">
		<div id="updates-photo-username"></div>
		<div id="updates-photo-map"></div>
		<div id="updates-photo-time"></div>
	</div>
</div>
<?php
include 'leftnavbar.php';
?>
</div>
</body> </html>