<script>
  import { link } from "svelte-spa-router";
  export let open;
</script>

{#if open}
  <div class="menu_navbar-mobile">
    <li class="menu_navbar-link">
      <a aria-label="page d'accueil" href="/" use:link>Accueil</a>
    </li>
    <li class="menu_navbar-link">
      <a aria-label="page conditions" href="/conditions" use:link
        >Conditions d'adoption</a
      >
    </li>
    <li class="menu_navbar-link">
      <a aria-label="page contact" href="/contact" use:link>Contact</a>
    </li>

    <li class="menu_navbar-link">
      <a aria-label="page animaux adoptés" href="/adoptes" use:link
        >Nos adoptés</a
      >
    </li>
    <li class="menu_navbar-link">
      <a aria-label="page animaux adoptés" href="/register" use:link
        >S'enregister</a
      >
    </li>
  </div>
{/if}
