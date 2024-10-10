@extends('layout.app')

@section('title', 'Register')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bulma-calendar@7.1.1/dist/css/bulma-calendar.min.css" rel="stylesheet">
    <style>
        .select {
            width: 100%;
        }

        .select select {
            width: 100%;
        }
    </style>
@endpush

@section('content')
    <div class="columns">
        <div class="column is-half is-offset-one-quarter">
            <h1 class="title">Register For Vaccine</h1>
            @if (session('error'))
                <div class="notification is-danger is-light">
                    {{ session('error') }}
                </div>
            @endif
            <form class="box" method="POST" action="{{ route('register.store') }}">
                @csrf
                <div class="field">
                    <label class="label">Vaccine Center <span class="has-text-danger">*</span></label>
                    <div class="select is-primary @error('center_id') is-danger @enderror">
                        <select name="center_id">
                            <option value="">Select Vaccine Center</option>
                            @foreach ($vaccineCenters as $vaccineCenter)
                                <option value="{{ $vaccineCenter->id }}" @selected(old('center_id') == $vaccineCenter->id)>
                                    {{ $vaccineCenter->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('center_id')
                        <p class="help is-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="columns">
                    <div class="column">
                        <div class="field">
                            <label class="label">First Name <span class="has-text-danger">*</span></label>
                            <div class="control">
                                <input class="input is-primary @error('first_name') is-danger @enderror" type="text"
                                    name="first_name" placeholder="First Name" value="{{ old('first_name') }}" />
                            </div>
                            @error('first_name')
                                <p class="help is-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="column">
                        <div class="field">
                            <label class="label">Last Name <span class="has-text-danger">*</span></label>
                            <div class="control">
                                <input class="input is-primary @error('last_name') is-danger @enderror" type="text"
                                    name="last_name" placeholder="Last Name" value="{{ old('last_name') }}" />
                            </div>
                            @error('last_name')
                                <p class="help is-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="columns">
                    <div class="column">
                        <div class="field">
                            <label class="label">NID <span class="has-text-danger">*</span></label>
                            <div class="control">
                                <input class="input is-primary @error('nid') is-danger @enderror" type="text"
                                    name="nid" placeholder="8210100000000000" value="{{ old('nid') }}" />
                            </div>
                            @error('nid')
                                <p class="help is-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="column">
                        <div class="field">
                            <label class="label">Birth Date <span class="has-text-danger">*</span></label>
                            <div class="control">
                                <input id="bulma-datepicker-2" class="input is-primary @error('birthday') is-danger @enderror"
                                    type="date" name="birthday" value="{{ old('birthday') }}">
                            </div>
                            @error('birthday')
                                <p class="help is-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="columns">
                    <div class="column">
                        <div class="field">
                            <label class="label">Email <span class="has-text-danger">*</span></label>
                            <div class="control">
                                <input class="input is-primary @error('email') is-danger @enderror" type="email"
                                    name="email" placeholder="example@example.com" value="{{ old('email') }}" />
                            </div>
                            @error('email')
                                <p class="help is-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="column">
                        <div class="field">
                            <label class="label">Phone <span class="has-text-danger">*</span></label>
                            <div class="control">
                                <input class="input is-primary @error('phone') is-danger @enderror" type="text"
                                    name="phone" placeholder="01xxxxxxxxx" value="{{ old('phone') }}" />
                            </div>
                            @error('phone')
                                <p class="help is-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <button class="button is-primary is-outlined">Register</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bulma-calendar@7.1.1/dist/js/bulma-calendar.min.js"></script>
    <script>
        bulmaCalendar.attach('#bulma-datepicker-2', {
            displayMode: 'dialog',
            startDate: new Date(),
            lang: 'en'
        });
    </script>
@endpush
