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
                        <th>Blockchain</th>
                        <th>Type</th>
                        <th>Price</th>
                        <th>Cost Transaction</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rate_master_data as $data)
                        @if (count($data->blockchains) > 0)
                            @php $priceFound = false; @endphp
                            @foreach ($data->blockchains as $blockchain)
                                @if ($blockchain->id_rate === $data->id && $blockchain->active === 'true')
                                    <tr>
                                        <td class="ikon">
                                            <img src="{{ $data->icons }}" alt="Bank Icon">
                                            <p>{{ $data->nama_bank }}</p>
                                        </td>
                                        <td>{{ $blockchain->nama_blockchain }}</td>
                                        <td>{{ $data->type }}</td>
                                        <td>
                                            {{ number_format($data->price, 0, ',', '.') }}
                                        </td>
                                        <td>
                                        @php
                                            // Ambil harga blockchain atau harga dari rate_master_data jika tidak ada blockchain
                                            $priceToShow = isset($blockchain->biaya_transaksi) ? number_format($blockchain->biaya_transaksi, 0, ',', '.') : number_format($data->biaya_transaksi, 0, ',', '.');
                                        @endphp
                                            {{ $priceToShow }}</td>
                                        <td>
                                            <a class="btn {{ Request::is('edit-rate*' . $data->id . '/' . $blockchain->id) ? 'active' : '' }}"
                                                href="{{ route('edit_rate', ['id' => $data->id, 'blockchain_id' => $blockchain->nama_blockchain]) }}">
                                                <iconify-icon icon="akar-icons:edit"></iconify-icon>
                                            </a>
                                        </td>
                                    </tr>
                                    @php $priceFound = true; @endphp
                                @endif
                            @endforeach
                        @else
                            @if ($data->active === 'true')
                                <tr>
                                    <td class="ikon">
                                        <img src="{{ $data->icons }}" alt="Bank Icon">
                                        <p>{{ $data->nama_bank }}</p>
                                    </td>
                                    <td>-</td> {{-- Empty blockchain --}}
                                    <td>{{ $data->type }}</td>
                                    <td>{{ number_format($data->price, 0, ',', '.') }}</td>
                                    <td>{{ number_format($data->biaya_transaksi, 0, ',', '.') }}</td>
                                    <td>
                                        <a class="btn {{ Request::is('edit-rate*' . $data->id) ? 'active' : '' }}"
                                            href="{{ route('edit_rate', ['id' => $data->id]) }}">
                                            <iconify-icon icon="akar-icons:edit"></iconify-icon>
                                        </a>
                                    </td>
                                </tr>
                            @endif
                        @endif
                    @empty
                        {{-- Handle the case where $rate_master_data is empty --}}
                        <tr>
                            <td colspan="5">No data available</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
