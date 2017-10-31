<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Droid+Sans:400,700">

<div id="live-chat">
    <header class="clearfix">
        <a href="#" class="chat-close">x</a>
        <h4>#general</h4>
        <span class="chat-message-counter">3</span>
    </header>
    <div class="chat">
        <div class="chat-history">
        </div>
        <div class="chat-history-template" style="display: none;">
            <center class="msgDate">Monday, October 30, 2017</center>
            <div class="msgDiv chat-message clearfix">
                <img class="msgPic" src="../images/1.png" alt="profile pic" width="32" height="32">
                <div class="msgContent chat-message-content clearfix">
                    <span class="chat-time">11:54 pm</span>
                    <b class="msgUser">Mater</b>
                    <p class="msgValue">who is thu</p>
                    <a href="javascript:void(0);" data-href="member.php?emoji=+1&person=1&msgid=1" class="msgPlus emoji">&#128077;<span style="color:black;">0</span></a>
                    <a href="javascript:void(0);" data-href="member.php?emoji=-1&person=1&msgid=1" class="msgMinus emoji">&#x1F44E;<span style="color:black;" >0</span></a>
                    <center class="replyDate">Sunday, October 29, 2017</center>
                    <div class="reply chat-message clearfix">
                        <img class="replyPic" src="../images/1.png" alt="profile pic" width="24" height="24">
                        <div class="replyContent chat-message-content clearfix">
                            <span class="chat-time">11:54 pm</span>
                            <b class="replyUser">Mater</b>
                            <p class="replyValue">who is thu</p>
                        </div>
                    </div>
                    <form class="replyForm" method="post">
                        <fieldset>
                            <div class="row">
                                <div class="col-sm-8 col-md-10 col-lg-10 col-xs-8">
                                    <input type="text" placeholder="Reply here…" name="reply_message" >
                                </div>
                                <div class="col-sm-4 col-md-2 col-lg-2 col-xs-4">
                                    <input type="submit" value="Reply" class="btn reply" name="reply"/>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <form method="post">
            <fieldset>
                <div class="row">
                    <div class="col-sm-8 col-md-10 col-lg-10 col-xs-8">
                        <input type="text" placeholder="Type your message…" name="message">
                    </div>
                    <div class="col-sm-4 col-md-2 col-lg-2 col-xs-4">
                        <input type="submit" value="Send" class="btn" name="submit" />
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>

<script type="text/javascript">
    function setData(channelName) {
        $.ajax({
            type: 'GET',
            url: 'chats.php?ch=' + channelName,
            data: {
                user: $('#user').val(),
                pass: $('#pass').val()
            },
            success: function(response) {
                var dateStr = '';
                $.each( response['chats'], function( key, message ) {
                    var chatMessageDivContent = $('.chat-history-template').find('.msgDiv').clone();
                    if (dateStr === '' || dateStr != message['date_str']) {
                        dateStr = message['date_str'];
                        $('.chat-history').append('<center>' + dateStr + '</center>');
                    }
                    minusCount = 0;
                    $.each( response['minusReaction'], function( key, reply ) {
                        if (reply['msg_id'] == message['msg_id']) {
                            minusCount++;
                        }
                    });
                    chatMessageDivContent.find('.msgMinus').find('span').html(minusCount);
                    plusCount = 0;
                    $.each( response['plusReaction'], function( key, reply ) {
                        if (reply['msg_id'] == message['msg_id']) {
                            plusCount++;
                        }
                    });
                    chatMessageDivContent.find('.msgPlus').find('span').html(plusCount);
                    var replyDiv = chatMessageDivContent.find('.reply').clone();
                    var replyDateStr = '';
                    chatMessageDivContent.find('.reply').remove();
                    chatMessageDivContent.find('.replyDate').remove();
                    $.each( response['replies'], function( key, reply ) {
                        if (reply['msg_id'] == message['msg_id']) {
                            if (replyDateStr === '' || replyDateStr != message['date_str']) {
                                replyDateStr = reply['date_str'];
                                $('.chat-history').append('<center>' + replyDateStr + '</center>');
                            }
                            $(replyDiv).insertBefore($('.replyForm'));
                        }
                    });
                    $('.chat-history').append(chatMessageDivContent);
                });
            }
        });
    }
    setData('general');
</script>
