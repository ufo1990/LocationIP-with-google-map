<?php	
if(isset($_POST['search']))
{	
	//Google Api Key
	$google_maps_key = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX';
	
	//Text if not found value
	$lang['no_data'] = 'No data';
	
	//Download information via address IP
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://ipinfo.io/'.$_POST['ip'].'');
	curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$res = json_decode(curl_exec($ch), true); 
	curl_close($ch);

	$message = false;
	$message .= '<b>Adress IP:</b> '.(!isset($res['ip']) ? $res['ip'] = $lang['no_data'] : $res['ip']).'<br/>';
	$message .= '<b>Hostname:</b> '.(!isset($res['hostname']) ? $res['hostname'] = $lang['no_data'] : $res['hostname']).'<br/>';
	$message .= '<b>City:</b> '.(!isset($res['city']) ? $res['city'] = $lang['no_data'] : $res['city']).'/'.(!isset($res['country']) ? $res['country'] = $lang['no_data'] : $res['country']).'<br/>';
	$message .= '<b>Region:</b> '.(!isset($res['region']) ? $res['region'] = $lang['no_data'] : $res['region']).'<br/>';
	$message .= '<b>Location:</b> '.(!isset($res['loc']) ? $res['loc'] = $lang['no_data'] : $res['loc']).'<br/>';

	//Download maps via google key
	$ch2 = curl_init();
	curl_setopt($ch2, CURLOPT_URL, 'https://maps.googleapis.com/maps/api/staticmap?center=50.080799149266184,%2019.917999965966096&zoom=1&size=1x1&key='.$google_maps_key.'');
	curl_setopt($ch2, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
	curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
	$res2 = curl_exec($ch2); 
	$message .= ($res['loc'] != $lang['no_data']) ? (curl_getinfo($ch2, CURLINFO_HTTP_CODE) == 200) ? '<iframe src="https://www.google.com/maps/embed/v1/place?language=en&key='.$google_maps_key.'&q='.$res['loc'].'" width="100%" height="300" style="border:0; margin-top:5px; background-color:#fff;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>' : '<div class="alert role alert-danger" role="alert">Problem with map display, incorrect API key!</div>' : '<div class="alert role alert-warning" role="alert">Problem displaying the map, incorrect data or missing API key</div>';
	curl_close($ch2);
}
?>
<!doctype html>
<html>
    <head>
		<title>Look up IP Address Location</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="robots" content="noindex">
		<link href="data:image/png;base64,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" rel="icon" type="image/x-icon" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"> 
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
	</head>
    <body>
		<div class="container centered-element">
			<h1>Look up IP Address Location</h1>
			<div class="content">
				<form action="index.php" method="post">
					<div class="form-group">
						<label for="ip">Address IP:</label>
						<i class="fa-solid fa-circle-info" title="The IP address must be in the form for example 127.0.0.1"></i>
						<input type="text" class="form-control" name="ip" placeholder="Enter IP Address..." pattern="^((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.){3}(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])$" value="<?= (isset($res['ip']) && ($res['ip'] != $lang['no_data'])) ? $_POST['ip'] : false; ?>" required>
					</div>
					<button type="submit" class="btn btn-success" name="search"><i class="fa-solid fa-magnifying-glass"></i> Get IP Details</button>
					<?= isset($message) ? '<button type="submit" class="btn btn-warning" name="clear"><i class="fa-solid fa-rotate-left"></i> Clear data</button>' : false; ?> 
				</form>
				<?= isset($message) ? '<hr/>'.$message : false; ?>
			</div>
		</div>
    </body>
</html>
<style>
body{
	font-family: "Poppins","Open Sans",sans-serif;
	background-color:#005ca7;
}
.container{
	background-color:#fff;
	max-width: 400px;
	border-radius: 10px;
	text-align: center;
	box-shadow: 0px 0px 10px rgba(0,0,0,0.4);
	padding:0 0 20px 0;
}
.content{
	padding:0px 20px 0 20px;
	text-align:left;
}
.content form{
	text-align:center;
}
h1{
	font-size: 1.2rem;
	font-weight: 700;
	background-color: #00376e;
	color:#fff;
	border-top-left-radius: 10px;
	border-top-right-radius: 10px;
	padding:20px;
	margin-bottom:20px;
	border:2px solid #fff;
	vertical-align: top;
}
.container:not(.centered-element){
	margin-top: 20px;
	margin-bottom: 20px;
}
.container.centered-element{
	position: absolute;
	top: 50%;
	left: 50%;
	transform: translate(-50%, -50%);	
    height: auto;
}
</style>
<script>
$('.container').height() > $(window).height() ? $('.container').removeClass('centered-element') : null;
$('.btn-warning').click(function(){ $('input').removeAttr('pattern'); }); 
</script>



