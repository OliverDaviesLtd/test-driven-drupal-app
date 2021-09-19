<?php

namespace Drupal\Tests\example\Functional;

use Drupal\Tests\BrowserTestBase;
use Symfony\Component\HttpFoundation\Response;

final class ExampleTest extends BrowserTestBase {

  public $defaultTheme = 'stark';

  /** @test */
  public function anonymous_users_cannot_access_admin_pages(): void {
    $this->drupalGet('/admin');

    $this->assertSession()->statusCodeEquals(Response::HTTP_FORBIDDEN);
  }

  /** @test */
  public function non_admin_users_cannot_access_admin_pages(): void {
    $this->drupalLogin($this->drupalCreateUser());

    $this->drupalGet('/admin');

    $this->assertSession()->statusCodeEquals(Response::HTTP_FORBIDDEN);
  }

  /** @test */
  public function admin_users_can_access_admin_pages(): void {
    $user = $this->drupalCreateUser(['access administration pages']);
    $this->drupalLogin($user);

    $this->drupalGet('/admin');

    $this->assertSession()->statusCodeEquals(Response::HTTP_OK);
  }

}
