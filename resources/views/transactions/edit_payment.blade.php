@extends('layouts.app')

@section('title', 'BakulPay | Edit Payment')

@section('content')
    <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="btn btn-info">
            <i class="fas fa-align-left"></i>
        </button>
    </div>

    <div class="container">
        <h2>Payment > Edit</h2>
        <div class="isi">
            <form action="{{ route('update_payment', ['id' => $payment->id]) }}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{ $payment->id }}">
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal"
                        value="{{ old('tanggal', $payment->tanggal) }}">
                    @error('tanggal')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="number_whatsapp">Number Whatsapp</label>
                    <input type="text" class="form-control" id="number_whatsapp" name="number_whatsapp"
                        value="{{ old('number_whatsapp', $payment->number_whatsapp) }}">
                    @error('number_whatsapp')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="customer">Customer</label>
                    <input type="text" class="form-control" id="customer" name="customer"
                        value="{{ old('customer', $payment->customer) }}">
                    @error('customer')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update Rate</button>
            </form>
        </div>
    </div>
@endsection
