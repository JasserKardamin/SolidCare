<?php
error_reporting(E_ALL);
ini_set('display_errors', true);

require("../model/dmd.php");
echo"test";
require("../model/rdv.php");
$des = $_POST["ar"];
var_dump($des);
$id_dmd = $_POST["id"];
var_dump($id_dmd);
if ($des == "accepted") {
  $new_dmd = new dmd();
  $new_dmd->update_DMD($id_dmd, $des);
  var_dump($new_dmd);
  $cinn = $_POST["cinn"];
  $cinp = $_POST["cinp"];
  $dt = $_POST["dt"];
  $in = $_POST["in"];
  $new_rdv = new rdv();
  $new_rdv->create_RDV($cinp, $cinn, $dt, $in);
}
if ($des == "refused") {
  $new_dmd = new dmd();
  $new_dmd->update_DMD($id_dmd, $des);

}
header('Location: ../../view/front_office/rdv/MainNurseDmd.php');
?>