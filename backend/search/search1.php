<?php
/** Mysql Starts **/
$host = "localhost";
// Host name
$username = "bloomigo_search";
// Mysql username
$password = "9893044015";
// Mysql password
$db_name = "bloomigo_search";
// Database name
// Connect to server and select database.
$db = mysqli_connect("$host", "$username", "$password") or die("cannot connect");
mysqli_select_db($db,$db_name) or die("cannot select DB");
/** MySql Ends **/
function array_delete($array, $element) {
    return array_diff($array, [$element]);
}


/** Function Ends **/

header('Access-Control-Allow-Origin: *');
header("Access-Control-Expose-Headers: Access-Control-Allow-Origin");
header("HTTP/1.1 200 OK");
header('Content-Type: application/json');
$param = $_GET['param'];
$allParams = $_GET;
$catArray = array('company', 'job', 'skill', 'industry');
$checkArray = array();
$emparray = array();
if (empty($_GET) || !isset($_GET)) {
    $y = 0;
    $catArray = array('trending','company', 'job', 'skill', 'industry');
    $sqlTreanding = "SELECT * FROM `search_v1` order by hits DESC LIMIT 10";
    $trendingResult = mysqli_query($db,$sqlTreanding);
    $trendingResult = mysql_fetch_assoc($trendingResult);   
    
    foreach ($catArray as $type) {
        $sql = "SELECT s_no as id, input as name FROM search_v1 where type='" . $type . "' ";
        if(strcmp($type, 'trending') == 0){
            $sql = "SELECT s_no as id, input as name FROM `search_v1` order by hits DESC LIMIT 10"; 
        }
        $result = mysqli_query($db,$sql);
        $emparray[$y]['category'] = $type;
        $x = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $emparray[$y]['values'][$x] = $row;
            $x++;
        }
        $y++;
    }
    $result = array('call' => array('success' => true, 'code' => 0, 'message' => 'null'));
    $result['call']['meta'] = array('total' => count($emparray));
    $result['call']['response'] = $emparray;
    /*$memcache = new Memcache;
    $memcache->connect('localhost', 11211) or die ("Could not connect");
    $result = $memcache->get('search');*/
    echo(json_encode($result));




} else {
    $pastSql = '';
    $z = 0;
    foreach ($_GET as $key => $values) {
        $catArray = array_delete($catArray, $key);
        if ($z < 1) {
            $pastSql = $key . "='" . $values . "' ";
        } else {
            $pastSql .= " and " . $key . "='" . $values . "' ";
        }
        $z++;
        //var_dump($catArray);
    }
    $y = 0;
    foreach ($catArray as $cat) {
        $sql = "SELECT s_no as id, " . $cat . " as name FROM search where " . $pastSql . " group by 2";
        $result = mysqli_query($db,$sql);
        $emparray[$y]['category'] = $cat;
        $x = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $emparray[$y]['values'][$x] = $row;
            $x++;
        }
        $y++;
    }

    $result = array('call' => array('success' => true, 'code' => 0, 'message' => 'null'));
    $result['call']['meta'] = array('total' => count($emparray));
    $result['call']['response'] = $emparray;
    echo(json_encode($result));
}
?>