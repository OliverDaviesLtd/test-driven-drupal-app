<?php

namespace Drupal\Tests\tdd_sessions\Functional;

use Drupal\node\NodeInterface;
use Drupal\Tests\BrowserTestBase;

abstract class SessionTestBase extends BrowserTestBase {

  public $defaultTheme = 'stark';

  public static $modules = [
    // Core.
    'filter',
    'node',
    'path',

    // Contrib.
    'hook_event_dispatcher',
    'preprocess_event_dispatcher',

    // Custom.
    'tdd_sessions',
    'tdd_sessions_test',
  ];

  protected function createSession(array $values = []): NodeInterface {
    $defaults = [
      'type' => 'session',
    ];

    return $this->drupalCreateNode($values + $defaults);
  }

}
