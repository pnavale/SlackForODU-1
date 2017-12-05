<?php include 'includes/htmlheader.php';
if (!isset($_SESSION)) {
    session_start();
}
if (!$_SESSION['wkid']) {
    header("Location: wklogin.php");
}
?>
<h3>User's statistics</h3>
<a href="member.php" class="pull-right">Go to Main Page</a>
<center>
<div class="row" style="padding-top: 90px;">
<label for="autocomplete">Search username: </label>
<input id="autocomplete"><br><br>
<input type="submit" class="btn btn-success" id="search" id="Search" style="width: 20%;" >
</div>
</center>
<script >
 var users=[];
function setData() {
	console.log('gvgv');
        $.ajax({
            type: 'GET',
            url: 'verifySearch.php',
            success: function(response) {
                console.log(response);
                $.each( response['users'], function( key, user ) {
                 	users.push(user['username']);
            })

            }
        })
    }
    setData();
    $( "#autocomplete" ).autocomplete({
  source: users
});
    $('#search').on('click',function(){
    	var search=$( "#autocomplete" ).val();
    	window.location.href='profile.php?userInfo='+search;
    	})
    	
</script>