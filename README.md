# Docker LEMP Drupal CMS

A Dockerized LEMP (Linux, Nginx, MySQL, PHP) stack for running a Drupal CMS application.

## Getting Started

### Step 1: Configure Environment Variables

Copy the `env.example` file to a new file named `.env` and update the environment variables as needed.
`cp .env.example .env`

### Step 2: Build and Start Docker Containers

Run the following command to build and start the Docker containers:
```bash
docker compose up -d --build