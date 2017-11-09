<?php
include 'includes/db_connection.php';
include 'includes/htmlheader.php';
if (!isset($_SESSION)) {
    session_start();
}
?>
<div class="row">
	<div class="col-sm-6 col-md-6 col-lg-6 col-xs-6 channel-name">
		
	</div>
	<div class="col-sm-6 col-md-6 col-lg-6 col-xs-6 channel-type">
		
	</div>
	


</div>

   <script type="text/javascript">
    
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
                
            })
    }
    });
   }
   console.log(location.search.substring(11,location.search.length));
   setData(location.search.substring(11,location.search.length));

    </script>