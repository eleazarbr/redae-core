<?php

declare(strict_types=1);

namespace Deployer;

require 'vendor/autoload.php'; // NOSONAR: matches Deployer bootstrap; file runs once per process so require_once is unnecessary.
require 'recipe/laravel.php'; // NOSONAR: same rationale as above.

set('application', 'redae-core');
set('repository', sprintf('file://%s/.git', __DIR__));
set('branch', static fn (): string => runLocally('git rev-parse --abbrev-ref HEAD'));
set('keep_releases', 3);
set('allow_anonymous_stats', false);
set('composer_action', 'install');
set('composer_options', '--verbose --prefer-dist --no-progress --no-interaction --optimize-autoloader');
set('env', static fn (): array => [
    'APP_ENV' => 'local',
    'DB_CONNECTION' => 'sqlite',
    'DB_DATABASE' => get('deploy_path').'/shared/database/database.sqlite',
]);

$homeDir = rtrim(getenv('HOME') ?: ($_SERVER['HOME'] ?? ''), '/');
$projectBase = dirname(realpath(__DIR__));
$defaultDeployPath = $projectBase.'/deploys/{{application}}';

if (! is_dir($projectBase)) {
    $defaultDeployPath = $homeDir !== '' ? $homeDir.'/deploys/{{application}}' : '/tmp/deploys/{{application}}';
}

$deployPath = getenv('DEPLOY_PATH') ?: $defaultDeployPath;

localhost('local')->set('deploy_path', $deployPath);

$phpBinary = getenv('DEPLOY_PHP') ?: 'php';
$composerBinary = getenv('DEPLOY_COMPOSER') ?: trim((string) shell_exec('command -v composer'));

if ($composerBinary === '') {
    $composerBinary = 'composer';
}

set('bin/php', escapeshellarg($phpBinary));
set('bin/composer', '{{bin/php}} '.escapeshellarg($composerBinary));

task('deploy:shared_env', static function (): void {
    if (! test('[ -f {{deploy_path}}/shared/.env ]')) {
        upload(__DIR__.'/.env', '{{deploy_path}}/shared/.env');
    }
});

task('deploy:prepare_sqlite', static function (): void {
    run('mkdir -p {{deploy_path}}/shared/database');
    run('test -f {{deploy_path}}/shared/database/database.sqlite || touch {{deploy_path}}/shared/database/database.sqlite');
});

before('deploy:shared', 'deploy:shared_env');
before('artisan:migrate', 'deploy:prepare_sqlite');
