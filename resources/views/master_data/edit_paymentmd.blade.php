@extends('layouts.app')

@section('title', 'BakulPay | Transaction MD')

@section('content')
    <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="btn btn-info">
            <i class="fas fa-align-left"></i>
        </button>
    </div>

    <div class="container">
        <h2><a href="{{ route('pay_md') }}">Payment Master Data</a> > Edit</h2>
        <div class="isi">
            <form action="{{ route('update_paymentmd', ['id' => $paymentMD->id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                
                <div class="group">
                    <div class="label">Bank Name</div>
                    <div class="separator">:</div>
                    <div class="value">
                        <input type="text" class="form-control" id="nama_bank" name="nama_bank"
                            value="{{ old('nama_bank', $paymentMD->nama_bank) }}" required>
                    </div>
                </div>

                <div class="group">
                    <div class="label">No.Rek</div>
                    <div class="separator">:</div>
                    <div class="value">
                        <input type="text" class="form-control" id="no_rekening" name="no_rekening"
                            value="{{ old('no_rekening', $paymentMD->no_rekening) }}" required>
                    </div>
                </div>

                <div class="group">
                    <div class="label">Name</div>
                    <div class="separator">:</div>
                    <div class="value">
                        <input type="text" class="form-control" id="nama" name="nama"
                            value="{{ old('nama', $paymentMD->nama) }}" required>
                    </div>
                </div>

                <div class="group">
                    <div class="label">Icons</div>
                    <div class="separator">:</div>
                    <div class="value">
                        <input type="file" class="form-control-file" id="icons" name="icons" accept="image/*">
                        @if ($paymentMD->icons)
                            <img src="{{ $paymentMD->icons }}" alt="Current Icon" width="30" height="30">
                        @endif
                    </div>
                </div>

                <button type="submit" class="button">Save</button>
            </form>
        </div>
    </div>
@endsection
