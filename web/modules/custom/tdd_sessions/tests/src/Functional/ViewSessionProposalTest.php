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
    $assert->pageTextContains('My proposed sessions');
    $assert->pageTextContainsOnce('Taking Flight with Tailwind CSS');
  }

  /** @test */
  public function a_user_should_see_only_their_sessions(): void {
    $this->drupalLogin($userA = $this->drupalCreateUser(['create session content']));
    $userB = $this->drupalCreateUser(['create session content']);

    $this->createSession([
      'title' => 'Taking Flight with Tailwind CSS',
      'uid' => $userA,
    ]);

    $this->createSession([
      'title' => 'Deploying PHP applications with Ansible and Ansistrano',
      'uid' => $userB,
    ]);

    $this->drupalGet("user/{$userA->id()}/sessions");

    $assert = $this->assertSession();
    $assert->statusCodeEquals(Response::HTTP_OK);
    $assert->pageTextContainsOnce('Taking Flight with Tailwind CSS');
    $assert->pageTextNotContains('Deploying PHP applications with Ansible and Ansistrano');
  }
}
