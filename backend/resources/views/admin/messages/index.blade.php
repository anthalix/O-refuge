@extends('layouts.app')

@section('content')

<h1>Contacts</h1>

<div class="container">
    @foreach($users as $user)
    <div class="card_contact" data-user-id="{{ $user->id }}">
        <p>
            <a href="{{ route('admin.messages.show', $user->id) }}">
                <strong>{{ $user->username }}</strong>
            </a><br />
            @if($user->unread_count > 0)
            <span class="badge_new" data-count="{{ $user->unread_count }}">
                {{ $user->unread_count }} nouveau{{ $user->unread_count > 1 ? 'x' : '' }} message{{ $user->unread_count > 1 ? 's' : '' }}
            </span>
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
        font-size: 1em;
        padding: 3px 8px;
        border-radius: 10px;
        margin-left: 8px;
        font-weight: bold;
    }

    strong {
        font-size: 1.5rem;
        margin-right: 5px;
    }
</style>
<script src="https://js.pusher.com/8.2/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.15.0/dist/echo.iife.js"></script>



<script>
    // ⚙️ Config Echo avec Pusher
    Pusher.logToConsole = true;
    const echo = new Echo({
        broadcaster: 'pusher',
        key: "{{ env('PUSHER_APP_KEY') }}",
        cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
        forceTLS: true
    });

    // 🔔 Écoute du canal "admin-messages"





    echo.channel("admin-channel")
        .listen('.new.message', (e) => {
            console.log("📩 Nouveau message reçu :", e);

            const card = document.querySelector(`[data-user-id="${e.user.id}"]`);
            if (card) {
                let badge = card.querySelector('.badge_new');

                if (badge) {
                    // 🔼 Augmente seulement visuellement le compteur
                    let count = parseInt(badge.dataset.count);
                    count++;
                    badge.dataset.count = count;
                    badge.textContent = `${count} nouveau${count > 1 ? 'x' : ''} message${count > 1 ? 's' : ''}`;
                } else {
                    // 🆕 Crée le badge si inexistant
                    const newBadge = document.createElement('span');
                    newBadge.className = 'badge_new';
                    newBadge.dataset.count = 1;
                    newBadge.textContent = '1 nouveau message';
                    card.querySelector('p').appendChild(newBadge);
                }
            } else {
                console.warn("⚠️ Aucun utilisateur trouvé pour userId :", e.userId);
            }
        });
</script>


@endsection