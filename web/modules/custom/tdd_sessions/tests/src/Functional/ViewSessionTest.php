<?php

namespace Drupal\Tests\tdd_sessions\Functional;

use Drupal\Tests\BrowserTestBase;
use Drupal\node\NodeInterface;
use Symfony\Component\HttpFoundation\Response;

final class ViewSessionTest extends BrowserTestBase {

  public $defaultTheme = 'stark';

  public static $modules = [
    // Core.
    'filter',
    'node',
    'path',

    // Contrib.
    'hook_event_dispatcher',
    'preprocess_event_dispatcher',

    // Custom.
    'tdd_sessions',
    'tdd_sessions_test',
  ];

  /** @test */
  public function a_session_page_can_be_viewed(): void {
    // Arrange.
    $speaker = $this->drupalCreateUser([], 'Oliver Davies');

    $this->createSession([
      'path' => '/sessions/test-driven-drupal',
      'title' => 'Test Driven Drupal',
      'uid' => $speaker->id(),
    ]);

    // Act.
    $this->drupalGet('/sessions/test-driven-drupal');

    // Assert.
    $assert = $this->assertSession();
    $assert->statusCodeEquals(Response::HTTP_OK);
    $assert->pageTextContains('Test Driven Drupal');
    $assert->pageTextContains('Oliver Davies');
  }

  /** @test */
  public function speaker_names_are_only_added_to_sessions(): void {
    // Arrange.
    $speaker = $this->drupalCreateUser([], 'Oliver Davies');

    $this->drupalCreateNode([
      'type' => 'page',
      'uid' => $speaker->id(),
    ]);

    // Act.
    $this->drupalGet('/node/1');

    // Assert.
    $assert = $this->assertSession();
    $assert->statusCodeEquals(Response::HTTP_OK);
    $assert->pageTextNotContains('Oliver Davies');
  }


  private function createSession(array $values = []): NodeInterface {
    $defaults = [
      'type' => 'session',
    ];

    return $this->drupalCreateNode($values + $defaults);
  }

}
