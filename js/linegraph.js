$(document).ready(function(){
	$.ajax({
		url : "http://chart.local/data.php",
		type : "GET",
		success : function(data){
			data = data['message'];
			var userid = [];
			var temper = [];
			var humming = [];
			for(var i in data) {
				userid.push(data[i].date1);

				temper.push(data[i].temp);
				humming.push(data[i].hum);
			}

			var chartdata = {
				labels: userid,
				datasets: [
					{
						label: "temp",
						fill: false,
						lineTension: 0.1,
						backgroundColor: "rgba(59, 89, 152, 0.75)",
						borderColor: "rgba(59, 89, 152, 1)",
						pointHoverBackgroundColor: "rgba(59, 89, 152, 1)",
						pointHoverBorderColor: "rgba(59, 89, 152, 1)",
						data: temper
					},
					{
						label: "hum",
						fill: false,
						lineTension: 0.1,
						backgroundColor: "rgba(29, 202, 255, 0.75)",
						borderColor: "rgba(29, 202, 255, 1)",
						pointHoverBackgroundColor: "rgba(29, 202, 255, 1)",
						pointHoverBorderColor: "rgba(29, 202, 255, 1)",
						data: humming					
					}
				]
			};

			var ctx = $("#mycanvas");

			var LineGraph = new Chart(ctx, {
				type: 'line',
				data: chartdata
			});
		},
		error : function(data) {

		}
	});
});