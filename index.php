<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>Google Maps AJAX + mySQL/PHP Example</title>
<style type="text/css">
body {
	font-family: 'Exo 2', sans-serif;
}
#map {
	height: 100%;
	position: absolute;
	top: 0;
	bottom: -200px;
	left: 0;
	right: 0;
	z-index: 0;
}
#header {
	z-index: 100;
	position: relative;
 	background-image: url(img/transparant.png);
	background-repeat: repeat;
	color: #fff;
	padding: 5px;
}
#tab {
	z-index: 100;
	position: relative;
	width: 50px;
	background-image: url(img/transparant.png);
	background-repeat: repeat;
	color: #fff;
	padding: 5px;
	display: block;
	float: right;
	-moz-border-radius: 4px;
	border-radius: 2px;
	top: 10px;
	right: 10px;
}
#box {
	z-index: 100;
	position: relative;
	width: 150px;
	height: 300px;
	background-image: url(img/transparant.png);
	background-repeat: repeat;
	color: #fff;
	padding: 5px;
	display: block;
	float: right;
	-moz-border-radius: 4px;
	border-radius: 2px;
	top: 50px;
	right: -50px;
	
	float: right;
}
</style>
<script src="http://maps.google.com/maps/api/js?sensor=false"
            type="text/javascript"></script>
<script type="text/javascript">
    //<![CDATA[

    var customIcons = {
      restaurant: {
        icon: 'img/red.png',
        shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
      },
      bar: {
        icon: 'img/blue.png',
        shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
      }
    };

    function load() {
      var map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(47.6145, -122.3418),
        zoom: 13,
        mapTypeId: 'roadmap'
      });
      var infoWindow = new google.maps.InfoWindow;

      // Change this depending on the name of your PHP file
      downloadUrl("phpsqlajax_genxml2.php", function(data) {
        var xml = data.responseXML;
        var markers = xml.documentElement.getElementsByTagName("marker");
        for (var i = 0; i < markers.length; i++) {
          var name = markers[i].getAttribute("name");
          var address = markers[i].getAttribute("address");
          var type = markers[i].getAttribute("type");
          var point = new google.maps.LatLng(
              parseFloat(markers[i].getAttribute("lat")),
              parseFloat(markers[i].getAttribute("lng")));
          var html = "<b>" + name + "</b> <br/>" + address;
          var icon = customIcons[type] || {};
          var marker = new google.maps.Marker({
            map: map,
            position: point,
            icon: icon.icon,
            shadow: icon.shadow
          });
          bindInfoWindow(marker, map, infoWindow, html);
        }
      });
    }

    function bindInfoWindow(marker, map, infoWindow, html) {
      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
    }

    function downloadUrl(url, callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;

      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request, request.status);
        }
      };

      request.open('GET', url, true);
      request.send(null);
    }

    function doNothing() {}

    //]]>
  </script>
  <script>
$(document).ready(function(){
  $("#tab").click(function(){
    $("#box").slideToggle("slow");
  });
});
</script>
</head>
<body onload="load()">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<div id="header">Hello World</div>
<div id="tab">Filter</div>
<div id="box">
  <p>Buikpijn</p>
  <p>Hoofdpijn</p>
</div>
<div id="map"/>
</div>
</body>
</html>