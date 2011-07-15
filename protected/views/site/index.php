<?php if (Yii::app()->user->isGuest): ?>
  <h1>Everyone can join <i><?php echo CHtml::encode(Yii::app()->name); ?></i>, sign up now.</h1>
  <?php echo $this->renderPartial('/user/_form', array('user' => $user, 'profile' => $profile)); ?>
<?php else: ?>
  Welcome back to your home page.
<?php endif; ?>
