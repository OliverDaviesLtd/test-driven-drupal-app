<?php

namespace Drupal\Tests\tdd_sessions\Functional;

use Drupal\node\Entity\Node;
use Drupal\node\NodeInterface;

final class SubmitSessionProposalTest extends SessionTestBase {

  /** @test */
  public function a_potential_speaker_can_submit_a_session_proposal(): void {
    // Arrange.
    $speaker = $this->createUser(['create session content']);

    $this->drupalLogin($speaker);

    // Act.
    $this->assertNull(Node::load(1));

    $edit = [
      'body[0][value]' => 'A session on automated testing and test-driven development in Drupal.',
      'title[0][value]' => 'Test Driven Drupal',
    ];

    $this->drupalPostForm('/node/add/session', $edit, 'Save');

    // Assert.
    $session = Node::load(1);

    $this->assertNotNull($session);
    $this->assertInstanceOf(NodeInterface::class, $session);

    $this->assertSame(
      'Test Driven Drupal',
      $session->label(),
    );

    $this->assertSame(
      'A session on automated testing and test-driven development in Drupal.',
      $session->get('body')->getValue()[0]['value'],
    );

    $this->assertSame($speaker->id(), $session->getOwnerId());
  }

}
