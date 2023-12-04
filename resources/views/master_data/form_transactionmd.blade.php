@extends('layouts.app')

@section('title', 'BakulPay | Transaction MD')

@section('content')
<div class="container-fluid">
    <button type="button" id="sidebarCollapse" class="btn btn-info">
        <i class="fas fa-align-left"></i>
    </button>
</div>

<div class="container">
    <h2>Transaction Master Data > Add New</h2>
    <div class="isi">
        <form action="{{ route('submit.form_transactionmd') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="nama_bank">Nama Bank</label>
                <input type="text" class="form-control" id="nama_bank" name="nama_bank" required>
            </div>

            <div class="form-group">
                <label for="type">Type</label>
                <select class="form-control" id="type" name="type" required>
                    <option value="Top Up">Top Up</option>
                    <option value="Withdraw">Withdraw</option>
                </select>
            </div>

            <div class="form-group">
                <label for="icons">Icons</label>
                <input type="file" class="form-control-file" id="icons" name="icons" accept="image/*" required>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection
