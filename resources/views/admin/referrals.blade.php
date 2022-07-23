@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div id="admin-referrals" referrals="{{ $referrals }}"></div>
        </div>
    </div>
</div>
@endsection
