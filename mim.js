var signinLink = document.getElementById('signin');
if (signinLink) {
    signinLink.onclick = function() {
        navigator.id.request({
            siteName: 'mim CV',
            returnTo: '/',
            backgroundColor: '#f00',
            oncancel: function() {
                alert('user refuses to share identity.')
            }
        });
    };
}
var signoutLink = document.getElementById('signout');
if (signoutLink) {
    signoutLink.onclick = function() {
        navigator.id.logout();
    };
}
navigator.id.watch({
    /*A string indicates that you believe the user is currently logged in to your site,
     and the value of the string is that user's case-sensitive email address.
     A literal null indicates that you do not believe the user is logged in.
     Omitting the value or setting it to undefined means you do not know if the user is logged in or not.*/
         // loggedInUser: 'mim3dot@gmail.com',
    onlogin: function(assertion) {
        // A user has logged in! Here you need to:
        // 2. Update your UI.
        $.ajax({// Sending the assertion to your backend for verification and to create a session
            type: 'POST',
            url:admin_page_address, // this variable is set on back-end (admin_page_address)
            data: {
                assertion: assertion,
                tok: tok // set on back-end
            },
            success: function(res, status, xhr) {
                // window.location.reload();
                //                console.log('Success!');
                console.log("res: "+res + " --- status: "+ status + " --- xhr: "+ xhr);
                // tok = res.tok;
                console.log("res: " + res);
            },
            error: function(xhr, status, err) {
                console.log('ERR! ' + err)
                navigator.id.logout();
                alert("Login failure: " + err);
            }
        });
    },
    onlogout: function() {
//        console.log('onlogOUT: ' + assertion);
        // A user has logged out! Here you need to:
        // Tear down the user's session by redirecting the user or making a call to your backend.
        $.ajax({
            type: 'POST',
            url: admin_page_address, // This is a URL on your website.
            success: function(res, status, xhr) {
//                window.location.reload();
            },
            error: function(xhr, status, err) {
                alert("Logout failure: " + err);
            }
        });
    }
}); 