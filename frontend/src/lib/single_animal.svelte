<script>
  import { link } from "svelte-spa-router";
  import { onMount } from "svelte";
  import { API_URL } from "./api";

  export let params = {};
  let animal = null;
  let images = [];

  const get_animal = async (id) => {
    const response = await fetch(`${API_URL}/animals/` + id);
    const result = await response.json();
    return result;
  };
  onMount(async () => {
    const data = await get_animal(params.id);
    animal = data[0]; // car ton API renvoie un tableau avec un seul élément
    images = animal.images;
  });

  onMount(() => {
    const myCarouselElement = document.querySelector("#carouselExample");
    if (myCarouselElement && window.bootstrap) {
      const carousel = new window.bootstrap.Carousel(myCarouselElement, {
        interval: 2000,
        touch: false,
      });
    }
  });

  function rtn() {
    window.history.back();
  }
</script>

<div class="container_single">
  {#if animal}
    <div class="photo-single">
      <div id="carouselExample" class="carousel slide">
        <div class="carousel-inner">
          {#each images as image, i}
            <div class="carousel-item {i === 0 ? 'active' : ''}">
              <img src={image} alt="Photo de {animal.name}" />
            </div>
          {/each}
        </div>
        <button
          class="carousel-control-prev"
          type="button"
          data-bs-target="#carouselExample"
          data-bs-slide="prev"
          aria-label="prev"
        >
          <span class="carousel-control-prev-icon"></span>
        </button>
        <button
          class="carousel-control-next"
          type="button"
          data-bs-target="#carouselExample"
          data-bs-slide="next"
          aria-label="next"
        >
          <span class="carousel-control-next-icon"></span>
        </button>
      </div>
    </div>
    <div class="presentation-single">
      <h1 class="title_home">{animal.name}</h1>
      <ul class="icons">
        {#if animal.child == 1}
          <li>
            <span>Compatible</span>

            <img
              class="icons_img"
              src="../src/assets/icons/enfants.png"
              alt="enfant"
            />
          </li>
        {/if}
        {#if animal.dog == 1}
          <li>
            <span>Compatible</span>

            <img
              class="icons_img"
              src="../src/assets/icons/okchien.png"
              alt="chien"
            />
          </li>
        {/if}
        {#if animal.cat == 1}
          <li>
            <span>Compatible</span>

            <img
              class="icons_img"
              src="../src/assets/icons/okchat.png"
              alt="chat"
            />
          </li>
        {/if}
      </ul>
      <div class="single_infos">
        <div class="p_infos">
          <p>{animal.name} a {animal.age} ans</p>
          <p>{animal.name} est un {animal.breed_name}</p>
          <p>{animal.name} est un {animal.sex}</p>
          <p>{animal.name} est de {animal.taille} taille</p>
        </div>
        <div class="p_description">
          <p>{animal.name} est {animal.description}</p>
        </div>
      </div>
      <div class="p_infos_link">
        <a href="/contact" aria-label="redirection" use:link>Je veux adopter</a>
      </div>
    </div>
  {/if}
  <div class="p_infos_link_btn">
    <button on:click={rtn}> <strong>Retour</strong></button>
  </div>
</div>

_
