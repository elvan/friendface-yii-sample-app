<?php if (Yii::app()->user->isGuest): ?>
  <h2>Everyone can join <i><?php echo CHtml::encode(Yii::app()->name); ?></i>, sign up now.</h2>
  <?php echo $this->renderPartial('/user/_form', array('user' => $user, 'profile' => $profile)); ?>
<?php else: ?>
  <div>
    <?php echo $this->renderPartial('/post/_create', array('post' => $post, 'returnUrl' => '/')); ?>
  </div>

  <div>
    <?php $this->renderPartial('/post/_feed',array(
      'profile' => $profile,
      'dataProvider' => $dataProvider,
    )); ?>
  </div>

<?php endif; ?>
