<script>
  import { onMount } from "svelte";
  import { API_URL } from "./api.js";

  let userId;
  let username = "";
  let verified = false;
  let error = "";
  let loading = true;

  onMount(async () => {
    const params = new URLSearchParams(window.location.search);
    userId = params.get("user_id");
    const token = params.get("token");

    if (!userId || !token) {
      error = "Lien de vérification invalide.";
      loading = false;
      return;
    }

    try {
      const response = await fetch(
        `${API_URL}/frontuser/verify?user_id=${userId}&token=${token}`,
        {
          method: "POST",
        }
      );

      if (!response.ok) throw new Error("Erreur lors de la vérification.");

      const data = await response.json();
      username = data.username;
      verified = data.is_verified;
    } catch (err) {
      error = err.message;
    } finally {
      loading = false;
    }
  });
</script>

{#if loading}
  <p>Vérification en cours...</p>
{:else if error}
  <p style="color:red">{error}</p>
{:else if verified}
  <h2>Bonjour {username} !</h2>
  <p>Votre compte a été vérifié avec succès 🎉</p>
{/if}
