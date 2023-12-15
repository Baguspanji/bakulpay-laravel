@extends('layouts.app')

@section('title', 'BakulPay | Payment')

@section('content')
    <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="btn btn-info">
            <i class="fas fa-align-left"></i>
        </button>
    </div>

    <div class="container">
        <h2><a href="{{ route('payment') }}">Payment</a> > Add New</h2>
        <div class="isi">
            <form action="{{ route('submit.form_payment') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="group">
                    <div class="label">Tanggal</div>
                    <div class="separator">:</div>
                    <div class="value"><input type="date" class="form-control" id="tanggal" name="tanggal" required>
                    </div>
                </div>

                <div class="group">
                    <div class="label">Number Whatsapp</div>
                    <div class="separator">:</div>
                    <div class="value"><input type="text" class="form-control" id="number_whatsapp" name="number_whatsapp" required>
                    </div>
                </div>

                <div class="group">
                    <div class="label">Customer</div>
                    <div class="separator">:</div>
                    <div class="value"><input type="text" class="form-control" id="customer" name="customer" required>
                    </div>
                </div>

                <button type="submit" class="button">Save</button>
            </form>
        </div>
    </div>
@endsection
