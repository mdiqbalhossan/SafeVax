@extends('layout.app')

@section('title', 'Registration Success')

@push('styles')
@endpush

@section('content')
    <div class="columns">
        <div class="column is-half is-offset-one-quarter">
            <div class="box">
                <div class="is-flex is-justify-content-center">
                    <img class="is-rounded" src="{{ asset('public/images/success.gif') }}" />
                </div>
                <h1 class="title has-text-centered mb-4">Registration Successful</h1>
                @if (session('another-center-message'))
                    <p class="notification is-info is-light">
                        {{ session('another-center-message') }}
                    </p>
                @endif
                <p class="subtitle has-text-centered">
                    Congratulations! You are scheduled for the vaccine at <strong class="has-text-primary">{{ $center->name }}</strong> on <strong class="has-text-primary">{{ $scheduleDate }}</strong>. Please make sure to be present at the vaccination center on time. Also, please bring your NID for confirmation. You will receive a notification email at 9 PM the night before your scheduled vaccination date.
                </p>
                <a href="{{ route('register') }}" class="button is-primary is-fullwidth is-outlined">Register Another Member</a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush
