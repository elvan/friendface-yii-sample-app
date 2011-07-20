<?php $this->beginContent('//layouts/main'); ?>
<div class="span-18">
  <div class="article">
    <?php echo $content; ?>
  </div>
</div>
<div class="span-6 last">
  <div id="sidebar">
  <div>
    Dashboard for Home
  </div>
  <?php
    $this->beginWidget('zii.widgets.CPortlet');
    $this->widget('zii.widgets.CMenu', array(
      'items'=>$this->menu,
      'htmlOptions'=>array('class'=>'operations'),
    ));
    $this->endWidget();
  ?>
  </div>
</div>
<?php $this->endContent(); ?>
