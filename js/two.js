var two = new Vue({
	el:"#vue-app-two",
	data: {
        show: {
            addItem: false,
            edit_mode: false,
            commons : false,
            listing: true
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
            item: []
        },
        listItems: [],
        listWItems: [],
        lists: [],
        addToWList: {
            name: "",
            list_id:""
        }
	},
	computed: {
		green_items : function() {
			var category = "green";
	
				return this.listItems.filter(function(item) {
					return item.category === category;
				});
            },
            
        blue_items : function() {
            var category = "indigo";

                return this.listItems.filter(function(item) {
                    return item.category === category;
                });
            },

        pink_items : function() {
            var category = "pink";

                return this.listItems.filter(function(item) {
                    return item.category === category;
                });
            },
        orange_items : function() {
            var category = "orange";
    
                return this.listItems.filter(function(item) {
                    return item.category === category;
                });
            },
		
		//return this.get_notes;
	},
	mounted: function(){
        this.getLists();
        this.getListItems();
        this.getListWItems();
	},
	watch: {
	},
	methods: {
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
                console.log("Here2");

                two.postwItem.item = [];
                //Set list detail name and id
                for (var i = 0; i < two.lists.length; i++) {
                    if(two.lists[i].id == index) {
                    two.postwItem.list_name = two.lists[i].list_name;
                    two.postwItem.list_id = two.lists[i].id;
                    two.postwItem.list_category = two.lists[i].category;

                    }
                }
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
                two.getLists();
                two.postwItem.list_id= response.data.last;
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
                        console.log("Here");
                        two.lists = response.data.lists;
                        if(two.postwItem.list_id !="") {
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
            }
	},

});
