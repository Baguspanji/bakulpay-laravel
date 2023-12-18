@extends('layouts.app')

@section('title', 'BakulPay | Edit Top Up')

@section('content')
    <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="btn btn-info">
            <i class="fas fa-align-left"></i>
        </button>
    </div>

    <div class="container">
        <h2><a href="{{ route('topup') }}">Top Up</a> > Action</h2>
        <div class="isi">
            <form action="{{ route('update_topup', ['id' => $topup->id]) }}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{ $topup->id }}">

                <div class="judul">
                    <div class="nama">ID Client</div>
                    <div class="keterangan">{{ $topup->id }}</div>
                </div>

                <div class="judul">
                    <div class="nama">Client Name</div>
                    <div class="keterangan">{{ $topup->nama }}</div>
                </div>

                <div class="judul_1">
                    <div class="nama_1">Date</div>
                    <div class="keterangan_1">{{ $topup->tanggal }}</div>
                </div>

                <hr class="hr_edt">

                <div class="judul">
                    <div class="nama">Bank</div>
                    <div class="keterangan">Pending</div>
                </div>

                <div class="judul">
                    <div class="nama">Email</div>
                    <div class="keterangan">{{ $topup->rek_client }}</div>
                </div>

                <div class="judul">
                    <div class="nama">Transaction</div>
                    <div class="keterangan">Top Up</div>
                </div>

                <div class="judul">
                    <div class="nama">Payment</div>
                    <div class="keterangan">{{ $topup->nama_bank }}</div>
                </div>

                <div class="judul">
                    <div class="nama">Price</div>
                    <div class="keterangan">Pending</div>
                </div>

                <div class="judul">
                    <div class="nama">Quantity</div>
                    <div class="keterangan">{{ $topup->jumlah }}</div>
                </div>

                <div class="judul">
                    <div class="nama">Total</div>
                    <div class="keterangan">{{ $topup->total_pembayaran }}</div>
                </div>

                <hr class="hr_edt">

                <div class="judul">
                    <div class="nama">Status</div>
                    <div class="keterangan">Pending</div>
                </div>

                <div class="judul">
                    <div class="nama">Photo</div>
                    <div class="keterangan">Pending</div>
                </div>


                <button type="submit" class="button">Save</button>
            </form>
        </div>
    </div>
@endsection
