@extends('layouts.app')

@section('content')

<h1>Créer un nouvel animal</h1>

<div class="container">
    <form action="{{ route('animaux.add') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-select">
            <label for="name"><strong>Nom :</strong></label>
            <input type="text" class="form-control" name="name" id="name" value="">
        </div>



        <div class="form-select">
            <label for="specie_id"><strong>Espèce :</strong></label>

            <select id="specie_id" class="form-control" name="specie_id">
                <option value="0">Choisir</option>
                <option value="1">Chien</option>
                <option value="2">Chat</option>
                <option value="3">Nouvelle espèce</option>
            </select>

            <input
                class="form-control"
                type="text"
                id="new_specie"
                name="new_specie"
                placeholder="Entrez la nouvelle espèce"
                style="display: none;" />
        </div>
        <p id="error-message" style="color: red; display: none; font-size: 1.2rem; margin-top: 5px;">
            Veuillez renseigner le nom de la nouvelle espèce.
        </p>

        <div class="form-select">
            <label for="age"><strong>Âge :</strong></label>
            <input type="number" class="form-control" name="age" id="age" value="">
        </div>

        <div class="form-select">
            <label for="sex"><strong>Sexe :</strong></label>
            <select id="sex" class="form-control" name="sex" placeholder="Choisir" autofocus="true">
                <option value="0">Choisir</option>

                <option value="Male">Male</option>
                <option value="Femelle">Femelle</option>
            </select>
        </div>

        <div class="form-select">
            <label for="size"><strong>Taille :</strong></label>
            <select id="size" class="form-control" name="size" autofocus="true">


                <option value="0">Choisir</option>

                <option value="petite">Petit</option>
                <option value="moyenne">Moyen</option>
                <option value="grande">Grand</option>
            </select>
        </div>

        <div class="form-select">
            <label for="description"><strong>Description :</strong></label>
            <textarea type="text" class="form-control" name="description" id="description"></textarea>
        </div>

        <div class="form-select">
            <label for="status"><strong>Status :</strong></label>
            <select id="status" class="form-control" name="status" autofocus="true">
                <option value="0">Choisir</option>

                <option value="disponible">Disponible</option>
                <option value="urgent">Urgent</option>
                <option value="adopté">Adopté</option>
            </select>
        </div>
        <br>

        <div class="form-check ">
            <label for="cat" class="form-check-label"><strong>OK Chat</strong></label>
            <input type="hidden" name="cat" value="0">
            <input type="checkbox" class="form-check-input" name="cat" id="cat" value="1">
        </div>
        <br>

        <div class="form-check ">
            <label for="dog" class="form-check-label"><strong>OK Chien</strong></label>
            <input type="hidden" name="dog" value="0">
            <input type="checkbox" class="form-check-input" name="dog" id="dog" value="1">
        </div>
        <br>

        <div class="form-check ">
            <label for="child" class="form-check-label"><strong>OK Enfant</strong></label>
            <input type="hidden" name="child" value="0">
            <input type="checkbox" class="form-check-input" name="child" id="child" value="1">
        </div>
        <br>


        <div class="form-select">
            <label for="images">Images :</label>
            <input type="file" class="form-control" name="images[]" multiple>
        </div>


        <div class="form-select">
            <label for="breeds_name"><strong>Race</strong></label>
            <input type="text" class="form-control" placeholder="entrez la race" name="breeds_name" id="breeds_name" value="">
        </div><br />

        <div class="d-grid gap-2 col-6 mx-auto">
            <button type="submit" class="btn btn-primary fs-2">Créer</button>
        </div>
    </form>


</div>
<script>
    const specieSelect = document.getElementById('specie_id');
    const newSpecieInput = document.getElementById('new_specie');
    const errorMessage = document.getElementById('error-message');

    specieSelect.addEventListener('change', () => {
        if (specieSelect.value === '3') {
            specieSelect.style.display = 'none';
            newSpecieInput.style.display = 'block';
            newSpecieInput.required = true;
            errorMessage.style.display = 'block';
            newSpecieInput.focus();
        } else {
            newSpecieInput.style.display = 'none';
            specieSelect.style.display = 'block';
            newSpecieInput.required = false;
            errorMessage.style.display = 'none';
            specieSelect.setAttribute('name', 'specie_id');
        }
    });
</script>
@endcontent