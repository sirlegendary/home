<?php
namespace Deployer;

require 'recipe/laravel.php';

// Configuration

set('repository', 'git@github.com:sirlegendary/home.git');
set('git_tty', true); // [Optional] Allocate tty for git on first deployment
add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);


// Hosts

host('home.walesalami.com')
//    ->stage('production')
    ->set('deploy_path', '/home/wale/');
    
//host('beta.project.com')
//    ->stage('beta')
//    ->set('deploy_path', '/var/www/project.com');  


// Tasks

desc('Restart PHP-FPM service');
task('php-fpm:restart', function () {
    // The user must have rights for restart service
    // /etc/sudoers: username ALL=NOPASSWD:/bin/systemctl restart php-fpm.service
    run('sudo systemctl restart php-fpm.service');
});
after('deploy:symlink', 'php-fpm:restart');

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'artisan:migrate');
