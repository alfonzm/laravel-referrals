@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div id="user-referrals"
                referrals="{{ $referrals }}"
                points="{{ $points }}"
                maxPoints="{{ $maxPoints }}"
            >
            </div>
        </div>
    </div>
</div>
@endsection
