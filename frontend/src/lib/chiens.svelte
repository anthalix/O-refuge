<script>
  import { link } from "svelte-spa-router";
  import { API_URL } from "./api";

  let selectedRace = "Race";
  let selectedSexe = "Sexe";
  let selectedTaille = "Taille";
  let selectedAge = "Age";

  const get_dogs = async () => {
    const response = await fetch(`${API_URL}/dogs`);

    const result = await response.json();

    return result;
  };
  /*const get_breeds = async () => {
      const response = await fetch("http://127.0.0.1:8000/api/breeds");

      const result = await response.json();

      return result;
   };
*/
  let breeds = [];
</script>

<h1 class="title_home">Nos Chiens</h1>

<div class="dog">
  <div class="critere">
    <h2 class="title-critere">Trier par :</h2>

    <div class="critere-form">
      <form class="form">
        <select
          bind:value={selectedRace}
          aria-label="tri par race"
          class="selectpicker"
        >
          <option>Race</option>

          {#await get_dogs()}
            <template>Chargement des races...</template>
          {:then dogs}
            {#each dogs as animal}
              {#if !breeds.includes(animal.breed_name)}
                <option>{animal.breed_name}</option>
                {breeds.push(animal.breed_name)}
              {/if}
            {/each}
          {/await}
        </select>
        <select
          bind:value={selectedSexe}
          aria-label="tri par sexe"
          class="selectpicker"
        >
          <option>Sexe</option>
          <option>mâle</option>
          <option>femelle</option>
        </select>

        <select
          bind:value={selectedTaille}
          aria-label="tri par taille"
          class="selectpicker"
        >
          <option>Taille</option>
          <option>petite</option>
          <option>moyenne</option>
          <option>grande</option>
        </select>
        <select
          bind:value={selectedAge}
          aria-label="tri par age"
          class="selectpicker"
        >
          <option>Age</option>
          <option value="1">1 ans et -</option>
          <option value="2">2 à 5 ans</option>
          <option value="3">6 ans et +</option>
        </select>
      </form>
    </div>
  </div>

  <div class="trombinoscope">
    {#await get_dogs()}
      <p>Chargement des chiens...</p>
    {:then dogs}
      {#each dogs as animal}
        {#if selectedSexe !== "Sexe" || selectedTaille !== "Taille" || selectedAge !== "Age" || selectedRace !== "Race"}
          {#if (selectedSexe === "Sexe" || animal.sex === selectedSexe) && (selectedTaille === "Taille" || animal.taille === selectedTaille) && (selectedAge === "Age" || (selectedAge === "1" && animal.age <= 1) || (selectedAge === "2" && animal.age >= 2 && animal.age <= 5) || (selectedAge === "3" && animal.age >= 6)) && (selectedRace === "Race" || animal.breed_name === selectedRace)}
            <div class="polaroid-images">
              <a href="/ficheAnimal/{animal.id}" title={animal.name} use:link>
                <!-- svelte-ignore a11y-img-redundant-alt -->
                <img
                  class="trombinoscope_profil-dog"
                  src={animal.thumbnail}
                  alt="image chiens à adopter"
                />
              </a>
            </div>
          {/if}
        {:else if selectedSexe === "Sexe" && selectedTaille === "Taille" && selectedAge === "Age" && selectedRace === "Race"}
          {#if animal.status === "urgent"}
            <div class="polaroid-images">
              <a href="/ficheAnimal/{animal.id}" title={animal.name} use:link>
                <!-- svelte-ignore a11y-img-redundant-alt -->
                <img
                  class="trombinoscope_profil-dog"
                  src={animal.thumbnail}
                  alt="image chiens à adopter"
                />
              </a>
              <div class="figcaption">SOS Urgent</div>
            </div>
          {:else}
            <div class="polaroid-images">
              <a href="/ficheAnimal/{animal.id}" title={animal.name} use:link>
                <!-- svelte-ignore a11y-img-redundant-alt -->
                <img
                  class="trombinoscope_profil-dog"
                  src={animal.thumbnail}
                  alt="image chiens à adopter"
                />
              </a>
            </div>
          {/if}
        {/if}
      {/each}
    {:catch error}
      <p>Une erreur s'est produite : {error.message}</p>
    {/await}
  </div>
</div>
