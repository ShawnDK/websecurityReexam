<?php
//GET THE DB CONNECTION DETAILS
require_once 'db_connect.php';

$result = $con->prepare("SELECT * FROM websecuserinfo WHERE userId LIKE :profileId");
$result->bindParam(':profileId', $profileId);
$result->execute();
$resultCheckCount = $result->rowCount();
$result = $result->fetchAll();

$result2 = $con->prepare("SELECT * FROM websecusers WHERE id LIKE :profileId");
$result2->bindParam(':profileId', $profileId);
$result2->execute();
$resultCheckCount2 = $result2->rowCount();
$result2 = $result2->fetchAll();
?>

<div class="container">
    <h1>Edit Profile</h1>
    <hr>
    <div class="row">
        <!-- left column -->
        <div class="col-md-3">
            <div class="text-center">
                <img src="/websecurity/uploads/<?php echo $result[0]['image']?>" class="avatar img-circle" alt="avatar">
                <h6>Upload a different photo...</h6>
                <form id="imgUploadForm" action="/websecurity/actions/action_update-profileimage.php" enctype="multipart/form-data">
                    <input type="file" name="image" class="form-control">
                    <input id="uploadPhoto" type="submit" value="Upload" />
                </form>
            </div>
        </div>

        <!-- edit form column -->
        <div class="col-md-9 personal-info">
            
                <?php
                if(isset($_SESSION['errorImg'])){
                    echo '<div class="alert alert-danger alert-dismissable">
                    <a class="panel-close close" data-dismiss="alert">×</a>
                    <i class="fa fa-file-o"></i>'. $_SESSION["errorImg"] .'</div>';
                };
                unset($_SESSION['errorImg']);?>
            
            <h3>Personal info</h3>

            <form class="form-horizontal" role="form">
                <div class="form-group">
                    <label class="col-lg-3 control-label">First name:</label>
                    <div class="col-lg-8">
                        <input id="inputFirstName" class="form-control" type="text" value="<?php echo $result[0]['firstname']?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Last name:</label>
                    <div class="col-lg-8">
                        <input id="inputLastName" class="form-control" type="text" value="<?php echo $result[0]['lastname']?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Adress:</label>
                    <div class="col-lg-8">
                        <input id="inputAdress" class="form-control" type="text" value="<?php echo $result[0]['adress']?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Age:</label>
                    <div class="col-lg-8">
                        <input id="inputAge" class="form-control" type="number" value="<?php echo $result[0]['age']?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Time Zone:</label>
                    <div class="col-lg-8">
                        <div class="ui-select">
                            <select id="user_time_zone" class="form-control">
                  <option value="Hawaii">(GMT-10:00) Hawaii</option>
                  <option value="Alaska">(GMT-09:00) Alaska</option>
                  <option value="Pacific Time (US &amp; Canada)">(GMT-08:00) Pacific Time (US &amp; Canada)</option>
                  <option value="Arizona">(GMT-07:00) Arizona</option>
                  <option value="Mountain Time (US &amp; Canada)">(GMT-07:00) Mountain Time (US &amp; Canada)</option>
                  <option value="Central Time (US &amp; Canada)" selected="selected">(GMT-06:00) Central Time (US &amp; Canada)</option>
                  <option value="Eastern Time (US &amp; Canada)">(GMT-05:00) Eastern Time (US &amp; Canada)</option>
                  <option value="Indiana (East)">(GMT-05:00) Indiana (East)</option>
                </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"></label>
                    <div class="col-md-8">
                        <input type="button" id="btnUpdateUser" class="btn btn-primary" value="Save Changes">
                        <span></span>
                        <input type="reset" class="btn btn-default" value="Cancel">
                    </div>
                </div>
            </form>
            <h3>Account info</h3>
            <form>
                <div class="form-group">
                    <label class="col-md-3 control-label">Username:</label>
                    <div class="col-md-8">
                        <input id="inputUsername" placeholder="username" class="form-control" type="text" value="<?php echo $result2[0]['user']?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Password:</label>
                    <div class="col-md-8">
                        <input id="inputPassword" placeholder="password" class="form-control" type="password" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Confirm password:</label>
                    <div class="col-md-8">
                        <input id="inputPasswordConfirm" placeholder="password" class="form-control" type="password" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"></label>
                    <div class="col-md-8">
                        <input type="button" id="btnUpdateAccount" class="btn btn-primary" value="Save Changes">
                        <span></span>
                        <input type="reset" class="btn btn-default" value="Cancel">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<hr>
<script>
$("#btnUpdateUser").click(function(){
    var age = $("#inputAge").val();
    var adress = $("#inputAdress").val();
    var fName = $("#inputFirstName").val();
    var lName = $("#inputLastName").val();
    var sLink = "/websecurity/actions/action_update-profile.php?age=" + age + "&firstname=" + fName + "&lastname=" + lName + "&adress=" + adress;


    $.ajax({
        "url":sLink,
        "dataType":"text",
        "method":"post",
        "cache": false
    }).done( function(Data){

        if (Data == "yes") {
            swal("Success!", "Your profile was updated!", "success")
        }else{
            swal({
            title: "Error!",
            text: "Please enter something",
            type: "error",
            confirmButtonText: "Cool"
            });
        }
    });


});

$('#imgUploadForm').on('submit',(function(e) {
    e.preventDefault();
    console.log(this);
    var formData = new FormData(this);
    console.log(formData);
         $.ajax({
         type:'POST',
         url: $(this).attr('action'),
         data:formData,
         cache:false,
         contentType: false,
         processData: false,
         success:function(data){
             console.log("success ");
             console.log(data);
             window.location.assign("/websecurity/profile/edit");
         },
         error: function(data){
             console.log("error ");
             console.log(data);
             //window.location.assign("/websecurity/profile");
         }
     });
}));

$("#btnUpdateAccount").click(function(){
    var username = $("#inputUsername").val();
    var password = $("#inputPassword").val();
    var sLink = "/websecurity/actions/action_update-profile.php?usr=" + username + "&pass=" + password;
    

    $.ajax({
        "url":sLink,
        "dataType":"text",
        "method":"post",
        "cache": false
    }).done( function(Data){
        console.log(Data);

        if (Data == "yes") {
            swal("Success!", "Your account was updated!", "success")
        }else{
            swal({
            title: "Error!",
            text: "Please enter something",
            type: "error",
            confirmButtonText: "Cool"
            });
        }
    });
});
</script>
