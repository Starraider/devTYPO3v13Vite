<?php
namespace Deployer;

require 'recipe/typo3.php';

// Config
// ssh-copy-id -f -i ~/.ssh/id_rsa.pub photogra1@167.235.201.149

set('repository', 'git@github.com:Starraider/devTYPO3v13Vite.git');

/**
 * DocumentRoot / WebRoot for the TYPO3 installation
 */
set('typo3_webroot', 'public');
set('web_path', 'public');
set('public_path', 'public');
set('deploy_path', '~/public_html/typo3');
set('keep_releases', '4');
set('http_user', 'leseohre2');

add('shared_files', [
    '.env'
]);
add('shared_dirs', []);
add('writable_dirs', []);

//->set('remote_user', 'deployer')
// Hosts

host('live')
    ->set('hostname', '167.235.201.149')
    ->set('remote_user', 'leseohre2')
    ->set('branch', 'main')
    ->set('public_urls', ['https://leseohrendb.staging.skom-server.de']);

host('local')
    ->set('hostname', 'local')
    ->set('deploy_path', getcwd())
    ->set('public_urls', ['https://devvitetypo3.ddev.site']);

// Hooks

after('deploy:failed', 'deploy:unlock');
