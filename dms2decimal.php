<?php
function DMS2Decimal($degrees = 0, $minutes = 0, $seconds = 0, $direction = 'n') {
	//converts DMS coordinates to decimal
	//returns false on bad inputs, decimal on success
	
	//direction must be n, s, e or w, case-insensitive
	$d = strtolower($direction);
	$ok = array('n', 's', 'e', 'w');
	
	//degrees must be integer between 0 and 180
	if(!is_numeric($degrees) || $degrees < 0 || $degrees > 180) {
		$decimal = false;
	}
	//minutes must be integer or float between 0 and 59
	elseif(!is_numeric($minutes) || $minutes < 0 || $minutes > 59) {
		$decimal = false;
	}
	//seconds must be integer or float between 0 and 59
	elseif(!is_numeric($seconds) || $seconds < 0 || $seconds > 59) {
		$decimal = false;
	}
	elseif(!in_array($d, $ok)) {
		$decimal = false;
	}
	else {
		//inputs clean, calculate
		$decimal = $degrees + ($minutes / 60) + ($seconds / 3600);
		
		//reverse for south or west coordinates; north is assumed
		if($d == 's' || $d == 'w') {
			$decimal *= -1;
		}
	}
	
	return $decimal;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN 
"http://www.w3.org/TR/xhtml1/DTD/xhtml-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<!--
		Converting Latitude And Longitude Coordinates Between Decimal And Degrees, Minutes, Seconds
		Copyright (C) 2012 Doug Vanderweide
		
		This program is free software: you can redistribute it and/or modify
		it under the terms of the GNU General Public License as published by
		the Free Software Foundation, either version 3 of the License, or
		(at your option) any later version.
		
		This program is distributed in the hope that it will be useful,
		but WITHOUT ANY WARRANTY; without even the implied warranty of
		MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
		GNU General Public License for more details.
		
		You should have received a copy of the GNU General Public License
		along with this program.  If not, see <http://www.gnu.org/licenses/>.
	-->
	<head>
		<title>Converting Latitude And Longitude Coordinates Between Decimal And Degrees, Minutes, Seconds Example 1: Converting Degrees-Minutes-Seconds (DMS) To Decimal</title>
		<link rel="stylesheet" type="text/css" href="../demo.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
		<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js" type="text/javascript"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#dms2decimal').validate({
					rules: {
						degrees: {
							required: true,
							digits: true,
							range: [0, 180]
						},
						minutes: {
							required: true,
							number: true,
							range: [0, 59]
						},
						seconds: {
							required: true,
							number: true,
							range: [0, 59]
						}
					} //rules
				}); //validate
			}); //ready
		</script>
		
		<style type="text/css">
			label.error { color: #300; }
		</style>
	</head>
	<body>
		<h2>
			Converting Latitude And Longitude Coordinates Between Decimal And Degrees, Minutes, Seconds<br />
			Example 1: Converting Degrees-Minutes-Seconds (DMS) To Decimal
		</h2>
		
		<?php
			if(isset($_POST['dms_submit'])) {
				$decimal = DMS2Decimal($_POST['degrees'], $_POST['minutes'], $_POST['seconds'], $_POST['direction']);
				if($decimal !== false) {
					echo "<p class=\"notice\">The decimal value for " . $_POST['degrees'] . "&deg " . $_POST['minutes'] . "' " . $_POST['seconds'] . "\" " . $_POST['direction'] . " is $decimal</p>\n";
				}
				else {
					echo "<p class=\"warning\">One or more form values are out of range.</p>\n";
				}
			}
		?>
		
		<p>Use the form below to enter coordinates in degrees, minutes and seconds North, South, East Or West; the form will return a decimal equivalent.</p>
		
		<form id="dms2decimal" name="dms2decimal" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
			<label for="degrees">Degrees: <input type="text" id="degrees" name="degrees" size="3" maxlength="3" /></label><br />
			<label for="minutes">Minutes: <input type="text" id="minutes" name="minutes" size="2" maxlength="2" /></label><br />
			<label for="seconds">Seconds: <input type="text" id="seconds" name="seconds" size="2" maxlength="2" /></label><br />
			<select id="direction" name="direction">
				<option value="N">N</option>
				<option value="S">S</option>
				<option value="E">E</option>
				<option value="W">W</option>
			</select>
			<p>
				<input type="submit" id="dms_submit" name="dms_submit" value="Submit" />
			</p>
		</form>
		<p>
			<a href="http://www.dougv.com/demo/php_lat_lon_conversion/index.php">Example 2: Converting Decimal To Degrees-Minutes-Seconds (DMS)</a><br />
			<a href="http://www.dougv.com/2012/03/07/converting-latitude-and-longitude-coordinates-between-decimal-and-degrees-minutes-seconds/">Converting Latitude And Longitude Coordinates Between Decimal And Degrees, Minutes, Seconds</a>
		</p>
	</body>
</html>
