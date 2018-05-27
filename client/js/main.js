function useApi(object) {
  switch (object) {
    case "customer":
      $("#customer-data").jsGrid({
        height: "auto",
        width: "100%",
        inserting: true,
        editing: true,
        sorting: true,
        autoload: true,
        paging: true,
        pageSize: 5,
        pageButtonCount: 5,
        deleteConfirm: "Do you really want to delete the customer?",
        
        controller: {
          loadData: function(filter) {
            return $.ajax({
                type: "GET",
                url: gURL + "customer/index.php",
                data: filter
            });
          },
          insertItem: function(item) {
            return $.ajax({
              type: "POST",
              url: gURL + "customer/index.php",
              data: item
            });
          },
          updateItem: function(item) {
            return $.ajax({
                type: "PUT",
                url: gURL + "customer/index.php",
                data: item
            });
          },
          deleteItem: function(item) {
            return $.ajax({
              type: "DELETE",
              url: gURL + "customer/index.php",
              data: item
            });
          }
        },          
        fields: [
          {name:'id', title: 'ID', type: 'number', inserting: false, editing: false, width: 20},
          {name:'companyname', title: 'Name', type: 'text'},
          {name:'address', title: 'Address', type: 'text'},
          {name:'phonenumber', title: 'Phone', type: 'text'},
          {name:'email', title: 'Email', type: 'text'},
          {name:'createdat', title: 'Created At'},
          {title: 'Edit', type: 'control'}
        ]
      });
      break;
    case "contact":
      $("#contact-data").jsGrid({
        height: "auto",
        width: "100%",
        inserting: true,
        editing: true,
        sorting: true,
        autoload: true,
        paging: true,
        pageSize: 5,
        pageButtonCount: 5,
        deleteConfirm: "Do you really want to delete the contact?",

        controller: {
          loadData: function(filter) {
            return $.ajax({
                type: "GET",
                url: gURL + "contact/index.php",
                data: filter
            });
          },
          insertItem: function(item) {
            return $.ajax({
              type: "POST",
              url: gURL + "contact/index.php",
              data: item
            });
          },
          updateItem: function(item) {
            return $.ajax({
                type: "PUT",
                url: gURL + "contact/index.php",
                data: item
            });
          },
          deleteItem: function(item) {
            return $.ajax({
              type: "DELETE",
              url: gURL + "contact/index.php",
              data: item
            });
          }
        },          
        fields: [
          {name:'id', title: 'ID', type: 'number', inserting: false, editing: false, width: 20},
          {name:'firstname', title: 'Firstname', type: 'text'},
          {name:'lastname', title: 'Lastname', type: 'text'},
          {name:'phonenumber', title: 'Phone', type: 'text'},
          {name:'email', title: 'Email', type: 'text'},
          {name:'company', title: 'Company', type: 'text', inserting: false, editing: false},
          {name:'createdat', title: 'Created At'},
          {title: 'Edit', type: 'control'}
        ]
      });
      break;
    case "user":
      $("#user-data").jsGrid({
        height: "auto",
        width: "100%",
        inserting: true,
        editing: true,
        sorting: true,
        autoload: true,
        paging: true,
        pageSize: 5,
        pageButtonCount: 5,
        deleteConfirm: "Do you really want to delete the user?",

        controller: {
          loadData: function(filter) {
            return $.ajax({
                type: "GET",
                url: gURL + "user/index.php",
                data: filter
            });
          },
          insertItem: function(item) {
            return $.ajax({
              type: "POST",
              url: gURL + "user/index.php",
              data: item
            });
          },
          updateItem: function(item) {
            return $.ajax({
                type: "PUT",
                url: gURL + "user/index.php",
                data: item
            });
          },
          deleteItem: function(item) {
            return $.ajax({
              type: "DELETE",
              url: gURL + "user/index.php",
              data: item
            });
          }
        },          
        fields: [
          {name:'id', title: 'ID', type: 'number', inserting: false, editing: false, width: 20},
          {name:'username', title: 'Username', type: 'text'},
          {name:'firstname', title: 'Firstname', type: 'text'},
          {name:'lastname', title: 'Lastname', type: 'text'},
          {name:'phonenumber', title: 'Phone', type: 'text'},
          {name:'email', title: 'Email', type: 'text'},
          {name:'roles', title: 'Roles', type: 'select', valueType: "string", items: [
            "user", "moderator", "admin"
          ],},
          {name:'createdat', title: 'Created At', inserting: false, editing: false},
          {name:'lastlogin', title: 'Last Login', inserting: false, editing: false},
          {title: 'Edit', type: 'control'}
        ]
      });
      break;
  }
}



