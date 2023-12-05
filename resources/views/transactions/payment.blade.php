@extends('layouts.app')

@section('title', 'BakulPay | Payment')

@section('content')
    <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="btn btn-info">
            <i class="fas fa-align-left"></i>
        </button>
    </div>

    <div class="container">
        <h2>Payment</h2>
        <a class="btn btn-primary {{ Request::is('form_payment*') ? 'active' : '' }}" href="{{ url('/form_payment') }}"
            role="button">+ Add New</a>
        <div class="isi">
            <table id="myTable" class="display">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Number Whatsapp</th>
                        <th>Customer</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $counter = 1;
                    @endphp
                    @foreach ($payment as $data)
                        <tr>
                            <td>{{ $counter++ }}</td>
                            <td>{{ $data->tanggal }}</td>
                            <td>{{ $data->number_whatsapp }}</td>
                            <td>{{ $data->customer }}</td>
                            <td>
                                <iconify-icon icon="iconamoon:eye"></iconify-icon>
                                <a class="btn btn-primary {{ Request::is('edit-payment*') ? 'active' : '' }}"
                                    href="{{ route('edit_payment', ['id' => $data->id]) }}">
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
