<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <title><?php echo e(config('app.name')); ?></title>
        <link rel="stylesheet" href="<?php echo e(url('/css/app.css?v=1')); ?>">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
        
        <?php echo $__env->yieldContent('head'); ?>
    </head>
    <body class="d-flex flex-column">
        <?php echo $__env->make('layouts.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <section class="container-fluid flex-grow">
            <div id="app" class="container py-3 conteudo">
                <div class="row">
                    <div class="col-sm-12">
                        <?php echo $__env->yieldContent('content'); ?>
                    </div>
                </div>
                <div id='loading' class="loader loader-default"></div>
            </div>
        </section>
		<div class="row justify-content-center mt-5">
			<div class="col-sm-8">
				<?php echo $__env->make('layouts.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
			</div>
		</div>
    </body>
</html>
