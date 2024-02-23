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
                            <td class="status-{{ strtolower(str_replace(' ', '-', $data->status)) }}">
                                <p class="stats">{{ $data->status }}</p>
                            </td>
                            <td>{{ $data->tanggal }}</td>
                            <td>
                                @if ($data->rateMasterData)
                                    <img src="{{ $data->icons }}" alt="Bank Icon" width="30" height="30">
                                @endif
                                {{ $data->nama_bank }}
                            </td>
                            <td>{{ $data->nama }}</td>
                            <td>{{ $data->rek_client }}</td>
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
                {{-- <div class="modal-header"> --}}
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{-- </div> --}}

                <div class="modal-body">
                    {{-- <p>ID: <span id="payment-id"></span></p>
                    <p>Date: <span id="payment-date"></span></p>
                    <p>Number Whatsapp: <span id="payment-number"></span></p>
                    <p>Customer: <span id="payment-customer"></span></p> --}}
                    {{-- <div class="judul_1">
                        <div class="keterangan_1"><span id="payment-date"></span></div>
                        <div class="nama_1">Date</div> --}}
                    {{-- kiri --}}
                    {{-- </div> --}}



                    <div class="judul">
                        <div class="nama">No ID</div>
                        <div class="keterangan"><span id="payment-id"></span></div>
                    </div>

                    <div class="judul">
                        <div class="nama_1">Date</div>
                        <div class="keterangan_3"><span id="payment-date"></span></div>
                    </div>

                    <div class="judul">
                        <div class="nama">Client Name</div>
                        <div class="keterangan_2"><span id="payment-nama"></span></div>
                    </div>

                    <div class="judul">
                        <div class="nama_1">Status</div>
                        <div class="keterangan_1"><span id="payment-status"></span></div>
                    </div>

                    <hr class="hr_edti">

                    <div class="judul_2">
                        <div class="nama">Bank</div>
                        <div class="keterangan"><span id="payment-namabank"></div>
                    </div>

                    <div class="judul_2">
                        <div class="nama_1">Photo</div>
                        <div class="keterangan_4"><span id="payment-buktipembayaran"></div>
                    </div>

                    <div class="judul_3">
                        <div class="nama">Email</div>
                        <div class="keterangan_2"><span id="payment-rekclient"></div>
                    </div>



                    <div class="judul_4">
                        <div class="nama">Number Transaction</div>
                        <div class="keterangan_2"><span id="payment-idpembayaran"></div>
                    </div>

                    <div class="judul_5">
                        <div class="nama">Transaction</div>
                        <div class="keterangan_2">Top-Up</div>
                    </div>

                   {{--  <div class="judul_1">
                        <div class="nama">Payment</div>
                        <div class="keterangan"><span id="payment-product"></div>
                    </div>

                    <div class="judul_1">
                        <div class="nama">Price</div>
                        <div class="keterangan"><span id="payment-pricerate"></div>
                    </div>

                    <div class="judul_1">
                        <div class="nama">Quantity</div>
                        <div class="keterangan"><span id="payment-jumlah"></div>
                    </div> --}}

                    {{-- <hr class="hr_edti"> --}}

                    {{-- <div class="judul">
                        <div class="nama">Total</div>
                        <div class="keterangan"><span id="payment-totalpembayaran"></div>
                    </div> --}}

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
                        $('#payment-userid').html(data.user_id)
                        $('#payment-idpembayaran').html(data.id_pembayaran)
                        $('#payment-date').html(data.date)
                        $('#payment-rekclient').html(data.rek_client)
                        $('#payment-jumlah').html(data.jumlah)
                        $('#payment-totalpembayaran').html(data.total_pembayaran)
                        $('#payment-namabank').html(data.nama_bank)
                        $('#payment-nama').html(data.nama ? data.nama : '-');
                        $('#payment-buktipembayaran').html('<img src="' + data.bukti_pembayaran +
                            '" alt="Payment Image">')
                        $('#payment-product').html(data.product)
                        $('#payment-pricerate').html(data.price_rate)
                        $('#payment-status').html(data.status)
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
