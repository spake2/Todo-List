<?php
function ok($content=false) {
  $return=array();
  $return["response"]="Bilgi Kaydedildi";
  $return["content"]=$content;
  header("HTTP/1.0 201 Created");
  header("content-type: application/json; charset=utf-8");
  return json_encode($return);
}

function error($content=false) {
  $return=array();
  $return["response"]="Lütfen alanları doldurun.";
  $return["content"]=$content;
  header("HTTP/1.0 400 Bad Request");
  header("content-type: application/json; charset=utf-8");
  return json_encode($return);
}

$id=(isset($_POST["id"]))?$_POST["id"]:"";
if(empty($_POST)) {
  echo error("id gelmedi");
}
require("kayıtlar.php");
$output="<?php";
$output.="\n";
$output.='$tasks=array();';
$output.="\n";
$output.="\n";
foreach ($tasks as $key=>$array) {
  if($key==$id) {
    continue 1;
  }
  $output.='$tasks['.$key.']["title"]="'.$array["title"].'";';
  $output.="\n";
  $output.='$tasks['.$key.']["mission"]="'.$array["mission"].'";';
  $output.="\n";
  $output.='$tasks['.$key.']["desc"]="'.$array["desc"].'";';
  $output.="\n";
  $output.='$tasks['.$key.']["date"]="'.$array["date"].'";';
  $output.="\n";
}
$myfile=fopen("kayıtlar.php","w");
fwrite($myfile,$output);
fclose($myfile);
echo ok();



 ?>
