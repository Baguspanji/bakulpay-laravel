@extends('layouts.app')

@section('title', 'BakulPay | Payment')

@section('content')
    <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="btn btn-info">
            <i class="fas fa-align-left"></i>
        </button>
    </div>

    <div class="container">
        <h2>Payment</h2>
        <a class="add {{ Request::is('form_payment*') ? 'active' : '' }}" href="{{ url('/form_payment') }}" role="button">+
            Add New</a>
        <div class="isi">
            <!-- Tabel -->
            <table id="myTable" class="display">
                <!-- Header Tabel -->
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Number Whatsapp</th>
                        <th>Customer</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <!-- Body Tabel -->
                <tbody>
                    @php
                        $counter = 1;
                    @endphp
                    @foreach ($payment as $data)
                        <tr data-row-id="{{ $data->id }}" class="{{ $data->hidden ? 'hidden-row' : '' }}">
                            <td>{{ $counter++ }}</td>
                            <td>{{ $data->tanggal }}</td>
                            <td>{{ $data->number_whatsapp }}</td>
                            <td>{{ $data->customer }}</td>
                            <td>
                                <!-- Icon mata (eyes) untuk membuka modal -->
                                <iconify-icon icon="iconamoon:eye" data-id="{{ $data->id }}"
                                    onclick="onDetail(this)"></iconify-icon>
                                <!-- Tombol edit -->
                                <a class="btn {{ Request::is('edit-payment*') ? 'active' : '' }}"
                                    href="{{ route('edit_payment', $data->id) }}">
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
        $(document).ready(function() {
            $('.open-payment-modal').on('click', function() {
                var paymentId = $(this).data('tanggal'); // Ganti ini menjadi data-tanggal
                $.ajax({
                    url: '/get_payment_details/' +
                        paymentId, // Sesuaikan URL dengan endpoint yang sesuai
                    type: 'GET',
                    success: function(data) {
                        // Log data yang diterima dari server
                        console.log('Data diterima dari server:', data);

                        // Parse data JSON
                        try {
                            var paymentData = JSON.parse(data);

                            // Log data yang sudah diparsing
                            console.log('Data yang sudah diparsing:', paymentData);

                            // Periksa apakah properti yang diperlukan ada
                            if ('id' in paymentData && 'date' in paymentData &&
                                'number_whatsapp' in paymentData && 'customer' in paymentData) {
                                // Perbarui konten modal-body
                                $('#payment-id').text(paymentData.id);
                                $('#payment-date').text(paymentData.date);
                                $('#payment-number').text(paymentData.number_whatsapp);
                                $('#payment-customer').text(paymentData.customer);

                                // Buka modal
                                $('#paymentModal').modal('show');
                            } else {
                                console.error(
                                    'Struktur JSON tidak valid: Properti yang diperlukan tidak ada'
                                );
                                alert(
                                    'Struktur JSON tidak valid: Properti yang diperlukan tidak ada'
                                );
                            }
                        } catch (e) {
                            console.error('Error parsing data JSON:', e);
                            alert('Error parsing detail pembayaran');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error mengambil detail pembayaran:', error);
                        alert('Error mengambil detail pembayaran');
                    }
                });
            });
        });

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
