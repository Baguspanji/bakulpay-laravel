@extends('layouts.app')

@section('title', 'BakulPay | Payment MD')

@section('content')
    <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="btn btn-info">
            <i class="fas fa-align-left"></i>
        </button>
    </div>

    <div class="container">
        <h2><a href="{{ route('bank_wd') }}">Bank Withdraw</a> > Add New</h2>
        <div class="isi">
            <form action="{{ route('submit.form_bankwd') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="group">
                    <div class="label">Bank Name</div>
                    <div class="separator">:</div>
                    <div class="value"><input type="text" class="form-control" id="nama_bank" name="nama_bank" required>
                    </div>
                </div>

                <div class="group">
                    <div class="label">Icons</div>
                    <div class="separator">:</div>
                    <div class="value">
                        <input type="file" class="form-control-file" id="icons" name="icons" accept="image/*" required>
                    </div>
                </div>

                <button type="submit" class="button">Save</button>
            </form>
        </div>
    </div>
@endsection
