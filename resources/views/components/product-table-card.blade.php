<div class="col-12">
  <div class="card">
    <div class="table-responsive">
      <table class="table">
        <thead class="table-light">
          <tr>
            <th class="text-truncate">ID Produk</th>
            <th class="text-truncate">Produk</th>
            <th class="text-truncate">Harga Produk</th>
            <th class="text-truncate">Stok</th>
            <th class="text-truncate">Terjual</th>
            <th class="text-truncate">Kategori</th>
            <th class="text-truncate">Dipublish Pada</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($datas as $data)
            <tr>
              <td class="text-truncate">
                <span class="badge bg-label-primary text-uppercase">#{{ Str::substr($data->uuid, 0, 4) }}</span>
              </td>
              <td>
                <div class="d-flex align-items-center">
                  <div class="avatar-wrapper me-3">
                    <div class="avatar rounded-2 bg-label-secondary">
                      <img src="{{ asset('storage/' . $data->image) }}" class="rounded-2">
                    </div>
                  </div>
                  <div class="">
                    <span
                      class="d-lg-flex d-md-flex d-flex text-dark text-capitalize fw-medium">{{ $data->name }}</span>
                    <small class="text-truncate">{{ Str::limit($data->description, 60) }}</small>
                  </div>
                </div>
              </td>
              <td class="text-truncate">
                <div class="d-flex align-items-center">
                  <div>
                    <h6 class="mb-1 text-truncate">Rp {{ number_format($data->price, 0, ',', '.') }}</h6>
                  </div>
                </div>
              </td>
              <td class="text-truncate">
                <div class="d-flex align-items-center">
                  <div>
                    <h6 class="mb-1 text-truncate">{{ $data->stock }} {{ $data->unit }}</h6>
                  </div>
                </div>
              </td>
              <td>
                @if (App\Models\Order::where('product_id', $data->id)->sum('quantity') > 0)
                  <span
                    class="text-truncate text-dark">{{ \App\Models\Order::where('product_id', $data->id)->sum('quantity') }}
                    {{ $data->unit }}
                  </span>
                @else
                  <span class="text-truncate text-dark">-</span>
                @endif
              </td>
              <td class="text-truncate">
                <span class="badge bg-label-primary rounded text-uppercase">{{ $data->category->name }}</span>
              </td>
              <td class="text-truncate fw-medium">
                <span class="badge bg-label-info rounded">{{ date('d M Y, H:i:s', strtotime($data->created_at)) }}
                  {{ $data->created_at->format('H:i') > '12:00' ? 'PM' : 'AM' }}</span>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <x-pagination :pages="$datas" />
  </div>
</div>
