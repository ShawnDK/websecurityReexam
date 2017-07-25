<?php
session_start();
if(!isset($_SESSION['userSession']))
{
    header("location: index.php");
}
?>
<!DOCTYPE html>

<html>
<head>
    <meta name = "viewport" content = "width = device-width">
    <title>Approved</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
</head>

<body>

<style>
    body, html {
        margin: 0;
        padding: 0;
    }
    #greenBox {
        width: 100vw;
        height: 120px;
        background-color: #8BC34A;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }
    #CommentWrap{
    	width: 100vw;
    	height: calc(100vh - 120px);
    	background-color:#eeeeee;
    	display:flex;
    	flex-direction: column;
    	justify-content: center;

    }
    
    #comments{
    	height: calc(100% - 20px);
    	padding:5px;
    }

    #inputComment{
        width: 100%;
    	margin:5px;
    }

    #btnSubmitComment{
    	margin:5px 5px 5px 0px	;
    }

    #inputFields{
    	display:flex;
    	flex-direction: row;

    }

    #label{    
    	position: absolute;
	    width: 320px;
	    background-color: rgba(0,0,0,0.7);
	    color: white;
	    left: calc(50% - 130px);
	    border-radius: 20px;
	    text-align: center;
	    padding: 5px;
    }

    h2 {
        margin: 0;
        color: white;
        text-shadow: 1px 1px black;
        font-family: sans-serif;
    }
    
    button {
        padding: 5px;
        margin: 20px;
    }
    
</style>
    

<div id="greenBox">
    <h2>YOU ARE LOGGED IN</h2>
    <button type="button" id="btnLogout" class="btn btn-warning btn-xs postBtn">LOGOUT</button>
</div>
<div id="CommentWrap">
	<div id="comments">
	<?php

require_once 'db_connect.php';
$result = $con->prepare("SELECT * FROM websecMandatoryComments");
$result->execute();
$result->store_result();
$result->bind_result($id,$comment);
while($result->fetch()) {
	echo "<div>".htmlentities($comment)."</div>";
}
	?>
	</div>
	<div id="inputFields">
		<div id="label"></div>
		<input id="inputComment" placeholder="Write your comment here" autofocus>
	  	<input id="btnSubmitComment" type="submit" value="Submit">
	</div>
</div>

<script>
$("#btnLogout").click(function(){
	logout();
});

$("#btnSubmitComment").click(function(){
	comment();
});
  
  
function logout(){
	$.ajax({
		"url":"destroy-session.php",
		"method":"post",
		"dataType":"text",
		"cache":false
	}).done(function(Data){
		location.reload();
		console.log(Data);
	})
};

function comment(){
	var sComment = $("#inputComment").val();
	var sUrl = "post-comment.php?c="+ sComment;
	$.ajax({
		"url":sUrl,
		"method":"post",
		"dataType":"text",
		"cache":false
	}).done(function(sData){
		if(sData==""){
			window.location.reload();
		}else{
			$("#label").html("Are you even trying?");
		}
	})
};
</script>


</body>
</html>
