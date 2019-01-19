
function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
    });
    // Simulate a mouse click:
window.location.href = "../oNotes/api/destroy.php";
    auth2.disconnect();
  }
  $('select').formSelect();
  $('.sidenav').sidenav();

  $('.sidenav')
        .sidenav()
        .on('click tap', 'li a', () => {
            $('.sidenav').sidenav('close');
        });

