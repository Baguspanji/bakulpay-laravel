@extends('layouts.app')

@section('title', 'BakulPay | Edit Rate')

@section('content')
    <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="btn btn-info">
            <i class="fas fa-align-left"></i>
        </button>
    </div>

    <div class="container">
        <h2><a href="{{ route('rate') }}">Rate</a> > Edit</h2>
        <div class="isi">
            <form action="{{ route('update_rate', ['id' => $rate->id]) }}" method="post">
                @csrf
                <div class="group">
                    <div class="label">Bank Name</div>
                    <div class="separator">:</div>
                    <div class="value1"><img src="{{ $rate->icons }}" alt="icons">{{ $rate->nama_bank }}</div>
                </div>

                <div class="group">
                    <div class="label">Blockchain Name</div>
                    <div class="separator">:</div>
                    <div class="value">
                        {{-- Retrieve blockchain_id from the URL --}}
                        @php
                            $blockchainIdFromUrl = request()->input('blockchain_id');
                        @endphp
                        {{ $blockchainIdFromUrl }}
                    </div>
                </div>

                <div class="group">
                    <div class="label">Type</div>
                    <div class="separator">:</div>
                    <div class="value">{{ $rate->type }}</div>
                </div>

                <div class="group">
                    <div class="label">Price</div>
                    <div class="separator">:</div>
                    <div class="value">
                        <input type="text" class="form-control" id="price" name="price"
                            value="{{ number_format($price, 0, ',', '.') }}" required>
                    </div>
                </div>

                <button type="submit" class="button">Save</button>
            </form>
        </div>
    </div>
@endsection
