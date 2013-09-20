<?php if (!defined('THINK_PATH')) exit(); if(empty($notifications)): ?><div class="center"><?php echo ($error); ?></div>
<?php else: ?>
<table class="table">
  <?php if(is_array($notifications)): foreach($notifications as $key=>$notification): ?><tr>
      <?php switch($notification["type"]): case "1": ?><td style="width:20px">
            <a class="show_detail" href="#<?php echo ($notification['id']); ?>"><i class="icon-plus"></i> </a>
          </td>
          <td>
            <div >
              <a href="<?php echo U('User/userPage',array('id'=>$notification['content']['user']['id']));?>"><?php echo ($notification['content']['user']['nickname']); ?></a>评论了你的活动<a href="<?php echo U('Main/event',array('id'=>$notification['content']['event']['id']));?>"><?php echo ($notification['content']['event']['name']); ?></a>
            </div>
            <div class="well well-small hide" id="<?php echo ($notification['id']); ?>">
              <div><?php echo ($notification['content']['content']); ?></div>
              <div class="text-right"><small><?php echo date('m-d G:i',$notification['create_time']);?></small></div>    
            </div>
          </td><?php break;?>
        <?php case "2": ?><td style="width:20px">
            <a class="show_detail" href="#<?php echo ($notification['id']); ?>"><i class="icon-plus"></i> </a>
          </td>
          <td>
            <div >
              <a href="<?php echo U('User/userPage',array('id'=>$notification['content']['user']['id']));?>"><?php echo ($notification['content']['user']['nickname']); ?></a>关注了你
            </div>
          </td><?php break; endswitch;?>
    </tr><?php endforeach; endif; ?>
</table>
<div class="pagination pagination-centered">
  <?php echo ($page); ?>
</div><?php endif; ?>
<script>
  $('.show_detail').click(function(e){
    e.preventDefault();
    if($($(this).attr('href')).hasClass('hide')){
      $($(this).attr('href')).removeClass('hide');
    }else{
      $($(this).attr('href')).addClass('hide');
    }
  });
</script>