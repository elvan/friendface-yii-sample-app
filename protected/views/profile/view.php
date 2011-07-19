<?php if(Yii::app()->user->hasFlash('profile')): ?>
  <div class="flash-success">
    <?php echo Yii::app()->user->getFlash('profile'); ?>
  </div>
<?php endif; ?>

<?php if ($this->isSignedIn()): ?>
  <?php echo $this->renderPartial('/post/_create', array('post' => $post, 'returnUrl' => '/profile/' . $profile->id)); ?>
<?php endif; ?>

<?php $this->renderPartial('/post/_list',array(
  'profile' => $profile,
  'posts' => $profile->posts,
  'dataProvider' => $dataProvider,
)); ?>
