<?php

namespace Drupal\Tests\tdd_sessions\Kernel;

use Drupal\Core\Test\AssertMailTrait;
use Drupal\KernelTests\Core\Entity\EntityKernelTestBase;
use Drupal\tdd_sessions\EventSubscriber\EmailSessionProposalConfirmationToSpeaker;
use Drupal\tdd_sessions\Factory\SessionFactory;
use Drupal\Tests\node\Traits\NodeCreationTrait;

class SessionProposalEmailNotificationTest extends EntityKernelTestBase {

  use AssertMailTrait;
  use NodeCreationTrait;

  public static $modules = [
    // Core.
    'filter',
    'node',

    // Contrib.
    'hook_event_dispatcher',
    'core_event_dispatcher',

    // Custom.
    'tdd_sessions',
  ];

  public function setUp(): void {
    parent::setUp();

    $this->installConfig(['filter']);
  }

  /** @test */
  public function an_email_should_be_sent_to_the_user_when_they_submit_a_session(): void {
    $this->assertMailCount(expectedCount: 0);

    SessionFactory::create(
      account: $this->createUser(values: ['mail' => 'speaker@example.com']),
      overrides: ['title' => '::title::'],
    )->save();

    $this->assertMailCount(expectedCount: 1);

    /** @var array{ key: string, to: string }[] */
    $mails = $this->getMails();

    $this->assertSame(EmailSessionProposalConfirmationToSpeaker::MAIL_KEY, $mails[0]['key']);
    $this->assertSame('speaker@example.com', $mails[0]['to']);

    // TODO: an email should not be sent if the user does not have an email address.
  }

  private function assertMailCount(int $expectedCount): void {
    $this->assertCount(
      expectedCount: $expectedCount,
      haystack: $this->getMails(),
    );
  }

}
