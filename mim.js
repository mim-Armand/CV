//var assertion;
var signinLink = document.getElementById('signin');
if (signinLink) {
    signinLink.onclick = function() {
        navigator.id.request({
            siteName: 'mim CV',
//            siteLogo: '/logo.png', //Must be served over SSL.
//            termsOfService: '/tos.html', //Must be served over SSL.
//            privacyPolicy: '/privacy.html', //Must be served over SSL.
            returnTo: '/welcome.html',
            backgroundColor: '#f00',
            oncancel: function() { alert('user refuses to share identity.')}
        });
    };
}

var signoutLink = document.getElementById('signout');
if (signoutLink) {
    signoutLink.onclick = function() { navigator.id.logout(); };
}
var delet_me;
navigator.id.watch({
    /*A string indicates that you believe the user is currently logged in to your site,
     and the value of the string is that user's case-sensitive email address.
     A literal null indicates that you do not believe the user is logged in.
     Omitting the value or setting it to undefined means you do not know if the user is logged in or not.*/
//      loggedInUser: 'mim3dot@gmail.com',
    onlogin: function(assertion) {
        // A user has logged in! Here you need to:
        // 1. Send the assertion to your backend for verification and to create a session.
        // 2. Update your UI.
        delet_me = assertion;
        $.ajax({ // This example uses jQuery, but you can use whatever you'd like
            type: 'POST',
            url: 'admin.php', // This is a URL on your website.
            data: {assertion: assertion},
            success: function(res, status, xhr) {
//                window.location.reload();
                console.log('Success!');
            },
            error: function(xhr, status, err) {
                console.log('ERR! '+err)
                navigator.id.logout();
                alert("Login failure: " + err);
            }
        });

    },
    onlogout: function() {
        console.log('onlogOUT: '+ assertion);
        // A user has logged out! Here you need to:
        // Tear down the user's session by redirecting the user or making a call to your backend.
        $.ajax({
            type: 'POST',
            url: '/auth/logout', // This is a URL on your website.
            success: function(res, status, xhr) { window.location.reload(); },
            error: function(xhr, status, err) { alert("Logout failure: " + err); }
        });

    }
});