function readApi (object) {
  var returnHTML = "";
  
  $.ajax({
    url: "/jambs/api/customer/read.php",
    type: "GET",
    
    contentType: 'application/json; charset=utf-8',
    success: function(resultData) {
      $.each(resultData.records, function( key, value) {
        returnHTML += "<tr>"
        $.each(value, function( i, j ) {
          returnHTML += "<td>" + i + "</td><td>" + j + "</td>";
          //console.log(i + ": " + j);
        });
        returnHTML += "</tr>"
      });
    },
    error : function(jqXHR, textStatus, errorThrown) {
    },
    timeout: 120000,
  });

  return returnHTML;

};