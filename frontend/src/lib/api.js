// Récupère le port sur lequel tourne le front
const frontPort = window.location.port;

// Associe automatiquement le backend
const backendPort = frontPort === "5173" ? 8000 : 8001;

export const API_URL = `http://localhost:${backendPort}/api`;
