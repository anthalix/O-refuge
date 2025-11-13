<script>
  import { link } from "svelte-spa-router";
  import { API_URL } from "./api";

  const get_adopt = async () => {
    const response = await fetch(`${API_URL}/status`);
    const result = await response.json();
    return result;
  };
</script>

<h1 class="title_home">Nos Chanceux!!</h1>
<div class="trombinoscope">
  {#await get_adopt()}
    <p>Chargement des adoptés...</p>
  {:then adopt}
    {#each adopt as animal}
      <div class="polaroid-images">
        <a href="/ficheAnimal/{animal.id}" title={animal.name} use:link>
          <!-- svelte-ignore a11y-img-redundant-alt -->
          <img
            class="trombinoscope_profil"
            src={animal.thumbnail}
            alt="image chiens à adopter"
          />
        </a>
      </div>
    {/each}
  {:catch error}
    <p>Une erreur s'est produite : {error.message}</p>
  {/await}
</div>
