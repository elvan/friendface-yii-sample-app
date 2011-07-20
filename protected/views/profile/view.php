<?php if(Yii::app()->user->hasFlash('profile')): ?>
  <div class="flash-success">
    <?php echo Yii::app()->user->getFlash('profile'); ?>
  </div>
<?php endif; ?>

<div>
  <h1>
    <?php echo CHtml::image(Helper::profilePicture($profile), 'Profile Pic'); ?>
    <?php echo $profile->fullName; ?>
  </h1>
  
  <?php
  if ($_GET['id'] !== Yii::app()->user->id) {
    $follower = Profile::model()->findByPk(Yii::app()->user->id);
    if ($follower->isFollowing($profile)) {
      $this->renderPartial('_unfollow', array('profile' => $profile));
    }
    else {
      $this->renderPartial('_follow', array('profile' => $profile));
    }
  }
  ?>
</div>

<?php if ($this->isSignedIn()): ?>
  <?php echo $this->renderPartial('/post/_create', array('post' => $post, 'returnUrl' => '/profile/' . $profile->id)); ?>
<?php endif; ?>

<?php $this->renderPartial('/post/_list',array(
  'profile' => $profile,
  'posts' => $profile->posts,
  'dataProvider' => $dataProvider,
)); ?>
