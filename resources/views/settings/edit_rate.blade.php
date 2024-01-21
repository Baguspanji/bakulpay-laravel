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
                    <div class="value" id="blockchainName">{{ $namaBlockchain ? $namaBlockchain : '-' }}</div>
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
                        <input type="text" class="form-control" id="price" name="price"
                            value="{{ number_format($price, 0, ',', '.') }}" required>
                    </div>
                </div>

                <button type="submit" class="button">Save</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var priceInput = document.getElementById('price');
            var blockchainIdFromUrl = getParameterByName('blockchain_id');

            // Function untuk mendapatkan nilai parameter dari URL
            function getParameterByName(name, url = window.location.href) {
                name = name.replace(/[\[\]]/g, "\\$&");
                var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                    results = regex.exec(url);
                if (!results) return null;
                if (!results[2]) return '';
                return decodeURIComponent(results[2].replace(/\+/g, ''));
            }

            // Function untuk mendapatkan nama_blockchain berdasarkan blockchain_id
            function getBlockchainNameById(blockchainId) {
                // Lakukan request AJAX atau operasi lainnya untuk mendapatkan nama_blockchain
                // di sini sesuai dengan blockchainId
                // Contoh:
                $.ajax({
                    url: '/get-blockchain-name/' + blockchainId,
                    method: 'GET',
                    success: function(response) {
                        document.getElementById('blockchainName').innerText = response.nama_blockchain;
                    },
                    error: function(error) {
                        console.error('Error getting blockchain name:', error);
                    }
                });
            }

            // Panggil fungsi untuk mendapatkan dan menetapkan nama_blockchain saat DOM dimuat
            getBlockchainNameById(blockchainIdFromUrl);

            function formatPrice(value) {
                // Menggunakan fungsi toLocaleString untuk format angka
                return 'Rp ' + parseInt(value, 10).toLocaleString('id-ID', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 2
                });
            }

            function unformatPrice(value) {
                // Menghapus karakter non-digit
                return value.replace(/[^\d]/g, '');
            }

            function updateFormattedPrice() {
                var unformattedValue = unformatPrice(priceInput.value);
                priceInput.value = formatPrice(unformattedValue);
            }

            // Format price when the page loads
            updateFormattedPrice();

            // Update formatted price while typing
            priceInput.addEventListener('input', function() {
                updateFormattedPrice();
            });

            // Ensure correct format when submitting the form
            document.querySelector('form').addEventListener('submit', function() {
                var unformattedValue = unformatPrice(priceInput.value);
                priceInput.value = unformattedValue;
            });
        });
    </script>
@endsection
