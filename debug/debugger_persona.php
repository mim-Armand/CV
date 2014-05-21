

<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<script src="https://login.persona.org/include.js"></script>




<a id="signin" class="persona-button persona-login persona-loaded" href="#">
    <span class="persona-icon">
        <i aria-hidden="true"></i>
    </span>
    <span class="signin">Sign in with Persona</span>
</a>


<script>
    navigator.id.watch({
      loggedInUser: 'mim3dot@gmail.com',
      onlogin: function(assertion) {
        // A user has logged in! Here you need to:
        // 1. Send the assertion to your backend for verification and to create a session.
        // 2. Update your UI.
      },
      onlogout: function() {
        // A user has logged out! Here you need to:
        // Tear down the user's session by redirecting the user or making a call to your backend.
      }
    });

    var signinLink = document.getElementById('signin');
    if (signinLink) {
      signinLink.onclick = function() { navigator.id.request(); };
    }

    var signoutLink = document.getElementById('signout');
    if (signoutLink) {
      signoutLink.onclick = function() { navigator.id.logout(); };
    }
</script>