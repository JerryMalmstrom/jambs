function readApi (object) {
  var returnHTML = "";
  var jsonURL = "";


    switch (object) {
      case "customers":
        jsonURL = gURL + "customer/read.php";
        break;
      case "users":
        jsonURL = gURL + "user/read.php";
        break;

      default:
        return "";
        break;
    }

    $.ajax({
      url: jsonURL,
      type: "GET",
      async: false,
      contentType: 'application/json; charset=utf-8',
      
      success: function(resultData) {
        $.each(resultData, function (i,j) {
          alert(i + ": " + j);
        })
      },
      error : function(jqXHR, textStatus, errorThrown) {
        alert(errorThrown);
      },
      complete : function() {
      }
    });
    return returnHTML;
  };