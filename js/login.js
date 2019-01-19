function onSignIn(googleUser) {
	console.log("here");
	// Useful data for your client-side scripts:
	var profile = googleUser.getBasicProfile();
	console.log("ID: " + profile.getId()); // Don't send this directly to your server!
	console.log('Full Name: ' + profile.getName());
	console.log('Given Name: ' + profile.getGivenName());
	console.log('Family Name: ' + profile.getFamilyName());
	console.log("Image URL: " + profile.getImageUrl());
	console.log("Email: " + profile.getEmail());

	// The ID token you need to pass to your backend:
	var id_token = googleUser.getAuthResponse().id_token;

	console.log("ID Token: " + id_token);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'api/signin.php');
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhr.onload = function () {
		$response = JSON.parse(xhr.responseText);
		if($response['redirect'] == 'yes') {
			window.location.href = "index.php";
			console.log('v pod');
			console.log(xhr.responseText);

		}
		console.log("TU:" + xhr.responseText);
	};
	xhr.send('idtoken=' + id_token + '&google_username=' + profile.getGivenName() + '&google_email=' + profile.getEmail());
	//xhr.send('google_username=' + profile.getGivenName());
	//xhr.send('google_email=' + profile.getEmail());
}

function signOut() {
	var auth2 = gapi.auth2.getAuthInstance();
	console.log(auth2);
	auth2.signOut().then(function () {
		console.log('User signed out.');
	});

}