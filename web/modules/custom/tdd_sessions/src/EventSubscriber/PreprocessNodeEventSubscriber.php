<?php

declare(strict_types=1);

namespace Drupal\tdd_sessions\EventSubscriber;

use Drupal\node\NodeInterface;
use Drupal\preprocess_event_dispatcher\Event\NodePreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\PreprocessEventInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class PreprocessNodeEventSubscriber implements EventSubscriberInterface {

  public static function getSubscribedEvents(): array {
    return [
      NodePreprocessEvent::name('session') => 'preprocessSession',
    ];
  }

  public function preprocessSession(NodePreprocessEvent $event): void {
    $variables = $event->getVariables();
    $content = $variables->get('content');

    $this->addSpeakerName($event, $content);

    $variables->set('content', $content);
  }

  private function addSpeakerName(PreprocessEventInterface $event, array &$content): void {
    /** @var NodeInterface $session */
    $session = $event->getVariables()->getNode();

    $content['speaker']['#markup'] = $session->getOwner()->label();
  }

}
