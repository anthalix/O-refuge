@extends('layouts.app')

@section('content')

<h1>Discussion avec {{ $user->username }}</h1>
<div class="chat-container">
    @foreach($messages as $msg)
    <div class="message-wrapper {{ $msg->from_admin ? 'admin' : 'user' }}">
        <div class="message-bubble">
            <div class="bubble">
                <p> <strong>{{ $msg->from_admin ? 'Admin' : $user->username }} </strong>
                </p>
                <p>{{ $msg->content }}</p>
            </div>
            <span class="timestamp">{{ $msg->created_at->format('H:i') }}</span>
        </div>
    </div>

    @endforeach
    @if ($messages ->isEmpty())
    <p style="color: #ccc; text-align: center;">
        Aucun message pour le moment
    </p>
    @endif

</div>

<form action="{{ route('admin.messages.reply') }}" method="POST" style="margin-top: 1rem;">
    @csrf
    <input type="hidden" name="user_id" value="{{ $user->id }}">
    <textarea name="content" rows="3" style="width:100%;" placeholder="Votre réponse..."></textarea>
    <button type="submit">Envoyer</button>
</form>
<style>
    .chat-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        max-width: 800px;
        margin: 20px auto;
        font-family: sans-serif;
        background-color: #2b5e91ff;
        padding: 20px;
        max-height: 400px;
        /* ✅ Limite visible */
        overflow-y: auto;
        /* ✅ Active le scroll */
    }

    form {
        max-width: 800px;

        background-color: #2b5e91ff;
        margin: auto auto;
        padding: 40px 20px 20px 20px;

    }

    strong {
        text-transform: uppercase;
    }

    button {
        margin-top: 20px;
        background-color: #173553ff;
        color: white;
        width: 100px;
        box-shadow: 2px 2px 10px 1px white;


    }

    textarea {
        background-color: #519ccaff;
        color: white;
        border-radius: 12px;
        padding-left: 15px;


    }

    .message-wrapper {
        display: flex;


    }

    .message-wrapper.user {
        justify-content: flex-start;

    }

    .message-wrapper.admin {
        justify-content: flex-end;
    }

    .bubble {
        display: flex;
        float: left;
    }

    .bubble p {

        margin-right: 20px;
        text-align: left;
    }

    .message-bubble {
        border-radius: 12px;
        padding: 10px 15px;
        width: 70%;
        position: relative;
        box-shadow: 0 2px 4px 0 white;
        display: flex;
        flex-direction: column;


    }

    .message-wrapper.admin .message-bubble {
        background-color: #134263ff;
        color: white;
    }

    .message-wrapper.user .message-bubble {
        background-color: #216fa0ff;
        color: white;
    }



    .timestamp {
        display: block;
        text-align: right;
        font-size: 0.75em;
        margin-top: 5px;
        opacity: 0.6;
    }
</style>
<script src="https://js.pusher.com/8.2/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.15.0/dist/echo.iife.js"></script>
<script>
    Pusher.logToConsole = true;

    const echo = new Echo({
        broadcaster: 'pusher',
        key: "{{ env('PUSHER_APP_KEY') }}",
        cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
        forceTLS: true
    });

    echo.channel('admin-channel')

        .listen('.new.message', (e) => {
            console.log('📨 Nouveau message reçu :', e);

            // Tu peux ici faire clignoter ton span “Nouveau message” ou rafraîchir le chat :
            const container = document.querySelector('.chat-container');
            const newMsg = document.createElement('div');
            newMsg.classList.add('message-wrapper', 'user');
            newMsg.innerHTML = `
                <div class="message-bubble">
                    <strong>${e.user.username ?? 'Utilisateur'} :</strong>
                    <p>${e.message.content}</p>
                    <span class="timestamp">maintenant</span>
                </div>
            `;
            container.appendChild(newMsg);
            setTimeout(() => {
                container.scrollTop = container.scrollHeight;
            }, 100);
        });
</script>

@endsection