@extends('layouts.app')

@section('title', 'BakulPay | Payment')

@section('content')
<div class="container-fluid">
    <button type="button" id="sidebarCollapse" class="btn btn-info">
        <i class="fas fa-align-left"></i>
    </button>
</div>

<div class="container">
    <h2>Payment > Add New</h2>
    <div class="isi">
        <form action="{{ route('submit.form_payment') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="tanggal">Tanggal</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
            </div>

            <div class="form-group">
                <label for="number_whatsapp">Number Whatsapp</label>
                <input type="text" class="form-control" id="number_whatsapp" name="number_whatsapp" required>
            </div>

            <div class="form-group">
                <label for="customer">Customer</label>
                <input type="text" class="form-control" id="customer" name="customer" required>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection
