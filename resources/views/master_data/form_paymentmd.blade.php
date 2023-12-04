@extends('layouts.app')

@section('title', 'BakulPay | Payment MD')

@section('content')
<div class="container-fluid">
    <button type="button" id="sidebarCollapse" class="btn btn-info">
        <i class="fas fa-align-left"></i>
    </button>
</div>

<div class="container">
    <h2>Payment Master Data > Add New</h2>
    <div class="isi">
        <form action="{{ route('submit.form_paymentmd') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="nama_bank">Nama Bank</label>
                <input type="text" class="form-control" id="nama_bank" name="nama_bank" required>
            </div>

            <div class="form-group">
                <label for="no_rekening">No.Rek</label>
                <input type="text" class="form-control" id="no_rekening" name="no_rekening" required>
            </div>

            <div class="form-group">
                <label for="nama">Name</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
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
