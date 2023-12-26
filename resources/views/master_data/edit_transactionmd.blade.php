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
            <form action="{{ route('update_transactionmd', ['id' => $rate->id]) }}" method="post"
                enctype="multipart/form-data">
                @csrf

                <div class="group">
                    <div class="label">Bank Name</div>
                    <div class="separator">:</div>
                    <div class="value">
                        <input type="text" class="form-control" id="nama_bank" name="nama_bank"
                            value="{{ old('nama_bank', $rate->nama_bank) }}" required>
                    </div>
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
                                value="{{ old('nama', $rate->nama) }}">
                        </div>
                    </div>
                    <div class="group">
                        <div class="label">No Rekening</div>
                        <div class="separator">:</div>
                        <div class="value">
                            <input type="text" class="form-control" id="no_rekening" name="no_rekening"
                                value="{{ old('no_rekening', $rate->no_rekening) }}">
                        </div>
                    </div>
                </div>

                <button type="submit" class="button">Save</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var typeSelect = document.getElementById('type');
            var withdrawFields = document.getElementById('withdrawFields');

            function toggleWithdrawFields() {
                withdrawFields.style.display = typeSelect.value === 'Withdraw' ? 'block' : 'none';
            }

            toggleWithdrawFields(); // Panggil fungsi ini saat halaman dimuat

            typeSelect.addEventListener('change', toggleWithdrawFields);
        });
    </script>
@endsection
