<!DOCTYPE html>
<html>
   <head>

      <title>SimplyNote</title>
      <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=0.9">
    <meta name="theme-color" content="#3367d6"/>
    <link rel="shortcut icon" href="img/notepad.png" type="image/x-icon" />
   <meta name="description" content="Free Note Taking App!">

    <link rel="manifest" href="manifest.json">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
      <!-- Compiled and minified JavaScript -->
      
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
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
      <div id="vue-app-one" class="vue-app">
         <div class="container-fluid">
            <div class="navbar-fixed" v-show="show.show_listing">
         <nav>
		<div class="nav-wrapper" >
			 <a href="index.php" class="brand-logo"><b>My notes</b></a>
			 <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down">
            <li class="active"><a href="#">My Notes</a></li>
               <li><a href="shoplist.php">My Lists</a></li>
               <li><a href="audio.html">My Audio</a></li>
               <li><a href="api/destroy.php">Logout</a></li>
                </ul>
          <ul id="more" class="dropdown-content">
          <li>Settings</li>
          <li>Logout</li>
          </ul>
          <ul class="sidenav" id="mobile-demo">
               <li class="black-text center-align"><b>SimplyNote 2019</b></li>
               <li class="active"><a href="#">My Notes</a></li>
              <li><a href="shoplist.php">My Lists</a></li>
              <li><a href="audio.html">My Audio</a></li>
              <li><a href="api/destroy.php">Sign out</a></li>
  </ul>
 
  
		</div>
 </nav>   
</div>   
       <div class="row">
               <div class="col m3 s12" v-show="show.show_listing">
               <div class="row filter-controls">
                  <div class="col m4 s4">
                  <span>Filter notes</span> 
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
               </div>
                </div>   

                  <div class="note_list" v-for="note in get_filtered_notes">
                     <div class="row" @click="getNote(note.note_id)">
                        <div class="col m12">
                           <span v-bind:class="note.note_category" class="note-cat"></span>
                           <h6><b>{{note.note_title}}</b></h6><br/>
                           <p class="truncat" v-html="note.note" style="font-size:12px !important; max-width:80%;"> </p>
                           <span class="date">{{note.updated}}</span>
                        </div>
                       <!-- <div class="col m4">
                           <div class="action-buttons">
                               <i class="fas fa-share-alt fa-lg" v-if="note.share_id"></i>
                              <i class="fas fa-trash-alt" v-if="note.privilege_id==2 || note.privilege_id==null || note.owner_id == profile.user_id" @click="deleteNote(note.note_id)"></i>
                           </div>
                        </div>-->
                     </div>
                  </div>
               </div>
               <div class="col m9" style="padding:0px;">
                  <div class="working-bench">
                  <span v-bind:class="post.notePost.note_category" class="cat-span"></span>
                     <div class="create-new" v-show="show.edit_mode">
                        <div class="row controls" >
                           <div class="col m12 s12">
                              <span><i class="fas fa-save" @click="sendNotes" ></i></span>
                              <a href="#" class="dropdown-trigger right right-align" data-target="dropdown1" v-show="! show.show_listing">
                              <i class="fas fa-ellipsis-v"></i>
                              </a>
                              <a href="#" class="dropdown-trigger right right-align" data-target="dropdown-cat" v-show="! show.show_listing">
                              <i class="fas fa-tag"></i>
                              </a>
                             <!-- <i class="fas fa-info-circle fa-lg" @click="showInfo" v-show="show.show_listing"></i>
                              <i class="fas fa-bell fa-lg" @click="showCalendar" v-show="show.show_listing"></i>
                                <i class="fas fa-envelope fa-lg" @click="moreEmailOptions" v-show="show.show_listing"></i>
-->                          <!-- <i class="fas fa-arrow-left" @click="show.edit_mode = !show.edit_mode; show.show_listing = true"></i>-->
                              <i class="fas fa-share-alt  fa-lg" @click="shareDialog" v-show="show.show_listing && post.notePost.privilege != 1"></i>
                           <i class="fas fa-print fa-lg " @click="exportPDF" v-show="show.show_listing"></i>
                          <i class="fas fa-trash fa-lg " @click="deleteNote(post.notePost.note_id)"  v-show="show.show_listing && post.notePost.privilege != 1"></i>
                           <ul id="dropdown1" class="dropdown-content">
                           <li><a href="#" @click="show.edit_mode = !show.edit_mode; show.show_listing = true">Back without save</a></li>
                           <li><a href="#" @click="exportPDF">To PDF</a></li>
                           <li><a href="#" @click="show.edit_mode = !show.edit_mode; show.listing = true">Share</a></li>
                           <li><a href="#" @click="deleteNote(post.notePost.note_id)">Delete</a></li>
                           </ul>
                           <ul id="dropdown-cat" class="dropdown-content dropdown-cat">
                           <li><label><input name="indigo" value="indigo" v-model.lazy="post.notePost.note_category" type="radio" />Blue</label></li>
                           <li><label><input name="orange" value="orange" v-model.lazy="post.notePost.note_category" type="radio" />Orange</label></li>
                           <li><label><input name="pink" value="pink" v-model.lazy="post.notePost.note_category" type="radio" />Pink</label></li>
                           <li><label><input name="green" value="green" v-model.lazy="post.notePost.note_category" type="radio" />Green</label></li>
                           </ul>                   
                           </div>
                        </div>
                        <input type="hidden" v-model.lazy="post.notePost.note_id" />
                        <div class="row note-header">
                        <div class="col m10 s12">
                        <label for="noteTitle" class="noteTitleLabel">Note title</label>
                        <input type="text" v-model.lazy="post.notePost.note_title" required="true" placeholder="Note title" name="noteTitle" class="note-title grey-text text-darken-1"/>
                        <span v-show="post.notePost.privilege == 1">Shared by {{post.notePost.owner}}</span>
                              <span v-show="post.notePost.shared && post.notePost.privilege != 1">
                        <span @click="shareDialog" style="cursor:pointer; font-style:italic; text-decoration: underline;">Shared list <i class="fas fa-share grey-text"></i></span>
                        </span>
                        </div>
                        <div class="col m2 s5 right-align note-cats-wrapper right-align" v-show="show.show_listing">
                           <label>Category</label>
                        <select v-model="post.notePost.note_category" class="browser-default">
                        <option value="blue">Blue</option>
                        <option value="orange">Orange</option>
                        <option value="pink">Pink</option>
                        <option value="green">Green</option>
                        <option value="brown">Brown</option>
                   </select>
                  </div>
                  </div>
                  <div id="editor">
               </div>
      
               <textarea v-model="post.notePost.note" style="display:none;"></textarea>
                     </div>
                     <a id="scale-demo" @click="newui" v-show="! show.edit_mode" href="#!" class="btn-floating btn-large scale-transition add-note">
                        <i class="material-icons white-text">add</i>
                     </a> 
                     <a id="scale-demo" @click="sendNotes" href="#!" v-show="show.edit_mode && show.show_listing" class="btn-floating btn-large scale-transition add-note">
                        <i class="material-icons white-text">save</i>
                     </a>

                  </div>
               </div>
            </div>
         </div>
         <div class="share-dialog" v-show="show.shareDialog" @click="shareDialog">
</div>
         <div class="context" v-show="show.shareDialog">
<h5 class="center-align">Sharing options</h5>
<h6 class="center-align">Shared to users</h6>
<div v-for="user in share.toUsers" style="border:1px solid lightgray; padding:5px; margin:3px;">
{{user.email}}
<i class="fas fa-times right grey-text" @click="cancelUserShare(user.user_id, post.notePost.note_id)"></i>
</div>
<input placeholder="Email" min="1" type="email" v-model="share.email">
<button class="btn-flat active" @click="shareNote(post.notePost.note_id)">Share</button>
</div>
      </div>
      <script src="js/vue.js"></script>
      <script src="js/axios.js"></script>
      <script src="js/app.js"></script>
      <script src="js/other.js"></script>
      <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<!-- Initialize Quill editor -->
<script>
  var toolbarOptions = [
  ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
  ['blockquote', 'code-block'],

  [{ 'header': 1 }, { 'header': 2 }],               // custom button values
  [{ 'list': 'ordered'}, { 'list': 'bullet' }],
  [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
  [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
  [{ 'direction': 'rtl' }],                         // text direction

  //[{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
  [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

  [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
  [{ 'font': [] }],
  [{ 'align': [] }],

  ['clean']                                         // remove formatting button
];

var quill = new Quill('#editor', {
  modules: {
    toolbar: toolbarOptions
  },
  theme: 'snow'
});
</script>
   </body>

</html>

