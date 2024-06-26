<div class="col-sm-6 col-lg-3">
  <div class="d-flex justify-content-between align-items-start card-widget-1 {{ $class }} pb-3 pb-sm-0">
    <div>
      <p class="mb-2">{{ $label }}</p>
      <div class="d-flex align-items-center">
        <h4 class="mb-2 me-2 display-6">{{ $condition }}</h4>
      </div>
      <p class="mb-0">
        <span class="me-2">{{ $description }}</span>
      </p>
    </div>
    <div class="avatar me-sm-4">
      <span class="avatar-initial rounded bg-label-{{ $variant }}">
        <i class="mdi mdi-{{ $icon }} mdi-24px"></i>
      </span>
    </div>
  </div>
  <hr class="d-none d-sm-block d-lg-none me-4">
</div>
