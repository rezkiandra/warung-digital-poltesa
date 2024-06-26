<div class="card">
  <h5 class="card-header">{{ $title }}</h5>
  <div class="table-responsive text-nowrap">
    <table class="table table-hover table-responsive">
      <thead>
        @foreach ($fields as $field)
          <th>{{ $field }}</th>
        @endforeach
      </thead>
      <tbody>
        @foreach ($datas as $data)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td class="sorting_1">
              <div class="d-flex justify-content-start align-items-center product-name">
                <div class="avatar-wrapper me-3">
                  <div class="avatar rounded-2 bg-label-secondary">
                    <img src="{{ asset('storage/' . $data->image) }}" class="rounded-2">
                  </div>
                </div>
                <div class="d-flex flex-column">
                  <span class="text-nowrap text-heading fw-medium">{{ $data->name }}</span>
                  <small class="d-flex flex-row text-truncate d-none d-sm-block d-flex">
                    <span class="fw-medium">{{ Str::limit($data->description, 50) }}</span>
                  </small>
                </div>
              </div>
            </td>
            <td class="sorting_1">
              <div class="d-flex flex-column justify-content-start product-name">
                <span class="fw-medium d-flex align-items-center">
                  <span class="d-flex justify-content-center align-items-center">
                    <i class="mdi mdi-tshirt-crew text-info me-1"></i>
                  </span>
                  {{ $data->category->name }}
                </span>
                @if (Auth::user()->role_id == 1)
                  <small class="fw-medium d-flex align-items-center">
                    {{ $data->seller->full_name }} - {{ $data->seller->user->email }}
                  </small>
                @endif
              </div>
            </td>
            <td>
              <span class="fw-medium">Rp.{{ number_format($data->price, 2, ',', '.') }}</span>
            </td>
            <td>
              <span class="fw-medium">{{ $data->stock }} pcs</span>
            </td>
            <td>
              <span
                class="fw-medium badge rounded-pill bg-label-info">{{ date('d M Y, H:i:s', strtotime($data->created_at)) }}
                {{ $data->created_at->format('H:i') > '12:00' ? 'PM' : 'AM' }}
              </span>
            </td>
            <td>
              <div class="d-flex align-items-center">
                @if (Auth::user()->role_id != 1)
                  <a class="me-2" href="{{ route('seller.edit.product', $data->uuid) }}">
                    <i class="mdi mdi-pencil-outline text-secondary"></i>
                  </a>
                @endif
                <div class="dropdown">
                  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="mdi mdi-dots-vertical"></i>
                  </button>
                  <div class="dropdown-menu">
                    <x-dropdown-item :label="'Detail'" :variant="'secondary'" :icon="'eye-outline'" :route="route('seller.detail.product', $data->slug)" />
                    @if (Auth::user()->role_id == 2)
                      <form action="{{ route('seller.destroy.product', $data->slug) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <x-delete-button :label="'Delete'" />
                      </form>
                    @endif
                  </div>
                </div>
              </div>
            </td>
          </tr>
        @endforeach
      </tbody>
      <tfoot class="table-border-bottom-0">
        @foreach ($fields as $field)
          <th>{{ $field }}</th>
        @endforeach
      </tfoot>
    </table>
  </div>
</div>
