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
  </meta>

  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  </meta>

  <meta name="viewport" content="width=device-width, initial-scale=0.9">
  </meta>

  <meta name="theme-color" content="#3367d6">
  </meta>

  <link rel="shortcut icon" href="img/notepad.png" type="image/x-icon">
  </link>

  <meta name="description" content="Free Note Taking App!">
  </meta>

  <link rel="manifest" href="manifest.json">
  </link>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
  </link>

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp"
    crossorigin="anonymous">
  </link>

  <!-- Compiled and minified JavaScript -->

  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  </link>

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </meta>

  <link rel="stylesheet" href="style/style.css">
  </link>

  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
  </link>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script src="https://unpkg.com/vue-ckeditor2"></script>

  <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
  </link>

  <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>

  <meta name="google-signin-client_id" content="161857244723-521c5i25359db4t6p6igfj6vjgd48c5o.apps.googleusercontent.com">
  </meta>

  <script src="https://apis.google.com/js/platform.js" async="async" defer="defer"></script>
</head>

<body bg-color="#e4ba4e">
  <div id="vue-app-two" class="vue-app-2">
    <div class="container-fluid">
      <div class="navbar-fixed" v-show="show.listing">
        <nav>
          <div class="nav-wrapper">
            <a href="index.php" class="brand-logo">
              <b>My lists</b>
            </a>

            <a href="#" data-target="mobile-demo" class="sidenav-trigger">
              <i class="material-icons">menu</i>
            </a>
            
           
            <ul class="right hide-on-med-and-down">
              <li>
                <a href="index.php">
                  <b>My Notes</b>
                </a>
              </li>
              <li>
                <a href="profile.php">
                  Profile
                </a>
              </li>
              <li>
                <a href="#">Sign out</a>
              </li>
            </ul>

            <ul class="sidenav" id="mobile-demo">
              <li class="black-text center-align">
                <b>SimplyNote 2019</b>
              </li>

              <li>
                <a href="index.php">
                  <b>My Notes</b>
                </a>
              </li>
              <li>
                <a href="profile.php">
                  Profile
                </a>
              </li>
              <li>
                <a href="#">Sign out</a>
              </li>
            </ul>
          </div>
        </nav>
      </div>

      <div class="row">
        <div class="col m2 s12">
       
          <button class="btn btn-floating btn-large scale-transition add-list" @click="createList()" v-show="! show.edit_mode">    <i class="material-icons white-text">add</i>
          </button>
       <!-- <a id="scale-demo" @click="saveList(postwItem.list_id)" href="#!" v-show="show.edit_mode" class="btn-floating btn-large scale-transition add-list">
          <i class="material-icons white-text">save</i>
        </a> -->
          <div v-show="show.listing">
          <center>
          <div class="row filter-controls">
                  <!--<div class="col m4 s4">
                  <span>Filter lists</span> 
                </div>
                  <div class="col m8 s8">
                  <select v-model="filter_cat"  class="browser-default">
                     <option value="All">All notes</option>
                     <option value="blue">Blue</option>
                     <option value="orange">Orange</option>
                     <option value="pink">Pink</option>
                     <option value="green">Green</option>
                     <option value="brown">Brown</option>
            </select>
               </div>-->
                </div>   
          </center>
          <div class="oneList" v-for="list in lists" @click="listDetail(list.id)">
            <span class="list-cat" v-bind:class="list.category"></span>
          <i class="fas fa-list fa-lg"></i>
           <p class="list-name"><b>{{list.list_name}}</b></p>
        </div>  
        </div>
        </div>
        <div class="col m7 s12" style="padding:0px;">
        <div class="working-bench" v-show="show.edit_mode">
        <span v-bind:class="postwItem.list_category" class="cat-span"></span>
          <div class="row controls">
          <i class="fas fa-save" @click="saveList(postwItem.list_id)"></i>
          <a href="#" class="dropdown-trigger right right-align" data-target="dropdown1" v-show="show.edit_mode">
              <i class="fas fa-ellipsis-v"></i>
            </a>
            <a href="#" class="dropdown-trigger right right-align" data-target="dropdown-cat" v-show="! show.listing">
            <i class="fas fa-tag"></i>
            </a>
            <ul id="dropdown1" class="dropdown-content">
          <li><a href="#" @click="show.edit_mode = !show.edit_mode; show.listing = true">Back without save</a></li>
          <li><a href="#" @click="show.edit_mode = !show.edit_mode; show.listing = true">Share</a></li>
          <li><a href="#" @click="deleteList(postwItem.list_id)">Delete</a></li>
          </ul>
          <ul id="dropdown-cat" class="dropdown-content dropdown-cat">
            <li><label><input name="indigo" value="indigo" v-model.lazy="postwItem.list_category" type="radio" />Blue</label></li>
            <li><label><input name="orange" value="orange" v-model.lazy="postwItem.list_category" type="radio" />Orange</label></li>
            <li><label><input name="pink" value="pink" v-model.lazy="postwItem.list_category" type="radio" />Pink</label></li>
            <li><label><input name="green" value="green" v-model.lazy="postwItem.list_category" type="radio" />Green</label></li>
            </ul> 
        </div>
          <div class="wItems">
              <div class="row header">
                <div class="col m9 s12">
            <label for="listTitle" class="noteTitleLabel">List title</label>
            <input type="text" v-model.lazy="postwItem.list_name" required="true" placeholder="List title" name="listTitle" class="list-title  grey-text text-darken-2"/>
        </div>
        <div class="col m3 s5 note-cats-wrapper" v-show="show.listing">
         
        <label class="cat-label">Category</label>
        <br>
        <select v-model="postwItem.list_category"  class="browser-default">
                     <option value="blue">Blue</option>
                     <option value="orange">Orange</option>
                     <option value="pink">Pink</option>
                     <option value="green">Green</option>
            </select>        
        </div>
        </div>
          
            <span class="listWItem" v-for="(item, index) in postwItem.item" :key="item.id">
              <label>
                <input type="checkbox" v-model="item.checked" class="filled-in">
                <span style="color:black; font-size:16px;">{{item.item}}</span>
              </label>
                <i class="fas fa-times grey-text right-align" style="float:right;" @click="removeWItem(index)"></i>
              <br>
            </span>
            <div class="addWItem row">
            <div class="col m11 s9">
              <br>
          <input name="name" v-model.lazy="addToWList.name"  v-on:keyup.enter="addwItem(addToWList.name, addToWList.list_id)" placeholder="Add item" class="input addwitem" min="1">
          </div>
          <div class="col m1 s3">
            <br>
                  <button class="btn-flat" @click="addwItem(addToWList.name, addToWList.list_id)"><i class="fas fa-plus"></i></button>
          </div> 
        </div>
          </div>
          
        </div>
  </div>
        <div class="col m3 s12">
      <div class="common-items" v-show="show.edit_mode">
      <div v-show="show.commons">

         
          <div class="listItems">
          <center>
            <h6 class="grey-text"><b>Common items</b></h6>
            <button class="add-item-button" @click="addItemShow()">Add item</button>
            </center>
            <div class="add-item row z-depth-1" v-show="show.addItem">
            <div class="col m9">
              <br>

              <input name="name" v-model.lazy="postItem.name" placeholder="Add a common item" class="input">
            </div>
            <div class="col m3">
              <br>
              <button class="btn" @click="addItem()"><i class="fas fa-plus"></i></button>
          </div>
          <div class="col m4 s4 right-align note-cats-wrapper">
              <label v-show="show.show_listing">Select color category</label>

              <p class="note-cats">
                <label>
                  <input name="indigo" value="indigo" v-model.lazy="postItem.category" type="radio" checked="checked">

                  <span class="indigo"></span>
                </label>

                <label>
                  <input name="orange" value="orange" v-model.lazy="postItem.category" type="radio">

                  <span class="orange"></span>
                </label>
                <br>
                <label>
                  <input name="pink" value="pink" v-model.lazy="postItem.category" type="radio">

                  <span class="pink"></span>
                </label>

                <label>
                  <input name="green" value="green" v-model.lazy="postItem.category" type="radio">

                  <span class="green"></span>
                </label>

                <label></label>
              </p>
            </div>
          </div>

            <div class="greenItems">
              <span class="listItem" v-for="item in green_items">
                <span class="itemname" @click="addwItem(item.name, postwItem.list_id)">{{item.name}}</span>

                <i class="fas fa-times grey-text" @click="removeItem(item.id)"></i>
              </span>
            </div>

            <div class="orangeItems">
              <span class="listItem" v-for="item in orange_items">
                <span class="itemname" @click="addwItem(item.name, postwItem.list_id)">{{item.name}}</span>

                <i class="fas fa-times grey-text" @click="removeItem(item.id)"></i>
              </span>
            </div>

            <div class="pinkItems">
              <span class="listItem" v-for="item in pink_items">
                <span class="itemname" @click="addwItem(item.name, postwItem.list_id)">{{item.name}}</span>

                <i class="fas fa-times grey-text" @click="removeItem(item.id)"></i>
              </span>
            </div>

            <div class="blueItems">
              <span class="listItem" v-for="item in blue_items">
                <span class="itemname" @click="addwItem(item.name, postwItem.list_id)">{{item.name}}</span>

                <i class="fas fa-times grey-text" @click="removeItem(item.id)"></i>
              </span>
            </div>
          </div>
      </div>
      <div class="shower center-align" @click="show.commons = true" v-show="! show.commons">
      <h6 class="grey-text"><b>Common items</b></h6>
          <i class="fas fa-angle-down fa-3x grey-text"></i>
        </div>
        <div class="shower center-align" @click="show.commons = false" v-show="show.commons">
          <i class="fas fa-angle-up fa-3x grey-text"></i>
        </div>
    </div>
    </div>
  </div>
  </div>
</div>
  <script src="js/vue.js"></script>
  <script src="js/axios.js"></script>
  <script src="js/two.js"></script>
  <script src="js/other.js"></script>
</body>

</html>