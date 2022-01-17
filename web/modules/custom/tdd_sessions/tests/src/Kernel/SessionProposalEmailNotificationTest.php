<?php

namespace Drupal\Tests\tdd_sessions\Kernel;

use Drupal\Core\Test\AssertMailTrait;
use Drupal\KernelTests\Core\Entity\EntityKernelTestBase;
use Drupal\Tests\node\Traits\NodeCreationTrait;

class SessionProposalEmailNotificationTest extends EntityKernelTestBase {

  use AssertMailTrait;
  use NodeCreationTrait;

  public static $modules = [
    'filter',
    'node',

    'hook_event_dispatcher',
    'core_event_dispatcher',
    'tdd_sessions',
  ];

  public function setUp(): void {
    parent::setUp();

    $this->installConfig(['filter']);
  }

  /** @test */
  public function an_email_should_be_sent_to_the_user_when_they_submit_a_session(): void {
    $this->assertCount(0, $this->getMails());

    $this->createNode(['type' => 'session']);

    $mails = $this->getMails();

    $this->assertCount(1, $mails);

    // TODO: assert that the correct email is sent.
    // TODO: assert that the email is sent to the correct email address.
    // TODO: an email should not be sent if the user does not have an email address.
  }

}
