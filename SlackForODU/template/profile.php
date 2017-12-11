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
        <div style="color:black;" class="col-sm-8 col-md-8 col-lg-8 col-xs-8">
            <span class="username"></span><br>
            <span class="userType"></span>
        </div>
    </div>
    <div class="row">
    <!-- Add button to show private channels. -->  
    <a style="color:black;"  href="#" class="gravatar">Set your Gravatar pic as a Profile Pic<a><br> <br> 
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
  0
  </div>
</div>
  <h3>Channels</h3>
</div>
</a>

<a class="nounderline" title="Users">
<div class="statBubbleContainer col-sm-2 col-md-4 col-lg-4 col-xs-2">
<div class="statBubble teamSize">
  <div class="statNum" id="member-metric">
  0
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
  0
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
<div>
  <input type="button" id="bar-chart" class="btn btn-default" value="Show individual Distribution"/>
  <div id="myDiv"></div>
</div>
<script >
 var privateCount=0;
 var currentUser='';
 var date=dateCount=chartUsers=countUsers=[];
 var gravatarUrl=localUrl='';
    // Function for button to show private channels.
     $('.private_channel').on('click', function(e) {
      if(privateCount%2==0){
        $('.private').css('display','block');
      }else{
        $('.private').css('display','none');
      }

        })
          $('.gravatar').on('click', function(e) {
              if($('.gravatar').html()=='Set your Gravatar pic as a Profile Pic'){
                $('.profile-img').attr('src',gravatarUrl);
                $('.gravatar').html('Set your profile pic instead of gravatar');
              }else{
                $('.profile-img').attr('src',localUrl);
                $('.gravatar').html('Set your Gravatar pic as a Profile Pic')
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
                date=response['dateArray'];
                dateCount=response['postCountByDate'];
                date=date.slice(1);
                dateCount=dateCount.slice(1);
                console.log(date);
                console.log(dateCount);
                chartUsers=response['chartUsers'];
                countUsers=response['usersCount'];
                console.log(chartUsers);
                console.log(countUsers);
                var trace1 = [
                      {
                        x: date,
                        y: dateCount,
                        type: 'scatter'
                      }
                    ];
                      var layout = {
                        title: 'Active Status of You',
                        xaxis:{title: 'Date when you posted'},
                        yaxis:{title: 'Count of posts'},
                      };

                    Plotly.newPlot('myDiv', trace1, layout);
                  
                currentUser=response['user'];
                // Getting profile picture.
                $.each( response['users'], function( key, user ) {
                  var userImg='';
                    
                  if(user['username']==userProfile){
                    console.log("here",userProfile);
                    console.log(user['gravatar_exist']);
                     if(user['group_id']== "gituser"){
                        $('.gravatar').html('');
                         userImg='https://github.com/'+user['username']+'.png';
                         localUrl=userImg;
                         }else if(user['group_id']== "twitteruser"){
                        $('.gravatar').html('');
                         userImg='https://twitter.com/'+user['username']+'/profile_image?size=original';
                         localUrl=userImg;
                         }
                      else if(currentUser==userProfile && user['gravatar_exist'] && user['gravatar_want']==0){
                      userImg=user['gravatar'];
                      gravatarUrl=userImg;
                      $('.gravatar').html('Set your profile pic instead of gravatar');
                    }else if(user['image']){
                      $('.gravatar').html('');
                         userImg="data:image/jpeg;base64,"+user['image'];
                         localUrl=userImg;
                         }
                      else{
                          userImg="../image/person.png";
                          $('.gravatar').html('');
                         }
                         gravatarUrl=user['gravatar'];
                         localUrl="data:image/jpeg;base64,"+user['image'];
                         if(localUrl==''){
                          localUrl="../image/person.png";
                         }
                        $('.profile-img').attr('src',userImg);
                        $('.username').html(user['username']);
                      currentUser=response['user'];
                        if(currentUser!=user['username']){
                          console.log('here'+currentUser);
                          $('.private_channel').html('');
                        }
                        
                      }
                });
                // Getting channel names and channel types.
                $('.channel-list').html('');
                channelDiv= $('.channel-list');
                $('#channel-metric').html(response['channels'].length);
                $('#member-metric').html(response['users'].length);
                $('#posts-metric').html(response['posts']);
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
var countChart=0;
$('#bar-chart').on('click', function(e) {
      $('#myDiv').html('');
      if(countChart%2==0) {
      var trace2 = [{ x: chartUsers,
                      y: countUsers,
                      type: 'bar'}];
      var layout = {title: 'Active Status of all users',
                    xaxis:{title: 'Username of users'},
                    yaxis:{title: 'Count of posts posted'}};
        
      Plotly.newPlot('myDiv', trace2, layout);
      $('#bar-chart').val('Show my activeness');

    }
     else {
        var trace1 = [
                      {
                        x: date,
                        y: dateCount,
                        type: 'scatter'
                      }
                    ];
                      var layout = {
                        title: 'Active Status of You',
                        xaxis:{title: 'Date when you posted'},
                        yaxis:{title: 'Count of posts'},
                      };

                    Plotly.newPlot('myDiv', trace1, layout);
        $('#bar-chart').val('Show individual Distribution');
      }
      countChart++;
  })

</script>
