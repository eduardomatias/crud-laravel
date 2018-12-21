<?php $__env->startSection('content'); ?>

<div class="row justify-content-center">
    <div class="col-md-4">
        <form class="form-signin" role="form" method="POST" action="<?php echo e(url('/login')); ?>">
            <?php echo csrf_field(); ?>


            <div class="form-group<?php echo e($errors->has('login') ? ' has-error' : ''); ?>">
                <div class="col-md-12">
                    <label class="control-label">Usuário</label>
                    <input type="login" class="form-control" name="login" value="<?php echo e(old('login')); ?>">
                    <?php if($errors->has('login')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('login')); ?></strong>
                        </span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                <div class="col-md-12">
                    <label class="control-label">Senha</label>
                    <input type="password" class="form-control" name="password">
                    <?php if($errors->has('password')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('password')); ?></strong>
                        </span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-btn fa-sign-in"></i> Entrar
                    </button>
                    <!-- <a class="btn btn-link" href="<?php echo e(url('/password/reset')); ?>">Forgot Your Password?</a> -->
                </div>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>