
document.getElementById("date").innerHTML = new Date().toISOString().slice(0,10);
$('.datepicker').datepicker({
    format: "yyyy-mm-dd"
});

function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
    });
    // Simulate a mouse click:
window.location.href = "../oNotes/api/destroy.php";
    auth2.disconnect();
  }
  
  $('.sidenav').sidenav();

