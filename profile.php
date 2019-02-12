<!DOCTYPE html>
<html>

<head>
   <?php 
   session_start();
   if(! isset($_SESSION['user_id'])) {
      header('Location: main.html');
   }
   ?>
   <title>SimplyNote</title>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=0.9">
   <meta name="theme-color" content="#3367d6" />
   <link rel="shortcut icon" href="img/notepad.png" type="image/x-icon" />
   <meta name="description" content="Free Note Taking App!">

   <link rel="manifest" href="manifest.json">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp"
      crossorigin="anonymous">
   <!-- Compiled and minified JavaScript -->

   <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <link rel="stylesheet" href="style/style.css">
   <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
   <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
   <script src="https://unpkg.com/vue-ckeditor2"></script>
   <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
   <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>

   <meta name="google-signin-client_id" content="161857244723-521c5i25359db4t6p6igfj6vjgd48c5o.apps.googleusercontent.com">
   <script src="https://apis.google.com/js/platform.js" async defer></script>

</head>

<body bg-color="#e4ba4e">
   <div>
      <div class="container-fluid">
         <div class="navbar-fixed" v-show="show.show_listing">
            <nav>
               <div class="nav-wrapper">
                  <a href="index.php" class="brand-logo"><b>SimplyNote</b></a>
                  <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                  <ul class="right hide-on-med-and-down">
                     <li><a href="shoplist.php"><b>My Lists</b></a></li>
                     <li><a href="">Profile</a></li>
                     <li><a href="#" onclick="signOut();">Sign out</a></li>
                  </ul>
                  <ul class="sidenav" id="mobile-demo">
                     <li class="black-text center-align"><b>SimplyNote 2019</b></li>
                     <li><a href="shoplist.php"><b>My Lists</b></a></li>
                     <li><a href="">Profile</a></li>
                     <li><a href="#" onclick="signOut();">Sign out</a></li>
                  </ul>
               </div>
            </nav>
         </div>
         <div class="container-fluid">
            <div class="row">
               <div class="col m3">

               </div>
               <div class="col m9">
               </div>
            </div>
         </div>
         <script src="js/vue.js"></script>
         <script src="js/axios.js"></script>
         <script src="js/other.js"></script>
         <script src="js/login.js"></script>
         <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
         <script>
            	var profile = googleUser.getBasicProfile();

            console.log(profile.getName());
                     </script>
</body>

</html>