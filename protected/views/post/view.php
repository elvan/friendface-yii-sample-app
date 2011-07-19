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
