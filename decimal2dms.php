<?php
function DecimalToDMS($decimal, &$degrees, &$minutes, &$seconds, &$direction, $type = true) {
	//set default values for variables passed by reference
	$degrees = 0;
	$minutes = 0;
	$seconds = 0;
	$direction = 'X';

	//decimal must be integer or float no larger than 180;
	//type must be Boolean
	if(!is_numeric($decimal) || abs($decimal) > 180 || !is_bool($type)) {
		return false;
	}
	
	//inputs OK, proceed
	//type is latitude when true, longitude when false
	
	//set direction; north assumed
	if($type && $decimal < 0) { 
		$direction = 'S';
	}
	elseif(!$type && $decimal < 0) {
		$direction = 'W';
	}
	elseif(!$type) {
		$direction = 'E';
	}
	else {
		$direction = 'N';
	}
	
	//get absolute value of decimal
	$d = abs($decimal);
	
	//get degrees
	$degrees = floor($d);
	
	//get seconds
	$seconds = ($d - $degrees) * 3600;
	
	//get minutes
	$minutes = floor($seconds / 60);
	
	//reset seconds
	$seconds = floor($seconds - ($minutes * 60));	
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
		<title>Converting Latitude And Longitude Coordinates Between Decimal And Degrees, Minutes, Seconds Example 2: Converting Decimal To Degrees-Minutes-Seconds (DMS)</title>
		<link rel="stylesheet" type="text/css" href="../demo.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
		<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js" type="text/javascript"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#decimal2dms').validate({
					rules: {
						decimal: {
							required: true,
							number: true,
							range: [-180, 180]
						}
					} //rules
				}); //validate
			}); //ready
		</script>
	</head>
	<body>
		<h2>
			Converting Latitude And Longitude Coordinates Between Decimal And Degrees, Minutes, Seconds<br />
			Example 2: Converting Decimal To Degrees-Minutes-Seconds (DMS)
		</h2>
		
		<?php
			if(isset($_POST['dec_submit'])) {
				if($_POST['type'] == 'lon') {
					$type = false;
				}
				else {
					$type = true;
				}
				if(DecimalToDMS($_POST['decimal'], $degrees, $minutes, $seconds, $direction, $type) !== false) {
					echo "<p class=\"notice\">The DMS value for " . $_POST['decimal'] . " (" . $_POST['type'] . ") is $degrees&deg; $minutes' $seconds\" $direction</p>\n";
				}
				else {
					echo "<p class=\"warning\">One or more form values are out of range.</p>\n";
				}
			}
		?>
		
		<p>Use the form below to enter coordinates in decimal; the form will return a degrees, minutes, seconds and direction equivalent.</p>
		
		<form id="decimal2dms" name="decimal2dms" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
			<label for="decimal">Decimal: <input type="text" id="decimal" name="decimal" size="10" maxlength="10" /></label><br />
			<label for="type">Coordinate type: 
				<select name="type" id="type">
					<option value="lat">Latitude</option>
					<option value="lon">Longitude</option>
				</select>
			</label>
			<p>
				<input type="submit" id="dec_submit" name="dec_submit" value="Submit" />
			</p>
		</form>
		<p>
			<a href="http://www.dougv.com/demo/php_lat_lon_conversion/dms2decimal.php">Example 1: Converting Degrees-Minutes-Seconds (DMS) To Decimal</a><br />
			<a href="http://www.dougv.com/2012/03/07/converting-latitude-and-longitude-coordinates-between-decimal-and-degrees-minutes-seconds/">Converting Latitude And Longitude Coordinates Between Decimal And Degrees, Minutes, Seconds</a>
		</p>
	</body>
</html>
