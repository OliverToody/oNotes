var two = new Vue({
	el:"#vue-app-two",
	data: {
        show: {
            addItem: false,
            edit_mode: false,
            commons : false,
            listing: true,
            shareDialog: false
        },
        postItem: {
            id: "",
            name: "",
            category:""
        },
        postwItem: {
            list_id:"",
            list_name: "",
            list_category: "",
            privilege: "",
            owner: "",
            shared: false,
            item: []
        },
        profile: {
			nickname: "",
			email:"",
			user_id:""
		},
        listItems: [],
        listWItems: [],
        lists: [],
        addToWList: {
            name: "",
            list_id:""
        },
        share: {
            email: "",
            toUsers: "",
            list_id: ""
        },
	},
	computed: {
		},
	mounted: function(){
        this.getLists();
        this.getListItems();
        this.getListWItems();
        this.getProfile();
	},
	watch: {
    },
    created () {
        document.addEventListener("backbutton", this.goBack, false);
        console.log("created");
    },
    beforeDestroy () {
        document.removeEventListener("backbutton", this.goBack);
      },
	methods: {
        goBack: function() {
            window.history.pushState({ noBackExitsApp: true }, '');

            console.log("tusom");
            two.show.edit_mode = false;
        },
            addItemShow: function() {
                two.show.addItem = ! two.show.addItem;
            },
            addItem: function() {
                if(two.postItem.id == "") {
                axios.post('api/list.php', JSON.stringify(this.postItem)
                  ).then(function (response) {
                      console.log(response);
                      two.getListItems();

                    }).catch(function (error) {
                    console.log(error);
                    });
                }
            },
            removeItem: function(index) {
                axios.delete('api/list.php?item_id=' + index).then(function (response) {
                    two.getListItems();
    
                  }).catch(function (error) {
                    console.log(error);
                    });
            },
            getListItems: function() {
                axios.get('api/list.php')
				.then(function(response){
					if(response.data.error){
						console.log(response.data.message);
					}
					else{
                        two.listItems = response.data.listItems;
					}
				});
            },
            getListWItems: function() {
                axios.get('api/wlist.php')
				.then(function(response){
					if(response.data.error){
						console.log(response.data.message);
					}
					else{
                        two.listWItems = response.data.listWItems;
					}
				});
            },
            listDetail: function(index) {
                two.postwItem.item = [];
                //Set list detail name and id
                for (var i = 0; i < two.lists.length; i++) {
                    if(two.lists[i].id == index) {
                    two.postwItem.list_name = two.lists[i].list_name;
                    two.postwItem.list_id = two.lists[i].id;
                    two.postwItem.list_category = two.lists[i].category;
                    two.postwItem.privilege = two.lists[i].privilege;
                    two.postwItem.owner = two.lists[i].email;
                    }
                }
                console.log(two.postwItem);

                //Set list items
                for (var i = 0; i < two.listWItems.length; i++) {
                    if(two.listWItems[i].list_id == index) {
                        two.postwItem.item.push(two.listWItems[i]);
                    }  

            }
            two.show.edit_mode = true;
            if(screen.width < 600) {
				two.show.listing = false;
            }
            
            if(navigator.onLine) { // true|false
                two.getUserShares(index);
            }
                

            for (var i = 0; i < two.postwItem.item.length; i++) {
                if(two.postwItem.item[i].checked == '1') {
                    two.postwItem.item[i].checked = true;
                } else {
                    two.postwItem.item[i].checked = false;

                }
            }
            },
            addwItem: function(name, list_id) {
                two.postwItem.item.push({"item": name, "list_id": list_id, "checked": false});
                two.addToWList.name = "";
                if(screen.width > 600) {
                $(".addwitem").focus();
                }
            },
            removeWItem: function(index) {
                this.postwItem.item.splice(index, 1);

            },
            saveList: function(id) {
            console.log(JSON.stringify(two.postwItem));
              axios.post('api/wlist.php', JSON.stringify(two.postwItem)
                ).then(function (response) {
                two.postwItem.item = [];
                two.postwItem.list_id = "";
                two.postwItem.list_name = "";
                two.postwItem.shared = false;
                two.getLists();
                two.getListWItems();
                two.show.edit_mode = false;
                two.show.listing = true;
                  }).catch(function (error) {
                  console.log(error);
                  });
            },
            createList: function() {
                axios.post('api/listManage.php', JSON.stringify("")
                ).then(function (response) {
                two.postwItem.list_id="";
                two.postwItem.list_name="";
                two.postwItem.item= [];
                two.postwItem.list_id= response.data.last;
                two.getLists();
     
                  }).catch(function (error) {
                  console.log(error);
                  });

            },
            getLists: function() {
                axios.get('api/listManage.php')
				.then(function(response){
					if(response.data.error){
						console.log(response.data.message);
					}
					else{
                        two.lists = response.data.lists;
                        if(two.postwItem.list_id != "") {
                            two.listDetail(two.postwItem.list_id);

                        }
					}
				});
            },
            deleteList: function(index) {
                axios.delete('api/listManage.php?item_id=' + index).then(function (response) {
                    two.getLists();
                    two.getListWItems();
                    two.postwItem.list_id = "";
                    two.postwItem.name = "";
                    two.show.edit_mode = false;
                    two.show.listing = true;
                  }).catch(function (error) {
                    console.log(error);
                    });
            },
            shareDialog: function() {
                two.show.shareDialog = ! two.show.shareDialog;
                two.getUserShares(two.postwItem.list_id);
            },
            shareList: function(listId) {
                two.share.list_id = listId;
                two.show.shareDialog = ! two.show.shareDialog;
                axios.post('api/shareList.php', JSON.stringify(two.share)
                ).then(function (response) {
                two.getLists();
                  }).catch(function (error) {
                  console.log(error);
                  });
            },
            getUserShares: function(listId) {
                axios.get('api/shareList.php?list_id=' + listId
                ).then(function (response) {
                    two.share.toUsers = response.data.sharedToUsers;
                    if(two.share.toUsers.length) {
                        two.postwItem.shared = true;
                    } else {
                        two.postwItem.shared = false;
    
                    }
                  }).catch(function (error) {
                  console.log(error);
                  });
            },
            cancelUserShare: function(user_id, list_id) {
                axios.delete('api/shareList.php?user_id=' + user_id + "&list_id=" + list_id).then(function (response) {

                    two.getUserShares(list_id);
                  }).catch(function (error) {
                    console.log(error);
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
                            two.profile.email = response.data.email;
                            two.profile.nickname = response.data.nickname;
                            two.profile.user_id = response.data.user_id;	
                        }
                    });
            }
	},

});
