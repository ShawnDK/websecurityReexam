<?php
  session_start();
?>

<!DOCTYPE html>

<html>
<head>
  <meta name = "viewport" content = "width = device-width">
    <title>Login</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.min.js"></script>
</head>

<body>
    
<style>
  * {
    margin: 0;
    padding: 0;
    }
  html, body {
    width: 100%;
    height: 100%;
    font: 12px "Lucida Grande", Sans-Serif;
    background: url(CopenhagenBlurred.jpg);
    background-size: cover;
    display: flex;
    justify-content: center;
    align-items: center;
    }
    
  .content {
    display: flex;
    justify-content: center;
    flex-direction: column;
    /*align-items: center;*/
  }
  
  #indexContent {
    width: 300px;
    box-shadow: 0px 0px 10px 4px #222222;
    background-size: cover;
    padding: 20px;
    border-radius: 5px;
    border: 2px #2c2c2c solid;
    background-color: rgba(17, 17, 17, 0.85);
  }
  
  .content input {
    margin: 5px;
    font-size: 1.5em;
    text-align: center;
    border-radius: 6px;
  }
  
  .sweet-alert {
    background-color: rgb(38, 38, 38);
  }
  
  .sweet-alert h2, .sweet-alert p {
    color: white;
  }
  
  .errorLabel {
    text-align: center;
    color: red;
  }
  
  .infoLabel {
    margin: 0;
    margin-left: 5px;
    color: white;
    text-shadow: 1px 1px black;
  }
  
  .successLabel  {
    text-align: center;
    color: green;
  }
  
  #loginDiv {
    width: 200px;
    margin: auto;
  }
  
  #createDiv {
    display: flex;
    width: 200px;
    margin: auto;
  }
  
  #btnChange {
    text-align: center;
    padding-bottom: 40px;
    width: 200px;
    margin: auto;
    display: flex;
    justify-content: space-around;
  }
  
  #btnLogin, #btnCreate {
    width: 190px;
    margin: auto;
    margin-bottom: 20px;
  }
  
  #headline {
    text-align: center;
    margin: 25px;
    color: white;
  }
  
  .btn-warning {
    text-shadow: 0px 0px 3px black;
  }
  
  .btn-warning {
    outline: 0px auto -webkit-focus-ring-color!important;
  }
  
  .bottomLabel {
    margin: 0;
  }
  
  
</style>

<div id="wrapper">

<div id="indexContent">
  <h3 id="headline">GROUP AWESOME</h3>
  <div id="btnChange">
    <button type="button" id="btnLoginSection" class="btn .btn-md btn-warning">Sign in</button>
    <button type="button" id="btnCreateSection" class="btn btn-warning">Sign up</button>
  </div>
    
  <div id="loginDiv" class="content">
    <h5 id="infoLabelUser" class="infoLabel">USERNAME</h5>
    <input id="userInput" autocorrect="off" autocapitalize="off" autocomplete="off" class="loginInputLoginpage" type="text" name="txLoginFormEmail">
    <h5 id="errorLabelUser" class="errorLabel"></h5>
    <h5 id="infoLabelUser" class="infoLabel">PASSWORD</h5>
    <input id="passInput" autocorrect="off" autocapitalize="off" autocomplete="off" class="loginInputLoginpage" type="password" name="txLoginFormPassword">
    <h5 id="errorLabelPass" class="errorLabel"></h5>
    <button type="button" id="btnLogin" class="btn btn-warning btn-xs postBtn">LOGIN</button>
    <h5 id="LoginLabel" class="errorLabel bottomLabel"></h5>
  </div>
    
  <div id="createDiv" class="content" style="display: none;">
    <h5 class="infoLabel">USERNAME</h5>
    <input id="userCreateInput" autocorrect="off" autocapitalize="off" autocomplete="off" class="loginInputLoginpage" type="text" name="txLoginFormEmail">
    <h5 id="CreateLabelUser" class="errorLabel"></h5>
    <h5 class="infoLabel">PASSWORD</h5>
    <input id="passCreateInput" autocorrect="off" autocapitalize="off" autocomplete="off" class="loginInputLoginpage" type="password" name="txLoginFormPassword">
    <h5 id="CreateLabelPass" class="errorLabel"></h5>
    <h5 class="infoLabel">REPEAT PASSWORD</h5>
    <input id="passRepeatCreateInput" autocorrect="off" autocapitalize="off" autocomplete="off" class="loginInputLoginpage" type="password" name="txLoginFormPassword">
    <h5 id="CreateLabelPassRepeat" class="errorLabel"></h5>
    <button type="button" id="btnCreate" class="btn btn-warning btn-xs postBtn">CREATE</button>
    <h5 id="CreateLabel" class="errorLabel bottomLabel"></h5>
    <h5 id="CreateLabelOk" class="successLabel bottomLabel"></h5>
  </div>
</div>

</div>
    
<script>
  

  //HIDE AND SHOW BASED ON BUTTONS
$("#btnCreateSection").click(function(){
  $("#createDiv").show();
  $("#loginDiv").hide();
  $(".errorLabel").html("");
  $(".bottomLabel").html("");
  $("input").val("");
});

$("#btnLoginSection").click(function(){
  $("#loginDiv").show();
  $("#createDiv").hide();
  $(".errorLabel").html("");
  $(".bottomLabel").html("");
  $("input").val("");
});
  
  
  
  

//LOGIN SECTION


  $("#btnLogin").click(function(){
    
   var sLoginUser = $("#userInput").val();
   var sLoginPass = $("#passInput").val();
   var sLink = "validate-login.php?user=" + sLoginUser + "&pass=" + sLoginPass;
   
   if ( sLoginUser == "") {
      $("#errorLabelUser").html("");
      $("#errorLabelUser").html("Please fill out the field");
   }else if( sLoginUser != "" ){
      $("#errorLabelUser").html("");
   }
    
  if ( sLoginPass == "") {
      $("#errorLabelPass").html("");
      $("#errorLabelPass").html("Please fill out the field");
   } else if( sLoginPass != "" ){
      $("#errorLabelPass").html("");
   }
   
   
   if ( sLoginUser !== "" && sLoginPass !== "" ) {
    
   $.ajax({
     "url":sLink,
     "dataType":"text",
     "method":"post",
     "cache": false
     }).done( function(Data){
       if (Data == "loginpass") {
          window.location.href = "approved.php";
       }else{
          var result = JSON.parse(Data);
          //sweetAlert(result.attempts);
          $("#LoginLabel").html("");
          $("#LoginLabel").html(result.attempts);
          //sweetAlert("Sorry", "Gæt igen", "error");
       }
       console.log(Data);
     })
   }
  });
  
  
  //CREATE SECTION
  
  $("#btnCreate").click(function(){
    
   var sCreateUser = $("#userCreateInput").val();
   var sCreatePass = $("#passCreateInput").val();
   var sCreatePassRepeat = $("#passRepeatCreateInput").val();
   var sLink = "create-login.php?user=" + sCreateUser + "&pass=" + sCreatePass + "&passRepeat=" + sCreatePassRepeat;
   
   //RESET ALL LABEL FIELDS
   $("#CreateLabelUser").html("");
   $("#CreateLabelPass").html("");
   $("#CreateLabelPassRepeat").html("");
   $("#CreateLabel").html("");
   $("#CreateLabelOk").html("");
   
   
  if ( sCreateUser == "") {
      $("#CreateLabelUser").html("Please fill out the field");
  }
   
  if ( sCreatePass == "") {
      $("#CreateLabelPass").html("Please fill out the field");
  }
  
  if ( sCreatePassRepeat == "") {
      $("#CreateLabelPassRepeat").html("Please fill out the field");
  }
   
  if ( sCreateUser !== "" && sCreatePass !== "" && sCreatePassRepeat != "") {
    
   $.ajax({
     "url":sLink,
     "dataType":"text",
     "method":"post",
     "cache": false
     }).done( function(Data){
      var result = JSON.parse(Data);

      $("#CreateLabelUser").html(result.user);
      $("#CreateLabelPass").html(result.pass);
      $("#CreateLabelPassRepeat").html(result.passRepeat);
      $("#CreateLabel").html(result.creation);
      $("#CreateLabelOk").html(result.creationOk);
       console.log(Data);
     })
   }
  });
  
  
</script>


</body>
</html>
