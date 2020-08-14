<!DOCTYPE html5>
<?php
require_once('../setting.php');
require_once('../function/common_function.php');
$common_function_object = new Common_function();
$all_work_array = $common_function_object->get_all_work();
?>
<html lang="zh-TW" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>影片管理</title>
  <meta name="description" content="news新聞網,最即時要聞!">
  <meta name="author" content="黎濠源">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <link rel="shortcut icon" href="../files/bulb-curvy-flat.ico">
</head>
<?php require_once('./menu.php'); ?>
<body>
<div class="main">
  <div class="container">
    <div class="row">
      <div class="col">
        <a href="work_add.php" class="btn btn-primary">新增影片</a><hr>
        <table class="table table-hover">
          <thead>
            <tr style="color:white; background-color:black;">
              <th scope="col">標題</th>
              <th scope="col">影片路徑</th>
              <th scope="col">是否發佈</th>
              <th scope="col">上傳日期</th>
              <th scope="col">管理動作</th>
            </tr>
          </thead>
          <?php if ($all_work_array !== FALSE) : ?>
          <?php foreach ($all_work_array as $all_work_array_val) : ?>
          <tbody>
            <tr>
              <td scope="row"><?php echo $all_work_array_val['title']; ?></td>
              <td scope="row">
              <?php
              if ($all_work_array_val['video_path'] !== NULL)
              {
                  echo $all_work_array_val['video_path'];
              }
              elseif ($all_work_array_val['youtube_link'] !== NULL)
              {
                  echo $all_work_array_val['youtube_link'];
              }
              ?>
              </td>
              <td scope="row"><?php echo ($all_work_array_val['publish']) ? '發佈' : '不發佈'; ?></td>
              <td scope="row"><?php echo $all_work_array_val['create_datetime']; ?></td>
              <td scope="row">
                <a href="work_edit.php?work_id=<?php echo $all_work_array_val['id']; ?>" class="btn btn-success">編輯</a>
                <a href="javascript:void(0)" class="btn btn-danger del_work" data-id=<?php echo $all_work_array_val['id']; ?>>刪除</a>
              </td>
            </tr>
          </tbody>
          <?php endforeach; ?>
          <?php else: ?>
          <tbody>
            <tr>
              <th scope="row" colspan="5">查無資料</th>
            </tr>
          </tbody>
          <?php endif; ?>
        </table>
      </div>
    </div>
  </div>
</div>
</body>
<?php require_once('./footer.php'); ?>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script>
$(document).ready(function() {
  $('a.del_work').click(function() {
    const chosen = confirm('確認要刪除嗎?');
    const target = $(this).parent().parent();
    if (chosen) {
      $.ajax({
        type:'POST',
        url:'../ajax/delete_work.php',
        data:{ 'work_id':$(this).attr('data-id') },
        dataType:'html'
      }).done(function(data) {
        if (data === 'yes') {
          alert('刪除成功');
          target.fadeOut();
        } else {
          alert('刪除失敗,請確認網路是否穩定,若仍無法刪除,請找工程人員檢查');
        }
      }).fail(function(jqXHR,textStatus,errorthrown) {
        alert('有錯誤產生,請查看console log');
        console.log(jqXHR.responseText);
      });
    }
  });
});
</script>
</html>
