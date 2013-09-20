<?php if (!defined('THINK_PATH')) exit(); if(empty($feeds)): else: ?>
<?php if(is_array($feeds)): foreach($feeds as $key=>$feed): ?><tr id="<?php echo ($feed['id']); ?>">
    <?php switch($feed["type"]): case "1": ?><td class="span1">
          <a href="<?php echo U('User/userPage',array('id'=>$feed['user']['id']));?>"><img class="media-object" src="<?php echo ($feed['user']['middle_img']); ?>"></a>  
        </td>
        <td>
          <div><a href=""><?php echo ($feed['user']['nickname']); ?></a>创建了此活动</div>
          <div class="text-right"><?php echo ($feed['show_create_time']); ?></div>
        </td><?php break;?>
      <?php case "2": ?><td class="span1">
          <a href="<?php echo U('User/userPage',array('id'=>$feed['user']['id']));?>"><img class="media-object" src="<?php echo ($feed['user']['middle_img']); ?>"></a>  
        </td>
        <td>
          <div><a href=""><?php echo ($feed['user']['nickname']); ?></a>对活动进行了更新</div>
          <div class="text-right"><?php echo ($feed['show_create_time']); ?></div>
        </td><?php break;?>
      <?php case "3": ?><td class="span1">
          <a href="<?php echo U('User/userPage',array('id'=>$feed['user']['id']));?>"><img class="media-object" src="<?php echo ($feed['user']['middle_img']); ?>"></a>  
        </td>
        <td>
          <?php $feed['content'] = json_decode($feed['content'],true); ?>
          <div><a href=""><?php echo ($feed['user']['nickname']); ?>:</a><?php echo ($feed['content']['content']); ?></div>
          <div class="text-right"><?php echo ($feed['show_create_time']); ?></div>
        </td><?php break; endswitch; endforeach; endif; endif; ?>