<?php include 'includes/htmlheader.php';
?>
<div class="short-profile">
    <div class="row"> 
        <div class="col-sm-2 col-md-2 col-lg-2 col-xs-2" style="color:#DCDCDC;font-size: 24px;">
            <img class="profile-img"/>
        </div>
        <div class="col-sm-10 col-md-10 col-lg-10 col-xs-10" style="color:#DCDCDC;">
            <span class="username"></span>
        </div>
    </div>
    <div class="row">
    <button class="btn btn-default private_channel">Show private channel</button>
    </div>
    <div class="channels">
        <div class="row channel-list">
        </div>
    </div>
</div>

<script type="text/javascript">
    function setData(userProfile) {
         var channelDiv ='';
        $.ajax({
            type: 'GET',
            url: 'verifyProfile.php?userProfile=' + userProfile,
            data: '',
            success: function(response) {
                var dateStr = '';
                console.log(response);
                $.each( response['userInfo'], function( key, user ) {
                         console.log(user['profile_pic']);
                         var userImg="data:image/jpeg;base64,"+user['image'];
                        $('.profile-img').attr('src',userImg);
                        $('.username').html(user['username']);
                        //$('.username').html(user['username']);
                });
                channelDiv= $('.channel-list').clone();
                $.each( response['channels'], function( key, channel ) {
                        if(channel['channel_type']=='public'){
                            channelDiv.append('<div class="col-sm-6 col-md-6 col-lg-6 col-xs-6">'+channel['channel_name']+'</div>');
                            channelDiv.append('<div class="col-sm-6 col-md-6 col-lg-6 col-xs-6">'+channel['channel_type']+'</div>');
                            $('.channels').append(channelDiv);   
                        }
                     
                });
                
            }
        });
    }
   
    setData(location.search.substring(10,location.search.length));
</script>
