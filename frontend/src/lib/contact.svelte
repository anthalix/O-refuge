<script lang="ts">
  import { onMount } from "svelte";
  import { API_URL } from "./api";

  import { echo } from "./echo.js";

  let messages: { content: string; from: string; from_admin?: boolean }[] = [];
  let user: { id?: number; username?: string; email?: string } = {};

  // Déclare à TypeScript que window.Pusher existe

  let message = "";

  const token = localStorage.getItem("token");
  const userId = localStorage.getItem("user_id");

  onMount(async () => {
    if (!token || !userId) {
      window.location.href = "/#/login";
      return;
    }

    const res = await fetch(`${API_URL}/frontuser/${userId}`, {
      headers: { Authorization: `Bearer ${token}` },
    });
    const data = await res.json();
    if (data.success) {
      if (data.success) {
        user = data.data;
      }
    }

    const msgRes = await fetch(`${API_URL}/messages/${userId}`, {
      headers: { Authorization: `Bearer ${token}` },
    });
    const msgData = await msgRes.json();
    if (msgData.success) {
      messages = msgData.data.map((m) => ({
        id: m.id,
        content: m.content,
        from: m.from_admin ? "admin" : m.users[0]?.username || "inconnu",
      }));
    }
  });

  async function sendMessage() {
    const res = await fetch(`${API_URL}/message`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${token}`,
      },
      body: JSON.stringify({ content: message }),
    });

    const data = await res.json();

    if (data.success) {
      messages = [...messages, { content: message, from: user.username }];
      message = "";
    } else {
      alert("Erreur : " + data.message);
    }
  }
  onMount(() => {
    // Écoute les nouveaux messages envoyés par l’admin
    echo.private(`user-${userId}`).listen(".new.message", (e: any) => {
      console.log("📩 Message reçu :", e);
      messages = [...messages, { content: e.message.content, from: "Admin" }];
    });
    echo.channel("admin-channel").listen(".nex.message", (e: any) => {
      console.log("📩 Message reçu :", e);
    });
  });

  $: {
    const chatBox = document.querySelector(".chat-box");
    if (chatBox) {
      chatBox.scrollTop = chatBox.scrollHeight;
    }
  }
  console.log(echo);
</script>

<main>
  <h1 class="title_home">contact</h1>
  {#if token}
    <div class="presentation_page-contact">
      <img
        class="logo2"
        src="./src/assets/logo.png"
        alt="Logo de l'entreprise"
      />

      <form
        on:submit|preventDefault={sendMessage}
        aria-label="form-contact"
        class="form_contact"
      >
        <div class="p_infos">
          <label for="lastname">Nom : </label>
          <input type="text" bind:value={user.username} readonly />
        </div>
        <div class="p_infos">
          <label for="email">Email : </label>
          <input type="text" bind:value={user.email} readonly />
        </div>

        <h3>Ma demande :</h3>
        <div class="p_text">
          <textarea
            aria-label="demande"
            name="message"
            cols="63"
            rows="10"
            bind:value={message}
          ></textarea>
        </div>

        <div>
          <input class="send_button" type="submit" value="Envoyer" />
        </div>
      </form>
    </div>
    <div class="chat-box">
      {#each messages as msg}
        <div id="message" class={msg.from_admin ? "admin-msg" : "user-msg"}>
          <strong>{msg.from} :</strong>
          {msg.content}
        </div>
      {/each}
    </div>
  {:else}
    <div id="lien">
      <h2>⚠️ Vous devez être connecté pour accéder à cette page</h2>
      <a class="lien" href="#/login">Se connecter </a>
      <span> ou </span>
      <a class="lien" href="#/register"> S’inscrire</a>
    </div>
  {/if}
</main>

<style>
  .p_infos {
    display: flex;
    flex-direction: column;
  }
  .lien {
    text-decoration: none;
    font-family: "bebas+neue";
    font-size: 1.7rem;
    color: #e8f0fa;
    text-shadow: 4px 4px 10px rgba(0, 0, 0, 0.8);
  }
  #lien {
    text-shadow: 4px 4px 10px rgba(0, 0, 0, 0.8);
    text-align: left;
    background-color: rgba(0, 0, 0, 0.5);
    text-align: center;
    margin-bottom: 50px;
  }
  .p_text {
    margin-bottom: 20px;
  }
  main {
    position: relative;
  }
  .chat-box {
    position: absolute;
    right: 10%;
    top: 15%;
    width: 30%;
    max-height: 400px;
    overflow-y: auto;
    background: rgba(6, 6, 6, 0.527);

    border-radius: 8px;
    padding: 10px;
    margin-top: 20px;
  }

  #message {
    display: flex;
    justify-content: space-between;
    background: white;
    border: 1px solid #ddd;
    padding: 8px;
    border-radius: 6px;
    margin-bottom: 6px;
  }
</style>
