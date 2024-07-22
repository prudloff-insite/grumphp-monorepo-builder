<?php

namespace GrumphpMonorepoBuilder;

use GrumPHP\Runner\TaskResult;
use GrumPHP\Runner\TaskResultInterface;
use GrumPHP\Task\AbstractExternalTask;
use GrumPHP\Task\Config\ConfigOptionsResolver;
use GrumPHP\Task\Context\ContextInterface;
use GrumPHP\Task\Context\GitPreCommitContext;
use GrumPHP\Task\Context\RunContext;
use Symfony\Component\OptionsResolver\OptionsResolver;
use function count;

class MonorepoBuilder extends AbstractExternalTask {

  /**
   * @return string
   */
  public function getName(): string {
    return 'monorepo_builder';
  }

  /**
   * @param ContextInterface $context
   *
   * @return TaskResultInterface
   */
  public function run(ContextInterface $context): TaskResultInterface {
    $files = $context->getFiles()
      ->names(['composer.json', 'composer.lock']);

    if (0 === count($files)) {
      return TaskResult::createSkipped($this, $context);
    }

    $arguments = $this->processBuilder->createArgumentsForCommand('monorepo-builder');
    $arguments->add('validate');

    $process = $this->processBuilder->buildProcess($arguments);
    $process->run();

    if (!$process->isSuccessful()) {
      $output = $this->formatter->format($process);

      return TaskResult::createFailed($this, $context, $output);
    }

    return TaskResult::createPassed($this, $context);
  }

  /**
   * @return \GrumPHP\Task\Config\ConfigOptionsResolver
   */
  public static function getConfigurableOptions(): ConfigOptionsResolver {
    return ConfigOptionsResolver::fromOptionsResolver(new OptionsResolver());
  }

  /**
   * @param ContextInterface $context
   *
   * @return bool
   */
  public function canRunInContext(ContextInterface $context): bool {
    return $context instanceof GitPreCommitContext || $context instanceof RunContext;
  }
}