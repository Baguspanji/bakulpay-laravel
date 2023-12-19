@extends('layouts.app')

@section('title', 'BakulPay | Edit Top Up')

@section('content')
    <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="btn btn-info">
            <i class="fas fa-align-left"></i>
        </button>
    </div>

    <div class="container">
        <h2><a href="{{ route('withdraw') }}">Withdraw</a> > Action</h2>
        <div class="isi">
            <form action="{{ route('update_withdraw', ['id' => $withdraw->id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $withdraw->id }}">

                <div class="judul_1">
                    <div class="keterangan_1">{{ \Carbon\Carbon::parse($withdraw->tanggal)->format('j M Y') }}</div>
                    <div class="nama_1">Date</div>

                </div>

                <div class="judul">
                    <div class="nama">ID Client</div>
                    <div class="keterangan">{{ $withdraw->id }}</div>
                </div>

                <div class="judul">
                    <div class="nama">Client Name</div>
                    <div class="keterangan_3">{{ $withdraw->nama }}</div>
                </div>

                <hr class="hr_edt">

                <div class="judul">
                    <div class="nama">Bank</div>
                    <div class="keterangan">{{ $withdraw->product }}</div>
                </div>

                <div class="judul">
                    <div class="nama">Email</div>
                    <div class="keterangan">{{ $withdraw->rek_client }}</div>
                </div>

                <div class="judul">
                    <div class="nama">Transaction</div>
                    <div class="keterangan">Withdraw</div>
                </div>

                <div class="judul">
                    <div class="nama">Payment</div>
                    <div class="keterangan">{{ $withdraw->nama_bank }}</div>
                </div>

                <div class="judul">
                    <div class="nama">Price</div>
                    <div class="keterangan_2">{{ $withdraw->price_rate }}</div>
                </div>

                <div class="judul">
                    <div class="nama">Quantity</div>
                    <div class="keterangan">{{ $withdraw->jumlah }}</div>
                </div>

                <div class="judul">
                    <div class="nama">Total</div>
                    <div class="keterangan_2">{{ $withdraw->total_pembayaran }}</div>
                </div>

                <div class="judul">
                    <div class="nama">Photo</div>
                    <div class="keterangan">
                        <a href="{{ asset($withdraw->bukti_pembayaran) }}" data-fancybox="withdraw-gallery"
                            data-options='{"buttons": ["zoom", "slideShow", "fullScreen", "close"], "iframe": {"preload": false, "css": {"width": "100%", "height": "100%"}}}'
                            data-caption="Bukti Pembayaran" class="view">
                            <img src="{{ asset($withdraw->bukti_pembayaran) }}" alt="withdraw Photo">
                        </a>
                    </div>
                </div>

                <hr class="hr_edt">

                <div class="judul">
                    <div class="nama">Status</div>
                    <div class="keterangan_2">
                        <select name="status">
                            <option value="Pending" @if ($withdraw->status == 'Pending') selected @endif>Pending</option>
                            <option value="Success" @if ($withdraw->status == 'Success') selected @endif>Success</option>
                            <option value="Failed" @if ($withdraw->status == 'Failed') selected @endif>Failed</option>
                        </select>
                    </div>
                </div>

                <div class="judul">
                    <div class="nama">Upload Photo</div>
                    <div class="keterangan"><input type="file" class="upload_foto" id="bukti_tf" name="bukti_tf" accept="image/*" required></div>
                </div>

                <button type="submit" class="button">Save</button>
            </form>
        </div>
    </div>



    <script>
        $(document).ready(function() {
            $("[data-fancybox]").fancybox();
        });
    </script>
    <script>
        $(document).ready(function() {
            // Loop through each element with class "keterangan_2"
            $(".keterangan_3").each(function() {
                // Check if the content is empty or consists only of whitespace
                if (!$(this).text().trim()) {
                    // Replace empty content with a hyphen
                    $(this).text("-");
                }
            });
        });
    </script>




@endsection
