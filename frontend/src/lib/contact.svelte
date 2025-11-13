<script lang="ts">
  import { onMount, onDestroy } from "svelte";
  import { API_URL } from "./api";
  import { echo } from "./echo.js";

  let messages: { content: string; from: string; from_admin?: boolean }[] = [];
  let user: { id?: number; username?: string; email?: string } = {};
  let message = "";

  const token = localStorage.getItem("token");
  const userId = localStorage.getItem("user_id");

  // Variable pour stocker la référence du channel
  let channel;

  onMount(async () => {
    if (token || userId) {
      // Récupérer les infos utilisateur
      const res = await fetch(`${API_URL}/frontuser/${userId}`, {
        headers: { Authorization: `Bearer ${token}` },
      });
      const data = await res.json();
      if (data.success) {
        user = data.data;
      }

      // Récupérer l'historique des messages
      const msgRes = await fetch(`${API_URL}/messages/${userId}`, {
        headers: { Authorization: `Bearer ${token}` },
      });
      const msgData = await msgRes.json();
      if (msgData.success) {
        messages = msgData.data.map((m) => ({
          id: m.id,
          content: m.content,
          from: m.from_admin ? "Admin" : m.users[0]?.username || "inconnu",
          from_admin: m.from_admin || false,
        }));
      }

      // ✅ Écouter les nouveaux messages en temps réel
      channel = echo.channel("admin-channel");

      channel.listen(".new.message", (e: any) => {
        console.log("📩 Message reçu en temps réel :", e);

        // Ajouter le message à la liste
        messages = [
          ...messages,
          {
            content: e.message.content,
            from: e.message.from_admin ? "Admin" : e.user.username,
            from_admin: e.message.from_admin,
          },
        ];
      });
    }
  });

  // ✅ Nettoyer quand le composant est détruit
  onDestroy(() => {
    if (channel) {
      echo.leave("admin-channel");
      console.log("🔌 Déconnecté du channel");
    }
  });

  async function sendMessage() {
    if (!message.trim()) return;

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
      // Le message sera ajouté via l'événement broadcast
      message = "";
    } else {
      alert("Erreur : " + data.message);
    }
  }

  // Auto-scroll vers le bas quand il y a de nouveaux messages
  $: if (messages.length > 0) {
    setTimeout(() => {
      const chatBox = document.querySelector(".chat-box");
      if (chatBox) {
        chatBox.scrollTop = chatBox.scrollHeight;
      }
    }, 100);
  }
</script>

<main class="main_contact">
  <h1 class="title_home">contact</h1>
  {#if token}
    <div class="presentation_page-contact">
      <img
        class="logo2"
        src="./src/assets/logo.png"
        alt="Logo de l'entreprise"
      />

      <div class="p_infos">
        <label for="lastname">Nom : </label>
        <input type="text" bind:value={user.username} readonly />
      </div>
      <div class="p_infos">
        <label for="email">Email : </label>
        <input type="text" bind:value={user.email} readonly />
      </div>
    </div>
    <div class="chat">
      <h3 style="color: white; margin-bottom: 10px;">💬 Messages</h3>
      <div class="chat-box">
        {#each messages as msg}
          <div class="message {msg.from_admin ? 'admin-msg' : 'user-msg'}">
            <div class="strong"><strong>{msg.from} :</strong></div>

            <div class="span"><span>{msg.content}</span></div>
          </div>
        {/each}
        {#if messages.length === 0}
          <p style="color: #ccc; text-align: center;">
            Aucun message pour le moment
          </p>
        {/if}
      </div>
    </div>

    <form
      on:submit|preventDefault={sendMessage}
      aria-label="form-contact"
      class="form_contact"
    >
      <div class="p_text">
        <textarea
          aria-label="demande"
          name="message"
          cols="47"
          rows="3"
          bind:value={message}
          placeholder="Écrivez votre message..."
        ></textarea>
        <div>
          <input class="send_button" type="submit" value="Envoyer" />
        </div>
      </div>
    </form>
  {:else}
    <div id="lien">
      <h2>⚠️ Vous devez être connecté pour accéder à cette page</h2>
      <a class="lien" href="#/login">Se connecter </a>
      <span> OU </span>
      <a class="lien" href="#/register"> S'inscrire</a>
    </div>
  {/if}
</main>
