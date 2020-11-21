<?php
// namespace Deployer;

// require 'recipe/laravel.php';

// // Project name
// set('application', 'my_project');

// // Project repository
// set('repository', 'git@github.com:randhipp/checklist-laravel.git');

// // [Optional] Allocate tty for git clone. Default value is false.
// set('git_tty', true);

// // Shared files/dirs between deploys
// add('shared_files', []);
// add('shared_dirs', []);

// // Writable dirs by web server
// add('writable_dirs', []);


// // Hosts

// host('project.com')
//     ->set('deploy_path', '~/{{application}}');

// // Tasks

// task('build', function () {
//     run('cd {{release_path}} && build');
// });

// // [Optional] if deploy fails automatically unlock.
// after('deploy:failed', 'deploy:unlock');

// // Migrate database before symlink new release.

// before('deploy:symlink', 'artisan:migrate');

namespace Deployer;

// Include the Laravel & rsync recipes
require 'recipe/laravel.php';
require 'recipe/rsync.php';

set('application', 'laravel-checklist');
set('ssh_multiplexing', true); // Speed up deployment

set('rsync_src', function () {
    return __DIR__; // If your project isn't in the root, you'll need to change this.
});

// Configuring the rsync exclusions.
// You'll want to exclude anything that you don't want on the production server.
add('rsync', [
    'exclude' => [
        '.git',
        '/.env',
        '/storage/',
        '/vendor/',
        '/node_modules/',
        '.github',
        'deploy.php',
    ],
]);

// Set up a deployer task to copy secrets to the server.
// Grabs the dotenv file from the github secret
task('deploy:secrets', function () {
    file_put_contents(__DIR__ . '/.env', getenv('DOT_ENV'));
    upload('.env', get('deploy_path') . '/shared');
});

host('production.app.com') // Name of the server
    ->hostname('34.101.203.145') // Hostname or IP address
    ->stage('production') // Deployment stage (production, staging, etc)
    ->user('deployer') // SSH user
    ->set('deploy_path', '/var/www/checklists');

    after('deploy:failed', 'deploy:unlock'); // Unlock after failed deploy

    desc('Deploy the application');
    task('deploy', [
        'deploy:info',
        'deploy:prepare',
        'deploy:lock',
        'deploy:release',
        'rsync', // Deploy code & built assets
        'deploy:secrets', // Deploy secrets
        'deploy:shared',
        'deploy:vendors',
        'deploy:writable',
        'artisan:storage:link', // |
        'artisan:view:cache',   // |
        'artisan:config:cache', // | Laravel specific steps
        'artisan:optimize',     // |
        'artisan:migrate:fresh',// |
        'artisan:db:seed',// |
        'deploy:symlink',
        'deploy:unlock',
        'cleanup',
    ]);
