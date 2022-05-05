<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>To-do List</title>
    <link rel="stylesheet" href="/css/main.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/common.js"></script>
  </head>
  <body>
    <form class="todo-form">
      <section class="todo">
        <h1>Yapılacaklar Listesi</h1>
        <section class="task_box">
          <h2>Yeni Görev</h2>
          <input id="task_baslık" name="title" class="gorev" placeholder="Görev Başlıgı" type="text">
          <input id="task_name" name="mission" class="gorev" placeholder="Görev Girin" type="text">
          <input id="task_acıklama" name="desc" class="gorev" placeholder="Görev Açıklaması" type="text">
          <input type="date" id="date" name="date" max="2023-12-31" min="2022-04-20">
          <button name="clear_input" class="gorev" type="reset">Temizle</button>
          <button id="button" name='submit' data-wait="Bekleyin" type='submit'>Ekle</button>
          <aside></aside>
        </section>
        <section class="task_list">
          <h2>Görev Listesi</h2>
          <?php
            $resp="";
            require("kayıtlar.php");
            if(isset($tasks) AND !empty($tasks)) {
              $resp.="<table border='1'>";
                $resp.="<tr><td>Görev Başlık</td><td>Görev</td><td>Açıklama</td><td>Tarih</td><td>Sil</td></tr>";
                foreach ($tasks as $key=>$array) {
                  $resp.="<tr><td>".$array["title"]."</td><td>".$array["mission"]."</td><td>".$array["desc"]."</td><td>".$array["date"]."</td><td><button type='button' id='clear_data' data-id='".$key."'>Sil</button></td></tr>";
                }
              $resp.="</table>";
            }
            echo $resp;
          ?>
        </section>
      </section>
    </form>
  </body>
</html>
