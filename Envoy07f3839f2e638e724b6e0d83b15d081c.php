<?php $__container->servers('web' => ['root@localhost -p 2222']); ?>

<?php $__container->startTask('restart-queues', ['on' => 'web']); ?>
    cd /home/user/example.com
    php artisan queue:restart
<?php $__container->endTask(); ?>