<?php echo CHtml::link(CHtml::image(Helper::profilePicture($data->author->profile), 'Profile Pic', array('class' => 'figure')), $this->createUrl('profile/' . $data->author->profile->id));?>
<div class="content">
  <span><?php echo CHtml::link($data->author->profile->fullName, $this->createUrl('profile/' . $data->author->profile->id)); ?>:</span>
  <?php echo $data->content; ?>
</div>
<div class="content">
  <?php echo CHtml::link(date('F j, Y \a\t h:i a', $data->create_time), $this->createUrl('profile/' . $data->author->profile->id . '/post/' . $data->create_time)); ?>
  <?php if (count($data->comments) >= 1): ?>
    <div>
      <?php echo CHtml::link((count($data->comments) > 1) ? count($data->comments) . ' comments' : 'One comment', $this->createUrl('profile/' . $data->author->profile->id . '/post/' . $data->create_time . '#comments')); ?>
    </div>
  <? endif; ?>

</div>
<div class="clear line"></div>
