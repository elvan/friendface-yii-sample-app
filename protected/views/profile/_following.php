<?php echo CHtml::link(CHtml::image(Helper::profilePicture($data->followed), 'Profile Pic', array('class' => 'figure')), $this->createUrl('profile/' . $data->followed->id));?>
<div class="content">
  <span><?php echo CHtml::link($data->followed->fullName, $this->createUrl('profile/' . $data->followed->id)); ?></span>
  <div>
    <?php
    $profile = Profile::model()->findByPk(Yii::app()->user->id);
    if ($data->followed->id == $profile->id) {
      echo 'You';
    }
    elseif ($profile->isFollowing($data->followed)) {
      $this->renderPartial('_unfollow', array('profile' => $data->followed));
    }
    else {
      $this->renderPartial('_follow', array('profile' => $data->followed));
    }
    ?>
  </div>
</div>
<div class="clear line"></div>
