<?php
include 'includes/db_connection.php';
include 'includes/htmlheader.php';
if (!isset($_SESSION)) {
    session_start();
}
if (!$_SESSION['wkid']) {
    header("Location: wklogin.php");
}
?>
<a href="member.php" class="pull-right">Go to Main Page</a>
<div class="login-container" style="width:500px">
<h4>Channel Details:</h4>
<br><br>
<div class="row">
	<div class="col-sm-3 col-md-3 col-lg-3 col-xs-3 ">
	<p>Channel Name :</p>
	</div>
	<div class="col-sm-9 col-md-9 col-lg-9 col-xs-9 channel-name">	
	</div>
</div>

<div class="row">
	<div class="col-sm-3 col-md-3 col-lg-3 col-xs-3">
		<p>Channel Type :</p>
	</div>
	<div class="col-sm-9 col-md-9 col-lg-9 col-xs-9 channel-type">	
	</div>
</div>
<div class="row">
  <div class="col-sm-3 col-md-3 col-lg-3 col-xs-3">
    <p>Channel Archived :</p>
  </div>
  <div class="col-sm-9 col-md-9 col-lg-9 col-xs-9 channel-archived">  
  </div>
</div>
<div class="row">
  <div class="col-sm-3 col-md-3 col-lg-3 col-xs-3">
    <p>Users :</p>
  </div>
  <div class="col-sm-9 col-md-9 col-lg-9 col-xs-9 users" style="word-wrap: break-word;">  
  </div>
</div>
<br><br>
<?php if($_SESSION['sess_user']== 'admin'){
	echo "<div class='row change-mem'><button class='change-membership'>Change Membership</button></div>";
}
?>
<br><br>
<div class="row">
<div class="ui-widget">
  <label for="tags">Invite people to join this channel: </label>
  <input id="tags" size="50" style="border: 1px solid;width: 95%"><br><br>
  <input id="invite" value="Invite" type="submit"/><br><br>
  <?php if($_SESSION['sess_user']== 'admin'){
	echo "<input id='add' value='Add user directly' type='submit'/>";
}
?>
</div>

</div>
<br><br>
  <?php if($_SESSION['sess_user']== 'admin'){
	echo "<div class='row'>";
	echo "<div class='ui-widget'>";
	echo "<label for='tagsR'>Remove people from this channel: </label>";
  echo "<input id='tagsR' size='50' style='border: 1px solid;width: 95%'><br><br>";
  echo "<input id='remove' value='Remove' type='submit'></div></div>";

  echo "<br><br><div class='row'>";
  echo "<input type='submit' class='archive' value='Archive'></div>";

}
?>
<div><p class="msg"></p></div>
</div>

   <script >
    var availableTags = [];
    var uninvitedlist = '';
    var availableTagsR = [];
    var joinedlist = '';
    var addList='';
    var removeList='';
    var chDetails=location.search.substring(11,location.search.length);
    function setData(chDetails) {
        $.ajax({
            type: 'GET',
            url: 'viewChannelDetailData.php?chDetails=' + chDetails,
            data: '',
            success: function(response) {
                console.log(response);
                $.each( response['channelDetail'], function( key, channel ) {
                         console.log(channel);
                         $('.channel-name').html(channel['channel_name']);
                         $('.channel-type').html(channel['channel_type']);
                         if (channel['joined'].substring(channel['joined'].length-1) == ",")
                          {
                            channel['joined'] = channel['joined'].substring(0, channel['joined'].length-1);
                          }else if(channel['joined'].substring(0,1) == ","){
                            channel['joined'] = channel['joined'].substring(1, channel['joined'].length);
                          }
                         $('.users').html(channel['joined']);
                         if(channel['archived']==1){
                          $('.channel-archived').html('Yes');
                          $('.archive').val('Unarchive');
                         }else{
                          $('.channel-archived').html('No');
                          $('.archive').val('Archive');
                         }

                         if(channel['channel_type']=='public'){
                         	$('.change-mem').html('');
                         }
                         uninvitedlist=channel['uninvited'];
                         joinedlist=channel['joined'];
                         console.log(joinedlist);
                         /*if(channel['channel_name'] == 'general' || channel['channel_name'] == 'random'){
                         	$('.ui-widget').html('');
                         	$('.ui-widget').append('<p>No invite need for this channel.</p>');
                         }*/
                
            })
                	function stringToArray(uninvitedlist){
                	if(uninvitedlist.indexOf(',') != -1){
                			if(uninvitedlist.indexOf(',')==0){
                				uninvitedlist = uninvitedlist.slice(uninvitedlist.indexOf(',')+1,uninvitedlist.length);
                			}
                			else{
                				availableTags.push(uninvitedlist.substring(0,uninvitedlist.indexOf(',')));
                				uninvitedlist = uninvitedlist.slice(uninvitedlist.indexOf(',')+1,uninvitedlist.length);
                			}
                			stringToArray(uninvitedlist);
                	}else if(uninvitedlist.length > 1){
                			availableTags.push(uninvitedlist.substring(0,uninvitedlist.length));
                	}
                }
                	stringToArray(uninvitedlist);
                	console.log(availableTags);
                    $( function() {
					    

					    function split( val ) {
					      return val.split( /,\s*/ );
					    }
					    function extractLast( term ) {
					      return split( term ).pop();
					    }
					 
					    $( "#tags" )
					      // don't navigate away from the field on tab when selecting an item
					      .on( "keydown", function( event ) {
					        if ( event.keyCode === $.ui.keyCode.TAB &&
					            $( this ).autocomplete( "instance" ).menu.active ) {
					          event.preventDefault();
					        }
					      })
					      .autocomplete({
					        minLength: 0,
					        source: function( request, response ) {
					          // delegate back to autocomplete, but extract the last term
					          response( $.ui.autocomplete.filter(
					            availableTags, extractLast( request.term ) ) );
					        },
					        focus: function() {
					          // prevent value inserted on focus
					          return false;
					        },
					        select: function( event, ui ) {
					          var terms = split( this.value );
					          // remove the current input
					          terms.pop();
					          // add the selected item
					          terms.push( ui.item.value );
					          // add placeholder to get the comma-and-space at the end
					          terms.push( "" );
					          this.value = terms.join( ", " );
					          addList=this.value;
					          return false;
					        }
					      });
					  } );


                    function stringToArrayR(joinedlist){
                	if(joinedlist.indexOf(',') != -1){
                			if(joinedlist.indexOf(',')==0){
                				joinedlist = joinedlist.slice(joinedlist.indexOf(',')+1,joinedlist.length);
                			}
                			else{
                				availableTagsR.push(joinedlist.substring(0,joinedlist.indexOf(',')));
                				joinedlist = joinedlist.slice(joinedlist.indexOf(',')+1,joinedlist.length);
                			}
                			stringToArrayR(joinedlist);
                	}else if(joinedlist.length > 1){
                			availableTagsR.push(joinedlist.substring(0,joinedlist.length));
                	}
                }
                	stringToArrayR(joinedlist);
                	console.log(availableTagsR);
                    $( function() {
					    

					    function split( val ) {
					      return val.split( /,\s*/ );
					    }
					    function extractLast( term ) {
					      return split( term ).pop();
					    }
					 
					    $( "#tagsR" )
					      // don't navigate away from the field on tab when selecting an item
					      .on( "keydown", function( event ) {
					        if ( event.keyCode === $.ui.keyCode.TAB &&
					            $( this ).autocomplete( "instance" ).menu.active ) {
					          event.preventDefault();
					        }
					      })
					      .autocomplete({
					        minLength: 0,
					        source: function( request, response ) {
					          // delegate back to autocomplete, but extract the last term
					          response( $.ui.autocomplete.filter(
					            availableTagsR, extractLast( request.term ) ) );
					        },
					        focus: function() {
					          // prevent value inserted on focus
					          return false;
					        },
					        select: function( event, ui ) {
					          var terms = split( this.value );
					          // remove the current input
					          terms.pop();
					          // add the selected item
					          terms.push( ui.item.value );
					          // add placeholder to get the comma-and-space at the end
					          terms.push( "" );
					          this.value = terms.join( ", " );
					          removeList=this.value;
					          return false;
					        }
					      });
					  } );

    }
    });
   }

   $('.archive').click(function() {
      $.ajax({
                type: 'GET',
                url: 'viewChannelDetailData.php?chDetails=' + chDetails,
                data: { archive: true },
                success: function(response) {
                    $('.msg').html(response.msg);
                    window.location.reload();
                }
            });
    });
   $('#add').click(function() {
   		console.log(addList);
   		$.ajax({
                type: 'GET',
                url: 'viewChannelDetailData.php?chDetails=' + chDetails,
                data: { addList: addList },
                success: function(response) {
                    $('.msg').html(response.msg);
                    window.location.reload();
                }
            });
   	});
   $('#invite').click(function() {
   		console.log(addList);
   		$.ajax({
                type: 'GET',
                url: 'viewChannelDetailData.php?chDetails=' + chDetails,
                data: { inviteList: addList },
                success: function(response) {
                    $('.msg').html(response.msg);
                    window.location.reload();
                }
            });
   	});
   $('#remove').click(function() {
   		console.log(removeList);
   		$.ajax({
                type: 'GET',
                url: 'viewChannelDetailData.php?chDetails=' + chDetails,
                data: { removeList: removeList },
                success: function(response) {
                	$('.msg').html(response.msg);
                  window.location.reload();
                    
                }
            });
   	});
   $('.change-membership').click(function() {
      $chType= $('.channel-type').html();
      if($chType=='public'){
        $chType="private";
      }else{
        $chType="public";
      }
      $.ajax({
                type: 'GET',
                url: 'viewChannelDetailData.php?chDetails=' + chDetails,
                data: { changeMem: $chType },
                success: function(response) {
                  $('.msg').html(response.msg);
                  window.location.reload();
                    
                }
            });
    });

   
   console.log(location.search.substring(11,location.search.length));
   setData(location.search.substring(11,location.search.length));


   </script>
