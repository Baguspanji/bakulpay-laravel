@extends('layouts.app')

@section('title', 'BakulPay | Top Up')

@section('content')
    <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="btn btn-info">
            <i class="fas fa-align-left"></i>
        </button>
    </div>

    <div class="container">
        <h2>Withdraw</h2>
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
                    @foreach ($withdraw as $data)
                        <tr>
                            <td>{{ $counter++ }}</td>
                            <td class="status-{{ strtolower(str_replace(' ', '-', $data->status)) }}">
                                <p class="stats">{{ $data->status }}</p>
                            </td>
                            <td>{{ $data->tanggal }}</td>
                            <td>
                                @if ($data->rateMasterData)
                                    <img src="{{ asset('storage/' . $data->rateMasterData->icons) }}" alt="Bank Icon"
                                        width="30" height="30">
                                @endif
                                {{ $data->nama_bank }}
                            </td>
                            <td>{{ $data->nama }}</td>
                            <td>{{ $data->rek_client }}</td>
                            <td>
                                <!-- Tombol edit -->
                                <a class="btn {{ Request::is('edit-withdraw*') ? 'active' : '' }}"
                                    href="{{ route('edit_withdraw', $data->id) }}">
                                    <iconify-icon icon="akar-icons:edit"></iconify-icon>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
                .finally(function() {});
        }
    </script>

    <script>
        $(document).ready(function() {
            $(".isi tbody td:nth-child(5)").each(function() {
                if (!$(this).text().trim()) {
                    $(this).text("-");
                }
            });
        });
    </script>
@endpush
