<html>
<body>
<?php
$m=new MongoClient();
$db=$m->dbottawa;
$collection = $db->syposters;

$filter=$_GET['filter'];
$filter_value=$_GET['filter_value'];

$search_array = array ( $filter => "$filter_value" );
$cursor = $collection->findOne( $search_array );

$User = $cursor['User'];
$id = $cursor['_id'];
$Type = $cursor['Type'];

echo "<SCRIPT>alert('$filter = $filter_value \\n _id = $id \\n User = $User \\n Type = $Type ')</SCRIPT>";



?>
</body>
</html>
