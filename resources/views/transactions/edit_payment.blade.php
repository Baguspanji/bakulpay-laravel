@extends('layouts.app')

@section('title', 'BakulPay | Edit Payment')

@section('content')
    <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="btn btn-info">
            <i class="fas fa-align-left"></i>
        </button>
    </div>

    <div class="container">
        <h2><a href="{{ route('payment') }}">Payment</a> > Edit</h2>
        <div class="isi">
            <form action="{{ route('update_payment', ['id' => $payment->id]) }}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{ $payment->id }}">

                <div class="group">
                    <div class="label">Tanggal</div>
                    <div class="separator">:</div>
                    <div class="value">
                        <input type="date" class="form-control" id="tanggal" name="tanggal"
                            value="{{ old('tanggal', $payment->tanggal) }}" required>
                    </div>
                </div>

                <div class="group">
                    <div class="label">Number Whatsapp</div>
                    <div class="separator">:</div>
                    <div class="value">
                        <input type="text" class="form-control" id="number_whatsapp" name="number_whatsapp"
                            value="{{ old('number_whatsapp', $payment->number_whatsapp) }}" required>
                    </div>
                </div>

                <div class="group">
                    <div class="label">Custommer</div>
                    <div class="separator">:</div>
                    <div class="value">
                        <input type="text" class="form-control" id="customer" name="customer"
                            value="{{ old('customer', $payment->customer) }}" required>
                    </div>
                </div>

                <button type="submit" class="button">Save</button>
            </form>
        </div>
    </div>
@endsection
