<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&ampdisplay=swap"
      rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('materio/assets/img/favicon/favicon.ico')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('materio/assets/vendor/fonts/materialdesignicons.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('materio/assets/vendor/css/core.css')); ?>"
      class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?php echo e(asset('materio/assets/css/demo.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('materio/assets/vendor/css/theme-default.css')); ?>"
      class="template-customizer-theme-css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <title><?php echo $__env->yieldContent('title'); ?> - Warung Digital</title>
    <?php echo $__env->yieldPushContent('styles'); ?>
    <style>
      * {
        font-family: Poppins;
      }

      body {
        background: #F4F5FA;
        scroll-behavior: smooth;
      }
    </style>
  </head>

  <body>
    <?php echo $__env->make('sweetalert::alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->make('components.navbar-guest', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldContent('content'); ?>
    <?php echo $__env->make('components.footer-guest', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <script src="<?php echo e(asset('materio/assets/vendor/libs/jquery/jquery.js')); ?>"></script>
    <script src="<?php echo e(asset('materio/assets/vendor/js/bootstrap.js')); ?>"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    
    
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
    <script>
      AOS.init();
    </script>
  </body>

</html>
<?php /**PATH C:\Users\USER\Desktop\warungdigital\resources\views/layouts/guest.blade.php ENDPATH**/ ?>