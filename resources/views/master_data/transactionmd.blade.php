@extends('layouts.app')

@section('title', 'BakulPay | Transaction MD')

@section('content')
<div class="container-fluid">
    <button type="button" id="sidebarCollapse" class="btn btn-info">
        <i class="fas fa-align-left"></i>
    </button>
</div>

<div class="container">
    <h2>Transaction Master Data</h2>
    <a class="btn btn-primary {{ Request::is('form_transactionmd*') ? 'active' : '' }}" href="{{ url('/form_transactionmd') }}" role="button">+ Add New</a>
    <div class="isi">
        <table id="myTable" class="display">
            <thead>
                <tr>
                    <th>Bank Name</th>
                    <th>Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rate_master_data as $data)
                <tr>
                    <td>
                        <img src="{{ asset('storage/' . $data->icons) }}" alt="Bank Icon" width="30" height="30">
                        {{ $data->nama_bank }}
                    </td>
                    <td>{{ $data->type }}</td>
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
