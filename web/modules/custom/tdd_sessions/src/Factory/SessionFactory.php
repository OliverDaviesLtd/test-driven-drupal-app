<?php

namespace Drupal\tdd_sessions\Factory;

use Drupal\node\Entity\Node;
use Drupal\node\NodeInterface;
use Drupal\user\UserInterface;

final class SessionFactory {

  private const NODE_TYPE = 'session';

  public static function create(
    UserInterface $account,
    array $overrides = [],
  ): NodeInterface {
    $values = array_merge(self::defaultValues(), $overrides);

    $session = Node::create(values: $values);
    $session->setOwner(account: $account);

    return $session;
  }

  private static function defaultValues(): array {
    return [
      'type' => self::NODE_TYPE,
    ];
  }

}
