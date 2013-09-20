<?php if (!defined('THINK_PATH')) exit();?><form id="commentForm" action="<?php echo U('EventComment/commentEvent');?>" method="POST">
  <input name="event_id" type="hidden" value="<?php echo ($event_id); ?>">
  <textarea id="commentContent" name="content" rows="3" style="resize: none;width:95%;"></textarea>
  <p class="text-right">
    <button id="submit" class="btn btn-primary" data-loading-text="正在提交...">提交</button>
  </p> 
</form>
<?php if(empty($comments)): ?><div class="center"><?php echo ($error); ?></div>
<?php else: ?>
<table class="table" class="commentWall">
  <?php if(is_array($comments)): foreach($comments as $key=>$comment): ?><tr id="<?php echo ($comment['id']); ?>">
      <td class="span1">
        <a class="pull-left" href="<?php echo U('User/userPage',array('id'=>$comment['user_id']));?>"><img class="media-object" src="<?php echo ($comment['small_img']); ?>"></a>  
      </td>
      <td>
        <div><a href="<?php echo U('User/userPage',array('id'=>$comment['user_id']));?>"><?php echo ($comment['nickname']); ?></a>：<?php echo ($comment['content']); ?></div>
        <div class="text-right"><small><?php echo date('m-d G:i',$comment['create_time']);?></small></div>
      </td>
    </tr><?php endforeach; endif; ?>
</table>
<div class="pagination pagination-centered">
  <?php echo ($page); ?>
</div><?php endif; ?>
<script type="text/javascript" src="__PUBLIC__/js/jquery.form.js"></script>
<script>
  var options = {
    beforeSubmit:validateForm,
    success:showResponse,
    clearForm:true
  }
  var submit = $("#submit");
  function validateForm(formData,jqForm,options){
    submit.button('loading');
    if($('#commentContent').val() == ''){
      $('.notifications').notify({
        type: 'error',
        message: { text: '请填写活动评论',}
      }).show();
    }else{
      return true;
    }
    submit.button('reset');
    return false;
  }
  function showResponse(ret,statusText){
    submit.button('reset');
    if(ret.status!=0){
      $('.notifications').notify({
        message: { text: '评论成功',}
      }).show();
    }else{
      $('.notifications').notify({
        type: 'error',
        message: { text: '评论失败',}
      }).show();
    }
  }
  $('#commentForm').ajaxForm(options);
</script>