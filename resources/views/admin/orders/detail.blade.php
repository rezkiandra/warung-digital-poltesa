@extends('layouts.authenticated')
@section('title', 'Detail Transaksi')
@section('content')
  <div class="row">
    <div class="col-12 col-lg-8">
      <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="card-title m-0">Detail Pesanan</h5>
        </div>
        <div class="card-datatable table-responsive">
          <div>
            <table class="table">
              <thead class="text-uppercase">
                <tr>
                  <th>ID Pesanan</th>
                  <th colspan="4">Produk</th>
                </tr>
              </thead>
              <tbody>
                <tr class="even">
                  <td>
                    <span class="badge bg-label-primary text-uppercase">#{{ Str::substr($order->uuid, 0, 5) }}</span>
                  </td>
                  <td class="sorting_1">
                    <div class="d-flex justify-content-start align-items-center product-name">
                      <div class="avatar-wrapper me-3">
                        <div class="avatar avatar-sm rounded-2 bg-label-secondary"><img
                            src="{{ asset('storage/' . $order->product->image) }}" alt="{{ $order->product->name }}"
                            class="rounded-2">
                        </div>
                      </div>
                      <div class="d-flex flex-column">
                        <span class="text-nowrap text-heading fw-medium">{{ $order->product->name }}</span>
                        <small class="text-truncate">{{ Str::limit($order->product->description, 120) }}</small>
                      </div>
                    </div>
                  </td>
                </tr>
              </tbody>
              <tr>
                <td colspan="4" class="text-start text-dark">
                  <div class="d-flex justify-content-start align-items-center my-2">
                    <div class="d-flex flex-column align-items-start justify-content-end">
                      <span class="text-nowrap text-heading fw-medium mb-3">Rincian Pesanan (IDR)</span>
                      <span class="text-truncate">
                        Quantity &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp; : {{ $order->quantity }}
                        {{ $order->product->unit }}
                      </span>
                      <span class="text-truncate">
                        Berat &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; : {{ $order->product->weight }} gram
                      </span>
                      <span class="text-truncate">
                        Subtotal Produk &emsp;&emsp;&ensp; : Rp {{ number_format($order->product->price, 0, ',', '.') }}
                      </span>
                      <span class="text-truncate">
                        Total Harga Produk &emsp; : Rp {{ number_format($order->total_price, 0, ',', '.') }}
                      </span>
                      <br>
                      <span class="text-truncate">
                        Biaya Admin &emsp;&emsp;&emsp;&emsp;&nbsp; : Rp
                        {{ number_format(\App\Models\Setting::getValue('admin_cost'), 0, ',', '.') }}
                      </span>
                      @if ($order->shipping)
                        <span class="text-truncate">
                          Biaya Pengiriman &emsp;&ensp;&nbsp; : Rp
                          {{ number_format($order->shipping->price, 0, ',', '.') }}
                        </span>
                        <br>
                        <span class="text-truncate">
                          Harga Keseluruhan &emsp; : Rp
                          {{ number_format($order->total_price + \App\Models\Setting::getValue('admin_cost') + $order->shipping->price, 0, ',', '.') }}
                        </span>
                      @else
                        <span class="text-truncate">
                          Harga Keseluruhan &emsp; : Rp
                          {{ number_format($order->total_price + \App\Models\Setting::getValue('admin_cost'), 0, ',', '.') }}
                        </span>
                      @endif
                    </div>
                  </div>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div class="card mb-3">
        <div class="card-header">
          <h5 class="card-title m-0">Aktivitas Pemesanan</h5>
        </div>
        <div class="card-body">
          <ul class="timeline pb-0 mb-0">
            {{-- Row 1 --}}
            <li class="timeline-item timeline-item-transparent border-primary">
              <span class="timeline-point timeline-point-primary"></span>
              <div class="timeline-event">
                <div class="timeline-header mb-1">
                  <h6 class="mb-0">Pesanan berhasil dibuat (Order ID: #<span
                      class="text-uppercase">{{ Str::substr($order->uuid, 0, 5) }}</span>)</h6>
                  <small class="text-muted">{{ date('d M Y, H:i:s', strtotime($order->created_at)) }}</small>
                </div>
                <p class="mt-1 mb-3">Pelanggan telah melakukan pemesanan</p>
              </div>
            </li>
            <li class="timeline-item timeline-item-transparent border-primary">
              <span class="timeline-point timeline-point-primary"></span>
              <div class="timeline-event">
                <div class="timeline-header mb-1">
                  @if ($order->order_type == 'ambil sendiri')
                    <h6 class="mb-0">Pelanggan memilih tipe pesanan Ambil Sendiri</h6>
                  @elseif($order->order_type == 'jasa kirim')
                    <h6 class="mb-0">Pelanggan memilih tipe pesanan Jasa Kirim</h6>
                  @endif
                  <small class="text-muted">{{ date('d M Y, H:i:s', strtotime($order->created_at)) }}</small>
                </div>
                <p class="mt-1 mb-3">Pelanggan telah memilih tipe pesanan</p>
              </div>
            </li>
            @if ($order->shipping)
              <li class="timeline-item timeline-item-transparent border-primary">
                <span class="timeline-point timeline-point-primary"></span>
                <div class="timeline-event">
                  <div class="timeline-header mb-1">
                    <h6 class="mb-0">Ekspedisi pengiriman menggunakan {{ $order->shipping->courier }}</h6>
                    <small class="text-muted">{{ date('d M Y, H:i:s', strtotime($order->shipping->created_at)) }}</small>
                  </div>
                  <p class="mt-1 mb-3">Estimasi pengiriman produk {{ $order->shipping->etd }} hari</p>
                </div>
              </li>
            @endif

            {{-- Row 2 --}}
            {{-- E-Channel --}}
            @if (
                $order->payment_method &&
                    ($order->status == 'sudah bayar' || $order->status == 'kadaluarsa' || $order->status == 'belum bayar') &&
                    $order->bill_key &&
                    $order->biller_code)
              <li class="timeline-item timeline-item-transparent border-primary">
                <span class="timeline-point timeline-point-primary"></span>
                <div class="timeline-event">
                  <div class="timeline-header mb-1">
                    <h6 class="mb-0">Metode pembayaran menggunakan <span
                        class="text-uppercase">{{ $order->payment_method }}</span></h6>
                    <small class="text-muted">{{ date('d M Y, H:i:s', strtotime($order->transaction_time)) }}</small>
                  </div>
                  <p class="mt-1 mb-3">Pelanggan harus membayar
                    {{ date('d M Y, H:i:s', strtotime($order->expiry_time)) }}</p>
                </div>
              </li>
              @if ($order->status == 'sudah bayar')
                <li class="timeline-item timeline-item-transparent border-primary">
                  <span class="timeline-point timeline-point-primary"></span>
                  <div class="timeline-event">
                    <div class="timeline-header mb-1">
                      @if ($order->shipping)
                        <h6 class="mb-0">Pelanggan berhasil membayar sebesar Rp
                          {{ number_format($order->total_price + \App\Models\Setting::getValue('admin_cost') + $order->shipping->price, 0, ',', '.') }}
                        </h6>
                      @else
                        <h6 class="mb-0">Pelanggan berhasil membayar sebesar Rp
                          {{ number_format($order->total_price + \App\Models\Setting::getValue('admin_cost'), 0, ',', '.') }}
                        </h6>
                      @endif
                      <small class="text-muted">{{ date('d M Y, H:i:s', strtotime($order->updated_at)) }}</small>
                    </div>
                    <p class="mt-1 mb-3">Anda sudah membayar pesanan</p>
                  </div>
                </li>
              @elseif ($order->status == 'kadaluarsa')
                <li class="timeline-item timeline-item-transparent border-primary">
                  <span class="timeline-point timeline-point-primary"></span>
                  <div class="timeline-event">
                    <div class="timeline-header mb-1">
                      <h6 class="mb-0">Pesanan telah kadaluarsa</h6>
                      <small class="text-muted">{{ date('d M Y, H:i:s', strtotime($order->updated_at)) }}</small>
                    </div>
                    <p class="mt-1 mb-3">Anda tidak dapat membeli produk</p>
                  </div>
                </li>
              @elseif ($order->status == 'belum bayar')
                <li class="timeline-item timeline-item-transparent border-primary">
                  <span class="timeline-point timeline-point-primary"></span>
                  <div class="timeline-event">
                    <div class="timeline-header mb-1">
                      <h6 class="mb-0">Pesanan belum dibayar</h6>
                      <small class="text-muted">{{ date('d M Y, H:i:s', strtotime($order->updated_at)) }}</small>
                    </div>
                    <p class="mt-1 mb-3">Pelanggan harus segera membayar pesanan</p>
                  </div>
                </li>
              @endif

              {{-- QRIS --}}
            @elseif (
                $order->payment_method &&
                    ($order->status == 'sudah bayar' || $order->status == 'kadaluarsa' || $order->status == 'belum bayar') &&
                    $order->issuer &&
                    $order->acquirer)
              <li class="timeline-item timeline-item-transparent border-primary">
                <span class="timeline-point timeline-point-primary"></span>
                <div class="timeline-event">
                  <div class="timeline-header mb-1">
                    <h6 class="mb-0">Metode pembayaran menggunakan <span
                        class="text-uppercase">{{ $order->payment_method }}</span></h6>
                    <small class="text-muted">{{ date('d M Y, H:i:s', strtotime($order->transaction_time)) }}</small>
                  </div>
                  <p class="mt-1 mb-3">Pelanggan harus membayar sebelum
                    {{ date('d M Y, H:i:s', strtotime($order->expiry_time)) }}</p>
                </div>
              </li>
              @if ($order->status == 'sudah bayar')
                <li class="timeline-item timeline-item-transparent border-primary">
                  <span class="timeline-point timeline-point-primary"></span>
                  <div class="timeline-event">
                    <div class="timeline-header mb-1">
                      @if ($order->shipping)
                        <h6 class="mb-0">Pelanggan berhasil membayar sebesar Rp
                          {{ number_format($order->total_price + \App\Models\Setting::getValue('admin_cost') + $order->shipping->price, 0, ',', '.') }}
                        </h6>
                      @else
                        <h6 class="mb-0">Pelanggan berhasil membayar sebesar Rp
                          {{ number_format($order->total_price + \App\Models\Setting::getValue('admin_cost'), 0, ',', '.') }}
                        </h6>
                      @endif
                      <small class="text-muted">{{ date('d M Y, H:i:s', strtotime($order->updated_at)) }}</small>
                    </div>
                    <p class="mt-1 mb-3">Pelanggan sudah membayar pesanan</p>
                  </div>
                </li>
              @elseif ($order->status == 'kadaluarsa')
                <li class="timeline-item timeline-item-transparent border-primary">
                  <span class="timeline-point timeline-point-primary"></span>
                  <div class="timeline-event">
                    <div class="timeline-header mb-1">
                      <h6 class="mb-0">Pesanan telah kadaluarsa</h6>
                      <small class="text-muted">{{ date('d M Y, H:i:s', strtotime($order->updated_at)) }}</small>
                    </div>
                    <p class="mt-1 mb-3">Anda tidak dapat membeli produk</p>
                  </div>
                </li>
              @elseif ($order->status == 'belum bayar')
                <li class="timeline-item timeline-item-transparent border-primary">
                  <span class="timeline-point timeline-point-primary"></span>
                  <div class="timeline-event">
                    <div class="timeline-header mb-1">
                      <h6 class="mb-0">Pesanan belum dibayar</h6>
                      <small class="text-muted">{{ date('d M Y, H:i:s', strtotime($order->updated_at)) }}</small>
                    </div>
                    <p class="mt-1 mb-3">Pelanggan harus segera membayar pesanan</p>
                  </div>
                </li>
              @endif

              {{-- Virtual Account --}}
            @elseif (
                $order->payment_method == 'bank_transfer' &&
                    ($order->status == 'sudah bayar' || $order->status == 'kadaluarsa' || $order->status == 'belum bayar'))
              <li class="timeline-item timeline-item-transparent border-primary">
                <span class="timeline-point timeline-point-primary"></span>
                <div class="timeline-event">
                  <div class="timeline-header mb-1">
                    <h6 class="mb-0">Metode pembayaran menggunakan <span
                        class="text-uppercase">{{ $order->payment_method }}</span></h6>
                    <small class="text-muted">{{ date('d M Y, H:i:s', strtotime($order->transaction_time)) }}</small>
                  </div>
                  <p class="mt-1 mb-3">Pelanggan harus membayar sebelum
                    {{ date('d M Y, H:i:s', strtotime($order->expiry_time)) }}</p>
                </div>
              </li>
              @if ($order->status == 'sudah bayar')
                <li class="timeline-item timeline-item-transparent border-primary">
                  <span class="timeline-point timeline-point-primary"></span>
                  <div class="timeline-event">
                    <div class="timeline-header mb-1">
                      @if ($order->shipping)
                        <h6 class="mb-0">Pelanggan berhasil membayar sebesar Rp
                          {{ number_format($order->total_price + \App\Models\Setting::getValue('admin_cost') + $order->shipping->price, 0, ',', '.') }}
                        </h6>
                      @else
                        <h6 class="mb-0">Pelanggan berhasil membayar sebesar Rp
                          {{ number_format($order->total_price + \App\Models\Setting::getValue('admin_cost'), 0, ',', '.') }}
                        </h6>
                      @endif
                      <small class="text-muted">{{ date('d M Y, H:i:s', strtotime($order->updated_at)) }}</small>
                    </div>
                    <p class="mt-1 mb-3">Pelanggan sudah membayar pesanan</p>
                  </div>
                </li>
              @elseif ($order->status == 'kadaluarsa')
                <li class="timeline-item timeline-item-transparent border-primary">
                  <span class="timeline-point timeline-point-primary"></span>
                  <div class="timeline-event">
                    <div class="timeline-header mb-1">
                      <h6 class="mb-0">Pesanan telah kadaluarsa</h6>
                      <small class="text-muted">{{ date('d M Y, H:i:s', strtotime($order->updated_at)) }}</small>
                    </div>
                    <p class="mt-1 mb-3">Pelanggan tidak dapat membeli produk</p>
                  </div>
                </li>
              @elseif ($order->status == 'belum bayar')
                <li class="timeline-item timeline-item-transparent border-primary">
                  <span class="timeline-point timeline-point-primary"></span>
                  <div class="timeline-event">
                    <div class="timeline-header mb-1">
                      <h6 class="mb-0">Pesanan belum dibayar</h6>
                      <small class="text-muted">{{ date('d M Y, H:i:s', strtotime($order->updated_at)) }}</small>
                    </div>
                    <p class="mt-1 mb-3">Anda harus segera membayar pesanan</p>
                  </div>
                </li>
              @endif

              {{-- Alfamart / Indomaret Group --}}
            @elseif (
                $order->payment_method &&
                    ($order->status == 'sudah bayar' || $order->status == 'kadaluarsa' || $order->status == 'belum bayar') &&
                    $order->payment_code &&
                    $order->store)
              <li class="timeline-item timeline-item-transparent border-primary">
                <span class="timeline-point timeline-point-primary"></span>
                <div class="timeline-event">
                  <div class="timeline-header mb-1">
                    <h6 class="mb-0">Metode pembayaran menggunakan <span
                        class="text-uppercase">{{ $order->payment_method }}</span></h6>
                    <small class="text-muted">{{ date('d M Y, H:i:s', strtotime($order->transaction_time)) }}</small>
                  </div>
                  <p class="mt-1 mb-3">Pelanggan harus membayar sebelum
                    {{ date('d M Y, H:i:s', strtotime($order->expiry_time)) }}</p>
                </div>
              </li>
              @if ($order->status == 'sudah bayar')
                <li class="timeline-item timeline-item-transparent border-primary">
                  <span class="timeline-point timeline-point-primary"></span>
                  <div class="timeline-event">
                    <div class="timeline-header mb-1">
                      @if ($order->shipping)
                        <h6 class="mb-0">Pelanggan berhasil membayar sebesar Rp
                          {{ number_format($order->total_price + \App\Models\Setting::getValue('admin_cost') + $order->shipping->price, 0, ',', '.') }}
                        </h6>
                      @else
                        <h6 class="mb-0">Pelanggan berhasil membayar sebesar Rp
                          {{ number_format($order->total_price + \App\Models\Setting::getValue('admin_cost'), 0, ',', '.') }}
                        </h6>
                      @endif
                      <small class="text-muted">{{ date('d M Y, H:i:s', strtotime($order->updated_at)) }}</small>
                    </div>
                    <p class="mt-1 mb-3">Pelanggan sudah membayar pesanan</p>
                  </div>
                </li>
              @elseif ($order->status == 'kadaluarsa')
                <li class="timeline-item timeline-item-transparent border-primary">
                  <span class="timeline-point timeline-point-primary"></span>
                  <div class="timeline-event">
                    <div class="timeline-header mb-1">
                      <h6 class="mb-0">Pesanan telah kadaluarsa</h6>
                      <small class="text-muted">{{ date('d M Y, H:i:s', strtotime($order->updated_at)) }}</small>
                    </div>
                    <p class="mt-1 mb-3">Pelanggan tidak dapat membeli produk</p>
                  </div>
                </li>
              @elseif ($order->status == 'belum bayar')
                <li class="timeline-item timeline-item-transparent border-primary">
                  <span class="timeline-point timeline-point-primary"></span>
                  <div class="timeline-event">
                    <div class="timeline-header mb-1">
                      <h6 class="mb-0">Pesanan belum dibayar</h6>
                      <small class="text-muted">{{ date('d M Y, H:i:s', strtotime($order->updated_at)) }}</small>
                    </div>
                    <p class="mt-1 mb-3">Pelanggan harus segera membayar pesanan</p>
                  </div>
                </li>
              @endif
            @elseif($order->status == 'dibatalkan')
              <li class="timeline-item timeline-item-transparent border-primary">
                <span class="timeline-point timeline-point-primary"></span>
                <div class="timeline-event">
                  <div class="timeline-header mb-1">
                    <h6 class="mb-0">Metode pembayaran menggunakan <span
                        class="text-uppercase">{{ $order->payment_method }}</span></h6>
                    <small class="text-muted">{{ date('d M Y, H:i:s', strtotime($order->transaction_time)) }}</small>
                  </div>
                  <p class="mt-1 mb-3">Pelanggan harus membayar sebelum
                    {{ date('d M Y, H:i:s', strtotime($order->expiry_time)) }}</p>
                </div>
              </li>
              <li class="timeline-item timeline-item-transparent border-primary">
                <span class="timeline-point timeline-point-primary"></span>
                <div class="timeline-event">
                  <div class="timeline-header mb-1">
                    <h6 class="mb-0">Pesanan telah dibatalkan</h6>
                    <small class="text-muted">{{ date('d M Y, H:i:s', strtotime($order->updated_at)) }}</small>
                  </div>
                  <p class="mt-1 mb-3">Pelanggan telah membatalkan pesanan</p>
                </div>
              </li>
            @endif

            {{-- Row 3 --}}
            @if ($order->status == 'sudah bayar')
              <li class="timeline-item timeline-item-transparent border-primary">
                <span class="timeline-point timeline-point-primary"></span>
                <div class="timeline-event">
                  <div class="timeline-header mb-1">
                    <h6 class="mb-0">Status pesanan <span class="text-uppercase badge bg-label-success">
                        Berhasil Dibayar</span></h6>
                    <small class="text-muted">{{ date('d M Y, H:i:s', strtotime($order->updated_at)) }}</small>
                  </div>
                  <p class="mt-1 mb-3">Pesanan selesai. Anda dapat melihat detail pesanan dan mencetaknya sebagai bukti
                    transaksi
                  </p>
                </div>
              </li>
            @elseif ($order->status == 'dibatalkan')
              <li class="timeline-item timeline-item-transparent border-primary">
                <span class="timeline-point timeline-point-primary"></span>
                <div class="timeline-event">
                  <div class="timeline-header mb-1">
                    <h6 class="mb-0">Status pesanan <span class="text-uppercase badge bg-label-dark">
                        Dibatalkan</span></h6>
                    <small class="text-muted">{{ date('d M Y, H:i:s', strtotime($order->updated_at)) }}</small>
                  </div>
                  <p class="mt-1 mb-3">Pesanan telah dibatalkan</p>
                </div>
              </li>
            @elseif ($order->status == 'kadaluarsa')
              <li class="timeline-item timeline-item-transparent border-primary">
                <span class="timeline-point timeline-point-primary"></span>
                <div class="timeline-event">
                  <div class="timeline-header mb-1">
                    <h6 class="mb-0">Status pesanan <span
                        class="text-uppercase badge bg-label-danger">Kadaluarsa</span></h6>
                    <small class="text-muted">{{ date('d M Y, H:i:s', strtotime($order->updated_at)) }}</small>
                  </div>
                  <p class="mt-1 mb-3">Pesanan sudah kadaluarsa</p>
                </div>
              </li>
            @endif
          </ul>
        </div>
      </div>
      <div class="d-flex justify-content-center align-items-center gap-3 mb-3">
        <x-basic-button :href="route('preview.transaction', $order->uuid)" :label="'Preview'" :class="'w-100'" :variant="'outline-primary'" :icon="'note-search-outline me-2'" />
        <x-basic-button :href="route('download.transaction', $order->uuid)" :label="'Cetak'" :class="'w-100'" :variant="'primary'" :icon="'file-download-outline me-2'" />
      </div>
    </div>
    <div class="col-12 col-lg-4">
      <div class="card mb-3">
        <div class="card-body">
          <h5 class="card-title mb-4">Detail Penjual</h5>
          <div class="d-flex justify-content-start align-items-center mb-4">
            <div class="avatar me-3">
              <img src="{{ asset('storage/' . $order->product->seller->image) }}"
                alt="{{ $order->product->seller->full_name }}" class="rounded-circle">
            </div>
            <div class="d-flex flex-column">
              <a href="app-user-view-account.html">
                <h6 class="mb-0">{{ $order->product->seller->full_name }}</h6>
              </a>
              <span>Seller ID: #<span
                  class="text-uppercase">{{ Str::substr($order->product->seller->uuid, 0, 5) }}</span></span>
            </div>
          </div>
          <div class="d-flex justify-content-between">
            <h6 class="mb-1">Info Kontak</h6>
          </div>
          <p class="mb-1">Email : {{ $order->product->seller->user->email }}</p>
          <p class="mb-0">Nomor HP : {{ $order->product->seller->phone_number }}</p>
          <p class="mb-0">Alamat : {{ $order->product->seller->address }}</p>
        </div>
      </div>

      <div class="card mb-3">
        <div class="card-body">
          <h5 class="card-title mb-4">Detail Pelanggan</h5>
          <div class="d-flex justify-content-start align-items-center mb-4">
            <div class="avatar me-3">
              <img src="{{ asset('storage/' . $order->customer->image) }}" alt="{{ $order->customer->full_name }}"
                class="rounded-circle">
            </div>
            <div class="d-flex flex-column">
              <a href="app-user-view-account.html">
                <h6 class="mb-0">{{ $order->customer->full_name }}</h6>
              </a>
              <span>Customer ID: #<span
                  class="text-uppercase">{{ Str::substr($order->customer->uuid, 0, 5) }}</span></span>
            </div>
          </div>
          <div class="d-flex justify-content-between">
            <h6 class="mb-1">Info Kontak</h6>
          </div>
          <p class="mb-1">Email : {{ $order->customer->user->email }}</p>
          <p class="mb-0">Nomor HP : {{ $order->customer->phone_number }}</p>
          <p class="mb-0">Alamat : {{ $order->customer->address }}</p>
        </div>
      </div>

      @if ($order->shipping)
        <div class="card mb-3">
          <div class="card-body">
            <h5 class="card-title mb-4 d-flex align-items-center">
              <i class="mdi mdi-truck-fast mdi-24px me-2"></i>
              <span>Detail Pengiriman</span>
            </h5>
            <div class="d-flex justify-content-between">
              <h6 class="mb-1">Info Kurir</h6>
            </div>
            <p class="mb-1">Kurir : {{ $order->shipping->courier }}</p>
            <p class="mb-1">Servis : {{ $order->shipping->description }} - {{ $order->shipping->code }}</p>
            <p class="mb-1">Estimasi Pengiriman : {{ $order->shipping->etd }} hari</p>
            <p class="mb-1">Status Pengiriman :
              @if ($order->shipping->status == 'dikirim')
                <span class="text-uppercase badge bg-label-dark rounded">{{ $order->shipping->status }}</span>
              @elseif ($order->shipping->status == 'diproses')
                <span class="text-uppercase badge bg-label-warning rounded">{{ $order->shipping->status }}</span>
              @elseif ($order->shipping->status == 'diterima')
                <span class="text-uppercase badge bg-label-success rounded">{{ $order->shipping->status }}</span>
              @endif
            </p>
            @if ($order->shipping->resi)
              <p class="mb-1">Nomor Resi : {{ $order->shipping->resi }}</p>
            @endif
          </div>
        </div>
      @endif

      <div class="card mb-3">
        <div class="card-body">
          <h5 class="card-title mb-4">Detail Pembayaran</h5>
          <div class="d-flex justify-content-between">
            <h6 class="mb-1">Info Pembayaran</h6>
          </div>

          @if ($order->status == 'sudah bayar')
            @if ($order->acquirer && $order->issuer)
              <p class="mb-1">Metode :
                <span class="text-uppercase">{{ $order->payment_method }}</span>
              </p>
              <p class="mb-1">Acquirer :
                <span class="text-capitalize">{{ $order->acquirer }}</span>
              </p>
              <p class="mb-1">Issuer :
                <span class="text-capitalize">{{ $order->issuer }}</span>
              </p>
              <p class="mb-1">Tanggal Pemesanan :
                <span
                  class="text-uppercase badge bg-label-info rounded">{{ date('d M Y, H:i:s', strtotime($order->created_at)) }}
                  {{ $order->created_at->format('H:i') > '12:00' ? 'PM' : 'AM' }}
                </span>
              </p>
              <p class="mb-1">Tanggal Pembayaran :
                <span
                  class="text-uppercase badge bg-label-success rounded">{{ date('d M Y, H:i:s', strtotime($order->updated_at)) }}
                  {{ $order->updated_at->format('H:i') > '12:00' ? 'PM' : 'AM' }}
                </span>
              </p>
              <p class="mb-1">Status :
                <span class="text-uppercase badge bg-label-success rounded">{{ $order->status }}</span>
              </p>
            @elseif($order->biller_code && $order->bill_key)
              <p class="mb-1">Metode :
                <span class="text-uppercase">{{ $order->payment_method }}</span>
              </p>
              <p class="mb-1">Kode Perusahaan :
                <span class="text-capitalize">{{ $order->biller_code }}</span>
              </p>
              <p class="mb-1">Nomor Virtual Account :
                <span class="text-capitalize">{{ $order->bill_key }}</span>
              </p>
              <p class="mb-1">Tanggal Pemesanan :
                <span
                  class="text-uppercase badge bg-label-info rounded">{{ date('d M Y, H:i:s', strtotime($order->created_at)) }}
                  {{ $order->created_at->format('H:i') > '12:00' ? 'PM' : 'AM' }}
                </span>
              </p>
              <p class="mb-1">Tanggal Pembayaran :
                <span
                  class="text-uppercase badge bg-label-success rounded">{{ date('d M Y, H:i:s', strtotime($order->updated_at)) }}
                  {{ $order->updated_at->format('H:i') > '12:00' ? 'PM' : 'AM' }}
                </span>
              </p>
              <p class="mb-1">Status :
                <span class="text-uppercase badge bg-label-success rounded">{{ $order->status }}</span>
              </p>
            @else
              <p class="mb-1">Metode :
                <span class="text-uppercase">{{ $order->payment_method }}</span>
              </p>
              @if ($order->store && $order->payment_code)
                <p class="mb-1">Gerai :
                  <span class="text-capitalize">{{ $order->store }}</span>
                </p>
                <p class="mb-1">Kode Pembayaran :
                  <span class="text-capitalize">{{ $order->payment_code }}</span>
                </p>
              @endif
              <p class="mb-1">Tanggal Pemesanan :
                <span
                  class="text-uppercase badge bg-label-info rounded">{{ date('d M Y, H:i:s', strtotime($order->created_at)) }}
                  {{ $order->created_at->format('H:i') > '12:00' ? 'PM' : 'AM' }}
                </span>
              </p>
              <p class="mb-1">Tanggal Pembayaran :
                <span
                  class="text-uppercase badge bg-label-success rounded">{{ date('d M Y, H:i:s', strtotime($order->updated_at)) }}
                  {{ $order->updated_at->format('H:i') > '12:00' ? 'PM' : 'AM' }}
                </span>
              </p>
              <p class="mb-1">Status :
                <span class="text-uppercase badge bg-label-success rounded">{{ $order->status }}</span>
              </p>
            @endif
          @elseif($order->status == 'belum bayar')
            @if ($order->store)
              <p class="mb-1">Metode :
                <span class="text-uppercase">{{ $order->payment_method }}</span>
              </p>
              <p class="mb-1">Gerai :
                <span class="text-capitalize">{{ $order->store }}</span>
              </p>
              <p class="mb-1">Kode Pembayaran :
                <span class="text-capitalize">{{ $order->payment_code }}</span>
              </p>
              <p class="mb-1">Tanggal Pemesanan :
                <span
                  class="text-uppercase badge bg-label-info rounded">{{ date('d M Y, H:i:s', strtotime($order->created_at)) }}
                  {{ $order->created_at->format('H:i') > '12:00' ? 'PM' : 'AM' }}
                </span>
              </p>
              <p class="mb-1">Status :
                <span class="text-uppercase badge bg-label-warning rounded">{{ $order->status }}</span>
              </p>
            @elseif ($order->payment_method == 'akulaku')
              <p class="mb-1">Metode :
                <span class="text-uppercase">{{ $order->payment_method }}</span>
              </p>
              <p class="mb-1">Tanggal Pemesanan :
                <span
                  class="text-uppercase badge bg-label-info rounded">{{ date('d M Y, H:i:s', strtotime($order->created_at)) }}
                  {{ $order->created_at->format('H:i') > '12:00' ? 'PM' : 'AM' }}
                </span>
              </p>
              <p class="mb-1">Status :
                <span class="text-uppercase badge bg-label-warning rounded">{{ $order->status }}</span>
              </p>
            @elseif($order->biller_code && $order->bill_key)
              <p class="mb-1">Metode :
                <span class="text-capitalize">{{ $order->payment_method }}</span>
              </p>
              <p class="mb-1">Kode Perusahaan :
                <span class="text-capitalize">{{ $order->biller_code }}</span>
              </p>
              <p class="mb-1">Nomor Virtual Account :
                <span class="text-capitalize">{{ $order->bill_key }}</span>
              </p>
              <p class="mb-1">Tanggal Pemesanan :
                <span
                  class="text-uppercase badge bg-label-info rounded">{{ date('d M Y, H:i:s', strtotime($order->created_at)) }}
                  {{ $order->created_at->format('H:i') > '12:00' ? 'PM' : 'AM' }}
                </span>
              </p>
              <p class="mb-1">Status :
                <span class="text-uppercase badge bg-label-warning rounded">{{ $order->status }}</span>
              </p>
            @else
              <p class="mb-1">Tanggal Pemesanan :
                <span
                  class="text-uppercase badge bg-label-info rounded">{{ date('d M Y, H:i:s', strtotime($order->created_at)) }}
                  {{ $order->created_at->format('H:i') > '12:00' ? 'PM' : 'AM' }}
                </span>
              </p>
              <p class="mb-1">Status :
                <span class="text-uppercase badge bg-label-warning rounded">{{ $order->status }}</span>
              </p>
            @endif
          @elseif($order->status == 'dibatalkan')
            @if ($order->payment_method && $order->biller_code && $order->bill_key)
              <p class="mb-1">Metode :
                <span class="text-uppercase">{{ $order->payment_method }}</span>
              </p>
              <p class="mb-1">Kode Perusahaan :
                <span class="text-uppercase">{{ $order->biller_code }}</span>
              </p>
              <p class="mb-1">Nomor Virtual Account :
                <span class="text-uppercase">{{ $order->bill_key }}</span>
              </p>
            @elseif ($order->payment_method && $order->store)
              <p class="mb-1">Metode :
                <span class="text-uppercase">{{ $order->payment_method }}</span>
              </p>
              <p class="mb-1">Gerai :
                <span class="text-uppercase">{{ $order->store }}</span>
              </p>
              <p class="mb-1">Kode Pembayaran :
                <span class="text-uppercase">{{ $order->payment_code }}</span>
              </p>
            @elseif ($order->payment_method && $order->issuer && $order->acquirer)
              <p class="mb-1">Metode :
                <span class="text-uppercase">{{ $order->payment_method }}</span>
              </p>
              <p class="mb-1">Acquirer :
                <span class="text-uppercase">{{ $order->acquirer }}</span>
              </p>
              <p class="mb-1">Issuer :
                <span class="text-uppercase">{{ $order->issuer }}</span>
              </p>
            @endif
            <p class="mb-1">Tanggal Pemesanan :
              <span
                class="text-uppercase badge bg-label-info rounded">{{ date('d M Y, H:i:s', strtotime($order->created_at)) }}
                {{ $order->created_at->format('H:i') > '12:00' ? 'PM' : 'AM' }}
              </span>
            </p>
            <p class="mb-1">Tanggal Pembatalan :
              <span
                class="text-uppercase badge bg-label-dark rounded">{{ date('d M Y, H:i:s', strtotime($order->updated_at)) }}
                {{ $order->updated_at->format('H:i') > '12:00' ? 'PM' : 'AM' }}
              </span>
            </p>
            <p class="mb-1">Status :
              <span class="text-uppercase badge bg-label-dark rounded">{{ $order->status }}</span>
            </p>
          @elseif ($order->status == 'kadaluarsa')
            <p class="mb-1">Metode :
              <span class="text-uppercase">{{ $order->payment_method }}</span>
            </p>
            @if ($order->store)
              <p class="mb-1">Gerai :
                <span class="text-capitalize">{{ $order->store }}</span>
              </p>
              <p class="mb-1">Kode Pembayaran :
                <span class="text-capitalize">{{ $order->payment_code }}</span>
              </p>
            @elseif($order->biller_code && $order->bill_key)
              <p class="mb-1">Kode Perusahaan :
                <span class="text-capitalize">{{ $order->biller_code }}</span>
              </p>
              <p class="mb-1">Nomor Virtual Account :
                <span class="text-capitalize">{{ $order->bill_key }}</span>
              </p>
            @elseif($order->issuer && $order->acquirer)
              <p class="mb-1">Acquirer :
                <span class="text-capitalize">{{ $order->acquirer }}</span>
              </p>
              <p class="mb-1">Issuer :
                <span class="text-capitalize">{{ $order->issuer }}</span>
              </p>
            @endif
            <p class="mb-1">Tanggal Pemesanan :
              <span
                class="text-uppercase badge bg-label-info rounded">{{ date('d M Y, H:i:s', strtotime($order->transaction_time)) }}
              </span>
            </p>
            <p class="mb-1">Tanggal Kadaluarsa :
              <span
                class="text-uppercase badge bg-label-dark rounded">{{ date('d M Y, H:i:s', strtotime($order->expiry_time)) }}
              </span>
            </p>
            <p class="mb-1">Status :
              <span class="text-uppercase badge bg-label-danger rounded">{{ $order->status }}</span>
            </p>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection
