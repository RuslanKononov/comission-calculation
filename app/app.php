<?php

declare(strict_types=1);

$output = shell_exec(sprintf('php bin/console comission:calculate %s', $argv[1]));
echo $output;
