<?php

use Symplify\MonorepoBuilder\Config\MBConfig;

return static function (MBConfig $mbConfig): void {
  // Fake subproject to test the grumphp task.
  $mbConfig->packageDirectories([__DIR__ . '/test/']);
};
