<?php

namespace Drupal\Tests\tdd_sessions\Functional;

use Drupal\Tests\BrowserTestBase;
use Drupal\node\NodeInterface;
use Symfony\Component\HttpFoundation\Response;

final class ViewSessionTest extends BrowserTestBase {

  public $defaultTheme = 'stark';

  public static $modules = [
    'filter',
    'node',
    'path',
    'tdd_sessions',
  ];

  /** @test */
  public function a_session_page_can_be_viewed(): void {
    $this->createSession([
      'path' => '/sessions/test-driven-drupal',
      'title' => 'Test Driven Drupal',
    ]);

    $this->drupalGet('/sessions/test-driven-drupal');

    $assert = $this->assertSession();
    $assert->statusCodeEquals(Response::HTTP_OK);
    $assert->pageTextContains('Test Driven Drupal');
  }

  private function createSession(array $values = []): NodeInterface {
    $defaults = [
      'type' => 'session',
    ];

    return $this->drupalCreateNode($values + $defaults);
  }

}
