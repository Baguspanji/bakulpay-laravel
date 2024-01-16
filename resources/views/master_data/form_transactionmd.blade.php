{{-- @extends('layouts.app')

@section('title', 'BakulPay | Transaction MD')

@section('content')
    <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="btn btn-info">
            <i class="fas fa-align-left"></i>
        </button>
    </div>

    <div class="container">
        <h2><a href="{{ route('transactionmd') }}">Transaction Master Data</a> > Add New</h2>
        <div class="isi">
            <form action="{{ route('submit.form_transactionmd') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="group" id="bankGroup">
                    <div class="label">Bank Name</div>
                    <div class="separator">:</div>
                    <div class="value">
                        <input type="text" class="form-control" id="nama_bank" name="nama_bank" required>
                    </div>
                    <a href="#" class="btn_1" id="addBankBlockchainBtn">Tambah Blockchain</a>
                </div>

                <div id="blockchainFieldsContainer"> <!-- Container untuk menyimpan input blockchain dinamis -->
                    <!-- Daftar blockchain akan ditambahkan di sini -->
                </div>

                <div class="group">
                    <div class="label">Type</div>
                    <div class="separator">:</div>
                    <div class="value">
                        <select class="form-control" id="type" name="type" required>
                            <option value="Top Up">Top Up</option>
                            <option value="Withdraw">Withdraw</option>
                        </select>
                    </div>
                </div>

                <div class="group">
                    <div class="label">Icons</div>
                    <div class="separator">:</div>
                    <div class="value">
                        <input type="file" class="form-control-file" id="icons" name="icons" accept="image/*"
                            required>
                    </div>
                </div>

                <div id="withdrawFields" style="display: none;">
                    <div class="group">
                        <div class="label">Nama</div>
                        <div class="separator">:</div>
                        <div class="value">
                            <input type="text" class="form-control" id="nama" name="nama">
                        </div>
                    </div>
                    <div class="group">
                        <div class="label">No Rekening</div>
                        <div class="separator">:</div>
                        <div class="value">
                            <input type="text" class="form-control" id="no_rekening" name="no_rekening">
                        </div>
                    </div>
                </div>

                <button type="submit" class="button">Submit</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            function toggleBlockchainInput() {
                var blockchainGroup = $('<div class="group">' +
                    '<div class="label">Blockchain</div>' +
                    '<div class="separator">:</div>' +
                    '<div class="value">' +
                    '<input type="text" class="form-control" name="nama_blockchain[]">' +
                    '</div>' +
                    '<a href="#" class="btn_1 remove-blockchain-field">-</a>' +
                    '</div>');

                $('#blockchainFieldsContainer').append(blockchainGroup);

                // Periksa jenis (Type) saat menambahkan Blockchain
                if ($('#type').val() === 'Withdraw' && $('#blockchainFieldsContainer .group').length > 0) {
                    $('#withdrawFields #nama').parent('.group').hide(); // Menyembunyikan form "Nama"
                } else {
                    $('#withdrawFields #nama').parent('.group').show();
                }

                // Selalu menampilkan form "No Rekening"
                $('#withdrawFields #no_rekening').parent('.group').show();
            }

            function addBankBlockchainField() {
                toggleBlockchainInput(); // Menunjukkan bidang input Blockchain
            }

            // Event handler untuk tombol "+" terkait "Bank Name"
            $('#addBankBlockchainBtn').on('click', function(e) {
                e.preventDefault();
                addBankBlockchainField();
            });

            // Event handler untuk tombol "-" pada bidang Blockchain yang ditambahkan secara dinamis
            $(document).on('click', '.remove-blockchain-field', function(e) {
                e.preventDefault();
                $(this).parent().remove(); // Hapus bidang Blockchain yang sesuai
            });

            // Event handler untuk perubahan pilihan jenis
            $('#type').on('change', function() {
                if ($(this).val() === 'Withdraw') {
                    $('#withdrawFields').show();
                    if ($('#blockchainFieldsContainer .group').length > 0) {
                        // Jika ada Blockchain, sembunyikan form "Nama"
                        $('#withdrawFields #nama').parent('.group').hide();
                    }
                } else {
                    $('#withdrawFields').hide();
                }
            });
        });
    </script>

@endsection --}}

@extends('layouts.app')

@section('title', 'BakulPay | Transaction MD')

@section('content')
    <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="btn btn-info">
            <i class="fas fa-align-left"></i>
        </button>
    </div>

    <div class="container">
        <h2><a href="{{ route('transactionmd') }}">Transaction Master Data</a> > Add New</h2>
        <div class="isi">
            <form action="{{ route('submit.form_transactionmd') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="group" id="bankGroup">
                    <div class="label">Bank Name</div>
                    <div class="separator">:</div>
                    <div class="value">
                        <input type="text" class="form-control" id="nama_bank" name="nama_bank" required>
                    </div>
                    <a href="#" class="btn_1" id="addBankBlockchainBtn" disabled>Add Blockchain</a>
                </div>

                <div id="blockchainFieldsContainer"> <!-- Container untuk menyimpan input blockchain dinamis -->
                    <!-- Daftar blockchain akan ditambahkan di sini -->
                </div>

                <div class="group">
                    <div class="label">Type</div>
                    <div class="separator">:</div>
                    <div class="value">
                        <select class="form-control" id="type" name="type" required>
                            <option value="Top Up">Top Up</option>
                            <option value="Withdraw">Withdraw</option>
                        </select>
                    </div>
                </div>

                <div class="group">
                    <div class="label">Icons</div>
                    <div class="separator">:</div>
                    <div class="value">
                        <input type="file" class="form-control-file" id="icons" name="icons" accept="image/*"
                            required>
                    </div>
                </div>

                <div id="withdrawFields" style="display: none;">
                    <div class="group">
                        <div class="label">Name</div>
                        <div class="separator">:</div>
                        <div class="value">
                            <input type="text" class="form-control" id="nama" name="nama">
                        </div>
                    </div>
                    <div class="group">
                        <div class="label">No Rekening</div>
                        <div class="separator">:</div>
                        <div class="value">
                            <input type="text" class="form-control" id="no_rekening" name="no_rekening">
                        </div>
                    </div>
                </div>

                <button type="submit" class="button">Submit</button>
            </form>
        </div>
    </div>

    {{-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> --}}
    <script>
        $(document).ready(function() {
            // Variable untuk melacak apakah tombol "Tambah Blockchain" telah diklik
            var blockchainButtonClicked = false;

            function addBankBlockchainField() {
                if (!blockchainButtonClicked) {
                    var blockchainGroup = $('<div class="group">' +
                        '<div class="label">Blockchain</div>' +
                        '<div class="separator">:</div>' +
                        '<div class="value">' +
                        '<input type="text" class="form-control" name="nama_blockchain[]" required>' +
                        '</div>' +
                        '<a href="#" class="btn_1 remove-blockchain-field">X</a>' +
                        '</div>');

                    $('#blockchainFieldsContainer').append(blockchainGroup);

                    // Nonaktifkan input "Nama" jika jenis (Type) adalah 'Withdraw' dan ada field blockchain
                    updateNamaFieldStatus();

                    // Nonaktifkan tombol "Tambah Blockchain" setelah ditambahkan satu kali
                    blockchainButtonClicked = true;
                    $('#addBankBlockchainBtn').prop('disabled', true);
                }
            }

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
