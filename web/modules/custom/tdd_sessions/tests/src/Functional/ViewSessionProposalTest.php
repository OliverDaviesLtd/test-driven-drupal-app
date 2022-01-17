<?php

namespace Drupal\Tests\tdd_sessions\Functional;

use Symfony\Component\HttpFoundation\Response;

class ViewSessionProposalTest extends SessionTestBase {

  /** @test */
  public function a_user_should_be_able_to_view_their_proposed_sessions(): void {
    $this->drupalLogin($user = $this->drupalCreateUser(['create session content']));

    $this->createSession([
      'title' => 'Taking Flight with Tailwind CSS',
      'uid' => $user,
    ]);

    $this->drupalGet("user/{$user->id()}/sessions");

    $assert = $this->assertSession();
    $assert->statusCodeEquals(Response::HTTP_OK);
    $assert->pageTextContainsOnce('Taking Flight with Tailwind CSS');
  }

}
