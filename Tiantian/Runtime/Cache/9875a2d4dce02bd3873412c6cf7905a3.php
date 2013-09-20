<?php if (!defined('THINK_PATH')) exit(); if(empty($feeds)): else: ?>
<?php if(is_array($feeds)): foreach($feeds as $key=>$feed): ?><li class="media" id="<?php echo ($feed['id']); ?>">
    <?php switch($feed["type"]): case "1": ?><a class="pull-left" href="<?php echo U('User/userPage',array('id'=>$feed['user']['id']));?>">
          <img class="media-object" style="width:50px;height:50px;" src="<?php echo ($feed['user']['middle_img']); ?>">
        </a>
        <div class="media-body">
          <div class=" well well-small">
            <div><a href="<?php echo U('User/userPage',array('id'=>$feed['user']['id']));?>"><?php echo ($feed['user']['nickname']); ?></a>对活动<a href="<?php echo U('Main/event',array('id'=>$feed['event_id']));?>"><?php echo ($feed['event']['name']); ?></a>进行了更新</div>
            <div class="text-right"><?php echo ($feed['create_time']); ?></div>
          </div>
        </div><?php break; endswitch;?>
  </li><?php endforeach; endif; endif; ?>