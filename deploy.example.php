<?php

declare(strict_types=1);

namespace Deployer;

require __DIR__.'/deploy.php'; // NOSONAR.

host('project-a')
    ->setHostname('example.com')
    ->setRemoteUser('forge')
    ->set('deploy_path', '/var/www/project-a')
    ->set('branch', 'main');

host('project-b')
    ->setHostname('example.org')
    ->setRemoteUser('forge')
    ->set('deploy_path', '/var/www/project-b')
    ->set('branch', 'main');
