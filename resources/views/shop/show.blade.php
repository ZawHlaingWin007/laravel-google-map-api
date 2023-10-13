@extends('layout.app')

@section('content')
    <div class="container my-4">
        <div class="card text-center">
            <div class="card-header">
                Welcome to our shop!
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ $shop->name }}</h5>
                <p class="card-text text-start">
                    {{ $shop->description }}
                </p>
                <a href="{{ route('shops.getNearByShops') }}" class="btn btn-danger">Go Back</a>
            </div>
            <div class="card-footer text-body-secondary">
                {{ $shop->created_at->diffForHumans() }}
            </div>
        </div>
    </div>
@endsection
