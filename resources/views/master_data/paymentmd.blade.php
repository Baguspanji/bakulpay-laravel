@extends('layouts.app')

@section('title', 'BakulPay | Payment MD')

@section('content')
<div class="container-fluid">
    <button type="button" id="sidebarCollapse" class="btn btn-info">
        <i class="fas fa-align-left"></i>
    </button>
</div>

<div class="container">
    <h2>Payment Master Data</h2>
    <a class="btn btn-primary {{ Request::is('form_paymentmd*') ? 'active' : '' }}" href="{{ url('/form_paymentmd') }}" role="button">+ Add New</a>
    <div class="isi">
        <table id="myTable" class="display">
            <thead>
                <tr>
                    <th>Bank Name</th>
                    <th>No.Rek</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payment_master_data as $data)
                <tr>
                    <td>
                        <img src="{{ asset('storage/' . $data->icons) }}" alt="Bank Icon" width="30" height="30">
                        {{ $data->nama_bank }}
                    </td>
                    <td>{{ $data->no_rekening }}</td>
                    <td>{{ $data->nama }}</td>
                    <td>
                        <iconify-icon icon="akar-icons:edit"></iconify-icon>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
