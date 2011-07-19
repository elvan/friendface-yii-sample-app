<div class="comment">
  <?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'/comment/_view',
    'template'=>"{items}\n{pager}",
  )); ?>
</div>
