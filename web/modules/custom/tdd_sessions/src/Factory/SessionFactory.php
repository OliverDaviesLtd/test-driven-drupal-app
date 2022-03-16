<?php

namespace Drupal\tdd_sessions\Factory;

use Drupal\Core\Session\AccountInterface;
use Drupal\node\Entity\Node;
use Drupal\node\NodeInterface;

final class SessionFactory {

  private const NODE_TYPE = 'session';

  public static function create(
    AccountInterface $user,
    array $overrides = [],
  ): NodeInterface {
    $values = array_merge([
      'type' => self::NODE_TYPE,
      'uid' => $user,
    ], $overrides);

    return Node::create(values: $values);
  }

}
