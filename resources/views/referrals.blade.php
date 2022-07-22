@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-5">
                <div class="card-header">{{ __('Referral Credits') }}</div>
                <div class="card-body">
                    You currently have <strong>{{ $claimedReferrals->count() }}/10</strong> succesful referrals.
                </div>
            </div>

            <div class="card">
                <div class="card-header">{{ __('Referrals') }}</div>
                <div class="card-body">
                    @if($referrals->isEmpty())
                        You haven't sent any referral links yet. Invite your friends now!
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Recipient Email</th>
                                    <th>Updated</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($referrals as $referral)
                                    <tr>
                                        <td>{{ $referral->recipient_email }}</td>
                                        <td>{{ $referral->updated_at }}</td>
                                        <td>{{ $referral->formattedStatus }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
