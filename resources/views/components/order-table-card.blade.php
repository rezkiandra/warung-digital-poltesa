@php
  $total_price = \App\Models\Order::where('customer_id', auth()->user()->customer->id)
      ->where('status', 'sudah bayar')
      ->sum('total_price');
@endphp
<div class="col-12">
  <div class="card">
    <div class="table-responsive">
      <table class="table">
        <thead class="table-light">
          <tr>
            <th class="text-truncate">Tgl. Pemesanan</th>
            <th class="text-truncate">Produk</th>
            <th class="text-truncate">Tipe Pesanan</th>
            <th class="text-truncate">Pengiriman</th>
            <th class="text-truncate">Total Pesanan</th>
            <th class="text-truncate">Status Pesanan</th>
            <th class="text-truncate">Status Paket</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($datas as $data)
            <tr>
              <td class="text-truncate fw-medium">
                <span class="badge bg-label-info rounded">{{ date('d M Y', strtotime($data->created_at)) }}</span>
              </td>
              <td>
                <div class="d-flex align-items-center">
                  <div class="avatar-wrapper me-3">
                    <div class="avatar rounded-2 bg-label-secondary">
                      <img src="{{ asset('storage/' . $data->product->image) }}" class="rounded-2">
                    </div>
                  </div>
                  <div class="">
                    <div class="d-flex flex-row align-items-start justify-content-start gap-1">
                      <span class="text-dark text-capitalize fw-medium">{{ $data->product->name }}</span>
                    </div>
                    <small class="text-truncate text-dark">Rp {{ number_format($data->product->price, 0, ',', '.') }} -
                      {{ $data->quantity }} {{ $data->product->unit }}</small>
                  </div>
                </div>
              </td>
              <td>
                @if ($data->order_type == 'ambil_sendiri')
                  <span class="text-truncate text-dark">Ambil Sendiri</span>
                @elseif ($data->order_type == 'jasa_kirim')
                  <span class="text-truncate text-dark">Jasa Kirim</span>
                @endif
              </td>
              <td>
                <div class="d-flex justify-content-start align-items-center user-name">
                  @if ($data->shipping)
                    <div class="d-flex flex-column">
                      <span class="fw-medium text-heading">{{ $data->shipping->courier }}</span>
                      <small class="text-truncate">Rp {{ number_format($data->shipping->price, 0, ',', '.') }}
                        ({{ $data->shipping->etd }} hari)</small>
                    </div>
                  @elseif($data->order_type == 'ambil_sendiri')
                    <span class="text-uppercase">-</span>
                  @else
                    <span class="text-uppercase">-</span>
                  @endif
                </div>
              </td>
              <td>
                @if ($data->shipping)
                  <span class="text-truncate text-dark">Rp
                    {{ number_format($data->total_price + 1000 + $data->shipping->price, 0, ',', '.') }}
                  </span>
                @else
                  <span class="text-truncate text-dark">Rp
                    {{ number_format($data->total_price, 0, ',', '.') }}
                  </span>
                @endif
              </td>
              <td class="text-truncate">
                @if ($data->status == 'sudah bayar')
                  <span class="badge bg-label-success rounded text-uppercase">{{ $data->status }}</span>
                @elseif ($data->status == 'belum bayar')
                  <span class="badge bg-label-warning rounded text-uppercase">{{ $data->status }}</span>
                @elseif ($data->status == 'kadaluarsa')
                  <span class="badge bg-label-danger rounded text-uppercase">{{ $data->status }}</span>
                @elseif ($data->status == 'dibatalkan')
                  <span class="badge bg-label-dark rounded text-uppercase">{{ $data->status }}</span>
                @endif
              </td>
              <td class="text-truncate">
                @if ($data->shipping)
                  @if ($data->shipping->status == 'diproses')
                    <span class="badge bg-label-warning rounded text-uppercase">{{ $data->shipping->status }}</span>
                  @elseif ($data->shipping->status == 'dikirim')
                    <span class="badge bg-label-dark rounded text-uppercase">{{ $data->shipping->status }}</span>
                  @elseif ($data->shipping->status == 'diterima')
                    <span class="badge bg-label-success rounded text-uppercase">{{ $data->shipping->status }}</span>
                  @endif
                @elseif($data->order_type == 'ambil_sendiri')
                  <span class="text-uppercase">-</span>
                @else
                  <span class="text-uppercase">-</span>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <x-pagination :pages="$datas" />
  </div>
</div>
