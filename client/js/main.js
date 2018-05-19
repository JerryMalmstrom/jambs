$(document).ready(function() {
  // create sidebar and attach to menu open
  $('.ui.sidebar').sidebar('attach events', '.toc.item');

  readApi("customers");
});

function readApi (object) {
  $.ajax({
    url: "http://localhost/jmapi/api/customer/read.php",
    type: "GET",

    contentType: 'application/json; charset=utf-8',
    success: function(resultData) {
      console.log(resultData);
      
      $.each(resultData.records, function( key, value) {
        $.each(value, function( i, j ) {
          console.log(i + ": " + j);
        });
        //console.log(key + ": " + value.address);
      });
    

    },
    error : function(jqXHR, textStatus, errorThrown) {
    },
    timeout: 120000,
});

};