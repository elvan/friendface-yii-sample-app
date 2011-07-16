<?php

class SiteTest extends WebTestCase {
  public function testContactInvalid() {
    $this->open('contact');
    $this->assertElementPresent('name=ContactForm[name]');
    $this->assertElementPresent('name=ContactForm[email]');
    $this->assertElementPresent('name=ContactForm[subject]');
    $this->assertElementPresent('name=ContactForm[body]');
    $this->assertElementPresent('name=ContactForm[verifyCode]');
    $this->type('name=ContactForm[name]','');
    $this->type('name=ContactForm[email]','');
    $this->type('name=ContactForm[subject]','');
    $this->type('name=ContactForm[body]','');
    $this->type('name=ContactForm[verifyCode]','');
    $this->clickAndWait("//input[@value='Submit']");
    $this->assertTextPresent('Name cannot be blank.');
    $this->assertTextPresent('Email cannot be blank.');
    $this->assertTextPresent('Subject cannot be blank.');
    $this->assertTextPresent('Body cannot be blank.');
    $this->assertTextPresent('The verification code is incorrect.');
  }

  public function testInvalidSignin() {
    // should re-render the signin page and have the right title
    $this->open('');
    // ensure the user is logged out
    if ($this->isTextPresent('Sign Out')) {
      $this->assertElementPresent('link=Sign Out');
      $this->clickAndWait('link=Sign Out');
    }
    $this->clickAndWait('link=Sign In');
    $this->assertEquals('Friendface - Sign In', $this->getTitle());
    $this->assertElementPresent('name=LoginForm[email]');
    $this->assertElementPresent('name=LoginForm[password]');
    $this->assertElementPresent('css=input[value=Sign In]');

    $this->type('name=LoginForm[email]', '');
    $this->type('name=LoginForm[password]', '');
    $this->clickAndWait('css=input[value=Sign In]');
    $this->assertTextPresent('Email cannot be blank.');
    $this->assertTextPresent('Password cannot be blank.');

    $this->type('name=LoginForm[email]', 'user@wrong.com');
    $this->type('name=LoginForm[password]', 'invalid');
    $this->clickAndWait('css=input[value=Sign In]');
    $this->assertTextPresent('Incorrect email.');

    $this->type('name=LoginForm[email]', 'test1@notanaddress.com');
    $this->type('name=LoginForm[password]', 'invalid');
    $this->clickAndWait('css=input[value=Sign In]');
    $this->assertTextPresent('Incorrect password.');
  }

  public function testValidSignin() {
    $this->open('');
    // ensure the user is logged out
    if($this->isTextPresent('Sign Out')) {
      $this->assertElementPresent('link=Sign Out');
      $this->clickAndWait('link=Sign Out');
    }
    // test login process, including validation
    $this->clickAndWait('link=Sign In');
    $this->assertEquals('Friendface - Sign In', $this->getTitle());
    $this->assertElementPresent('name=LoginForm[email]');
    $this->assertElementPresent('name=LoginForm[password]');
    $this->assertElementPresent('css=input[value=Sign In]');
    $this->type('name=LoginForm[email]', 'test1@notanaddress.com');
    $this->type('name=LoginForm[password]', 'test_1');
    $this->clickAndWait('css=input[value=Sign In]');

    // shouldn't have flash message
    $this->assertTextNotPresent('Email cannot be blank.');
    $this->assertTextNotPresent('Password cannot be blank.');

    // should sign a user out
    $this->assertTextNotPresent('Sign In');
    $this->assertElementPresent('link=Sign Out');
    $this->clickAndWait('link=Sign Out');
    $this->assertTextPresent('Sign In');
    $this->assertEquals('Friendface - Home', $this->getTitle());
  }

  public function testFriendlyForwardings() {
    $this->open('');
    $this->assertElementPresent('link=Sign In');
    $this->clickAndWait('link=Sign In');
    $this->type('name=LoginForm[email]', 'test1@notanaddress.com');
    $this->type('name=LoginForm[password]', 'test_1');
    $this->clickAndWait('css=input[value=Sign In]');
    $this->assertElementPresent('link=Sign Out');
    $this->clickAndWait('link=Sign Out');

    // the test automatically follows the redirect to the signin page
    $this->open('profile/edit');
    $this->assertStringEndsWith('friendface/signin', $this->getLocation());

    $this->open('');
    $this->assertElementPresent('link=Sign In');
    $this->clickAndWait('link=Sign In');
    $this->type('name=LoginForm[email]', 'test1@notanaddress.com');
    $this->type('name=LoginForm[password]', 'test_1');
    $this->clickAndWait('css=input[value=Sign In]');

    // the test follows the redirect again, this time to user/update/[id]
    $this->assertStringEndsWith('profile/edit', $this->getLocation());
  }
}
