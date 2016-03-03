<html>
<head>
<script type = "text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type = "text/javascript"> 
$(document).ready(function() {
    var max_fields      = 4; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div>\
<select name="filter[]">\
    <option value="Name">Name</option>\
    <option value="Type">Type</option>\
    <option value="City">City</option>\
    <option value="User">User</option>\
    <option value="CreateTime">CreateTime</option>\
</select>\
<input type="text" name="filter_value[]"/><a href="#" class="remove_field">Remove</a></div>'); //add input box
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});
</script>
</head>
<body>
<?php
$username=$_GET['username'];
$timestamp=$_GET['timestamp'];
?>
<form action="edit.php?username=<?php echo "$username"; ?>&timestamp=<?php echo "$timestamp"; ?>" method="POST" enctype="multipart/form-data">

<div class="input_fields_wrap">
    <button class="add_field_button">Add More Fields</button>
    <div><select name="filter[]">
        <option value="User">User</option>
        <option value="CreateTime">CreateTime</option>
        <option value="Name">Name</option>
        <option value="Type">Type</option>
        <option value="City">City</option>
    </select><input type="text" name="filter_value[]" value="<?php echo "$username"; ?>"/></div>
    <div><select name="filter[]">
        <option value="CreateTime">CreateTime</option>
        <option value="Name">Name</option>
        <option value="Type">Type</option>
        <option value="City">City</option>
        <option value="User">User</option>
    </select><input type="text" name="filter_value[]" value="<?php echo "$timestamp"; ?>"/></div>
</div>

<input type="submit" value="Search">
<b><font color=red>  &lt;-- Please click here twice first, it's a bug, will be fixed!!</font></b>
<HR>

<?php
$m=new MongoClient();
$db=$m->dbottawa;
$collection1 = $db->syposters;
$collection2 = $db->locdata;

if (empty ($filter[0])) {
    $filter[0] = "User";
    $filter_value[0] = $username;
    $filter[1] = "CreateTime";
    $filter_value[1] = $timestamp;
}

if (empty ($_POST["filter"][1])) {
    $filter=$_POST["filter"][0];
    $filter_value=$_POST["filter_value"][0];
    $search_array = array ( $filter => "$filter_value" );
}
else if (empty ($_POST["filter"][2]) and !empty ($_POST["filter"][1])) {
    $filter1=$_POST["filter"][0];
    $filter1_value=$_POST["filter_value"][0];
    $filter2=$_POST["filter"][1];
    $filter2_value=$_POST["filter_value"][1];
    $search_array = array ( $filter1 => "$filter1_value", $filter2 => "$filter2_value" );
}
else if (empty ($_POST["filter"][3]) and !empty ($_POST["filter"][2])) {
    $filter1=$_POST["filter"][0];
    $filter1_value=$_POST["filter_value"][0];
    $filter2=$_POST["filter"][1];
    $filter2_value=$_POST["filter_value"][1];
    $filter3=$_POST["filter"][2];
    $filter3_value=$_POST["filter_value"][2];
    $search_array = array ( $filter1 => "$filter1_value", $filter2 => "$filter2_value", $filter3 => "$filter3_value" );
}
else if (empty ($_POST["filter"][4]) and !empty ($_POST["filter"][3])) {
    $filter1=$_POST["filter"][0];
    $filter1_value=$_POST["filter_value"][0];
    $filter2=$_POST["filter"][1];
    $filter2_value=$_POST["filter_value"][1];
    $filter3=$_POST["filter"][2];
    $filter3_value=$_POST["filter_value"][2];
    $filter4=$_POST["filter"][3];
    $filter4_value=$_POST["filter_value"][3];
    $search_array = array ( $filter1 => "$filter1_value", $filter2 => "$filter2_value", $filter3 => "$filter3_value", $filter4 => "$filter4_value" );
}
else if (empty ($_POST["filter"][5]) and !empty ($_POST["filter"][4])) {
    $filter1=$_POST["filter"][0];
    $filter1_value=$_POST["filter_value"][0];
    $filter2=$_POST["filter"][1];
    $filter2_value=$_POST["filter_value"][1];
    $filter3=$_POST["filter"][2];
    $filter3_value=$_POST["filter_value"][2];
    $filter4=$_POST["filter"][3];
    $filter4_value=$_POST["filter_value"][3];
    $filter5=$_POST["filter"][4];
    $filter5_value=$_POST["filter_value"][4];
    $search_array = array ( $filter1 => "$filter1_value", $filter2 => "$filter2_value", $filter3 => "$filter3_value", $filter4 => "$filter4_value", $filter5 => "$filter5_value" );
}

# syposters DB
$cursor1 = $collection1->findOne( $search_array );
# locdata DB
$cursor2 = $collection2->findOne( $search_array );

$Name = $cursor1['Name'];
$City = $cursor1['City'];
$User = $cursor1['User'];
$id1 = $cursor1['_id'];
$Type = $cursor1['Type'];
$CreateTime = $cursor1['CreateTime'];
$NumPosters = $cursor1['NumPosters'];
$NumFlyers = $cursor1['NumFlyers'];
$Comments = $cursor1['Comments'];

$id2 = $cursor2['_id'];
$Address = $cursor2['Address'];
$Postcode = $cursor2['Postcode'];
$MapLink = $cursor2['MapLink'];
$MapLink = substr($MapLink, 9, -26);

?>
<table>

<tr><td>
Posters DB id:
</td><td>
<input style="width:500px" name="id1" type="text" readonly value="<?php if (empty($id1)) echo ""; else echo $id1; ?>"></br>
</td></tr>

<tr><td>
Name:
</td><td>
<input style="width:500px" name="Name" type="text" value="<?php if (empty($Name)) echo ""; else echo $Name; ?>"></br>
</td></tr>

<tr><td>
City:
</td><td>
<input style="width:500px" name="City" type="text" value="<?php if (empty($City)) echo ""; else echo $City; ?>"></br>
</td></tr>

<tr><td>
User:
</td><td>
<input style="width:500px" name="User" type="text" value="<?php if (empty($User)) echo ""; else echo $User; ?>"></br>
</td></tr>

<tr><td>
Type:
</td><td>
<input style="width:500px" name="Type" type="text" value="<?php if (empty($Type)) echo ""; else echo $Type; ?>"></br>
</td></tr>

<tr><td>
CreateTime:
</td><td>
<input style="width:500px" name="CreateTime" type="text" readonly value="<?php if (empty($CreateTime)) echo ""; else echo $CreateTime; ?>"></br>
</td></tr>

<tr><td>
Number of Posters:
</td><td>
<input style="width:500px" name="NumPosters" type="text" value="<?php if (empty($NumPosters)) echo ""; else echo $NumPosters; ?>"></br>
</td></tr>

<tr><td>
Number of Flyers:
</td><td>
<input style="width:500px" name="NumFlyers" type="text" value="<?php if (empty($NumFlyers)) echo ""; else echo $NumFlyers; ?>"></br>
</td></tr>

<tr><td>
Comments:
</td><td>
<textarea name="Comments" style="width:500px; height:100px" rows="6" cols="80"><?php if (empty($Comments)) echo ""; else echo $Comments; ?></textarea></br>
</td></tr>

<tr><td>
Locations DB id:
</td><td>
<input style="width:500px" name="id2" type="text" readonly value="<?php if (empty($id2)) echo ""; else echo $id2; ?>"></br>
</td></tr>

<tr><td>
Address:
</td><td>
<input style="width:500px" name="Address" type="text" value="<?php if (empty($Address)) echo ""; else echo $Address; ?>"></br>
</td></tr>

<tr><td>
Postcode:
</td><td>
<input style="width:500px" name="Postcode" type="text" value="<?php if (empty($Postcode)) echo ""; else echo $Postcode; ?>"></br>
</td></tr>

<tr><td>
Google Map Link:
</td><td>
<textarea name="MapLink" style="width:500px; height:100px" rows="6" cols="80"><?php if (empty($MapLink)) echo ""; else echo $MapLink; ?>"</textarea></br>
</td></tr>

</table>

<?php
echo "<input type=\"submit\" name=\"Update\" value=\"Update\">";
echo "   ";
echo "<input type=\"submit\" name=\"Delete\" value=\"Delete\">";
echo "   ";
echo "<input type=\"submit\" name=\"UnDelete\" value=\"UnDelete\">";

	$Name=$_POST["Name"];
	$Type=$_POST["Type"];
	#$Contact=$_POST["Contact"];
	#$Phone=$_POST["Phone"];
	$Address=$_POST["Address"];
	$Postcode=$_POST["Postcode"];
	$User=$_POST["User"];
	$CreateTime=$_POST["CreateTime"];

	// change http link to html format
	$tempdata=$_POST["MapLink"];
	if ( $tempdata == '' ) {
		$MapLink=$_POST["MapLink"];
	}
        else {
		$MapLink="<a href=\"$tempdata\" target=\"_blank\">Link</a>";
	}

	$City=$_POST["City"];
	#$Area=$_POST["Area"];
	#$Posters=$_POST["Posters"];
	#$Flyers=$_POST["Flyers"];
	#$EngPapers=$_POST["EngPapers"];
	#$ChnPapers=$_POST["ChnPapers"];
	#$SellTickets=$_POST["SellTickets"];
	#$SYPresentation=$_POST["SYPresentation"];
	#$PaperAds=$_POST["PaperAds"];
	$NumPosters=$_POST["NumPosters"];
	$NumFlyers=$_POST["NumFlyers"];
	$Comments=$_POST["Comments"];


	// add a Shen Yun posters record
	$document1 = array( 
		"Name" => "$Name",
		"Type" => "$Type",
		"City" => "$City",
		"Postcode" => "$Postcode",
		"NumPosters" => "$NumPosters",
		"NumFlyers" => "$NumFlyers",
		"Comments" => "$Comments",
		"User" => "$User",
                "CreateTime" => "$CreateTime"
	);

	// add a location record
	$document2 = array( 
		"Name" => "$Name",
		"Type" => "$Type",
		"City" => "$City",
	        "Address" => "$Address",
	        "Postcode" => "$Postcode",
	        "MapLink" => "$MapLink",
		"User" => "$User",
                "CreateTime" => "$CreateTime"
        );

if(isset($_POST["Update"])) {
    $m=new MongoClient();
    $db=$m->dbottawa;
    $collection1 = $db->syposters;
    $collection2 = $db->locdata;

    $collection1->update(
        $search_array,
        array ( '$set' => $document1 )
    );
    $cursor1 = $collection1->findOne( $search_array );

    $collection2->update(
        $search_array,
        array ( '$set' => $document2 )
    );
    $cursor2 = $collection2->findOne( $search_array );
    echo "<SCRIPT>alert('Updated!!')</SCRIPT>";
}

if(isset($_POST["Delete"])) {
    $m=new MongoClient();
    $db=$m->dbottawa;
    $collection1 = $db->syposters;
    $collection2 = $db->locdata;

    $delete_flag = array ('DelFlag' => "Deleted");
    $collection1->update(
        $search_array,
        array ( '$set' => $delete_flag )
    );
    $cursor1 = $collection1->findOne( $search_array );

    $collection2->update(
        $search_array,
        array ( '$set' => $delete_flag )
    );
    $cursor2 = $collection2->findOne( $search_array );
    echo "<SCRIPT>alert('Added delete flag to this record!!')</SCRIPT>";
}

if(isset($_POST["UnDelete"])) {
    $m=new MongoClient();
    $db=$m->dbottawa;
    $collection1 = $db->syposters;
    $collection2 = $db->locdata;

    $delete_flag = array ('DelFlag' => "Deleted");
    $collection1->update(
        $search_array,
        array ( '$unset' => $delete_flag )
    );
    $cursor1 = $collection1->findOne( $search_array );

    $collection2->update(
        $search_array,
        array ( '$unset' => $delete_flag )
    );
    $cursor2 = $collection2->findOne( $search_array );
    echo "<SCRIPT>alert('Removed delete flag from this record!!')</SCRIPT>";
}


?>
</body>
</html>
