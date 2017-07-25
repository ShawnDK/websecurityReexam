<div class="container">
    <h1>Edit Profile</h1>
    <hr>
    <div class="row">
        <!-- left column -->
        <div class="col-md-3">
            <div class="text-center">
                <img src="//placehold.it/100" class="avatar img-circle" alt="avatar">
                <h6>Upload a different photo...</h6>
                <form id="imgUploadForm" action="/websecurity/actions/action_update-profileimage.php" enctype="multipart/form-data">
                    <input type="file" name="image" class="form-control">
                    <input id="uploadPhoto" type="submit" value="Upload" />
                </form>
            </div>
        </div>

        <!-- edit form column -->
        <div class="col-md-9 personal-info">
            <div class="alert alert-info alert-dismissable">
                <a class="panel-close close" data-dismiss="alert">×</a>
                <i class="fa fa-coffee"></i> This is an <strong>.alert</strong>. Use this to show important messages to the user.
            </div>
            <h3>Personal info</h3>

            <form class="form-horizontal" role="form">
                <div class="form-group">
                    <label class="col-lg-3 control-label">First name:</label>
                    <div class="col-lg-8">
                        <input id="inputLastName" class="form-control" type="text" value="name">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Last name:</label>
                    <div class="col-lg-8">
                        <input id="inputFirstName" class="form-control" type="text" value="name">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Adress:</label>
                    <div class="col-lg-8">
                        <input id="inputAdress" class="form-control" type="text" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Age:</label>
                    <div class="col-lg-8">
                        <input id="inputAge" class="form-control" type="number" value="18">
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
                        <input id="inputUsername" placeholder="username" class="form-control" type="text" value="">
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
    // $.ajax({
    //     type:'POST',
    //     url: $(this).attr('action'),
    //     data:formData,
    //     cache:false,
    //     contentType: false,
    //     processData: false,
    //     success:function(data){
    //         console.log("success ");
    //         console.log(data);
    //         window.location.assign("http://188.226.140.143/profile");
    //     },
    //     error: function(data){
    //         console.log("error ");
    //         console.log(data);
    //         window.location.assign("http://188.226.140.143/profile");
    //     }
    // });
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
