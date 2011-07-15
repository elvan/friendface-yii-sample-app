<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo CHtml::encode(Helper::title($this->pageTitle)); ?></title>
    <!-- blueprint CSS framework -->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/form.css" />
    <!-- Internet Explorer HTML5 enabling code: -->
    <!--[if IE]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <style type="text/css">
    .clear {
      zoom: 1;
      display: block;
    }
    </style>
    <![endif]-->
  </head>
  <body>
    <section id="page">
      <header>
        <hgroup>
            <h1><?php echo CHtml::link(CHtml::encode(Yii::app()->name), Yii::app()->baseUrl); ?></h1>
            <h3>Jen's favorite social net site</h3>
        </hgroup>
        <nav class="clear" id="mainmenu">
        <?php $this->widget('zii.widgets.CMenu',array(
          'items'=>array(
            array('label'=>'Home', 'url'=> Yii::app()->baseUrl),
            array('label' => 'Sign In', 'url' => array('/signin'), 'visible'=>Yii::app()->user->isGuest),
            array('label' => 'Profile', 'url'=>array(Helper::profile()), 'visible'=>!Yii::app()->user->isGuest),
            array('label' => 'Sign Out', 'url'=>array('/signout'), 'visible'=>!Yii::app()->user->isGuest)
          ),
        )); ?>
        </nav>
      </header>
      <section id="articles">
        <div class="line"></div>
        <article id="article">
          <div class="articleBody clear">
            <?php echo $content; ?>
          </div>
        </article>
      </section>
      <footer>
         <div class="line"></div>
         <?php echo CHtml::link('Home', Yii::app()->baseUrl); ?>
         <?php echo CHtml::link('About', 'about'); ?>
         <?php echo CHtml::link('Contact', 'contact'); ?>
         <?php echo CHtml::link('Help', 'help'); ?>
         <a href="#" class="up">Go UP</a>
      </footer>
    </section>
  </body>
</html>
