@php
  $totalEarnings = \App\Models\Order::join('products', 'orders.product_id', '=', 'products.id', 'left')
      ->join('sellers', 'products.seller_id', '=', 'sellers.id', 'left')
      ->orderBy('orders.total_price', 'desc')
      ->sum('total_price');
@endphp

<div class="col-xl-4 col-md-6">
  <div class="card">
    <div class="card-header d-flex align-items-center justify-content-start">
      <h5 class="card-title m-0 me-2">{{ $title }}</h5>
    </div>
    <div class="card-body">
      @foreach ($datas as $data)
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
          <div class="d-flex align-items-center">
            <div class="avatar-wrapper me-3">
              <div class="avatar rounded-2 bg-label-secondary">
                <img src="{{ asset('storage/' . $data->seller->image) }}" class="rounded-2">
              </div>
            </div>
            <div class="">
              <div class="d-flex flex-row align-items-start justify-content-start gap-1">
                <span class="text-dark text-capitalize fw-medium">{{ $data->seller->full_name }}</span>
              </div>
              <small>{{ $data->seller->user->email }}</small>
            </div>
          </div>
          <div class="text-end">
            <h6 class="mb-0">Rp{{ number_format($totalEarnings, 0, '.', ',') }}</h6>
            <small>Pendapatan</small>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>
