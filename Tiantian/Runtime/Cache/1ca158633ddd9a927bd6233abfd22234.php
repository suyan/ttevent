<?php if (!defined('THINK_PATH')) exit();?><form id="feedForm" action="<?php echo U('EventFeed/addFeed');?>" method="POST">
  <input name="event_id" type="hidden" value="<?php echo ($event_id); ?>">
  <textarea id="content" name="content" rows="3" style="resize: none;width:95%;"></textarea>
  <p class="text-right">
    <button id="submit" class="btn btn-primary" data-loading-text="正在提交...">提交</button>
  </p> 
</form>
<table class="table" id="feedWall">
  <?php echo W('Feed',$data);?>
</table>
<div class="text-center well well-small"><a href="javascript:;" id="getMore">获取更多</a></div>
<script type="text/javascript" src="__PUBLIC__/js/jquery.form.js"></script>
<script>
  $(function(){
    var click = false;
    $('#getMore').click(function(e){
      if(!click){
        click = true;
        e.preventDefault();
        var button=$(this);
        button.html('<img src="__PUBLIC__/img/loading.gif" />');  
        $.get('<?php echo U("EventFeed/getFeed",array("event_id"=>$event_id));?>'+'/feed_id/'+$('#feedWall tr:last-child').attr('id'),function(data){
          if(data.length<10){
            $('.notifications').notify({
              type:'error',
              message: { text: '已经没有新的动态了' }
            }).show();  
          }else{
            $('#feedWall').append(data);
          }
          button.html('获取更多');
          click = false;
        });
      }
    });
    var options = {
      beforeSubmit:validateForm,
      success:showResponse,
      clearForm:true
    }
    var submit = $("#submit");
    function validateForm(formData,jqForm,options){
      submit.button('loading');
      if($('#content').val() == ''){
        $('.notifications').notify({
          type: 'error',
          message: { text: '请填写动态内容',}
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
          message: { text: '发布成功',}
        }).show();
      }else{
        $('.notifications').notify({
          type: 'error',
          message: { text: '发布失败',}
        }).show();
      }
    }
    $('#feedForm').ajaxForm(options);
  });
</script>