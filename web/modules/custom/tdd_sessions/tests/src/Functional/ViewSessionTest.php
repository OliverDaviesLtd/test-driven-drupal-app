<?php

namespace Drupal\Tests\tdd_sessions\Functional;

use Symfony\Component\HttpFoundation\Response;

final class ViewSessionTest extends SessionTestBase {

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


}
