<div class="card">
  <h5 class="card-header"><?php echo e($title); ?></h5>
  <div class="table-responsive text-nowrap">
    <table class="table table-hover">
      <thead>
        <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <th><?php echo e($field); ?></th>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </thead>
      <tbody>
        <?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <tr>
            <td><?php echo e($loop->iteration); ?></td>
            <td>
              <span class="text-dark"><?php echo e($data->nik_nim); ?></span>
            </td>
            <td class="sorting_1">
              <div class="d-flex justify-content-start align-items-center product-name">
                <div class="avatar-wrapper me-3">
                  <div class="avatar rounded-2 bg-label-secondary">
                    <img src="<?php echo e(asset('storage/' . $data->image)); ?>" class="rounded-2">
                  </div>
                </div>
                <div class="d-flex flex-column">
                  <span class="text-nowrap text-heading fw-medium text-capitalize"><?php echo e($data->full_name); ?></span>
                  <small class="text-truncate">
                    <span class="fw-medium"><?php echo e($data->user->email); ?></span>
                  </small>
                </div>
              </div>
            </td>
            <td class="sorting_1">
              <div class="d-flex justify-content-start align-items-center product-name">
                <div class="d-flex flex-column">
                  <span class="text-nowrap text-heading fw-medium text-capitalize">
                    <?php if($data->gender == 'laki-laki'): ?>
                      <i class="mdi mdi-gender-male text-info"></i>
                    <?php elseif($data->gender == 'perempuan'): ?>
                      <i class="mdi mdi-gender-female text-danger"></i>
                    <?php endif; ?>
                    <?php echo e($data->gender); ?>

                  </span>
                  <small class="text-truncate">
                    <span class="fw-medium text-capitalize">
                      <?php echo e(Str::limit($data->address, 40)); ?>

                    </span>
                  </small>
                </div>
              </div>
            </td>
            <td class="sorting_1">
              <div class="d-flex justify-content-start align-items-center product-name">
                <div class="d-flex flex-column">
                  <span class="text-nowrap text-heading fw-medium text-capitalize">
                    <?php if($data->status == 'active'): ?>
                      <i class="mdi mdi-account-check-outline text-success mdi-20px"></i>
                    <?php elseif($data->status == 'pending'): ?>
                      <i class="mdi mdi-account-search-outline text-warning mdi-20px"></i>
                    <?php else: ?>
                      <i class="mdi mdi-account-off-outline text-danger mdi-20px"></i>
                    <?php endif; ?>
                    <?php echo e($data->status); ?>

                  </span>
                  <small class="text-truncate d-none d-sm-block">
                    <span class="fw-medium"><?php echo e($data->phone_number); ?></span>
                  </small>
                </div>
              </div>
            </td>
            <td class="sorting_1">
              <div class="d-flex justify-content-start align-items-center product-name">
                <div class="d-flex flex-column">
                  <span
                    class="text-nowrap text-heading fw-medium text-capitalize"><?php echo e(\App\Models\Seller::join('bank_accounts', 'bank_accounts.id', '=', 'sellers.bank_account_id', 'left')->where('sellers.id', $data->id)->first()->bank_name); ?></span>
                  <small class="text-truncate d-none d-sm-block">
                    <span class="fw-medium"><?php echo e($data->account_number ?? '-'); ?></span>
                  </small>
                </div>
              </div>
            </td>
            <td>
              <span class="fw-medium badge rounded bg-label-info"><?php echo e(date('d M Y, H:i:s', strtotime($data->created_at))); ?>

                <?php echo e($data->created_at->format('H:i') > '12:00' ? 'PM' : 'AM'); ?>

              </span>
            </td>
            <td>
              <div class="d-flex align-items-center">
                <a class="me-2" href="<?php echo e(route('admin.edit.seller', $data->uuid)); ?>">
                  <i class="mdi mdi-pencil-outline text-secondary"></i>
                </a>
                <div class="dropdown">
                  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="mdi mdi-dots-vertical"></i>
                  </button>
                  <div class="dropdown-menu">
                    <?php if (isset($component)) { $__componentOriginal449bfa6e40fc6b9502e7641b2b70c69491540e98 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DropdownItem::class, ['label' => 'Detail','variant' => 'secondary','icon' => 'eye-outline','route' => route('admin.detail.seller', $data->slug)]); ?>
<?php $component->withName('dropdown-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal449bfa6e40fc6b9502e7641b2b70c69491540e98)): ?>
<?php $component = $__componentOriginal449bfa6e40fc6b9502e7641b2b70c69491540e98; ?>
<?php unset($__componentOriginal449bfa6e40fc6b9502e7641b2b70c69491540e98); ?>
<?php endif; ?>
                    <form action="<?php echo e(route('admin.destroy.seller', $data->uuid)); ?>" method="POST">
                      <?php echo csrf_field(); ?>
                      <?php echo method_field('DELETE'); ?>
                      <?php if (isset($component)) { $__componentOriginald4808ebc7c3433bc77b986e62d0056fde61922a0 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DeleteButton::class, ['label' => 'Delete']); ?>
<?php $component->withName('delete-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald4808ebc7c3433bc77b986e62d0056fde61922a0)): ?>
<?php $component = $__componentOriginald4808ebc7c3433bc77b986e62d0056fde61922a0; ?>
<?php unset($__componentOriginald4808ebc7c3433bc77b986e62d0056fde61922a0); ?>
<?php endif; ?>
                    </form>
                  </div>
                </div>
              </div>
            </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </tbody>
    </table>
  </div>

  <?php if (isset($component)) { $__componentOriginal41fa1a726c2cdc888fd1699c1c531da853ade966 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Pagination::class, ['pages' => $datas]); ?>
<?php $component->withName('pagination'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal41fa1a726c2cdc888fd1699c1c531da853ade966)): ?>
<?php $component = $__componentOriginal41fa1a726c2cdc888fd1699c1c531da853ade966; ?>
<?php unset($__componentOriginal41fa1a726c2cdc888fd1699c1c531da853ade966); ?>
<?php endif; ?>
</div>
<?php /**PATH C:\laragon\www\warungdigital\resources\views/components/seller/seller-table.blade.php ENDPATH**/ ?>