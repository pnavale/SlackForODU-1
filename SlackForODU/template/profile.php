<?php include 'includes/htmlheader.php';
if (!isset($_SESSION)) {
    session_start();
}
if (!$_SESSION['wkid']) {
    header("Location: wklogin.php");
}
?>
<div class="row"> 
<div class="col-sm-12 col-md-3 col-lg-3 col-xs-12">
<div class="short-profile" style="border:1px;padding-left:5%;background-color: #0E76BD;">
    <div class="row"> 
        <!-- Display profile picture. -->
        <div class="col-sm-4 col-md-4 col-lg-4 col-xs-4">
            <img class="profile-img">
        </div>
        <!-- Display username. -->
        <div class="col-sm-8 col-md-8 col-lg-8 col-xs-8">
            <span class="username"></span>
        </div>
    </div>
    <div class="row">
    <!-- Add button to show private channels. -->    
    <a type="button" href="#" class="private_channel" style="color:black;">Show private channel</a>
    </div>
    <!-- Display subscribed channels with channel type. -->
    <div class="channels">
        <div class="row channel-list">
        </div>
    </div>
</div>
</div>
 <div class="col-sm-0 col-md-9 col-lg-9 col-xs-0">
<div class="statContainer">    
<a class="nounderline" title="Channels">
<div class="statBubbleContainer col-sm-2 col-md-4 col-lg-4 col-xs-2">
<div class="statBubble websitesLaunched">
  <div class="statNum" id="channel-metric">
  50+
  </div>
</div>
  <h3>Channels</h3>
</div>
</a>

<a class="nounderline" title="Users">
<div class="statBubbleContainer col-sm-2 col-md-4 col-lg-4 col-xs-2">
<div class="statBubble teamSize">
  <div class="statNum" id="member-metric">
  3
  </div>
</div>
  <h3>Users</h3>
</div>
</a>

<a class="nounderline" title="Posts">
<div class="statBubbleContainer col-sm-2 col-md-4 col-lg-4 col-xs-2">
<div class="statBubble topSEORank">
  <div class="statNum" id="member-metric">
  3
  </div>
</div>
  <h3>Posts</h3>
</div>
</a>  

  
  <a class="nounderline" href="#" title="Reactions">
<div class="statBubbleContainer col-sm-2 col-md-4 col-lg-4 col-xs-2">
<div class="statBubble facebookLikes">
  <div class="statNum" id="reaction-metric">
  132
  </div>
</div>
  <h3>Reactions</h3>
</div>
</a>
</div>
</div>
</div>

<script type="text/javascript">
    // Function to go to change profile picture page.
    $('.profile-img').on('click', function(e) {
        window.location.href ="changeProfilePic.php";
        })
    // Function for button to show private channels.
     $('.private_channel').on('click', function(e) {
        $('.private').css('display','block');
        })
    // Setting user profile data
    function setData(userProfile) {
         var channelDiv ='';
        $.ajax({
            type: 'GET',
            url: 'verifyProfile.php?userProfile=' + userProfile,
            data: '',
            success: function(response) {
                var dateStr = '';
                console.log(response);
                // Getting profile picture.
                $.each( response['userInfo'], function( key, user ) {
                  var userImg='';
                         if(user['image']){
                         userImg="data:image/jpeg;base64,"+user['image'];
                         }else{
                          userImg="../image/person.png";
                         }
                        $('.profile-img').attr('src',userImg);
                        $('.username').html(user['username']);
                });
                // Getting channel names and channel types.
                channelDiv= $('.channel-list').clone();
                $('#channel-metric').html(response['channels'].length);
                $('#member-metric').html(response['users'].length);
                $('#reaction-metric').html(response['reactions'].length);
                $.each( response['channels'], function( key, channel ) {
                        if(channel['channel_type']=='public'){
                            channelDiv.append('<div class="col-sm-6 col-md-6 col-lg-6 col-xs-6">'+channel['channel_name']+'</div>');
                            channelDiv.append('<div class="col-sm-6 col-md-6 col-lg-6 col-xs-6">'+channel['channel_type']+'</div>');
                        }else{
                            channelDiv.append('<div class="col-sm-6 col-md-6 col-lg-6 col-xs-6 private" style="display:none;">'+channel['channel_name']+'</div>');
                            channelDiv.append('<div class="col-sm-6 col-md-6 col-lg-6 col-xs-6 private" style="display:none;">'+channel['channel_type']+'</div>');
                        }
                         $('.channels').append(channelDiv);   
                     
                });
                
            }
        });
    }
   
    setData(location.search.substring(10,location.search.length));
</script>
