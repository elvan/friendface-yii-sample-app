<div>
  <h1>
    <?php echo CHtml::image(Helper::profilePicture($profile), 'Profile Pic', array('width' => 80, 'height' => 80)); ?>
    <?php echo CHtml::link($profile->fullName, array('/profile/' . $profile->id)); ?>
  </h1>
  
  <?php
  if ($_GET['uid'] !== Yii::app()->user->id && !Yii::app()->user->isGuest) {
    $follower = Profile::model()->findByPk(Yii::app()->user->id);
    if ($follower->isFollowing($profile)) {
      $this->renderPartial('/profile/_unfollow', array('profile' => $profile));
    }
    else {
      $this->renderPartial('/profile/_follow', array('profile' => $profile));
    }
  }
  ?>
</div>
<div class="clear line"></div>

<?php $this->renderPartial('_viewSingle', array(
  'data'=>$post,
)); ?>

<div id="comments">
<?php $this->renderPartial('/comment/_list', array(
  'dataProvider' => $dataProvider,
)); ?>

<?php $this->renderPartial('/comment/_create',array(
  'comment' => $comment,
)); ?>
</div>
