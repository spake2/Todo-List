<?php

function ok($content=false) {
  $return=array();
  $return["response"]="Bilgi Kaydedildi";
  $return["content"]=$content;
  header("HTTP/1.0 201 Created");
  header("content-type: application/json; charset=utf-8");
  return json_encode($return);
}
// Alan boş bırakınca yeni bir fonksiyon oluşturup çıktıyı almak için.
function error($content=false) {
  $return=array();
  $return["response"]="Lütfen alanları doldurun.";
  $return["content"]=$content;
  header("HTTP/1.0 400 Bad Request");
  header("content-type: application/json; charset=utf-8");
  return json_encode($return);
}

if(isset($_POST["title"]) AND isset($_POST["mission"]) AND isset($_POST["desc"]) AND isset($_POST["date"])) {
  require("kayıtlar.php");
  $title=$_POST["title"];
  $mission=$_POST["mission"];
  $desc=$_POST["desc"];
  $date=$_POST["date"];
  // Header statü olarak 400 kullanıp hata mesajı çıktısı yazdırdık.
  if(empty($title) OR empty($mission) OR empty($desc) OR empty($date)){
    header("HTTP/1.0 400 Bad Request");
    echo "Lütfen Tüm alanları doldurun.";
    exit;
  }
  elseif(is_numeric($title) OR is_numeric($mission) OR is_numeric($desc)){
    header("HTTP/1.0 400 Bad Request");
    echo "Sayısal Değer Girmeyiniz.";
    exit;
  }
  elseif(preg_match('/[\'^£$%&*()!}{@#~?><>,|=_+¬-]/',$title) OR preg_match('/[\'^£$%&*()!}{@#~?><>,|=_+¬-]/',$mission) OR preg_match('/[\'^£$%&*()!}{@#~?><>,|=_+¬-]/',$desc)){
    header("HTTP/1.0 400 Bad Request");
    echo "Karakterler Kullanılamaz.Yalnızca Harf Kullanılabilir.";
    exit;
  }
  else {
    $date = date('d-m-Y', strtotime($date));
    $output="<?php";
    $output.="\n";
    $output.='$tasks=array();';
    $output.="\n";
    $output.="\n";
    if(isset($tasks) AND is_array($tasks)) {
      foreach($tasks as $key=>$array) {
        $output.='$tasks['.$key.']["title"]="'.$array["title"].'";';
        $output.="\n";
        $output.='$tasks['.$key.']["mission"]="'.$array["mission"].'";';
        $output.="\n";
        $output.='$tasks['.$key.']["desc"]="'.$array["desc"].'";';
        $output.="\n";
        $output.='$tasks['.$key.']["date"]="'.$array["date"].'";';
        $output.="\n";
        $output.="\n";
      }
      $_key=count($tasks);
      $output.='$tasks['.$_key.']["title"]="'.$title.'";';
      $output.="\n";
      $output.='$tasks['.$_key.']["mission"]="'.$mission.'";';
      $output.="\n";
      $output.='$tasks['.$_key.']["desc"]="'.$desc.'";';
      $output.="\n";
      $output.='$tasks['.$_key.']["date"]="'.$date.'";';
      $output.="\n";
    }
    else {
      $output.='$tasks[0]["title"]="'.$title.'";';
      $output.="\n";
      $output.='$tasks[0]["mission"]="'.$mission.'";';
      $output.="\n";
      $output.='$tasks[0]["desc"]="'.$desc.'";';
      $output.="\n";
      $output.='$tasks[0]["date"]="'.$date.'";';
      $output.="\n";
    }
    $myfile=fopen("kayıtlar.php","w");
    fwrite($myfile,$output);
    fclose($myfile);
    $output="";
    if(!isset($tasks) OR empty($tasks)) {
      $output.= "<table border='1'>";
      $output.= "<tr><td>Görev Başlığı</td><td>Görev</td><td>Görev Açıklaması</td><td>Tarih</td><td>Sil</td></tr>";
    }
    $output.="<tr><td>".$title."</td><td>".$mission."</td><td>".$desc."</td><td>".$date."</td><td><button type=reset id=clear_data>Sil</button></td></tr>";
    if(!isset($tasks) OR empty($tasks)) {
      $output.= "</table>";
    }
    echo ok($output);
  }
}


 ?>
