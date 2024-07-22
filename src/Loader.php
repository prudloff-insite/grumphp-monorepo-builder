<?php

namespace GrumphpMonorepoBuilder;

use GrumPHP\Extension\ExtensionInterface;

class Loader implements ExtensionInterface {

  /**
   * @return iterable
   */
  public function imports(): iterable {
    return [
      __DIR__ . '/../monorepo_builder.yml',
    ];
  }
}