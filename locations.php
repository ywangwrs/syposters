<?php echo '<?xml version="1.0"?' . '>'; ?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">

<html>
 <head>
<?php

// Expect-lite web runner v0.1
// by Yang Wang Nov 9, 2015
// 

// 20151109 v0.1 - Created


// script version
$version=0.1;

// ===== Change these vars to valid values in your environment ====
// path to this script and ini_writer scripts
$path="/opt/lampp/htdocs/ottawa";

$bg="aero_bike_gear_cluster_shadowed_cls_bg.jpg";

?>

  <style type="text/css">
body {
text:"#000000" ;
bgcolor:"#ffffff" ;
background-image: url("<?php echo $bg ?>");
link:"#0000ee" ;
vlink:"#551a8b";
alink:"#ff0000" ;
padding:30px;
}
.opaque_box {
background-image: url("opacity.png");
background-image: url('opacity.png');border: thin groove blue; padding: 1em; -moz-border-radius: 10px;
-webkit-border-radius: 10px; max-width:900px; margin:auto;
}
</style>
 
 
<?php
// ================================================================

function write_mongodb($Name,$Type,$Contact,$Phone,$Address,$Postcode,$MapLink,$City,$Area,$Posters,$Flyers,$EngPapers,$ChnPapers,$SellTickets,$PaperAds,$NumPosters,$NumFlyers,$Comments) {

	echo "Name=$Name<br>";
	echo "Type=$Type<br>";
	echo "Contact=$Contact<br>";
	echo "Phone=$Phone<br>";
	echo "Address=$Address<br>";
	echo "Postcode=$Postcode<br>";
	echo "MapLink=$MapLink<br>";
	echo "City=$City<br>";
	echo "Area=$Area<br>";
	echo "Posters=$Posters<br>";
	echo "Flyers=$Flyers<br>";
	echo "EngPapers=$EngPapers<br>";
	echo "ChnPapers=$ChnPapers<br>";
	echo "SellTickets=$SellTickets<br>";
	echo "PaperAds=$PaperAds<br>";
	echo "NumPosters=$NumPosters<br>";
	echo "NumFlyers=$NumFlyers<br>";
	echo "Comments=$Comments<br>";

        $username   = $_SESSION['username'];
        $password   = $_SESSION['password'];

        // connect to dbottawa
        $m=new MongoClient("mongodb://${username}:${password}@localhost/dbottawa");
	$db=$m->dbottawa;

	// select a collection (analogous to a relational database's table)
	$collection1 = $db->locdata;
	$collection2 = $db->syposters;

        // get system time
        date_default_timezone_set('EST');
        $time = date('Y/m/d H:i');

	// add a location record
	$document1 = array( 
		"Name" => "$Name",
		"Type" => "$Type",
		"Contact" => "$Contact",
		"Phone" => "$Phone",
		"Address" => "$Address",
		"Postcode" => "$Postcode",
		"MapLink" => "$MapLink",
		"City" => "$City",
		"Area" => "$Area",
		"Posters" => "$Posters",
		"Flyers" => "$Flyers",
		"EngPapers" => "$EngPapers",
		"ChnPapers" => "$ChnPapers",
		"SellTickets" => "$SellTickets",
		"PaperAds" => "$PaperAds",
		"User" => "$username",
                "CreateTime" => "$time"
	);
	$collection1->insert($document1);

	// add a Shen Yun posters record
	$document2 = array( 
		"Name" => "$Name",
		"Type" => "$Type",
		"City" => "$City",
		"Area" => "$Area",
		"Postcode" => "$Postcode",
		"NumPosters" => "$NumPosters",
		"NumFlyers" => "$NumFlyers",
		"Comments" => "$Comments",
		"User" => "$username",
                "CreateTime" => "$time"
	);
	$collection2->insert($document2);

	echo "<br>";
	echo "<form action=\"search.php\" method=\"get\">";
	echo "<input type=\"hidden\" name=\"dbname\" value=\"syposters\"/>";
	echo "<input type=\"submit\" value=\"SY Postesrs\">";
	echo "</form>";
	echo "<form action=\"search.php\" method=\"get\">";
	echo "<input type=\"hidden\" name=\"dbname\" value=\"locdata\"/>";
	echo "<input type=\"submit\" value=\"Ottawa Locations\">";
	echo "</form>";
}

?>
  <title>LocDataOttawa</title>
 </head>
 <body>
<div class="opaque_box">




<?php

session_start();
$username   = $_SESSION['username'];
$password   = $_SESSION['password'];
echo "<h2>Current user is: $username</h2>";

// ====== Show Form
 if (empty($_POST)) {
 	echo "<h1>Ottawa Locations Info Submit</h1>";
 	echo "<h3>(*) The field we must fill in</h3>";
 	echo "<form action=\"locations.php\" method=\"POST\"  enctype=\"multipart/form-data\">";
?>


<table>
<tr>
<td>
        Location Name (*):
        </td><td>
        <input style="width:500px" name="Name" type="text" placeholder="Location Name (mandatory info)"/></br>
        </td></tr><tr><td>

        Location Type (*):
        </td><td>
        <select name="Type">
                <option value="Coffee_shop">Coffee Shop</option>
                <option value="Restrauent">Restrauent</option>
                <option value="HiTech">Hi-Tech Building</option>
                <option value="Church">Church</option>
                <option value="Bank">Bank</option>
                <option value="Library">Library</option>
                <option value="Grocry_store">Grocery Store</option>
                <option value="Golf_club">Golf Club</option>
                <option value="Car_dealer">Car Dealer</option>
                <option value="Dentiest_office">Denitest Office</option>
                <option value="Lawyer_office">Lawyer Office</option>
                <option value="Other">Other</option>
        </select>

        </td></tr><tr><td>

        Contact Person:
        </td><td >
        <input style="width:500px" name="Contact" type="text" placeholder="FirstName LastName (optional for posters)" /></br>
        </td></tr><tr><td>

        Contact Number:
        </td><td >
        <input style="width:500px" name="Phone" type="tel" placeholder="613-xxx-xxxx (optional for posters)" /></br>
        </td></tr><tr><td>

        Address (*):
        </td><td >
        <input style="width:500px" name="Address" type="text" placeholder="335 Terry Fox Dr"/></br>
        </td></tr><tr><td>

        Post Code:
        </td><td >
        <input style="width:500px" name="Postcode" type="text" placeholder="K2K 2L5 (better to have it here)" /></br>
        </td></tr><tr><td>

        Google Map Link:
        </td><td >
        <textarea name="MapLink" style="width:500px; height:50px" rows="3" cols="80" placeholder="https://www.google.ca/maps/place/xxxx (if you have it)"></textarea></br>
        </td></tr><tr><td>

        City (*):
        </td><td>
        <select name="City">
                <option value="--">--</option>
                <option value="Ottawa">Ottawa</option>
                <option value="Gatineau">Gatineau</option>
                <option value="Kanata">Kanata</option>
                <option value="Orleans">Orleans</option>
                <option value="Nepean">Nepean</option>
                <option value="Gloucester">Gloucester</option>
                <option value="Osgoode">Osgoode</option>
                <option value="Barrhaven">Barrhaven</option>
                <option value="Other">Other</option>
        </select>
        </td></tr><tr><td>

        Area:
        </td><td >
        <input style="width:500px" name="Area" type="text" placeholder="such as Katimavic (optional)"/></br>
        </td></tr><tr><td>

        <?php
                echo "Possible for posters?";
                echo "</td><td>";
                echo "<select name=\"Posters\">";
                echo "<option value=\"Yes\">Yes</option>";
                echo "<option value=\"No\">No</option>";
                echo "</select>";
                // close table cell
                echo "</td></tr><tr><td>";

                echo "Possible for flyers?";
                echo "</td><td>";
                echo "<select name=\"Flyers\">";
                echo "<option value=\"Yes\">Yes</option>";
                echo "<option value=\"No\">No</option>";
                echo "</select>";
                // close table cell
                echo "</td></tr><tr><td>";

                echo "Able for English Papers?";
                echo "</td><td>";
                echo "<select name=\"EngPapers\">";
                echo "<option value=\"--\">--</option>";
                echo "<option value=\"Yes\">Yes</option>";
                echo "<option value=\"No\">No</option>";
                echo "</select>";
                // close table cell
                echo "</td></tr><tr><td>";

                echo "Able for Chinese Papers?";
                echo "</td><td>";
                echo "<select name=\"ChnPapers\">";
                echo "<option value=\"--\">--</option>";
                echo "<option value=\"Yes\">Yes</option>";
                echo "<option value=\"No\">No</option>";
                echo "</select>";
                // close table cell
                echo "</td></tr><tr><td>";

                echo "Possible for selling SY tickets?";
                echo "</td><td>";
                echo "<select name=\"SellTickets\">";
                echo "<option value=\"--\">--</option>";
                echo "<option value=\"Possible\">Possible</option>";
                echo "<option value=\"Impossible\">Impossible</option>";
                echo "</select>"; // close table cell
                echo "</td></tr><tr><td>";

                echo "Possible for Epochtimes Ads?";
                echo "</td><td>";
                echo "<select name=\"PaperAds\">";
                echo "<option value=\"--\">--</option>";
                echo "<option value=\"Possible\">Possible</option>";
                echo "<option value=\"Impossible\">Impossible</option>";
                // close table cell
                echo "</td></tr><tr><td>";

		echo "<HR /></td></tr><tr><td>";

		echo "Delivered posters (*):";
        	echo "</td><td >";
        	echo "<input style=\"width:50px\" name=\"NumPosters\" type=\"number\" /></br>";
                // close table cell
                echo "</td></tr><tr><td>";

		echo "Delivered flyers (*):";
        	echo "</td><td >";
        	echo "<input style=\"width:50px\" name=\"NumFlyers\" type=\"number\" /></br>";
                // close table cell
                echo "</td></tr><tr><td>";

		echo "Comments:";
        	echo "</td><td >";
        	echo "<textarea name=\"Comments\" style=\"width:500px; height:100px\" rows=\"6\" cols=\"80\" placeholder=\"such as location of the bulletin board; reaction when you introduce Shen Yun; anything else.\"></textarea></br>";
                // close table cell
                echo "</td></tr><tr><td>";

	?>
</td></tr></table>

	<br/>

<?php
	echo "<input type=\"submit\" value=\"Submit-It\">";
	echo "</form> ";
	}
  else {
	// Get info from form and process it
	$Name=$_POST["Name"];
	$Type=$_POST["Type"];
	$Contact=$_POST["Contact"];
	$Phone=$_POST["Phone"];
	$Address=$_POST["Address"];
	$Postcode=$_POST["Postcode"];

	// change http link to html format
	$tempdata=$_POST["MapLink"];
	if ( $tempdata == '' ) {
		$MapLink=$_POST["MapLink"];
	}
        else {
		$MapLink="<a href=\"$tempdata\" target=\"_blank\">Link</a>";
	}

	$City=$_POST["City"];
	$Area=$_POST["Area"];
	$Posters=$_POST["Posters"];
	$Flyers=$_POST["Flyers"];
	$EngPapers=$_POST["EngPapers"];
	$ChnPapers=$_POST["ChnPapers"];
	$SellTickets=$_POST["SellTickets"];
	$PaperAds=$_POST["PaperAds"];
	$NumPosters=$_POST["NumPosters"];
	$NumFlyers=$_POST["NumFlyers"];
	$Comments=$_POST["Comments"];


	if ($Name == "DEBUG") {
		echo "<b>Data Info:</b><br/>";
		$l_type=$_FILES['myFile']['type'];
		$l_name=$_FILES['myFile']['name'];
		$l_size=$_FILES['myFile']['size'];
		$l_error=$_FILES['myFile']['error'];
		
		echo "Content type: $l_type <br/>";
		echo "Content type: $l_name <br/>";
		echo "Content type: $l_size<br/>";
		echo "Content type: $l_error <br/>";
	}


	// write the MongoDB
	if ($Name != "DEBUG") {
		write_mongodb($Name,$Type,$Contact,$Phone,$Address,$Postcode,$MapLink,$City,$Area,$Posters,$Flyers,$EngPapers,$ChnPapers,$SellTickets,$PaperAds,$NumPosters,$NumFlyers,$Comments);
	}
  }
?>

<HR />
<form action="search.php" method="get">
<input type="hidden" name="dbname" value="syposters"/>
<input type="submit" value="SY Postesrs">
</form>
<form action="search.php" method="get">
<input type="hidden" name="dbname" value="locdata"/>
<input type="submit" value="Ottawa Locations">
</form>

Version:<?php echo "$version"; ?>  &nbsp; &nbsp;  <small>by ywang</small><BR>
</div>
 </body>
</html>
