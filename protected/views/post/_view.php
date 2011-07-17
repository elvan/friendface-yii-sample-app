<div class="post">
  <?php echo CHtml::link(CHtml::image(Helper::profilePicture($data->author), 'Profile Pic', array('class' => 'figure')), $this->createUrl('profile/' . $data->author->id));?>
  <div class="content">
    <span><?php echo CHtml::link($data->author->fullName, $this->createUrl('profile/' . $data->author->id)); ?>:</span>
    <?php echo $data->content; ?>
  </div>
  <div class="content">
    <?php echo date('F j, Y \a\t h:i a', $data->update_time); ?>
  </div>
</div>
<div class="clear line"></div>
