<script>
  import { API_URL } from "./api.js";
  import { push } from "svelte-spa-router";

  let email = "";
  let password = "";

  const loginUser = async () => {
    const response = await fetch(`${API_URL}/login`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        email,
        password,
      }),
    });
    const data = await response.json();
    console.log(data);

    if (data.token) {
      localStorage.setItem("token", data.token);
      localStorage.setItem("user_id", data.user.id);
      push("/contact");
    } else {
      alert(data.message);
    }
  };
</script>

<div class="presentation_page_login">
  <img class="logo3" src="./src/assets/logo.png" alt="Logo de l'entreprise" />
  <form
    on:submit|preventDefault={loginUser}
    aria-label="register-form"
    class="form_contact_login"
  >
    <div class="p_infos_login">
      <label for="username">Adresse Email</label>
      <input type="text" id="username" bind:value={email} required />
    </div>

    <div class="p_infos_login">
      <label for="password">Mot de passe</label>
      <input type="password" id="password" bind:value={password} required />
    </div>
    <button class="send_button_login" type="submit"> Se logger </button>
  </form>
</div>
