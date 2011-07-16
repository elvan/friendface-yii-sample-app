<?php

/**
 * Change the following URL based on your server configuration
 * Make sure the URL ends with a slash so that we can use relative URLs in test cases
 */
define('TEST_BASE_URL','http://localhost/friendface/index-test.php/');

/**
 * The base class for functional test cases.
 * In this class, we set the base URL for the test application.
 * We also provide some common methods to be used by concrete test classes.
 */
class WebTestCase extends CWebTestCase {
  public $title = 'Friendface - ';

  /**
   * Sets up before each test method runs.
   * This mainly sets the base URL for the test application.
   */
  protected function setUp() {
    parent::setUp();
    $this->setBrowserUrl(TEST_BASE_URL);
  }

  public function signinUser() {
    $this->open('');
    $this->clickAndWait('link=Sign In');
    $this->assertEquals('Friendface - Sign In', $this->getTitle());
    $this->assertElementPresent('name=LoginForm[email]');
    $this->assertElementPresent('name=LoginForm[password]');
    $this->assertElementPresent('css=input[value=Sign In]');
    $this->type('name=LoginForm[email]', 'test1@notanaddress.com');
    $this->type('name=LoginForm[password]', 'test_1');
    $this->clickAndWait('css=input[value=Sign In]');
    $this->assertEquals('Friendface - Home', $this->getTitle());
    $this->assertElementPresent('link=Sign Out');
  }
}
