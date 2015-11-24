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

 <head>
<?php
        echo "<form action=\"search.php\" method=\"get\">";
        echo "<input type=\"hidden\" name=\"dbname\" value=\"syposters\"/>";
        echo "<input type=\"submit\" value=\"SY Postesrs\">";
        echo "</form>";
        echo "<form action=\"search.php\" method=\"get\">";
        echo "<input type=\"hidden\" name=\"dbname\" value=\"locdata\"/>";
        echo "<input type=\"submit\" value=\"Ottawa Locations\">";
        echo "</form>";

//$dbname = $_GET['dbname'];
$dbname = 'syposters';
set_error_handler('exceptions_error_handler');

function exceptions_error_handler($severity, $message, $filename, $lineno) {
  if (error_reporting() == 0) {
    return;
  }
  if (error_reporting() & $severity) {
    throw new ErrorException($message, 0, $severity, $filename, $lineno);
  }
}
        $m=new MongoClient();

        $db=$m->dbottawa;

        // select a collection (analogous to a relational database's table)
        $collection = $db->$dbname;

    // search weekly numbers
    $num_overall = $collection->count();

    $num_ruizhang = $collection->count(array("User" => "rui.zhang"));
    $num_kathygillis = $collection->count(array("User" => "kathy.gillis"));
    $num_yangwang = $collection->count(array("User" => "yang.wang"));

    echo "Overall: $num_overall<br>";

    echo "Rui Zhang: $num_ruizhang<br>";
    echo "Kathy Gillils: $num_kathygillis<br>";
    echo "Yang Wang: $num_yangwang";

?>


<HR />
<i>ywang</i> version:<?php echo "0.1"; ?>  &nbsp; &nbsp;  <small>by Yang Wang</small><BR>
</div>
 </body>
</html>

