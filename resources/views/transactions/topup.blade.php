@extends('layouts.app')

@section('title', 'BakulPay | Top Up')

@section('content')
    <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="btn btn-info">
            <i class="fas fa-align-left"></i>
        </button>
    </div>

    <div class="container">
        <h2>Top Up</h2>
        <div class="isi">
            <table id="myTable" class="display">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Bank Name</th>
                        <th>Customer</th>
                        <th>Account</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $counter = 1; // Inisialisasi variabel counter
                    @endphp
                    @foreach ($top_up as $data)
                        <tr>
                            <td>{{ $counter++ }}</td>
                            <td>{{ $data->status }}</td>
                            <td>{{ $data->tanggal }}</td>
                            <td>
                                @if ($data->rateMasterData)
                                    <img src="{{ asset('storage/' . $data->rateMasterData->icons) }}" alt="Bank Icon"
                                        width="30" height="30">
                                @endif
                                {{ $data->nama_bank }}
                            </td>
                            <td>{{ $data->nama }}</td>
                            <td>{{ $data->kode_bank }}</td>
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
