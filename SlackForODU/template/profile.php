<?php include 'includes/htmlheader.php';
if (!isset($_SESSION)) {
    session_start();
}
if (!$_SESSION['wkid']) {
    header("Location: wklogin.php");
}
?>
<a href="member.php" class="pull-right">Go to Main Page</a>
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
            <span class="username"></span><br>
            <span class="userType"></span>
        </div>
    </div>
    <div class="row">
    <!-- Add button to show private channels. -->    
    <a type="button" href="#" class="private_channel" style="color:black;">Show private channel(s)</a>
    </div>
    <!-- Display subscribed channels with channel type. -->
    <div class="row channels">
        <div class="channel-list">
        </div>
    </div>
     <div class="row">
    
    </div>
</div>
</div>
 <div class="col-sm-0 col-md-9 col-lg-9 col-xs-0">
<div class="statContainer">    
<a class="nounderline" title="Channels">
<div class="statBubbleContainer col-sm-2 col-md-4 col-lg-4 col-xs-2">
<div class="statBubble websitesLaunched">
  <div class="statNum" id="channel-metric">
  50
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
  <div class="statNum" id="posts-metric">
  0
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
<div class="container" style="margin-top: 60px;">
  <div class="row">                   
        <div class="progress">
            <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;" id="channel-percent-div">
                <span class="sr-only" style="font-size:13px;">60% Complete</span>
            </div>
            <span class="progress-type" style="font-size:13px;">Channels subscribed</span>
            <span class="progress-completed" style="font-size:13px;" id="channel-percent">60%</span>
        </div>
        <div class="progress">
            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%" id="post-percent-div">
                <span class="sr-only">40% Complete (success)</span>
            </div>
            <span class="progress-type" style="font-size:13px;">Posts posted</span>
            <span class="progress-completed" style="font-size:13px;" id="post-percent">40%</span>
        </div>
        <div class="progress">
            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%" id="react-percent-div">
                <span class="sr-only">20% Complete (info)</span>
            </div>
            <span class="progress-type" style="font-size:13px;">Reactions added</span>
            <span class="progress-completed" style="font-size:13px;" id="react-percent">20%</span>
        </div>
         <div class="progress">
            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%" id="user-percent-div">
                <span class="sr-only">60% Complete (warning)</span>
            </div>
            <span class="progress-type" style="font-size:13px;" id="user-type"></span>
            <span class="progress-completed" id="user-percent" style="font-size:13px;">60%</span>
        </div>

  </div>
</div>
<script type="text/javascript">
 var privateCount=0;
 var currentUser='';
    // Function for button to show private channels.
     $('.private_channel').on('click', function(e) {
      if(privateCount%2==0){
        $('.private').css('display','block');
      }else{
        $('.private').css('display','none');
      }

        })
    // Setting user profile data
    function setData(userProfile) {
         var channelDiv ='';
        $.ajax({
            type: 'GET',
            url: 'verifyProfile.php?userProfile=' + userProfile,
            success: function(response) {
                var dateStr = '';
                console.log(response);
                // Getting profile picture.
                $.each( response['users'], function( key, user ) {
                  var userImg='';
                  if(user['username']==userProfile){
                         if(user['image']){
                         userImg="data:image/jpeg;base64,"+user['image'];
                         }else{
                          userImg="../image/person.png";
                         }
                        $('.profile-img').attr('src',userImg);
                        $('.username').html(user['username']);
                      currentUser=response['sess_user'];
                        if(response['sess_user']!=user['username']){
                          console.log('here');
                          $('.private_channel').html('');
                        }
                        
                      }
                });
                // Getting channel names and channel types.
                $('.channel-list').html('');
                channelDiv= $('.channel-list');
                $('#channel-metric').html(response['channels'].length);
                $('#member-metric').html(response['users'].length);
                $('#posts-metric').html(response['users'].length);
                $('#reaction-metric').html(response['reactions'].length);
                $.each( response['channels'], function( key, channel ) {
                        if(channel['channel_type']=='public'){
                            channelDiv.append('<div class="col-sm-6 col-md-6 col-lg-6 col-xs-6">'+channel['channel_name']+'</div>');
                            channelDiv.append('<div class="col-sm-6 col-md-6 col-lg-6 col-xs-6">'+channel['channel_type']+'</div>');
                        }else{
                            channelDiv.append('<div class="col-sm-6 col-md-6 col-lg-6 col-xs-6 private" style="display:none;color:#CA6F1E;">'+channel['channel_name']+'</div>');
                            channelDiv.append('<div class="col-sm-6 col-md-6 col-lg-6 col-xs-6 private" style="display:none;color:#CA6F1E;">'+channel['channel_type']+'</div>');
                        }
                         $('.channels').append(channelDiv);   
                     
                });

               $('#post-percent-div').css('width',response['postPercent']);
                $('#post-percent').html(response['postPercent']+'%');
                $('#channel-percent-div').css('width',response['channelPercent']);
                $('#channel-percent').html(response['channelPercent']+'%');
                $('#react-percent-div').css('width',response['reactionPercent']);
                $('#react-percent').html(response['reactionPercent']+'%');
                $('#user-percent-div').css('width',response['totalPercent']);
                $('#user-percent').html(response['totalPercent']+'%');
                $('#user-type').html(response['userType']);
                $('.userType').html(response['userType']);
                
            }
        });
    }
   
    setData(location.search.substring(10,location.search.length));
     // Function to go to change profile picture page.
    $('.profile-img').on('click', function(e) {
        if(currentUser==$('.username').html()){
        window.location.href ="changeProfilePic.php";
        }
        })
</script>
