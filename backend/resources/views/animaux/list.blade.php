@extends('layouts.app')

@section('content')


<h1>Liste des animaux à adopter
    <div>
        <a href="{{ route('animaux.add') }}" class="btn admin-link">
            Ajouter un animal
        </a>
    </div>
</h1>





<div class="container ">


    @foreach ($animaux as $animal)


    <div class="card">

        <strong>{{ $animal->name }}</strong>

        <img src="{{ $animal->first_image_url }}" alt="Photo de {{ $animal->name }}">
        <div class="infos-animal">
            <p> {{ $animal->specie_name }} : {{ $animal-> breed_name}}</p>
            <p> {{ $animal->sex }} de {{ $animal->age }} ans</p>

        </div>
        <div class=actions>
            <p> <a href="{{ route('animaux.edit', ['id' => $animal->id]) }}" class="btn admin-link">Modifier</a>

            <p>
            <form action="{{ route('animaux.delete', ['id' => $animal->id]) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet animal ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Supprimer</button>
            </form>
            </p>
        </div>
    </div>
    @endforeach

</div>
<div class="d-grid col-11 d-md-flex justify-content-md-start fixed-bottom ">
    <button onclick="topFunction()" id="myBtn" title="Go to top" class="btn btn-primary d-flex " style="font-size :2rem ; padding:  0 15px">top</button>
</div>



<script>
    // Afficher ou masquer le bouton de défilement vers le haut en fonction de la position de défilement
    window.onscroll = function() {
        scrollFunction()
    };

    function scrollFunction() {
        var mybutton = document.getElementById("myBtn");
        if (document.body.scrollTop > 30 || document.documentElement.scrollTop > 30) {
            mybutton.style.display = "block";
        } else {
            mybutton.style.display = "none";
        }
    }

    // Défiler vers le haut lorsque le bouton est cliqué
    function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }
</script>

<style>
    .access-denied {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0, 0, 0, 0.4);
        z-index: 9999;
    }

    .access-denied.hidden {
        display: none;
    }

    .access-box {
        background: #fff;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
        width: min(90%, 400px);
        animation: fadeIn 0.3s ease-out;
    }

    .access-box h2 {
        color: #e74c3c;
        margin-bottom: .5rem;
    }

    .access-box p {
        color: #333;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endsection