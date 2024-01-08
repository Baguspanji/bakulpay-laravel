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
                        {{-- <span id="addBlockchain" class="plus-sign">+</span> --}}
                    </div>
                </div>

                <div class="group" id="blockchainGroup" style="display: none;">
                    <div class="label">Blockchain</div>
                    <div class="separator">:</div>
                    <div class="value">
                        <input type="text" class="form-control" id="nama_blockchain" name="nama_blockchain">
                    </div>
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

    <script>
        document.getElementById('addBlockchain').addEventListener('click', function() {
            var blockchainGroup = document.getElementById('blockchainGroup');
            blockchainGroup.style.display = 'block';
        });

        document.getElementById('type').addEventListener('change', function() {
            console.log("Type changed:", this.value);
            var withdrawFields = document.getElementById('withdrawFields');
            withdrawFields.style.display = this.value === 'Withdraw' ? 'block' : 'none';
        });
    </script>
@endsection
