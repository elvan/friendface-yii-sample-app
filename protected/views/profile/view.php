<?php if(Yii::app()->user->hasFlash('profile')): ?>
  <div class="flash-success">
    <?php echo Yii::app()->user->getFlash('profile'); ?>
  </div>
<?php endif; ?>

<?php echo $this->renderPartial('/post/_create', array('post' => $post)); ?>

<?php $this->renderPartial('/post/_list',array(
  'profile' => $profile,
  'posts' => $profile->posts,
  'dataProvider' => $dataProvider,
)); ?>
