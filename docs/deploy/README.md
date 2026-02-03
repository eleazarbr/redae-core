## Deploys with Deployer

This project ships with a generic `deploy.php` that works locally and can be reused for multiple remote instances. Keep instance-specific hosts and secrets out of Git by using the `.deploy/` directory (already in `.gitignore`).

### Local deploy (SQLite)
- Uses the local git repo (`file://.../.git`) and deploys to `deploys/{{application}}` beside the repo by default. Override with `DEPLOY_PATH`.
- Deployer sets `APP_ENV=local` and `DB_CONNECTION=sqlite` pointing to `{{deploy_path}}/shared/database/database.sqlite`. The file is created automatically.
- Composer/PHP binaries can be overridden with `DEPLOY_COMPOSER` and `DEPLOY_PHP`; otherwise it falls back to what is on your PATH.
- Command example: `vendor/bin/dep deploy local`.

### Remote deploys (per project)
1) Copy `deploy.example.php` to `.deploy/project-a.php` (or any name) and edit the host(s):
   ```php
   <?php
   declare(strict_types=1);
   namespace Deployer;
   require __DIR__.'/../deploy.php';

   host('project-a')
       ->setHostname('your.server.com')
       ->setRemoteUser('forge')
       ->set('deploy_path', '/var/www/project-a')
       ->set('branch', 'main');
   ```
2) Run from your machine: `vendor/bin/dep deploy project-a -f .deploy/project-a.php`.
3) Repeat with another file (e.g., `.deploy/project-b.php`) for other instances.

### Environment variables
- `DEPLOY_PATH`: override the default deploy path.
- `DEPLOY_PHP`: absolute path to the PHP binary to use during deploy.
- `DEPLOY_COMPOSER`: absolute path to the Composer binary to use during deploy.

### What is ignored
- `.deploy/` is ignored in Git for host definitions and secrets.
- The shared `.env` is uploaded on first deploy if missing; keep your real values out of the repo.

### CI/CD (optional)
If you prefer remote-triggered deploys, create manual (`workflow_dispatch`) workflows per project that call `dep deploy …` with secrets stored in GitHub Actions environments. Keep triggers manual or tag-based to avoid auto-deploying on every push.
