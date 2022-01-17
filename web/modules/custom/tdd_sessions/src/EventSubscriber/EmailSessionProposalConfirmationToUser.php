<?php

declare(strict_types=1);

namespace Drupal\tdd_sessions\EventSubscriber;

use Drupal\Core\Mail\MailManagerInterface;
use Drupal\core_event_dispatcher\Event\Entity\EntityInsertEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\node\NodeInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class EmailSessionProposalConfirmationToUser implements EventSubscriberInterface {

  public const MAIL_KEY = 'session_proposed';

  public function __construct(
    private MailManagerInterface $mailManager,
  ) {}

  public static function getSubscribedEvents(): array {
    return [
      HookEventDispatcherInterface::ENTITY_INSERT => 'sendNotificationEmailToSubmitter',
    ];
  }

  public function sendNotificationEmailToSubmitter(EntityInsertEvent $event): void {
    /** @var NodeInterface */
    $entity = $event->getEntity();

    if ($entity->getEntityTypeId() != 'node') {
      return;
    }

    $speaker = $entity->getOwner();

    if ($emailAddress = $speaker->getEmail()) {
      $this->mailManager->mail('tdd_sessions', self::MAIL_KEY, $emailAddress, $speaker->getPreferredLangcode());
    }
  }

}
