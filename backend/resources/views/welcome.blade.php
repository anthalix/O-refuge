@extends('layouts.app')

@section('content')

<main class="welcome">

</main>
<style>
    .welcome {
        width: 100%;
        height: 100vh;
        background-image: url('{{ asset("assets/refuge.jpg") }}');
        background-size: center;
        /* Pour que l'image couvre tout le div */
    }

    #navbarNav {

        display: flex;
        justify-content: center;

    }

    .logo2 {


        width: 100px;
        height: 100px;
    }
</style>
@endsection