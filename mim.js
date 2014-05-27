console.log('tok: ' + tok);

function ajaxCaller(d) {
    console.log('tok: ' + tok)
    $.ajax({
        // dataType: 'json',
        type: 'POST',
        url: admin_page_address,
        data: {
            dataArray: d,
            tok: tok,
            assertion: ass,
            act: act
        },
        success: function(res, status, xhr) {
            console.log('status:' + status);
            console.log('res: ' + res);
            receivedAjax = jQuery.parseJSON(res);
            console.log('receivedAjax: ' + receivedAjax);
            tok = receivedAjax.tok;
            isLogedIn = receivedAjax.logedIn;
        },
        error: function(xhr, status, err) {
            console.log('ERR! ' + err)
            navigator.id.logout();
            alert("Login failure: " + err);
        },
        beforeSend: function() {
            duringAjax(act);
            //TODO: use this to make a little LED light that let the users know when AJAX is in action!
            console.log('AJAX call STARTED!');
        },
        complete: function() {
            afterAjax(act);
            //TODO: use this to make a little LED light that let the users know when AJAX is in action!
            console.log('AJAX call FINISHED!');
        },
        statusCode: {
            404: function() {
                console.log("page not found");
            },
            200: function() {
                console.log('status 200 !!!');
            }
        }
    })
}
function duringAjax(act){
    if (act == 'auth' || act == 'killUser'){
//        $("#page_loader_mask").fadeIn();
    }
}
function afterAjax(act){
    if (act == 'auth' && isLogedIn == true){
        // isLogedIn ? : $("#page_loader_mask").fadeOut();
    }
}
var receivedAjax;
var ass;
var act;
var isLogedIn;
// ================================================= PERSONA RELATED SH**! :P
var signinLink = document.getElementById('signin');
if (signinLink) {
    signinLink.onclick = function() {
        navigator.id.request({
            siteName: 'mim CV',
            returnTo: '/',
            backgroundColor: '#f00',
            oncancel: function() {
                alert('Incomplete Login!')
            }
        });
    };
}
var signoutLink = document.getElementById('signout');
if (signoutLink) {
    signoutLink.onclick = function() {
        act = 'killUser';
        ass = null;
        navigator.id.logout();
    };
}
navigator.id.watch({
    onlogin: function(assertion) {
        act = 'auth';
        ass = assertion;
        ajaxCaller();
    },
    onlogout: function() {
        act = 'auth';
        //TODO: kill the session on server and destroy the UI (refresh the page on ajax success)!
        ajaxCaller();
    }
});