<?php
include 'includes/htmlheader.php';
include 'includes/db_connection.php';
include 'includes/functions.php';
session_start();
?>
<?php
// define variables and set to empty values
$nameErr = $purposeErr = $invitesErr = "";
$name = $purpose = $c = $invites=$chType= "";

if(isset($_POST["submit"]))
{ $name=verify_input($_POST['name']);
	if(!empty($_POST['name']))
	{ 
    if($_POST['name']==''){
      echo $error="Please enter channel name in lowercase without spaces or period.";
    }else{
		    $purpose=$_POST['purpose'];
        $invites=$_POST['invites'];
        $query="SELECT * FROM channel ORDER BY channel_id DESC LIMIT 1";
        $result= $connection->query($query);
        $channel_id='';
        $chType = $_POST['chType'];
		if($result-> num_rows>0)
		{
			while($row=$result->fetch_assoc())
			{
				$channel_id=$row['channel_id'];
                }
                }
        $channel_id=substr("$channel_id", 2,2 );
        $channel_id=$channel_id+1;
        $uchannel_id='ch'.$channel_id;
        $user=$_SESSION['sess_user'];
        $wk_id=$_SESSION['wkid'];

        $result1=$connection->query("insert into channel (channel_id,channel_name,channel_creator,channel_created,wk_id,channel_type,purpose,invites)    values('$uchannel_id','$name','$user',NOW(),'$wk_id','$chType','$purpose','$invites');
        ");
        if($result1){
          header("Location: member.php");
        }
        else{
          $error="This channel already exists. Please use different name to start a new channel or go to dashboard to see this channel.";
        }
  
    }
    }else{
        echo 'Please enter the channel name.';
    }
}

if(isset($_POST["cancel"])){
    /* Redirect browser */
			header("Location: member.php");
}      
?>
<div class="login-container" style="width:600px">
<h2>Create a Channel</h2>
      <br><br>
<p> Channels are where your members communicate. They're best when organized around a topic. E.g. <b>#foodie</b>.</p>
      <br><br>
<!--<p><span class="error">* required field.</span></p>-->
<span class="error"><?php if(isset($error)){ echo $error; } ?></span>
<form method="POST">  
  Name <input type="text" class="form-control" name="name" maxlength="22"  placeholder="# e.g. foodie" value="<?php echo $name;?>">
    <span class="grey-font">Names must be lowercase, without spaces or periods, and shorter than 22 characters.</span>
<!--  <span class="error">* <?php echo $nameErr;?></span>-->
  <br><br>  <br><br>
    Purpose <span class="grey-font">(optional)</span> <input type="text" class="form-control" name="purpose" value="<?php echo $purpose;?>">
     <span class="grey-font">What's this channel about?</span>
<!--  <span class="error">* <?php echo $purposeErr;?></span>-->
  <br><br>  <br><br>
    Send invites to <span class="grey-font">(optional)</span>
    <input type="text" class="form-control" list="invites"  name="invites" placeholder="Search by name" value="<?php echo $invites;?>"  multiple/>
<datalist id="invites">
<?php 
$members = array();
  if($_SESSION['sess_user']){
    $query="SELECT * FROM users where workspace_id='".$_SESSION['wkid']."'";
    $result= $connection->query($query);
  if($result-> num_rows>0)
  {
  while($row=$result->fetch_assoc())
  {
   array_push($members, $row);
        
  }
}
}
foreach ($members as $value) {
echo "<option value=".$value['username'].">".$value['username']."</option>";
}
mysqli_close($connection); 
?>
</datalist>

    <span class="grey-font">Select up to 100 people to add into this channel.</span>
<!--  <span class="error"><?php echo $invitesErr;?></span>-->
  <br><br>
<center>
 <div class="input-group"> Channel Type
 <span style="padding: 40px;">
<input  type="radio" name="chType" 
<?php if (isset($chType) && $chType=="Private") echo "checked";?>
value="private">Private</span>
<span style="padding: 40px;">
<input type="radio" name="chType" 
<?php if (isset($chType) && $chType=="Public") echo "checked";?>
value="public">Public</span>

</div>
</center>
  <br><br>
<div class="btn-group" style="width:100%;">
    <button type="submit" value="Cancel" class="btn btn-basic" name="cancel"  style="width:50%;">Cancel</button>
    <button type="submit" value="Create Channel" class="btn btn-success" name="submit"  style="width:50%;" >Create Channel</button>
    
    </div>
</form>
</div>
