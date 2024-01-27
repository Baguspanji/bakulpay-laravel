@extends('layouts.app')

@section('title', 'BakulPay | Edit Rate')

@section('content')
    <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="btn btn-info">
            <i class="fas fa-align-left"></i>
        </button>
    </div>

    <div class="container">
        <h2><a href="{{ route('rate') }}">Rate</a> > Edit</h2>
        <div class="isi">
            <form action="{{ route('update_rate', ['id' => $rate->id]) }}" method="post">
                @csrf
                <div class="group">
                    <div class="label">Bank Name</div>
                    <div class="separator">:</div>
                    <div class="value1"><img src="{{ $rate->icons }}" alt="icons">{{ $rate->nama_bank }}</div>
                </div>

                <div class="group">
                    <div class="label">Blockchain Name</div>
                    <div class="separator">:</div>
                    <div class="value">
                        @php
                            $blockchainIdFromUrl = request()->input('blockchain_id');
                            $biaya_transaksi = $blockchainIdFromUrl ? \App\Models\Blockchain::where('nama_blockchain', $blockchainIdFromUrl)->value('biaya_transaksi') : $rate->biaya_transaksi;
                            $blockchainNameToShow = $blockchainIdFromUrl ?: '-';
                        @endphp
                        {{ $blockchainNameToShow }}
                        <input type="hidden" name="blockchain_id" value="{{ $blockchainIdFromUrl }}">
                    </div>
                </div>

                <div class="group">
                    <div class="label">Type</div>
                    <div class="separator">:</div>
                    <div class="value">{{ $rate->type }}</div>
                </div>

                <div class="group">
                    <div class="label">Price</div>
                    <div class="separator">:</div>
                    <div class="value">
                        <input type="text" name="price" id="price_input"
                            value="Rp {{ number_format($rate->price, 0, ',', '.') }}" class="form-control"
                            oninput="formatCurrency(this, 'numeric_price')">
                        <input type="hidden" name="numeric_price" id="numeric_price" value="{{ $rate->price }}">
                    </div>
                </div>

                <div class="group">
                    <div class="label">Cost Transaction</div>
                    <div class="separator">:</div>
                    <div class="value">
                        <input type="text" name="biaya_transaksi"
                            value="Rp {{ number_format($biaya_transaksi, 0, ',', '.') }}" class="form-control"
                            id="biaya_transaksi" oninput="formatCurrency(this, 'numeric_biaya_transaksi')">
                        <input type="hidden" name="numeric_biaya_transaksi" id="numeric_biaya_transaksi"
                            value="{{ $biaya_transaksi }}">
                    </div>
                </div>

                <button type="submit" class="button">Save</button>
            </form>
        </div>
    </div>

    <script>
        function formatCurrency(input, targetFieldId) {
            const numericValue = input.value.replace(/[^\d]/g, '');
            const formattedValue = new Intl.NumberFormat('id-ID').format(parseInt(numericValue, 10));
            const valueWithComma = formattedValue.replace(/\./g, '.');
            input.value = `Rp ${valueWithComma}`;

            // Update hidden input with numeric value
            document.getElementById(targetFieldId).value = numericValue;

            // Log the value sent to the server
            console.log(`Value sent to the server for ${targetFieldId}:`, numericValue);
        }

        // Call the function for the "biaya_transaksi" and "Price" fields
        formatCurrency(document.getElementById('biaya_transaksi'), 'numeric_biaya_transaksi');
        formatCurrency(document.getElementById('price_input'), 'numeric_price');
    </script>

@endsection
