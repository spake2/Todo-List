$(function(){
  $("body").on("submit","form.todo-form", function() {
      var $form=$(this);
      var $submit=$form.find("button[type='submit']");
      var $submit_val=$submit.html();
      $submit.attr("disabled",true).html($submit.data("wait"));
      $.post("todo.php",$form.serialize(),function(data,textStatus,statusCode) {
        console.log(statusCode.status);
      if(statusCode.status==200 || statusCode.status==201) {
        console.log(data);
        if($("section.task_list table").length>0) {
          $("section.task_list table tr").first().after(data.content);
        }
        else {
          $("aside").html(data.response).show();
        }
        $submit.attr("disabled",false).html($submit_val);
      }
    },'json').fail(function(e) {
      $("aside").html(e.responseText).show();
      $submit.attr("disabled",false).html($submit_val);
    });
   return false;
 }).on("click","button#clear_data",function() {
   var $this=$(this);
   var $id=$this.data("id");
   var $params=new Array();
   $params.push({"name": "id", "value":$id});
   $.post("delete.php", $.param($params), function(data,textStatus,statusCode) {
     console.log(statusCode.status);
     if(statusCode.status==200 || statusCode.status==201) {
       console.log(data);
      $this.parents("tr").first().remove();
     }
    },'json').fail(function(e) {
      alert(e.responseText);
    });
  });
});
