<script>
  import { onMount } from "svelte";

  let userId;
  let token;

  onMount(() => {
    const hash = window.location.hash;
    const queryString = hash.split("?")[1];
    //const params = new URLSearchParams(window.location.search);
    if (queryString) {
      const params = new URLSearchParams(queryString);
      userId = params.get("user_id");
      token = params.get("token");
      localStorage.setItem("token", token);
      localStorage.setItem("user_id", userId);
      const channel = new BroadcastChannel("orefuge_verify_channel");
      channel.postMessage({ userId, token });
    }
    setTimeout(() => {
      window.close();
    }, 1000);
  });
</script>

<h2>✅ Compte vérifié !</h2>
<p>Merci d’avoir confirmé votre adresse e-mail !</p>
