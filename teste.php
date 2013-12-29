<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">  
  <title>Localização do usuário via Geo IP</title>
  <style type="text/css" media="screen">
	body,html{
	background:#666	;
	color:#ccc;
	padding:50px;
	margin:0;
	}

	#doc{
	width:700px;
	margin:0 auto;
	background:#f8f8f8;
	color:#333;
	border:1em solid #f8f8f8;
	font-family:georgia,serif;
	} 

	h1,h2,h3{
	color:#369;
	}

	li{
	list-style-type:none;
	}

	#info{
	height:400px;
	}

	#map{
	margin:0 auto;
	min-height:200px;
	width:300px;
	position:relative;
	float:left;   
	padding:25px;
	}
  </style>
</head>
<body>
<div id="doc">
  <div id="map"></div>
  <div  id="info"></div>
</div>
<script type="text/javascript" src="http://j.maxmind.com/app/geoip.js"></script>
<script>
(function(){

  var info = document.getElementById('info');
  var lat = geoip_latitude();
  var lon = geoip_longitude();
  var city = geoip_city();
  var out = '<h3>Informações para seu IP</h3>'+ 
            '<ul>'+
            '<li>Latitude: ' + lat + '</li>'+
            '<li>Longitude: ' + lon + '</li>'+
            '<li>Cidade: ' + city + '</li>'+
            '<li>Cód. Região: ' + geoip_region() + '</li>'+
            '<li>Região: ' + geoip_region_name() + '</li>'+
            '<li>Código do País: ' + geoip_country_code() + '</li>'+
            '<li>Nome do País: ' + geoip_country_name() + '</li>'+
            '</ul>';
  info.innerHTML = out;
  var url = 'http://maps.google.com/maps/api/staticmap?center='+
            lat+','+lon+'&sensor=false&size=300x300&maptype=roadmap&key='+
            'ABQIAAAAijZqBZcz-rowoXZC1tt9iRT2yXp_ZAY8_ufC3CFXhHIE1NvwkxQQBCa'+
            'F1R_k1GBJV5uDLhAKaTePyQ&markers=color:blue|label:I|'+lat+
            ','+lon+'6&visible='+lat+','+lon+'|'+(+lat+1)+','+(+lon+1);
  var map = document.getElementById('map');
  map.innerHTML = '<img src="'+url+'" alt="'+city+'">';
  
})();
</script>
</body>
</html>
  