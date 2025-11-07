@extends('layouts.app')

@section('content')

<h1>Contacts</h1>

<div class="container">
    @foreach($users as $user)
    <div class="card_contact">
        <p>
            <a href="{{ route('admin.messages.show', $user->id) }}">
                <strong>{{ $user->username }}</strong>
            </a>
            @if($user->unread_count > 0)
            <span class="badge_new">Nouveau message</span>
            @endif
        </p>
        <p>{{ $user->email }} — tel : {{ $user->tel }}</p>
    </div>
    @endforeach
</div>

<style>
    .badge_new {
        background-color: #ff4444;
        color: white;
        font-size: 0.8em;
        padding: 3px 8px;
        border-radius: 10px;
        margin-left: 8px;
        font-weight: bold;
    }
</style>

@endsection