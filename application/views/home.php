<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Weather App</title>
	<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		$('#city').on('change', function(){
			var city = $(this).val();
			$.ajax({
				url:"https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20weather.forecast%20where%20woeid%20in%20(select%20woeid%20from%20geo.places(1)%20where%20text%3D%22"+city+"%22)&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys",
				//url:"https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20weather.forecast%20where%20woeid%20in%20(select%20woeid%20from%20geo.places(1)%20where%20text%3D%22"+city+"%22)&format=xml&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys",
				dataType:"json",
				success:function(resp){

					var channel = resp.query.results.channel;
					// $("#result").append(JSON.stringify(channel.atmosphere));
					// $("#result").append("<br/>");
					// $("#result").append(JSON.stringify(channel.forecast));

					var location = "<tr> <td>City</td> <td>"+channel.location.city+"</td> \
									<tr> <td>country</td> <td>"+channel.location.country+"</td>";
					var astronomy = "<tr> <td>Sunrise</td> <td>"+channel.astronomy.sunrise+"</td> \
									<tr> <td>Sunset</td> <td>"+channel.astronomy.sunset+"</td>";
					var atmosphere = "<tr> <td>Humidity</td> <td>"+channel.atmosphere.humidity+"</td> \
									<tr> <td>Pressure</td> <td>"+channel.atmosphere.pressure+"</td>";
					var forecast = channel.item.forecast;
					var forecast_res = "";
					 for (var i = forecast.length - 1; i >= 0; i--) {
						
						forecast_res +="<tr><td>"+forecast[i].day+"</td><td> High Temperature :"+forecast[i].high+" Low Temperature:"+forecast[i].low+"</td</tr>";
					};


					var table = "<table>"+astronomy+atmosphere+forecast_res+"</table>";

					$("#result").append(table);

				},
				error:function(resp){

				}

			});
		});
	});
	</script>

</head>
<body>

<div id="container">
	<h1>Welcome to Weather App</h1>

	<div id="body">
		<form>
			<select id="city">
				<option value="bangalore">Bangalore</option>
				<option value="mumbai">Mumbai</option>
				<option value="chennai">Chennai</option>
				<option value="kolkatta">Kolkatta</option>
				<option value="delhi">Delhi</option>
			</select>
		</form>

		<div id="result">

		</div>
	</div>
</div>

</body>
</html>