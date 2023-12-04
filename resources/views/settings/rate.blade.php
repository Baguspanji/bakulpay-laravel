@extends('layouts.app')

@section('title', 'BakulPay | Rate')

@section('content')
    <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="btn btn-info">
            <i class="fas fa-align-left"></i>
        </button>
    </div>

    <div class="container">
        <h2>Rate</h2>
        <div class="isi">
            <table id="myTable" class="display">
                <thead>
                    <tr>
                        <th>Bank Name</th>
                        <th>Type</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rate_master_data as $data)
                        <tr>
                            <td>
                                <img src="{{ asset('storage/' . $data->icons) }}" alt="Bank Icon" width="30"
                                    height="30">
                                {{ $data->nama_bank }}
                            </td>
                            <td>{{ $data->type }}</td>
                            <td>
                                @if ($data->price !== null)
                                    Rp {{ number_format($data->price, 2, ',', '.') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-primary {{ Request::is('edit-rate*') ? 'active' : '' }}" href="{{ route('edit_rate', ['id' => $data->id]) }}">
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
