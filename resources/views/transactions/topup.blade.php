@extends('layouts.app')

@section('title', 'BakulPay | Top Up')

@section('content')
    <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="btn btn-info">
            <i class="fas fa-align-left"></i>
        </button>
    </div>

    <div class="container">
        <h2>Top Up</h2>
        <div class="isi">
            <table id="myTable" class="display">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Bank Name</th>
                        <th>Customer</th>
                        <th>Account</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $counter = 1; // Inisialisasi variabel counter
                    @endphp
                    @foreach ($top_up as $data)
                        <tr>
                            <td>{{ $counter++ }}</td>
                            <td>{{ $data->status }}</td>
                            <td>{{ $data->tanggal }}</td>
                            <td>
                                @if ($data->rateMasterData)
                                    <img src="{{ $data->icons }}" alt="Bank Icon" width="30" height="30">
                                @endif
                                {{ $data->nama_bank }}
                            </td>
                            <td>{{ $data->nama }}</td>
                            <td>{{ $data->kode_bank_client }}</td>
                            <td>
                                <!-- Icon mata (eyes) untuk membuka modal -->
                                <iconify-icon icon="iconamoon:eye" data-id="{{ $data->id }}"
                                    onclick="onDetail(this)"></iconify-icon>

                                <!-- Tombol edit -->
                                <a class="btn {{ Request::is('edit-topup*') ? 'active' : '' }}"
                                    href="{{ route('edit_topup', $data->id) }}">
                                    <iconify-icon icon="akar-icons:edit"></iconify-icon>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Payment Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>ID: <span id="payment-id"></span></p>
                    <p>Date: <span id="payment-date"></span></p>
                    <p>Number Whatsapp: <span id="payment-number"></span></p>
                    <p>Customer: <span id="payment-customer"></span></p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        function onDetail(self) {
            var paymentId = $(self).data('id')

            axios.get('{{ url('get_payment_details') }}/' + paymentId)
                .then(function(res) {
                    if (res.status == 200) {
                        let data = res.data
                        console.log(data.date)
                        $('#payment-id').html(data.id)
                        $('#payment-date').html(data.date)
                        $('#payment-number').html(data.number_whatsapp)
                        $('#payment-customer').html(data.customer)

                        $('#paymentModal').modal('show')
                    }
                })
                .catch(function(error) {
                    alert('Data gagal dimuat!')
                    console.log(error);
                })
                .finally(function() {
                    // always executed
                });

        }
    </script>
@endpush
