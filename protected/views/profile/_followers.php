<?php echo CHtml::link(CHtml::image(Helper::profilePicture($data->follower), 'Profile Pic', array('class' => 'figure')), $this->createUrl('profile/' . $data->follower->id));?>
<div class="content">
  <span><?php echo CHtml::link($data->follower->fullName, $this->createUrl('profile/' . $data->follower->id)); ?></span>
  <div>
    <?php
    $profile = Profile::model()->findByPk(Yii::app()->user->id);
    if ($data->follower->id == $profile->id) {
      echo 'You';
    }
    elseif ($profile->isFollowing($data->follower)) {
      $this->renderPartial('_unfollow', array('profile' => $data->follower));
    }
    else {
      $this->renderPartial('_follow', array('profile' => $data->follower));
    }
    ?>
  </div>
</div>
<div class="clear line"></div>
