 function renderButton() {
      gapi.signin2.render('my-signin2', {
        'scope': 'profile email',
        'width': 290,
        'height': 52,
        'longtitle': true,
        'theme': 'dark',
        'onsuccess': onSuccess,
        'onfailure': onFailure
      });
    }


function onSuccess(googleUser) {
      console.log('Logged in as: ' + googleUser.getBasicProfile().getName());
      document.getElementById('signout').style.display = 'block';
      document.getElementById('login').style.display = 'none'; 
      document.getElementById('logout').style.display = 'none'; 
      $( ".modal_close" ).trigger( "click" );
      document.getElementById('status').innerHTML = "<img src='" + googleUser.getBasicProfile().getImageUrl() + "'>";
      $("#name").append(googleUser.getBasicProfile().getName());
    }
    function onFailure(error) {
      document.getElementById('signout').style.display = 'none';
      document.getElementById('logout').style.display = 'none';
    }
   

function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
      document.location.reload();
    });
  }
/*******************************facebook API login ********************************/

// initialize and setup facebook js sdk
window.fbAsyncInit = function() {
    FB.init({
      appId      : '1498930736807544',
      xfbml      : true,
      version    : 'v2.5'
    });
    FB.getLoginStatus(function(response) {
      if (response.status === 'connected') {
        getInfo();
        document.getElementById('logout').style.display = 'block';
        document.getElementById('signout').style.display = 'none';
        document.getElementById('login').style.display = 'none'; 
      } else if (response.status === 'not_authorized') {
        document.getElementById('status').innerHTML = 'You are not logged in.';
        document.getElementById('logout').style.display = 'none';
        document.getElementById('signout').style.display = 'none';
      } else {
        document.getElementById('logout').style.display = 'none';
        document.getElementById('signout').style.display = 'none';
      }
    });
};
(function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
    
// login with facebook with extra permissions
function login() {
  FB.login(function(response) {
    if (response.status === 'connected') {
        getInfo();
        document.getElementById('logout').style.display = 'block';
        document.getElementById('signout').style.display = 'none';
        document.getElementById('login').style.display = 'none'; 
        $( ".modal_close" ).trigger( "click" );
      } else if (response.status === 'not_authorized') {
        document.getElementById('logout').style.display = 'none';
        document.getElementById('signout').style.display = 'none';
      } else {
        document.getElementById('logout').style.display = 'none';
        document.getElementById('signout').style.display = 'none';
      }
  }, {scope: 'email'});
}
    
// getting basic user info
function getInfo() {
  FB.api('/me', 'GET', {fields: 'first_name,last_name,name,id,picture.width(26).height(26)'}, function(response) {
    document.getElementById('status').innerHTML = "<img src='" + response.picture.data.url + "'>";
    $("#name").append(response.name);
  });
}

function logout(){
FB.logout(function(response) {
 document.location.reload();
 });
}
/*******************************LEANMODAL login ********************************/

$("#modal_trigger").leanModal({
  top: 100,
  overlay: 0.6,
  closeButton: ".modal_close"
});

$(function() {
  // Calling Login Form
  $("#login_form").click(function(){
    $(".social_login").hide();
    $(".user_login").show();
    return false;
  });

  // Calling Register Form
  $("#register_form").click(function() {
    $(".social_login").hide();
    $(".user_register").show();
    $(".header_title").text('Register');
    return false;
  });

  // Going back to Social Forms
  $(".back_btn").click(function() {
    $(".user_login").hide();
    $(".user_register").hide();
    $(".social_login").show();
    $(".header_title").text('Login');
    return false;
  });
});

