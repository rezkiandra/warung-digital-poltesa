<div class="card-body">
  <div class="customer-avatar-section">
    <div class="d-flex align-items-center flex-column">
      <img class="img-fluid rounded mb-3 mt-3" src="{{ $image }}" height="120" width="120" alt="User avatar">
      <div class="customer-info text-center mb-4">
        <h5 class="mb-1 text-uppercase">{{ $name }}</h5>
        <span>{{ $id }}</span>
      </div>
    </div>
  </div>
  <div class="d-flex justify-content-around flex-wrap mb-4">
    <div class="d-flex align-items-center gap-2">
      <div class="avatar me-1">
        <div class="avatar-initial rounded-3 bg-label-primary"><i class="mdi mdi mdi-cart-plus mdi-20px"></i>
        </div>
      </div>
      <div>
        <h5 class="mb-0">{{ $totalOrder }}</h5>
        <span>{{ $labelOrder }}</span>
      </div>
    </div>
    <div class="d-flex align-items-center gap-2">
      <div class="avatar me-1">
        <div class="avatar-initial rounded-3 bg-label-primary"><i class="mdi mdi-currency-usd mdi-20px"></i>
        </div>
      </div>
      <div>
        <h5 class="mb-0">{{ $spentCost }}</h5>
        <span>{{ $labelCost }}</span>
      </div>
    </div>
  </div>

  <div class="info-container">
    <h5 class="border-bottom text-uppercase pb-3">DETAILS</h5>
    <ul class="list-unstyled mb-4">
      <li class="mb-2">
        <span class="h6 me-1">Username:</span>
        <span class="text-capitalize">{{ $username }}</span>
      </li>
      <li class="mb-2">
        <span class="h6 me-1">Email:</span>
        <span>{{ $email }}</span>
      </li>
      <li class="mb-2">
        <span class="h6 me-1">Status:</span>
        <span
          class="badge text-capitalize @if ($status == 'active') bg-label-success @elseif($status == 'inactive') bg-label-danger @else bg-label-warning @endif rounded-pill">{{ $status }}</span>
      </li>

      <li class="mb-2">
        <span class="h6 me-1">Nomor Telepon:</span>
        <span>{{ $phone }}</span>
      </li>

      @if (auth()->user()->seller)
        <li class="mb-2">
          <span class="h6 me-1">Bank:</span>
          <span>{{ $bank }} - {{ $account }}</span>
        </li>
      @endif

      <li>
        <span class="h6 me-1">Alamat:</span>
        <span class="text-capitalize">{{ $address }}</span>
      </li>
    </ul>
    <div class="d-flex justify-content-center gap-3">
      @include('components.basic-button', [
          'label' => 'Edit Details',
          'href' => $href,
          'variant' => 'primary w-100',
          'icon' => 'pencil-outline me-2',
      ])
    </div>
  </div>
</div>
