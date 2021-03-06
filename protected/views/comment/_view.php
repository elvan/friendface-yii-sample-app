<?php echo CHtml::link(CHtml::image(Helper::profilePicture($data->author->profile), 'Profile Pic', array('class' => 'figure')), $this->createUrl('profile/' . $data->author->profile->id));?>
<div class="content">
  <span><?php echo CHtml::link($data->author->profile->fullName, $this->createUrl('profile/' . $data->author->profile->id)); ?>:</span>
  <?php echo $data->content; ?>
</div>
<div class="content">
  <?php echo date('F j, Y \a\t h:i a', $data->create_time); ?>
  <?php if ($data->author->profile->id == Yii::app()->user->id): ?>
    <?php echo CHtml::linkButton('delete', array(
      'submit' => array('/comment/delete/' . $data->id),
      'confirm' => 'Are you sure?',
    )); ?>
  <?php endif; ?>
</div>
<div class="clear line"></div>
