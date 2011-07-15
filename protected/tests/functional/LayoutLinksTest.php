<?php

class LayoutLinksTest extends WebTestCase {
  public $title = 'Friendface - ';

  public function testHome() {
    $this->open('');
    $this->assertEquals($this->title . 'Home', $this->getTitle());
  }

  public function testSignin() {
    $this->open('signin');
    $this->assertEquals($this->title . 'Sign In', $this->getTitle());
  }

  public function testAbout() {
    $this->open('about');
    $this->assertEquals($this->title . 'About', $this->getTitle());
  }

  public function testContact() {
    $this->open('contact');
    $this->assertEquals($this->title . 'Contact', $this->getTitle());
  }

  public function testHelp() {
    $this->open('help');
    $this->assertEquals($this->title . 'Help', $this->getTitle());
  }

  public function testLinks() {
    $this->open('');

    $this->assertElementPresent('link=Sign In');
    $this->clickAndWait('link=Sign In');
    $this->assertEquals($this->title . 'Sign In', $this->getTitle());

    $this->assertElementPresent('link=About');
    $this->clickAndWait('link=About');
    $this->assertEquals($this->title . 'About', $this->getTitle());

    $this->assertElementPresent('link=Contact');
    $this->clickAndWait('link=Contact');
    $this->assertEquals($this->title . 'Contact', $this->getTitle());

    $this->assertElementPresent('link=Help');
    $this->clickAndWait('link=Help');
    $this->assertEquals($this->title . 'Help', $this->getTitle());

    $this->assertElementPresent('link=Home');
    $this->clickAndWait('link=Home');
    $this->assertEquals($this->title . 'Home', $this->getTitle());
  }
}
