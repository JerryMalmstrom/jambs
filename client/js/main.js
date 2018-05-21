function readApi (object) {
  var returnHTML = "";
  
    $.ajax({
      url: gURL + "customer/read.php",
      type: "GET",
      async: false,
      contentType: 'application/json; charset=utf-8',
      
      success: function(resultData) {
        $.each(resultData.records, function( key, value) {
          returnHTML += "<tr>";
          $.each(value, function( i, j ) {
            returnHTML += "<td>";
            returnHTML += j;
            returnHTML += "</td>";
            //console.log(i + ": " + j);
          });
          returnHTML += "</tr>";
        });

        
      },
      error : function(jqXHR, textStatus, errorThrown) {
        alert(errorThrown);
      },
      complete : function() {
        //alert(returnHTML);
      }
    });

    return returnHTML;

  };