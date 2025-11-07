<script>
  import Router from "svelte-spa-router";

  import Footer from "./lib/footer.svelte";
  import Header from "./lib/header.svelte";
  import Home from "./lib/home.svelte";
  import Presentation from "./lib/qui_sommes_nous.svelte";
  import Mentions from "./lib/mentions_legales.svelte";
  import Contact from "./lib/contact.svelte";
  import Conditions from "./lib/conditions_adoption.svelte";
  import Cats from "./lib/chats.svelte";
  import Dogs from "./lib/chiens.svelte";
  import Adopt from "./lib/adopté.svelte";
  import SingleAnimal from "./lib/single_animal.svelte";
  import Register from "./lib/register.svelte";
  import Verified from "./lib/verified.svelte";
  import Verify from "./lib/verify.svelte";
  import Login from "./lib/login.svelte";
  import { onMount } from "svelte";
  import { fade } from "svelte/transition";

  const routes = {
    "/": Home,
    "/chiens": Dogs,
    "/chats": Cats,
    "/conditions": Conditions,
    "/contact": Contact,
    "/adoptes": Adopt,
    "/mentions": Mentions,
    "/presentation": Presentation,
    "/ficheAnimal/:id": SingleAnimal,
    "/register": Register,
    "/verified": Verified,
    "/verify": Verify,
    "/login": Login,
  };
  let verifiedMessage = "";
  let showToast = false;

  onMount(() => {
    // Canal pour écouter les messages du nouvel onglet
    const channel = new BroadcastChannel("orefuge_verify_channel");

    channel.onmessage = (event) => {
      const { userId, token } = event.data;
      console.log("Compte vérifié :", userId, token);

      // Affiche le toast
      verifiedMessage =
        "✅ Ton compte a été vérifié ! Redirection vers login...";
      showToast = true;

      // Cache le toast après 4s
      setTimeout(() => {
        showToast = false;
      }, 4000);

      // Redirection vers login après 5 secondes
      setTimeout(() => {
        verifiedMessage = "";
        window.location.hash = "#/login";
      }, 5000);
    };
  });
</script>

<main>
  {#if showToast}
    <div class="toast" transition:fade>
      {verifiedMessage}
    </div>
  {/if}

  <style>
    .toast {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%); /* centrer parfaitement */
      background: #2ecc71;
      color: white;
      padding: 1rem 1.5rem;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
      font-size: 1rem;
      z-index: 100; /* toujours au-dessus */
      animation: pop 0.3s ease-out;
      max-width: 90%;
      text-align: center;
    }

    @keyframes pop {
      from {
        transform: translateY(20px);
        opacity: 0;
      }
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }
  </style>

  <Header />
  <Router {routes} />
  <Footer />
</main>
