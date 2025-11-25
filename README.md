# O-refuge

[![Laravel](https://img.shields.io/badge/Laravel-10-red?logo=laravel)](https://laravel.com/)
[![PHP](https://img.shields.io/badge/PHP-8.2-blue?logo=php)](https://www.php.net/)
[![Svelte](https://img.shields.io/badge/Svelte-3.59-orange?logo=svelte)](https://svelte.dev/)
[![Build Status](https://img.shields.io/github/actions/workflow/status/anthalix/O-refuge/ci.yml?branch=main)](https://github.com/anthalix/O-refuge/actions)
[![Coverage](https://img.shields.io/badge/Coverage-100%25-brightgreen)](https://github.com/anthalix/O-refuge)
[![License](https://img.shields.io/badge/License-MIT-green)](LICENSE)
[![GitHub issues](https://img.shields.io/github/issues/anthalix/O-refuge)](https://github.com/anthalix/O-refuge/issues)
[![GitHub forks](https://img.shields.io/badge/GitHub-forks-blue)](https://github.com/anthalix/O-refuge/network)

O-refuge est une application web pour l’adoption d’animaux. Les utilisateurs peuvent filtrer les animaux, consulter les fiches, et contacter l’équipe via un formulaire. Les administrateurs disposent d’un backoffice CRUD et peuvent communiquer via une messagerie en temps réel.

---

## Architecture

```mermaid
flowchart LR
    subgraph Frontend
        A[Svelte] -->|Appelle API REST| B(Laravel Backend)
    end

    subgraph Backend
        B --> C[MySQL Database]
        B --> D[Pusher / Laravel Echo]
    end

    subgraph Utilisateurs
        U[Utilisateur] -->|Navigue & Envoie messages| A
    end

    subgraph Administrateurs
        Admin[Admin] -->|Gère animaux & messages| B
    end

    D -->|Push notifications| A
Installation et Configuration

Cloner le dépôt
git clone https://github.com/anthalix/O-refuge.git
cd O-refuge

    Installer les dépendances backend

composer install

    Installer les dépendances frontend

npm install

    Copier .env.example en .env

cp .env.example .env

    Générer la clé Laravel

php artisan key:generate

    Configurer la base de données dans .env

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=o_refuge
DB_USERNAME=root
DB_PASSWORD=

    Configurer Pusher pour la messagerie temps réel

PUSHER_APP_ID=...
PUSHER_APP_KEY=...
PUSHER_APP_SECRET=...
PUSHER_APP_CLUSTER=...
BROADCAST_DRIVER=pusher

    Exécuter les migrations et seeders

php artisan migrate --seed

    Lancer le frontend Svelte

npm run dev

Screenshots

(Remplace ces liens par tes captures réelles)

    Page d’accueil :

    Fiche animal :

    Backoffice admin :

    Messagerie :

Contribuer

    Fork le projet

    Crée une branche (git checkout -b feature/ma-fonctionnalite)

    Commit (git commit -m "Ajout de ... ")

    Push (git push origin feature/ma-fonctionnalite)

    Ouvre un Pull Request

Licence

MIT License © Anthalix
