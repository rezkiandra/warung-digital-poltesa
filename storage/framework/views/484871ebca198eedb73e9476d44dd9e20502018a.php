

<?php $__env->startSection('title', 'Detail Level'); ?>

<?php $__env->startSection('content'); ?>
  <div class="card mb-4 col-lg-6">
    <div class="card-body">
      <a href="<?php echo e(route('admin.levels')); ?>">
        <i class="tf-icons mdi mdi-arrow-left me-2 fs-4"></i>
      </a>
      <div class="d-flex justify-content-between flex-wrap my-2 py-3">
        <div class="d-flex align-items-center me-4 mt-3 gap-3">
          <div class="avatar">
            <?php if($level->level_name == 'Admin'): ?>
              <div class="avatar-initial bg-label-danger rounded">
                <i class="mdi mdi-laptop mdi-24px"></i>
              </div>
            <?php elseif($level->level_name == 'Seller'): ?>
              <div class="avatar-initial bg-label-info rounded">
                <i class="mdi mdi-store-outline mdi-24px"></i>
              </div>
            <?php elseif($level->level_name == 'Customer'): ?>
              <div class="avatar-initial bg-label-warning rounded">
                <i class="mdi mdi-account-outline mdi-24px"></i>
              </div>
            <?php elseif($level->level_name == 'Super Admin'): ?>
              <div class="avatar-initial bg-label-primary rounded">
                <i class="mdi mdi-shield-crown-outline mdi-24px"></i>
              </div>
            <?php elseif($level->level_name == 'Maintainer'): ?>
              <div class="avatar-initial bg-label-success rounded">
                <i class="mdi mdi-bug-check-outline mdi-24px"></i>
              </div>
            <?php elseif($level->level_name == 'Developer'): ?>
              <div class="avatar-initial bg-label-dark rounded">
                <i class="mdi mdi-code-block-tags mdi-24px"></i>
              </div>
            <?php else: ?>
              <div class="avatar-initial bg-label-secondary rounded">
                <i class="mdi mdi-chart-donut mdi-24px"></i>
              </div>
            <?php endif; ?>
          </div>
          <div>
            <h4 class="mb-0"><?php echo e($level->level_name); ?></h4>
            <span>Level name</span>
          </div>
        </div>
        <div class="d-flex align-items-center me-4 mt-3 gap-3">
          <div class="avatar">
            <div class="avatar-initial bg-label-warning rounded">
              <i class="mdi mdi-account-group-outline mdi-24px"></i>
            </div>
          </div>
          <div>
            <h4 class="mb-0"><?php echo e($level_user_count); ?></h4>
            <span>Total users</span>
          </div>
        </div>
      </div>
      <h5 class="pb-3 border-bottom mb-3">Level Details</h5>
      <div class="info-container">
        <ul class="list-unstyled mb-4">
          <li class="mb-3 h5">
            <span>ID:</span>
            <span>#<?php echo e($level->id); ?></span>
          </li>
          <li class="mb-3">
            <span class="h6">Created At:</span>
            <span
              class="badge bg-label-success rounded-pill"><?php echo e(date('d F Y, H:i:s', strtotime($level->created_at))); ?></span>
          </li>
          <li class="mb-3">
            <span class="h6">Updated At:</span>
            <span
              class="badge bg-label-info rounded-pill"><?php echo e(date('d F Y, H:i:s', strtotime($level->updated_at))); ?></span>
          </li>
        </ul>
        <div class="d-flex justify-content-center align-items-center gap-3 mt-5">
          <?php if (isset($component)) { $__componentOriginal884241e53d2640b5f4918f6ac6f391c8aaea60a8 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\BasicButton::class, ['label' => 'Edit','icon' => 'pencil-outline','href' => route('admin.edit.level', $level->slug),'variant' => 'primary']); ?>
<?php $component->withName('basic-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal884241e53d2640b5f4918f6ac6f391c8aaea60a8)): ?>
<?php $component = $__componentOriginal884241e53d2640b5f4918f6ac6f391c8aaea60a8; ?>
<?php unset($__componentOriginal884241e53d2640b5f4918f6ac6f391c8aaea60a8); ?>
<?php endif; ?>
          <form action="<?php echo e(route('admin.destroy.level', $level->slug)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button type="submit" class="btn btn-outline-danger">
              <i class="mdi mdi-trash-can-outline text-danger me-2"></i>Delete
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.authenticated', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\warungdigital\resources\views/admin/levels/detail.blade.php ENDPATH**/ ?>