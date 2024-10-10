@extends('layout.app')

@section('title', 'Search')

@section('content')
    <div class="columns">
        <div class="column is-half is-offset-one-quarter">
            <h1 class="title">Status Check</h1>
            <form class="box" method="POST" action="{{ route('search.result') }}">
                @csrf
                <div class="columns">
                    <div class="column">
                        <div class="field">
                            <label class="label">NID <span class="has-text-danger">*</span></label>
                            <div class="control">
                                <input class="input is-primary" type="text"
                                    name="nid" placeholder="8210100000000000" value="{{ old('nid') }}" />
                            </div>                            
                        </div>
                    </div>
                </div>
                <button class="button is-primary is-outlined">Search</button>
            </form>
            @isset ($status)
                <div class="box">
                    <h1 class="title">Vaccine Status</h1>
                    <div class="columns">
                        <div class="column">
                            @isset($member)
                                <p>Name: {{ $member->first_name }} {{ $member->last_name }}</p>
                                <p>NID: {{ $member->nid }}</p>
                                <p>Phone: {{ $member->phone }}</p>
                            @endisset
                            <p>Vaccine Status: <span class="has-text-weight-bold tag is-info is-light">{{ $status }}</span></p>
                        </div>
                    </div>
                    @if ($status == 'Not Registered')
                        <p>You are not registered yet. <a href="{{ $link }}">Register now</a>.</p>
                    @elseif ($status == 'Not Scheduled')
                        <p>You are registered but not scheduled for vaccine yet.</p>
                    @elseif ($status == 'Scheduled')
                        <p>Your vaccination is scheduled for {{ $date }} at {{ $center }}.</p>
                    @else
                        <p>You have been vaccinated.</p>
                    @endif
                </div>
            @endif
        </div>
    </div>
@endsection
