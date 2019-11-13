@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <purchase-button></purchase-button>
                    <user-purchases></user-purchases>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-header"><b><i>Hot Purchases </i></b><i class="em em-fire" aria-role="presentation" aria-label="FIRE"></i></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table table-striped">
                        <thead>
                            <th>Name</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Total</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Pagkain</td>
                                <td>2</td>
                                <td>24.00</td>
                                <td>48.00</td>
                            </tr>
                            <tr>
                                <td>Pagkain</td>
                                <td>2</td>
                                <td>24.00</td>
                                <td>48.00</td>
                            </tr>
                            <tr>
                                <td>Pagkain</td>
                                <td>2</td>
                                <td>24.00</td>
                                <td>48.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
