@php
  $alertMessage = 'Anda memiliki kendali penuh terhadap aplikasi ini. Jadilah seorang administrator yang bertanggung jawab!!';
  $message = 'Dashboard admin berisi informasi tentang transaksi, pengguna, penjual, dan produk';
  $greetings = 'Halo, ' . auth()->user()->name;
  $descriptionGreetings = 'Selamat datang di dashboard admin';
  $label = 'Total Pengguna';
  $value = \App\Models\User::count();
  $actionLabel = 'Selengkapnya';
  $route = route('admin.users');
  $title = 'Data Master';
  $description = 'Total data master keseluruhan';
@endphp
@extends('layouts.authenticated')
@section('title', 'Dashboard')
@push('styles')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush
@section('content')
  <x-customer-dashboard-card :description="$alertMessage" />
  <x-content-card>
    <x-greetings-card :greetings="$greetings" :description="$descriptionGreetings" :label="$label" :value="$value" :actionLabel="$actionLabel"
      :route="$route" />
    <x-transactions-card :title="$title" :description="$description">
      <x-transaction-item-card :label="'Penjual'" :value="$totalSeller" :variant="'info'" :icon="'account-group-outline'"
        :href="route('admin.sellers')" />
      <x-transaction-item-card :label="'Pelanggan'" :value="$totalCustomer" :variant="'success'" :icon="'account-multiple-outline'"
        :href="route('admin.customers')" />
      <x-transaction-item-card :label="'Produk'" :value="$totalProduct" :variant="'warning'" :icon="'package'"
        :href="route('admin.products')" />
      <x-transaction-item-card :label="'Pesanan'" :value="$totalOrder" :variant="'danger'" :icon="'basket-outline'"
        :href="route('admin.orders')" />
    </x-transactions-card>

    <x-bar-graph-card :height="'300'" :title="'Transaksi Bulanan Tahun Ini (' . date('Y') . ')'" :id="'monthlyOrders'" />
    <x-top-customers-card :datas="$topCustomers" :title="'Pelanggan Teratas 🎉'" :class="'col-lg-4 col-md-12 col-12'" />
    <x-top-products-card :datas="$topProducts" :title="'Produk Teratas 🎉'" :class="'col-12 col-lg-4 col-md-12'" />
    <x-top-sellers-card :datas="$topSellers" :title="'Penjual Teratas 🎉'" :class="'col-12 col-lg-4 col-md-12'" />

    <x-user-table-card :datas="$users" />
  </x-content-card>
@endsection

@push('scripts')
  <script>
    var ctx = document.getElementById('monthlyOrders');
    var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: @json($data['labels']),
        datasets: [{
            label: 'Sudah Bayar',
            data: @json($data['sudah bayar']),
            backgroundColor: 'rgba(86, 202, 0, 0.5)',
            borderColor: 'rgba(86, 202, 0, 1)',
            borderWidth: 1,
            tension: 0
          },
          {
            label: 'Belum Bayar',
            data: @json($data['belum bayar']),
            backgroundColor: 'rgba(255, 180, 0, 0.5)',
            borderColor: 'rgba(255, 180, 0, 1)',
            borderWidth: 1,
            tension: 0
          },
          {
            label: 'Kadaluarsa',
            data: @json($data['kadaluarsa']),
            backgroundColor: 'rgba(255, 76, 81, 0.5)',
            borderColor: 'rgba(255, 76, 81, 1)',
            borderWidth: 1,
            tension: 0
          },
          {
            label: 'Dibatalkan',
            data: @json($data['dibatalkan']),
            backgroundColor: 'rgba(2, 11, 12, 0.5)',
            borderColor: 'rgba(2, 11, 12, 1)',
            borderWidth: 1,
            tension: 0
          },
        ],
      },
      options: {
        transitions: {
          show: {
            animations: {
              x: {
                from: 0
              },
              y: {
                from: 0
              }
            }
          },
          hide: {
            animations: {
              x: {
                to: 0
              },
              y: {
                to: 0
              }
            }
          }
        },
        animations: {
          tension: {
            duration: 5000,
            easing: 'easeInOutCubic',
            from: .2,
            to: 0,
            loop: true
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            min: 0,
            max: 30
          }
        },
        plugins: {
          legend: {
            display: true,
            position: 'top',
            fullSize: true,
            align: 'center',
            title: {
              display: false,
              text: 'Status Pesanan',
            }
          }
        }
      }
    });
  </script>
@endpush
