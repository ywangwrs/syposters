<?php echo '<?xml version="1.0"?' . '>'; ?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">

<html>
<style>
           body {
                background-image:url("http://s6.postimg.org/hut4nisjx/lotus.png");
                background-repeat:no-repeat;background-position:right top;
                font: normal medium/1.0 Arial;
            }
            table {
                border-collapse: collapse;
                border-style: hidden;
                word-break: break-all;
                word-wrap: break-word;
                font-size:Small;
            }
            th, td {
                padding: 0.2rem;
                text-align: left;
                border: 1px dotted #f8f8f8;
            }
            tbody tr:hover {
                background: powderblue;
            }
</style>

<div align="right" id="links">
    <a href="/ottawa/login.php" target="_blank">Login</a>
    <a href="/ottawa/statistics.php" target="_blank">Report</a>
    <a href="http://luntan.ddns.net/phpbb/index.php" target="_blank">Forum</a>
    <a href="https://www.youtube.com/watch?v=mUHHcXkAVo8" target="_blank">Trainning</a>
</div>

<head>
</head>
<body onload="finishTable();">
<h1><div id="TitleWtihNumbers"></div></h1>
<?php

        set_error_handler('exceptions_error_handler');

function exceptions_error_handler($severity, $message, $filename, $lineno) {
  if (error_reporting() == 0) {
    return;
  }
  if (error_reporting() & $severity) {
    throw new ErrorException($message, 0, $severity, $filename, $lineno);
  }
}

        echo "<form action=\"search.php\" method=\"POST\"  enctype=\"multipart/form-data\">";

        echo "<table><tr><td>";
        echo "Database:";
        echo "<select name=\"dbname\">";
        echo "<option value=\"syposters\">Posters</option>";
        echo "<option value=\"locdata\">Locations</option>";
        echo "</select>";
        echo "</td><td>";

        echo "Type:";
        echo "<select name=\"Type\">";
        echo "<option value=\"All\">All</option>";
        echo "<option value=\"Coffee_shop\">Coffee_shop</option>";
        echo "<option value=\"Restrauent\">Restrauent</option>";
        echo "<option value=\"HiTech\">HiTech</option>";
        echo "<option value=\"Church\">Church</option>";
        echo "<option value=\"Bank\">Bank</option>";
        echo "<option value=\"Grocry_store\">Grocry_store</option>";
        echo "<option value=\"Golf_club\">Golf_club</option>";
        echo "<option value=\"Car_dealer\">Car_dealer</option>";
        echo "<option value=\"Dentiest_office\">Dentiest_office</option>";
        echo "<option value=\"Lawyer_office\">Lawyer_office</option>";
        echo "<option value=\"Other\">Other</option>";
        echo "</select>";
        echo "</td><td>";

        echo "City:";
        echo "<select name=\"City\">";
        echo "<option value=\"All\">All</option>";
        echo "<option value=\"Ottawa\">Ottawa</option>";
        echo "<option value=\"Gatineau\">Gatineau</option>";
        echo "<option value=\"Kanata\">Kanata</option>";
        echo "<option value=\"Orleans\">Orleans</option>";
        echo "<option value=\"Nepean\">Nepean</option>";
        echo "<option value=\"Gloucester\">Gloucester</option>";
        echo "<option value=\"Osgoode\">Osgoode</option>";
        echo "<option value=\"Barrhaven\">Barrhaven</option>";
        echo "<option value=\"Other\">Other</option>";
        echo "</select>";
        echo "</td><td>";

        echo "User:";
        echo "</td><td >";
        echo "<input style=\"width:100px\" name=\"User\" type=\"text\" /></br>";
        echo "</td><td>";

        #$gt_time = date("Y/m/d", strtotime("monday last week"));
        $lt_time = date("Y/m/d", strtotime("monday next week"));
        $gt_time = date("Y/m/d", strtotime("2016/02/29"));
        #$lt_time = date("Y/m/d", strtotime("2015/12/14"));
        echo "Between:";
        echo "</td><td >";
        echo "<input style=\"width:100px\" name=\"gt_time\" type=\"text\" value=$gt_time /></br>";
        echo "</td><td>";
        echo "<input style=\"width:100px\" name=\"lt_time\" type=\"text\" value=$lt_time /></br>";
        echo "</td><td>";

        echo "<input type=\"submit\" value=\"Search\">";
        echo "</td></tr></table>";

        echo "<HR>";

        // connect to MongoDB
        $m=new MongoClient();

        $db=$m->dbottawa;

        if (empty($_POST)) {
             $Type = "All";
             $City = "All";
             $User = '';
             $dbname = "syposters";
        }
        else {
             $Type=$_POST["Type"];
             $City=$_POST["City"];
             $dbname=$_POST["dbname"];
             $User=$_POST["User"];
             $gt_time=$_POST["gt_time"];
             $lt_time=$_POST["lt_time"];
        }
        //echo "Type=$Type dbname=$dbname";

        // select a collection (analogous to a relational database's table)
        $collection = $db->$dbname;

        if ( $Type == "All" && $City == "All" && $User == '' ) {
            $search_array = array ( 
                'Type' => array( '$ne' => null), 
                'City' => array( '$ne' => null), 
                'User' => array( '$ne' => null), 
                'CreateTime' => array ( '$gt' => "$gt_time", '$lt' => "$lt_time" ));
        }
        else if ( $Type == "All" && $City == "All" && $User != '' ) {
            $search_array = array ( 
                'Type' => array( '$ne' => null), 
                'City' => array( '$ne' => null), 
                'User' => "$User", 
                'CreateTime' => array ( '$gt' => "$gt_time", '$lt' => "$lt_time" ));
        }
        else if( $Type == "All" && $City != "All" ) {
            $search_array = array ( 'Type' => array( '$ne' => null), 'City' => "$City" );
        }
        else if( $Type != "All" && $City == "All" ) {
            $search_array = array ( 'Type' => "$Type", 'City' => array( '$ne' => null) );
        }
        else {
            $search_array = array ( 'Type' => "$Type", 'City' => "$City" );
        }

    echo "<table id=\"hikeTable\" border=\"3\" cellspacing=\"2\" cellpadding=\"1\">";
    echo "<tbody>";

    // building table head with keys
    $cursor = $collection->find( $search_array );
    $array = iterator_to_array($cursor);
    $keys = array();
    foreach ($array as $k => $v) {
            foreach ($v as $a => $b) {
                    $keys[] = $a;
            }
    }
    $keys = array_values(array_unique($keys));
    // assuming first key is MongoID so skipping it
    foreach (array_slice($keys,1) as $key => $value) {
        if ( $value == 'Comments' ) {
            echo "<th width=\"30%\">" . $value . "</th>";
        }
        else if ( $value == 'Name' || $value == 'Area' || $value == 'Address' ) {
            echo "<th width=\"10%\">" . $value . "</th>";
        }
        else {
            echo "<th>" . $value . "</th>";
        }
    }

    echo "<th>Edit</th>";

    $cursor = $collection->find( $search_array );
    $cursor_count = $cursor->count();
    $username = '';
    $timestamp = '';
    foreach ($cursor as $venue) {
        echo "<tr>";
        foreach (array_slice($keys,1) as $key => $value) {
               try {
                   echo "<td>" . $venue[$value] . "</td>";
                   if ( $value == 'User' ) {
                       $username = $venue[$value];
                   }
                   else if ( $value == 'CreateTime' ) {
                       $timestamp = $venue[$value];
                   }
               }
               catch(Exception $e) {
                   echo "<td>" . '' . "</td>";
               } 
        }

        echo "<td><a href='edit.php?username=$username&timestamp=$timestamp' target='_blank'><img src='/ottawa/styles/edit.png' width='20' height='17'></a></td>";
        echo "</tr>";
    }

    echo "</table>";
?>


<HR />
Version:<?php echo "0.1"; ?>  &nbsp; &nbsp;  <small>by Yang Wang</small><BR>
</div>
<script type="text/javascript">
var debugScript = false;

function computeTableColumnTotal(tableId, colNumber)
{
  // find the table with id attribute tableId
  // return the total of the numerical elements in column colNumber
  // skip the top row (headers) and bottom row (where the total will go)
		
  var result = 0;
		
  try
  {
    var tableElem = window.document.getElementById(tableId); 		   
    var tableBody = tableElem.getElementsByTagName("tbody").item(0);
    var i;
    var howManyRows = tableBody.rows.length;
    for (i=1; i<(howManyRows); i++) // skip first and last row (hence i=1, and howManyRows-1)
    {
       var thisTrElem = tableBody.rows[i];
       var thisTdElem = thisTrElem.cells[colNumber];			
       var thisTextNode = thisTdElem.childNodes.item(0);
       try
       {
          var thisTextNodeData = thisTextNode.data;
       }
       catch (ex)
       {
          thisTextNodeData = 0;
       }
       if (debugScript)
       {
          window.alert("text is " + thisTextNodeData);
       } // end if

       // try to convert text to numeric
       var thisNumber = parseFloat(thisTextNodeData);
       // if you didn't get back the value NaN (i.e. not a number), add into result
       if (!isNaN(thisNumber))
         result += thisNumber;
	 } // end for
		 
  } // end try
  catch (ex)
  {
     window.alert("Exception in function computeTableColumnTotal()\n" + ex);
     result = 0;
  }
  finally
  {
     return result;
  }
	
}
		
function finishTable()
{
   if (debugScript)
     window.alert("Beginning of function finishTable");
		
   var tableElemName = "hikeTable";
		
   var totalPosters = computeTableColumnTotal("hikeTable",5);
   var totalFlyers = computeTableColumnTotal("hikeTable",6);

   var TitleWtihNumbers = "MongoDB Search (Total posters: " + totalPosters + ", flyers: " + totalFlyers + ")";

   if (debugScript)
   {
      window.alert("totalPosters=" + totalPosters + "\n" +
                   "totalFlyers=" + totalFlyers);
   }

   try 
   {
   var totalMilesPlannedElem = window.document.getElementById("TitleWtihNumbers");
   totalMilesPlannedElem.innerHTML = TitleWtihNumbers;
   }
   catch (ex)
   {
     window.alert("Exception in function finishTable()\n" + ex);
   }

   return;
}
</script>
 </body>
</html>

