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
            <form class="box">
                <div class="field">
                    <label class="label">Vaccine Center <span class="has-text-danger">*</span></label>
                    <div class="select is-primary">
                        <select required>
                            <option value="">Select Vaccine Center</option>
                            @foreach ($vaccineCenters as $vaccineCenter)
                                <option value="{{ $vaccineCenter->id }}">{{ $vaccineCenter->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="columns">
                    <div class="column">
                        <div class="field">
                            <label class="label">First Name <span class="has-text-danger">*</span></label>
                            <div class="control">
                                <input class="input is-primary" type="text" placeholder="First Name" required />
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="field">
                            <label class="label">Last Name <span class="has-text-danger">*</span></label>
                            <div class="control">
                                <input class="input is-primary" type="text" placeholder="Last Name" required />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="columns">
                    <div class="column">
                        <div class="field">
                            <label class="label">NID <span class="has-text-danger">*</span></label>
                            <div class="control">
                                <input class="input is-primary" type="text" placeholder="8210100000000000" required />
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="field">
                            <label class="label">Birth Date <span class="has-text-danger">*</span></label>
                            <div class="control">
                                <input id="bulma-datepicker-2" class="input is-primary" type="date" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="columns">
                    <div class="column">
                        <div class="field">
                            <label class="label">Email <span class="has-text-danger">*</span></label>
                            <div class="control">
                                <input class="input is-primary" type="email" placeholder="example@example.com" required />
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="field">
                            <label class="label">Phone <span class="has-text-danger">*</span></label>
                            <div class="control">
                                <input class="input is-primary" type="text" placeholder="01xxxxxxxxx" required />
                            </div>
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
