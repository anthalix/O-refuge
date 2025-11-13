import Echo from "laravel-echo";
import Pusher from "pusher-js";
import { API_URL } from "./api";

window.Pusher = Pusher;

// Exemple : http://localhost:8000
const broadcastToken = localStorage.getItem("broadcast_token"); // Récupère ton token Bearer (Sanctum ou JWT)

export const echo = new Echo({
  broadcaster: "pusher",
  key: import.meta.env.VITE_PUSHER_APP_KEY,
  cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
  forceTLS: true, // false si pas HTTPS local
  authEndpoint: `${API_URL}/broadcasting/auth`,
  auth: {
    headers: {
      Authorization: `Bearer ${broadcastToken}`,
      Accept: "application/json",
    },
  },
});
