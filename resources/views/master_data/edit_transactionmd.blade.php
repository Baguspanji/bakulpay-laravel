@extends('layouts.app')

@section('title', 'BakulPay | Transaction MD')

@section('content')
    <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="btn btn-info">
            <i class="fas fa-align-left"></i>
        </button>
    </div>

    <div class="container">
        <h2><a href="{{ route('transactionmd') }}">Transaction Master Data</a> > Edit</h2>
        <div class="isi">
            <form
                action="{{ route('update_transactionmd', ['id' => $rate->id, 'blockchain_id' => request('blockchain_id')]) }}"
                method="post" enctype="multipart/form-data">
                @csrf

                <div class="group" id="bankGroup">
                    <div class="label">Bank Name</div>
                    <div class="separator">:</div>
                    <div class="value">
                        <input type="text" class="form-control" id="nama_bank" name="nama_bank"
                            value="{{ old('nama_bank', $rate->nama_bank) }}" required>
                    </div>
                    <a href="#" class="btn_1" id="addBankBlockchainBtn" disabled>Add Blockchain</a>
                </div>

                <div id="blockchainFieldsContainer"> <!-- Container untuk menyimpan input blockchain dinamis -->
                    <input type="hidden" name="blockchain_id" value="{{ request('blockchain_id') }}">

                </div>


                <div class="group">
                    <div class="label">Type</div>
                    <div class="separator">:</div>
                    <div class="value">
                        <select class="form-control" id="type" name="type" required>
                            <option value="Top Up" {{ old('type', $rate->type) == 'Top Up' ? 'selected' : '' }}>Top Up
                            </option>
                            <option value="Withdraw" {{ old('type', $rate->type) == 'Withdraw' ? 'selected' : '' }}>Withdraw
                            </option>
                        </select>
                    </div>
                </div>

                <div class="group">
                    <div class="label">Icons</div>
                    <div class="separator">:</div>
                    <div class="value">
                        <input type="file" class="form-control-file" id="icons" name="icons" accept="image/*">
                        @if ($rate->icons)
                            <img src="{{ $rate->icons }}" alt="Current Icon" width="30" height="30">
                        @endif
                    </div>
                </div>

                <div id="withdrawFields"
                    style="{{ old('type', $rate->type) == 'Withdraw' ? 'display: block;' : 'display: none;' }}">
                    <div class="group">
                        <div class="label">Nama</div>
                        <div class="separator">:</div>
                        <div class="value">
                            <input type="text" class="form-control" id="nama" name="nama"
                                value="{{ old('nama', $rate->nama) }}"
                                {{ old('type', $rate->type) == 'Withdraw' && count($rate->blockchains) > 0 ? 'disabled' : '' }}>
                        </div>
                    </div>
                    <div class="group">
                        <div class="label">No Rekening</div>
                        <div class="separator">:</div>
                        <div class="value">
                            @if (old('type', $rate->type) == 'Withdraw' && count($rate->blockchains) > 0)
                                <!-- Jika ada nama blockchain, ambil dari tabel blockchain -->
                                <input type="text" class="form-control" id="no_rekening" name="no_rekening"
                                    value="{{ old('no_rekening', $rate->blockchains[0]->rekening_wallet) }}">
                            @else
                                <!-- Jika tidak ada nama blockchain, ambil dari tabel rate_master_data -->
                                <input type="text" class="form-control" id="no_rekening" name="no_rekening"
                                    value="{{ old('no_rekening', $rate->no_rekening) }}">
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Bagian lain dari formulir Anda -->

                <button type="submit" class="button">Save</button>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Variable untuk melacak apakah tombol "Tambah Blockchain" telah diklik
            var blockchainButtonClicked = false;

            // Mengambil nilai blockchain_id dari URL
            var blockchainIdFromUrl = getParameterByName('blockchain_id');

            // Function untuk mendapatkan nilai parameter dari URL
            function getParameterByName(name, url = window.location.href) {
                name = name.replace(/[\[\]]/g, "\\$&");
                var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                    results = regex.exec(url);
                if (!results) return null;
                if (!results[2]) return '';
                return decodeURIComponent(results[2].replace(/\+/g, ' '));
            }

            function addBankBlockchainField() {
                if (!blockchainButtonClicked) {
                    var blockchainGroup = $('<div class="group">' +
                        '<div class="label">Nama Blockchain</div>' +
                        '<div class="separator">:</div>' +
                        '<div class="value">' +
                        '<input type="text" class="form-control" name="nama_blockchain[]" required>' +
                        '</div>' +
                        '<a href="#" class="btn_1 remove-blockchain-field">X</a>' +
                        '</div>');

                    // Set nilai nama_blockchain sesuai dengan blockchain_id dari URL
                    if (blockchainIdFromUrl && $('#blockchainFieldsContainer').find('[data-blockchain-id="' +
                            blockchainIdFromUrl + '"]').length === 0) {
                        var blockchainInput = blockchainGroup.find('input[name="nama_blockchain[]"]');
                        blockchainInput.val(blockchainIdFromUrl);
                        blockchainGroup.attr('data-blockchain-id', blockchainIdFromUrl);

                        // Set label text to "Nama Blockchain"
                        blockchainGroup.find('.label').text('Nama Blockchain');

                        $('#blockchainFieldsContainer').append(blockchainGroup);
                    }

                    // Nonaktifkan input "Nama" jika jenis (Type) adalah 'Withdraw' dan ada field blockchain
                    updateNamaFieldStatus();

                    // Nonaktifkan tombol "Tambah Blockchain" setelah ditambahkan satu kali
                    blockchainButtonClicked = true;
                    $('#addBankBlockchainBtn').prop('disabled', true);
                }
            }


            // Panggil fungsi untuk menambahkan bidang blockchain
            addBankBlockchainField();

            function updateNamaFieldStatus() {
                if ($('#type').val() === 'Withdraw' && $('#blockchainFieldsContainer .group').length > 0) {
                    $('#withdrawFields #nama').prop('disabled', true);
                } else {
                    $('#withdrawFields #nama').prop('disabled', false);
                }
            }

            // Event handler untuk tombol "+" terkait "Bank Name"
            $('#addBankBlockchainBtn').on('click', function(e) {
                e.preventDefault();
                addBankBlockchainField();
            });

            // Event handler untuk tombol "-" pada bidang Blockchain yang ditambahkan secara dinamis
            $(document).on('click', '.remove-blockchain-field', function(e) {
                e.preventDefault();
                $(this).closest('.group').remove();
                updateNamaFieldStatus();
                // Aktifkan kembali tombol "Tambah Blockchain" setelah menghapus blockchain field
                blockchainButtonClicked = false;
                $('#addBankBlockchainBtn').prop('disabled', false);
            });

            // Event handler untuk perubahan pilihan jenis
            $('#type').on('change', function() {
                if ($(this).val() === 'Withdraw') {
                    $('#withdrawFields').show();
                } else {
                    $('#withdrawFields').hide();
                }
                updateNamaFieldStatus();
            });
        });
    </script>
@endsection
