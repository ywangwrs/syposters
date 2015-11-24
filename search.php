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
</div>

 <head>
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

        echo "<h1>MongoDB Search</h1>";
        echo "<form action=\"search.php\" method=\"POST\"  enctype=\"multipart/form-data\">";

        echo "<table><tr><td>";
        echo "Database:";
        echo "<select name=\"dbname\">";
        echo "<option value=\"syposters\">Posters</option>";
        echo "<option value=\"locdata\">Locations</option>";
        echo "</select>";
        // close table cell
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
        // close table cell
        echo "</td><td>";

        echo "<input type=\"submit\" value=\"Search\">";
        echo "</td></tr></table>";

        echo "<HR>";

        // connect to MongoDB
        $m=new MongoClient();

        $db=$m->dbottawa;

        if (empty($_POST)) {
             $Type = "All";
             $dbname = "syposters";
        }
        else {
             $Type=$_POST["Type"];
             $dbname=$_POST["dbname"];
        }
        echo "Type=$Type dbname=$dbname";

        // select a collection (analogous to a relational database's table)
        $collection = $db->$dbname;

        if ( $Type == "All" ) {
            $type_array = array( 'Type' => array( '$ne' => null) );
        }
        else {
            $type_array = array( "Type" => "$Type" );
        }

    echo "<table>";

    // building table head with keys
    $cursor = $collection->find( $type_array );
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

    $cursor = $collection->find( $type_array );
    $cursor_count = $cursor->count();
    foreach ($cursor as $venue) {
        echo "<tr>";
        foreach (array_slice($keys,1) as $key => $value) {
               try {
                   echo "<td>" . $venue[$value] . "</td>";
               }
               catch(Exception $e) {
                   echo "<td>" . '' . "</td>";
               } 
        }
        echo "</tr>";
    }

    echo "</table>";
?>


<HR />
Version:<?php echo "0.1"; ?>  &nbsp; &nbsp;  <small>by Yang Wang</small><BR>
</div>
 </body>
</html>
