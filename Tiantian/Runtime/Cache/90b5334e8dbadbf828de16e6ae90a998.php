<?php if (!defined('THINK_PATH')) exit(); if(empty($events)): ?><div class="center"><?php echo ($error); ?></div>
<?php else: ?>
  <ul class="media-list">
    <?php if(is_array($events)): foreach($events as $key=>$event): ?><li class="media">
        <a class="pull-left" href="<?php echo ($event['url']); ?>">
          <?php if($event['small_img']): ?><img src="<?php echo ($event['small_img']); ?>" style="height:120px;width:90px">
          <?php else: ?>
            <img src="" style="height:120px;width:90px"><?php endif; ?>
        </a>
        <div class="media-body">
          <h4 class="media-heading"><a href="<?php echo ($event['url']); ?>"><?php echo ($event['name']); ?></a></h4>
            <?php echo ($event['show_status']); ?>
            <div>
              <small><strong>时间：</strong><?php echo ($event['start_time']); ?> —— <?php echo ($event['end_time']); ?></small><br>
              <small><strong>地点：</strong><?php echo ($event['province']); ?> <?php echo ($event['city']); ?> <?php echo ($event['area']); ?> <?php echo ($event['location']); ?></small><br>
              <small><strong>发起：</strong><?php echo ($event['user']['nickname']); ?></small><br>
              <small><strong>描述：</strong><?php echo ($event['short_description']); ?></small>
            </div>
        </div>
      </li><?php endforeach; endif; ?>
  </ul>
  <div class="pagination pagination-centered">
    <?php echo ($page); ?>
  </div><?php endif; ?>