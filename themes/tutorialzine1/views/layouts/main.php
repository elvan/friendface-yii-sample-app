<!DOCTYPE html> <!-- The new doctype -->
<html>
    <head>
    
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        
		<title><?php echo CHtml::encode($this->pageTitle); ?></title>
        
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" media="screen, projection" />
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
    	
    	<section id="page"> <!-- Defining the #page section with the section tag -->
    
            <header> <!-- Defining the header section of the page with the appropriate tag -->
            
                <hgroup>
                    <h1><?php echo CHtml::encode(Yii::app()->name); ?></h1>
                    <h3>and your slogan</h3>
                </hgroup>
                                
                <nav class="clear" id="mainmenu"> <!-- The nav link semantically marks your main site navigation -->
						<?php $this->widget('zii.widgets.CMenu',array(
							'items'=>array(
								array('label'=>'Home', 'url'=>array('/site/index')),
								array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
								array('label'=>'Contact', 'url'=>array('/site/contact')),
								array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
								array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
							),
						)); ?>

                </nav>
            </header>
            
            <section id="articles"> <!-- A new section with the articles -->
				<!-- Article 1 start -->
                <div class="line"></div>  <!-- Dividing line -->
                <article id="article"> <!-- The new article tag. The id is supplied so it can be scrolled into view. -->
                    <div class="articleBody clear">
						<?php echo $content; ?>
                    </div>
                </article>
				<!-- Article end -->
            </section>

        <footer> <!-- Marking the footer section -->
           <div class="line"></div>
           <p>Copyright 2010 - YourSite.com</p> <!-- Change the copyright notice -->
           <a href="#" class="up">Go UP</a>
           <a href="http://tutorialzine.com/2010/02/html5-css3-website-template/" class="by">Template by Tutorialzine</a>
           
        </footer>
		</section> <!-- Closing the #page section -->
    </body>
</html>
