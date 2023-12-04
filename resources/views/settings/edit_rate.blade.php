@extends('layouts.app')

@section('title', 'BakulPay | Edit Rate')

@section('content')
    <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="btn btn-info">
            <i class="fas fa-align-left"></i>
        </button>
    </div>

    <div class="container">
        <h2>Rate > Edit</h2>
        <div class="isi">
            <form action="{{ route('update_rate', ['id' => $rate->id]) }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="bank_name">Bank Name</label>
                    <input type="text" class="form-control" id="bank_name" value="{{ $rate->nama_bank }}" readonly>
                    <img src="{{ asset('storage/' . $rate->icons) }}" alt="Bank Icon" width="30" height="30">
                </div>

                <div class="form-group">
                    <label for="type">Type</label>
                    <input type="text" class="form-control" id="type" value="{{ $rate->type }}" readonly>
                </div>

                <div class="form-group">
                    <label for="price">Price</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <input type="text" class="form-control" id="price" name="price"
                            value="{{ number_format($rate->price, 0, ',', '.') }}" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update Rate</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            // Format price with thousand separators
            function formatPrice(value) {
                return value.toLocaleString('id-ID');
            }

            // Remove non-numeric characters when saving the value
            function unformatPrice(value) {
                return parseFloat(value.replace(/[^\d]/g, ''));
            }

            // Add thousand separators while typing
            $('#price').on('input', function() {
                var inputVal = $(this).val();
                if (inputVal !== "") {
                    inputVal = unformatPrice(inputVal);
                    $(this).val(formatPrice(inputVal));
                }
            });

            // Ensure correct format when submitting the form
            $('form').submit(function() {
                var inputVal = $('#price').val();
                if (inputVal !== "") {
                    var unformatted = unformatPrice(inputVal);
                    $('#price').val(unformatted);
                }
            });
        });
    </script>
@endsection
