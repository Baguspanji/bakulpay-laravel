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

                <div class="group">
                    <div class="label">Bank Name</div>
                    <div class="separator">:</div>
                    <div class="value">
                        <input type="text" class="form-control" id="nama_bank" name="nama_bank" required>
                    </div>

                    <!-- Tambahkan ini sebelum formulir -->
                    <button type="button" id="addBlockchain" class="btn btn-success">Tambah Blockchain</button>

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

                <div id="blockchainsContainer"></div>

                <div id="blockchainTemplate" style="display: none;">
                    <div class="group">
                        <div class="label">Blockchain Name</div>
                        <div class="separator">:</div>
                        <div class="value">
                            <input type="text" class="form-control" name="blockchain_name[]" required>
                        </div>
                    </div>
                </div>

                <button type="submit" class="button">Submit</button>
            </form>
        </div>
    </div>

    <!-- Tambahkan jQuery dari CDN -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        document.getElementById('type').addEventListener('change', function() {
            console.log("Type changed:", this.value);
            var withdrawFields = document.getElementById('withdrawFields');
            withdrawFields.style.display = this.value === 'Withdraw' ? 'block' : 'none';
        });
    </script>
    <script>
        $(document).ready(function() {
            var counter = 1;

            $("#addBlockchain").click(function() {
                var newBlockchainGroup = $("#blockchainTemplate").clone();
                newBlockchainGroup.attr("id", "blockchainGroup" + counter);
                newBlockchainGroup.find("input").each(function() {
                    $(this).attr("name", $(this).attr("name") + counter);
                });

                newBlockchainGroup.appendTo("#blockchainsContainer");
                counter++;
            });

            $("#type").change(function() {
                var withdrawFields = $("#withdrawFields");
                withdrawFields.toggle(this.value === 'Withdraw');
            });
        });
    </script>

@endsection
