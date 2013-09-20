<?php if (!defined('THINK_PATH')) exit();?><legend><?php echo ($form_title?$form_title:''); ?></legend>
<form id="<?php echo ($form_id); ?>" class="form-horizontal" action="<?php echo ($action_url); ?>" method="post">
  <?php if(is_array($inputs)): foreach($inputs as $key=>$input): switch($input['type']): case "radio": ?><div class="control-group">
          <label class="control-label"><?php echo isset($input['name'])?$input['name']:'';?></label>
          <div class="controls ">
            <?php if(is_array($input['radios'])): foreach($input['radios'] as $key=>$value): ?><label class="radio <?php echo isset($input['inline'])?$input['inline']:'';?>">
                <input type="radio" name="<?php echo isset($input['id'])?$input['id']:'';?>" value="<?php echo isset($value[0])?$value[0]:0;?>" <?php echo isset($value['2'])?'checked':'';?>><?php echo isset($value[1])?$value[1]:'';?>
              </label><?php endforeach; endif; ?>
          </div>
        </div><?php break;?>
      <?php case "select": ?><div class="control-group">
          <label class="control-label"><?php echo isset($input['name'])?$input['name']:'';?></label>
          <div class="controls">
            <select name="<?php echo isset($input['id'])?$input['id']:'';?>" class="required">
              <option></option>
              <?php if(is_array($input['selects'])): foreach($input['selects'] as $key=>$value): ?><option value="<?php echo ($key); ?>"><?php echo ($value); ?></option>
                </label><?php endforeach; endif; ?>
            </select>
          </div>
        </div><?php break;?>
      <?php case "checkbox": ?><div class="control-group">
          <label class="control-label"><?php echo isset($input['name'])?$input['name']:'';?></label>
          <div class="controls ">
            <?php if(is_array($input['checkboxs'])): foreach($input['checkboxs'] as $key=>$value): ?><label class="checkbox">
                <input type="checkbox" name="<?php echo isset($input['id'])?$input['id']:'';?>" value="<?php echo ($key); ?>"><?php echo ($value); ?>
              </label><?php endforeach; endif; ?>
          </div>
        </div><?php break;?>
      <?php case "textarea": ?><div class="control-group">
          <label class="control-label"><?php echo ($input['name']); ?></label>
          <div class="controls">
            <textarea name="<?php echo isset($input['id'])?$input['id']:'';?>" id="<?php echo isset($input['id'])?$input['id']:'';?>" cols="3" placeholder="<?php echo isset($input['placeholder'])?$input['placeholder']:'';?>"><?php echo isset($input['value'])?$input['value']:'';?></textarea>
          </div>
        </div><?php break;?>
      <?php case "hidden": ?><input type="hidden" id="<?php echo ($input['id']); ?>" name="<?php echo ($input['id']); ?>" value="<?php echo ($input['value']); ?>"><?php break;?>
      <?php default: ?>
        <div class="control-group">
          <label class="control-label"><?php echo ($input['name']); ?></label>
          <div class="controls">
            <input type="<?php echo isset($input['type'])?$input['type']:'';?>" <?php echo isset($input['disabled'])?$input['disabled']:'';?> name="<?php echo isset($input['id'])?$input['id']:'';?>" id="<?php echo isset($input['id'])?$input['id']:'';?>" placeholder="<?php echo isset($input['placeholder'])?$input['placeholder']:'';?>" value="<?php echo isset($input['value'])?$input['value']:'';?>">
          </div>
        </div><?php endswitch; endforeach; endif; ?>
  <div class="control-group">
    <div class="controls">
      <div id="show_alert" class="alert hide"></div>
      <div id="show_success" class="alert alert-success hide"></div>
    </div>
  </div>
  <div class="form-actions">
      <button id="submit" class="btn btn-primary" data-loading-text="<?php echo ($submit_loading); ?>"><?php echo ($submit_name); ?></button>
  </div>
</form>
<script type="text/javascript" src="__PUBLIC__/js/jquery.form.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.validate.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/messages_zh.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.validate.bootstrap.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  var form = null;
  var options = {
    beforeSubmit:validateForm,
    success:showResponse,
    clearForm:false
  }
  var submit = $("#submit");
  function validateForm(formData,jqForm,options){
    form = formData;
    submit.button('loading');
    return true;
  }
  function showResponse(ret,statusText){
    submit.button('reset');
    if(ret.status==0){
      <?php echo ($error); ?>
    }else{
      <?php echo ($success); ?>
    }
  }
  //增加表单验证
  $("#<?php echo ($form_id); ?>").validate({
    rules:{
      <?php if(is_array($inputs)): foreach($inputs as $key=>$input): if(isset($input['rules'])): echo ($key); ?>:<?php echo ($input['rules']); ?>,<?php endif; endforeach; endif; ?>
    },
    messages:{
      <?php if(is_array($inputs)): foreach($inputs as $key=>$input): if(isset($input['messages'])): echo ($key); ?>:<?php echo ($input['messages']); ?>,<?php endif; endforeach; endif; ?>
    },
    submitHandler:function(form) {
      $('#show_alert').html('').hide();
      $('#show_success').html('').hide();
      $(form).ajaxSubmit(options);
  }});
});
</script>