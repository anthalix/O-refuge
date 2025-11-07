<script>
  import { API_URL } from "./api.js"; // ton backend Laravel

  let username = "";
  let email = "";
  let password = "";
  let tel = "";
  let adresse = "";
  let successMessage = "";
  let errorMessage = "";
  let loading = false;

  const registerUser = async () => {
    loading = true;
    successMessage = "";
    errorMessage = "";

    try {
      const response = await fetch(`${API_URL}/register`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          username,
          email,
          password,
          tel,
          adresse,
        }),
      });

      const data = await response.json();

      if (!response.ok) {
        throw new Error(data.message || "Erreur lors de l’inscription.");
      }

      successMessage =
        data.message + " Un email de confirmation vous est envoyé!";
      // Reset form
      username = "";
      email = "";
      password = "";
      tel = "";
      adresse = "";
    } catch (err) {
      errorMessage = err.message;
    } finally {
      loading = false;
    }
  };
</script>

<h1 class="title_home">S'enregistrer</h1>

<div class="presentation_page-contact">
  <img class="logo2" src="./src/assets/logo.png" alt="Logo de l'entreprise" />
  <form
    on:submit|preventDefault={registerUser}
    aria-label="register-form"
    class="form_contact"
  >
    <div class="p_infos">
      <label for="username">Nom d’utilisateur</label>
      <input type="text" id="username" bind:value={username} required />
    </div>

    <div class="p_infos">
      <label for="email">Email</label>
      <input type="email" id="email" bind:value={email} required />
    </div>

    <div class="p_infos">
      <label for="password">Mot de passe</label>
      <input type="password" id="password" bind:value={password} required />
    </div>

    <div class="p_infos">
      <label for="tel">Téléphone</label>
      <input type="text" id="tel" bind:value={tel} />
    </div>

    <div class="p_infos">
      <label for="adresse">Adresse</label>
      <input type="text" id="adresse" bind:value={adresse} />
    </div>

    <button class="send_button_login" type="submit" disabled={loading}>
      {#if loading}Enregistrement...{/if}
      {#if !loading}S’inscrire{/if}
    </button>

    {#if successMessage}
      <p style="color:green">{successMessage}</p>
    {/if}

    {#if errorMessage}
      <p style="color:red">{errorMessage}</p>
    {/if}
  </form>
</div>
