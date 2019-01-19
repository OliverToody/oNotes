
Vue.component('menu1', {
		template: ` <nav>
		<div class="nav-wrapper">
			 <a href="index.php" class="brand-logo white-text">Edyssea</a>
			 <ul id="nav-mobile" class="right hide-on-med-and-down">
					<li @click="newui"><a><i class="fas fa-plus"></i></a></li>
					<li><a href="about.html"><i class="fas fa-info-circle"></i></a></li>
					<li><a href="settings.html"><i class="fas fa-user-alt"></i></a></li>
					<li><a href="api/destroy.php"><i class="fas fa-sign-out-alt"></i></a></li>
			 </ul>
		</div>
 </nav>`,
	});
  
var one = new Vue({
	el:"#vue-app-one",
	data: {
		post: 
			{
			notePost: {
				note: "",
				note_title: "",
				note_id:"",
				note_category:"",
				updated: "",
				created:"",
				deadline: ""
				},
			sharingInfo: {
				privilege_name: "",
				privilege_description: "",
				ownerName: "",
				privilege_id: "",
				owner_id:"",
				users: [],
				test: ""
			}
		},
		get_notes: [],
		get_note: [],
		email: {
			email_subject: "",
			email_content: ""
		},
		profile: {
			nickname: "",
			email:"",
			user_id:""
		},
		share: {
			privilege: "",
			shared_to_user: "",
			note_id: "",
			owner_id: ""
		},
		shareInfo: {
			users: []
		},
		show: {
			edit_mode: false,
			more_email_options: false,
			show_info: false,
			show_sharing: false,
			show_calendar: false,
			show_listing: true
		},
		filter_cat: "All"
				
	},
	computed: {
		get_filtered_notes : function() {
			//var vm = this;
			var category = this.filter_cat;
			console.log(category);
			if(category === "All") {
				return this.get_notes;
			} else {
				return this.get_notes.filter(function(note) {
					return note.note_category === category;
				});
			}
		
		//return this.get_notes;
	}
	},
	mounted: function(){
		this.getNotes();
		this.getProfile();

	},
	watch: {
		value: function(){
			let html = this.instance.getData();
			if(html != this.value){
				this.instance.setData(this.value)
				console.log(this.value)
			}
		}
	},
	methods: {
		newui: function() {
			this.show.edit_mode = ! this.show.edit_mode;
			one.post.notePost.note = "";
			one.post.notePost.note_category = "blue";
			one.post.notePost.note_title = "";
			one.post.notePost.note_id = "";
			one.post.notePost.updated = new Date();
			one.post.notePost.created = new Date();
			one.show.show_listing = false;

			$('.ql-toolbar').show();
			$('input.note-title').prop('disabled', false);
			$('.fa-save,.controls  .fa-share-alt, .note-cats-wrapper, .delete').show();
			quill.enable();
			$('.ql-editor').html("");
	
		},
		sendNotes: function() {
			console.log(one.post.notePost.deadline);
			one.post.notePost.deadline = one.post.notePost.deadline + " 00:00:00";
			one.show.edit_mode = false;
			one.show.show_listing = true;
			one.post.notePost.note = $('.ql-editor').html();
			if(one.post.notePost.note_id == "") {
			axios.post('api/notes.php', JSON.stringify(this.post)
			  ).then(function (response) {
				one.getNotes();
			  }).catch(function (error) {
				console.log(error);
				});
			} else {
				axios.put('api/notes.php', JSON.stringify(this.post)
			  ).then(function (response) {
				one.getNotes();
			  }).catch(function (error) {
				console.log(error);
				});				
			}
			one.post.notePost.note = "";
			one.post.notePost.note_title = "";
			one.post.notePost.note_id = "";
			one.post.notePost.note_category = "";
			one.post.notePost.deadline = "";

		},
		getNotes: function() {
			axios.get('api/notes.php')
				.then(function(response){
					if(response.data.error){
						console.log(response.data.message);
					}
					else{
						one.get_notes = response.data.notes;
						
					}
				});
		},
		getProfile: function() {
			axios.get('api/profile.php')
				.then(function(response){
					console.log(response);
					if(response.data.error){
						console.log("tu" +response.data.message);
					}
					else{
						one.profile.email = response.data.email;
						one.profile.nickname = response.data.nickname;
						one.profile.user_id = response.data.user_id;	
					}
				});
		},
		getNote: function(index) {
			console.log(index);
			one.show.edit_mode = true;
			if(screen.width < 600) {
				one.show.show_listing = false;
			}
			console.log(one.get_notes);
			for (var i = 0; i < one.get_notes.length; i++) {
				if(one.get_notes[i].note_id == index) {
					one.post.notePost.note =	one.get_notes[i].note;
					one.post.notePost.note_title =	one.get_notes[i].note_title;
					one.post.notePost.note_id =	one.get_notes[i].note_id;
					one.post.notePost.note_category =	one.get_notes[i].note_category;
					one.post.notePost.updated =	one.get_notes[i].updated;
					one.post.notePost.created =	one.get_notes[i].created;
					one.post.notePost.deadline = one.get_notes[i].deadline;
					one.post.sharingInfo.ownerName = one.get_notes[i].ownerName;
					one.post.sharingInfo.privilege_name =	one.get_notes[i].privilege_name;
					one.post.sharingInfo.privilege_description =	one.get_notes[i].privilege_description;
					one.post.sharingInfo.privilege_id =	one.get_notes[i].privilege_id;
					one.post.sharingInfo.owner_id =	one.get_notes[i].owner_id;
					one.post.sharingInfo.users = [];
					$('.ql-editor').html(one.post.notePost.note);
					one.getSharingInfo(one.post.notePost.note_id);

				}
			}
		},
		deleteNote: function(index) {
			one.show.edit_mode = false;
			one.show.show_listing = true;

			axios.delete('api/notes.php?note_id=' + index).then(function (response) {
				one.getNotes();
				one.show.edit_mode = false;


			  }).catch(function (error) {
				console.log(error);
				});
			
			},

		sendEmail: function(note_id) {
			one.show.more_email_options = ! one.more_email_options;
			one.email.email_content = one.post.notePost.note;
			one.email.email_subject = one.post.notePost.note_title;
			one.email.email_sender = one.profile.name;
			one.email.email_recepient = one.profile.recepient;

			axios.post('api/email.php', JSON.stringify(this.email)
			  ).then(function (response) {
			  }).catch(function (error) {
				console.log(error);
				});
		},
		exportPDF: function() {
			printJS({ printable: 'editor', type: 'html', header: 'PrintJS - Form Element Selection',showModal:true });
		},
		showInfo: function() {
			one.show.more_email_options = false;
			one.show.show_sharing = false;
			one.show.show_info = ! one.show.show_info;
			one.show.show_calendar = false;

		},
		moreEmailOptions: function() {
			one.show.more_email_options = ! one.show.more_email_options;
			one.show.show_info = false;
			one.show.show_sharing = false;
			one.show.show_calendar = false;

		},
		showSharing: function() {
				one.show.show_sharing= ! one.show.show_sharing;
				one.show.show_info = false;
				one.show.more_email_options = false;
				one.show.show_calendar = false;

		},
		showCalendar: function() {
			one.show.show_calendar = ! one.show.show_calendar;
			one.show.show_info = false;
			one.show.more_email_options = false;
			one.show.show_sharing = false;
	},
		shareNote: function(note_id) {
			one.sendNotes();
			one.share.note_id = note_id;
			one.share.owner_id = one.profile.user_id;

			axios.post('api/shareNote.php', JSON.stringify(this.share)
			  ).then(function (response) {
				console.log(response);
			  }).catch(function (error) {
				console.log(error);
				});
		},
		getSharingInfo: function(note_id) {
			//if(one.get_notes[i].owner_id != one.profile.user_id) {
				if(one.post.sharingInfo.privilege_id == 1 && one.post.sharingInfo.owner_id != one.profile.user_id) {
					quill.disable();
					$('.ql-toolbar').hide();
					$('input.note-title').prop('disabled', true);
					$('.fa-save, .delete,.controls .fa-share-alt, .note-cats-wrapper').hide();
				} 
				else if (one.post.sharingInfo.privilege_id == 2 && one.post.sharingInfo.owner_id != one.profile.user_id) {
					quill.enable();
					$('.ql-toolbar').show();
					$('input.note-title').prop('disabled', false);
					$('.fa-save,  .note-cats-wrapper').show();
					$('.delete').hide();
				} else {
					quill.enable();
					$('.ql-toolbar').show();
					$('input.note-title').prop('disabled', false);
					$('.fa-save,.controls  .fa-share-alt, .note-cats-wrapper, .delete').show();
				}
			//}
			axios.get('api/shareNote.php?note_id=' + note_id)
				.then(function(response){
					if(response.data.error){
						console.log(response.data.message);
					}
					else{
						one.post.sharingInfo.test = response.data.shared_to;
						for (var i = 0; i < one.post.sharingInfo.test.length; i++) {
							one.post.sharingInfo.users.push(one.post.sharingInfo.test[i].username);
						}
					}
				});
		},
		signOut: function() {
			var auth2 = gapi.auth2.getAuthInstance();
			console.log(auth2);
			auth2.signOut().then(function () {
			  console.log('User signed out.');
			});
		
		}
	},

});

