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
                                <iconify-icon icon="iconamoon:eye" class="open-payment-modal"
                                    data-payment-id="{{ $data->id }}" data-toggle="modal"
                                    data-target="#paymentModal"></iconify-icon>
                                <!-- Tombol edit -->
                                <a class="btn {{ Request::is('edit-payment*') ? 'active' : '' }}"
                                    href="{{ route('edit_payment', ['id' => $data->id]) }}">
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


    <script>
        $(document).ready(function() {
            $('.open-payment-modal').on('click', function() {
                var paymentId = $(this).data('payment-id');
                $.ajax({
                    url: '/get_payment_details/' + paymentId,
                    type: 'GET',
                    success: function(data) {
                        // Log the data received from the server
                        console.log('Data received from server:', data);

                        // Parse the JSON data
                        try {
                            var paymentData = JSON.parse(data);

                            // Log the parsed data
                            console.log('Parsed data:', paymentData);

                            // Update modal-body content
                            $('#payment-id').text(paymentData.id);
                            $('#payment-date').text(paymentData.date);
                            $('#payment-number').text(paymentData.number_whatsapp);
                            $('#payment-customer').text(paymentData.customer);

                            // Open the modal
                            $('#paymentModal').modal('show');
                        } catch (e) {
                            console.error('Error parsing JSON data:', e);
                            alert('Error parsing payment details');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching payment details:', error);
                        alert('Error fetching payment details');
                    }
                });
            });
        });
    </script>



@endsection
