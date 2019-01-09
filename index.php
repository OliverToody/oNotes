<!DOCTYPE html>
<html>
   <head>
      <title>oNotes</title>
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
         <nav>
		<div class="nav-wrapper">
			 <a href="index.php" class="brand-logo">oNotes</a>
			 <ul id="nav-mobile" class="right hide-on-med-and-down">
					<li @click="newui"><a><i class="fas fa-plus"></i></a></li>
					<li><a href="about.html"><i class="fas fa-info-circle"></i></a></li>
					<li><a href="settings.html"><i class="fas fa-user-alt"></i></a></li>
					<li><a href="#" onclick="signOut();">Sign out</a></li>
       </ul>
          <ul class="sidenav" id="mobile-demo">
          <li @click="newui"><a><i class="fas fa-plus"></i></a></li>
					<li><a href="about.html"><i class="fas fa-info-circle"></i></a></li>
					<li><a href="settings.html"><i class="fas fa-user-alt"></i></a></li>
					<li><a href="#" onclick="signOut();">Sign out</a></li>
        </ul>
		</div>
 </nav>            <div class="row">
               <div class="col m3 s12">
                  <h5>Your notes</h5>
                  <div class="g-signin2" data-onsuccess="onSignIn" style="display:none;"></div>

                  <div class="note_list" v-for="note in get_notes">
                     <div class="row" @click="getNote(note.note_id)">
                        <div class="col m8">
                           <span v-bind:class="note.note_category" class="note-cat"></span>
                           <h6><b>{{note.note_title}}</b></h6><br/>
                           <p class="hide-on-med-and-up show-on-small">{{note.note}}</p>
                           <span class="date">{{note.updated}}</span>
                        </div>
                        <div class="col m4">
                           <div class="action-buttons">
                               <i class="fas fa-share-alt fa-lg" v-if="note.share_id"></i>
                              <i class="fas fa-trash-alt" v-if="note.privilege_id==2 || note.privilege_id==null || note.owner_id == profile.user_id" @click="deleteNote(note.note_id)"></i>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col m9">
                  <div class="working-bench">
                     <div class="create-new" v-show="show.edit_mode">
                        <div class="row controls">
                           <div class="col m6">
                              <i class="fas fa-arrow-left" @click="show.edit_mode = !show.edit_mode"></i>
                              <i class="fas fa-info-circle fa-lg" @click="showInfo"></i>
                             <!-- <i class="fas fa-bell fa-lg" @click="showCalendar"></i>
                                <i class="fas fa-envelope fa-lg" @click="moreEmailOptions"></i>
                              <i class="fas fa-share-alt fa-lg" @click="showSharing"></i>-->
                           <i class="fas fa-print fa-lg" @click="exportPDF"></i>
                           <i class="fas fa-trash-alt delete fa-lg" @click="deleteNote(post.notePost.note_id)"></i>
                           </div>
                           <div class="col m6 right-align">
                           
                           <i class="fas fa-save save fa-lg" @click="sendNotes"></i>
                   
                           </div>
                        </div>
                        <div class="show-calendar" v-show="show.show_calendar">
                           <p>Set a date when you want to be reminded via email.</p>  
                           <input type="text" v-model.lazy="post.notePost.deadline" class="datepicker">
                           <button class="btn" @click="sendNotes">Remind me on this date</button>
                        </div>
                        <div class="show-sharing" v-show="show.show_sharing">
                        <i class="fa fa-share-alt fa-lg"></i>
                        <span class="input-field">
                        <input v-model="share.shared_to_user" name="share_user" placeholder="Share to user">
                        </span>
                        <select v-model="share.privilege">
                           <option value="" disabled selected>Choose privilege</option>
                           <option value="1">View</option>
                           <option value="2">Edit</option>
                           <option value="3">Full permissions</option>
                        </select>
                        <button class="btn" @click="shareNote(post.notePost.note_id)">Share note</button>
                        </div>
                        <div class="show-info" v-show="show.show_info">
                        <span><b>Created:</b> {{post.notePost.created}}</span>
                        <div v-if="post.sharingInfo.ownerName != profile.nickname">
                        <span v-if="post.sharingInfo.privilege_name"><br/> <b>{{post.sharingInfo.privilege_name}}</b> permission granted from the note owner({{post.sharingInfo.ownerName}}).</span>
                        <span v-if="post.sharingInfo.privilege_description"><br> {{post.sharingInfo.privilege_description}}</span>
                       </span>
                       
                        </div>
                        <div v-if="post.sharingInfo.ownerName == profile.nickname">

                       <span><b>Note shared to:</b></span>
                       <span v-for="users in post.sharingInfo.users">
                       <span>{{users}}
                       </div>
                        </div>
                        <div class="more-email-options" v-show="show.more_email_options">
                        
                        <h6>Email options</h6>
                        <label>
                        <input name="email" value="me"  type="radio" checked />
                        <span class="">Email to me</span>
                        </label>
                        <label>
                        <input name="email"  value="custom" type="radio"  />
                        <span class="">Custom Email</span>
                        <button class="btn teal" @click="sendEmail">Send email</button>
                        </label>
                        </div>       
                        <input type="hidden" v-model.lazy="post.notePost.note_id" />
                        <div class="row note-header">
                        <div class="col m6 s12 input-field">
                        <label for="noteTitle">Note title</label>
                        <input type="text" v-model.lazy="post.notePost.note_title" required="true" placeholder="Note title" name="noteTitle" class="note-title"/>
                        <span v-if="post.sharingInfo.privilege_name" @click="showInfo"><i>
                        <span v-if="post.sharingInfo.ownerName == profile.nickname">You shared this note</span>
                         <span v-if="post.sharingInfo.ownerName != profile.nickname">Shared note by {{post.sharingInfo.ownerName}}</span></i></span>
                        </div>
                        <div class="col m6 s12 right-align note-cats-wrapper">
                        <label>Select color category</label>
                        <p class="note-cats">
                        <label>
                        <input name="blue" value="blue" v-model.lazy="post.notePost.note_category" type="radio" checked />
                        <span class="blue"></span>
                        </label>
                        <label>
                        <input name="orange"  value="orange" v-model.lazy="post.notePost.note_category" type="radio"  />
                        <span class="orange"></span>
                        </label>
                        <label>
                        <input name="pink" value="pink" v-model.lazy="post.notePost.note_category" type="radio"  />
                        <span class="pink"></span>
                        </label>
                        <label>
                        <input name="green" value="green" v-model.lazy="post.notePost.note_category" type="radio"  />
                        <span class="green"></span>
                        </label>
                        <label>
                        <label>
                        <input name="brown" value="brown" v-model.lazy="post.notePost.note_category" type="radio"  />
                        <span class="brown"></span>
                        </label>
                     </p>
                  </div>
                  </div>
                  <div id="editor">
               </div>
               <textarea v-model="post.notePost.note" style="display:none;"></textarea>
                     </div>
                     <div class="new_div center-align" v-show="!show.edit_mode">
                     <div @click="newui" class="new center-align">
                           <h1 id="date"></h1>
                           <h4 id="time"></h4>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
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

  [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
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

