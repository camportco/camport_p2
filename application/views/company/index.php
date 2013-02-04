<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

<style type="text/css">
		.demo { width: 500px; height: 200px; }
		#button { padding: .5em 1em; text-decoration: none; }
		#resizableb {
	width: 750px;
	height: 420px;
	position: relative;
	font-style: normal;
	font-size: 18px;
	margin-left: 20px;
}
		#resizableb h3 {
	margin: 0;
	padding: 0.4em;
	text-align: left;
}
		.ui-effects-transfer { border: 2px dotted gray; } 
	</style>

<script type="text/javascript">
	$(function() {
		$("#companyinfo").show('clip');
		$("#resizableb").resizable();
});
</script>

<div>
	<div id="resizableb" class="ui-widget-content ui-corner-all">
        <div id="companymap">
        </div>
    
        <div id="companyinfo">
            <u>Camport Camera Accessories</u><br />
            Shop 123A, 298 Computer Zone,<br />
            298 Hennessy Road, Wan Chai,<br />
            Hong Kong<br />
            <br />
            <u>Contact No / Fax No:</u><br />
            (852)-2838-3832<br />
            <br />
            <u>Email:</u><br /> 
            sales@camportco.com<br />
            <br />
            <u>Opening hours:</u><br />
            Mon - Sat 1:00pm - 9:00pm <br />
            Sun &amp; Public holiday 2:30pm - 8:00pm
        </div>

    </div>
</div>

<script type="text/javascript">
jq(function() {
	init();
});

function init() {
	var map;
	var infowindow = new google.maps.InfoWindow();
	var myOptions = {
		zoom: 17,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	map = new google.maps.Map(document.getElementById("companymap"), myOptions);
	var pos = new google.maps.LatLng(22.277881, 114.177488);
	var marker = new google.maps.Marker({
	    position: pos,
	    map: map,
	    title:"Hello World!"
	});
	map.setCenter(pos);
	infowindow.setContent("Camport ");
	infowindow.setPosition(pos);
	infowindow.open(map,marker);
}
</script>
