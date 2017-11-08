<?php
include 'includes/db_connection.php';
if (!isset($_SESSION)) {
    session_start();
}
?>
<div>
    <div class="row">
        <div class="col-sm-10 col-md-10 col-lg-10 col-xs-10 wkurl" style="color:#DCDCDC;font-size: 24px;">
           <?php echo $_SESSION['wkurl']; ?>
        </div>
        <div class="col-sm-2 col-md-2 col-lg-2 col-xs-2 alert" style="color:#DCDCDC;">
            <span style="color:#DCDCDC;" class="material-icons" style="font-size:36px">add_alert</span>
        </div>
    </div>
    
    <div class="row">
    <div class="col-sm-10 col-md-10 col-lg-10 col-xs-10"><?php echo "<a href='profile.php?userInfo=".$_SESSION['sess_user']."'>See your profile</a>"; ?></div>
    </div>

    <!--notification class-->
    <div class="notification row">
    </div>

    <div class="row">
        <div class="Channel col-sm-10 col-md-10 col-lg-10 col-xs-10" style="color:#DCDCDC;">
            <span>Channels </span>
        </div>
        <div class="col-sm-2 col-md-2 col-lg-2 col-xs-2">
            <a href="channel.php">
            <span style="color:#F5F5F5;" class="glyphicon glyphicon-plus-sign"></span>
            </a>
        </div>
    </div>

    <div class="channels row" style="color:#DCDCDC;">
        <div class="channel-item col-sm-10 col-md-10 col-lg-10 col-xs-10">
        <a class="channel-list-item" name='ch'>
        <span style='color:#FFFFFF;' class="chItem"></span>
        </a>
        <br>
        </div>
    </div>
<br><br>
    <div class="row" style="color:#DCDCDC;">
        <div class="col-sm-10 col-md-10 col-lg-10 col-xs-10">
            <span>Direct Messages </span>
        </div>
        <div class="col-sm-2 col-md-2 col-lg-2 col-xs-2">
            <a href="#">
            <span style="color:#F5F5F5;" class="glyphicon glyphicon-plus-sign"></span>
            </a>
        </div>
    </div>
    <div class="row users" style="color:#DCDCDC;">
<!--         <a name='pc' style='color:#FFFFFF;' value="slackbot"><span style='color:#f27670;'>&hearts;</span>slackbot</a> --> 
        <div class="user-item col-sm-10 col-md-10 col-lg-10 col-xs-10">
       <a name='pc' class="user-list-item">
       <span  style='color:#FFFFFF;' class="usname"></span><br></a>
       </div>
    </div>
</div>
    <script type="text/javascript">
    var click = 0;
    var alertClick = 0;
    var private_channel =0;
    var sidebarInvite=0;
    var channelname='';
  /*  $('.wkurl').click(function() {
        if (click % 2 == 0) {
            $('.short-profile').css('display', 'block');
            $('.notification').css('display', 'none');
        } else {
            $('.short-profile').css('display', 'none');
        }
        click++;

    })


    $('.alert').click(function() {
        if (alertClick % 2 == 0) {
            $('.notification').css('display', 'block');
            $('.short-profile').css('display', 'none');
        } else {
            $('.notification').css('display', 'none');
        }
        alertClick++;

    })
        $('.sidebar_invite').click(function(e) {
            console.log($(this).attr('id'));
            channelname = $(this).attr('id');
        if (sidebarInvite % 2 == 0) {
            $('.sinvite').css('display', 'block');
            console.log("1");
        } else {
            $('.sinvite').css('display', 'none');
            console.log("1");
        }
        sidebarInvite++;

    })
        $('.inviteBtn'+channelname).click(function(e) {
            e.preventDefault();
             console.log($(this).attr('id'));
            var invites=$('.invites'+channelname).val();
            $.ajax({
                type: 'GET',
                url: 'sidebar.php',
                data: { channelname: channelname,invites:invites},
                success: function(response) {
                    console.log({ channelname: channelname});
                    return { channelname: channelname};
                }
            });
           })
        $('.sidebar_invite').click(function(e) {
            console.log($(this).attr('id'));
            channelname = $(this).attr('id');
             })

$('.private_channel').click(function() {
        if (private_channel % 2 == 0) {
            $('.private-ch').css('display', 'block');
        } else {
            $('.private-ch').css('display', 'none');
        }
        private_channel++;

    })


        $('.profile-img').click(function() {
            window.location.href="changeProfilePic.php";
    })


    $('.join').click(function() {
        var whichChannelJoined = $(this).val();
        console.log('join', whichChannelJoined);
        $.ajax({
            type: 'GET',
            url: 'member.php',
            data: { whichChannelJoined: whichChannelJoined },
            success: function(response) {
                return { whichChannelJoined: whichChannelJoined };
            }
        });
    })
*/
    function setData(userProfile) {
         var channelDiv ='';
         var newchannelsDiv = '';
         var membersDiv='';
        $.ajax({
            type: 'GET',
            url: 'sideBarData.php',
            success: function(response) {
                console.log(response);
            /*    channelDiv= $('.channels').clone();
                $.each( response['newchannels'], function( key, channel ) {
                        if(channel['channel_type']=='public'){
                            channelDiv.append('<div class="col-sm-6 col-md-6 col-lg-6 col-xs-6">'+channel['channel_name']+'</div>');
                            channelDiv.append('<div class="col-sm-6 col-md-6 col-lg-6 col-xs-6">'+channel['channel_type']+'</div>');
                            $('.channels').append(channelDiv);   
                        }
                     
                });*/
                $('.channels').html('');
    
                $.each( response['channels'], function( key, channel ) {
                    var channelDiv = $('<div class="channel-item col-sm-10 col-md-10 col-lg-10 col-xs-10"></div>');
                    var href = "member.php?ch="+channel['channel_name'];
                    var span = $('<span style="color:#FFFFFF;" class="chItem"></span>');
                    var a = $('<a name="ch" class="channel-list-item"></a>');
                    a.attr('href',href);
                    span.html('#'+channel['channel_name']);
                    a.html(span);
                    channelDiv.html(a);
                    $('.channels').append(channelDiv);  
                     
                });
                
                $('.users').html('');

                $.each( response['members'], function( key, member ) {
                    var membersDiv = $('<div class="user-item col-sm-10 col-md-10 col-lg-10 col-xs-10"></div>');
                    var href = "member.php?pc="+member['username'];
                    var span = $('<span style="color:#FFFFFF;" class="usname"></span>');
                    var a = $('<a name="pc" class="user-list-item"></a>');
                    a.attr('href',href);
                    span.html(member['username']);
                    a.html(span);
                    membersDiv.html(a);
                    $('.users').append(membersDiv);
                });
                
            }
        });
    }
    setData('<?php echo $_SESSION['sess_user'];?>');

    </script>
