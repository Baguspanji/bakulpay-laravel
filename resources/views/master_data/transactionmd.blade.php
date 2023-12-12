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
        <a class="add {{ Request::is('form_transactionmd*') ? 'active' : '' }}" href="{{ url('/form_transactionmd') }}" role="button">+ Add New</a>
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
                            <td class="ikon">
                                <img src="{{ $data->icons }}" alt="Bank Icon">
                                <p>
                                {{ $data->nama_bank }}</p>
                            </td>
                            <td>{{ $data->type }}</td>
                            <td>
                                <a class="btn {{ Request::is('edit-transactionmd*') ? 'active' : '' }}" href="{{ route('edit_transactionmd', ['id' => $data->id]) }}">
                                    <iconify-icon icon="akar-icons:edit"></iconify-icon>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
