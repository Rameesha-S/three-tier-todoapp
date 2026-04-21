# Three‑Tier ToDo App with Vagrant, Laravel, MySQL, Redis

This project demonstrates a complete three‑tier (plus caching) web application running on four Vagrant virtual machines.

## Architecture

- **Web server** (192.168.56.10) – serves static HTML/JS frontend (port 8080 on host)
- **App server** (192.168.56.11) – Laravel API backend (port 8081 on host)
- **Database server** (192.168.56.12) – MySQL
- **Cache server** (192.168.56.13) – Redis (optional)

## How to run

1. Install [VirtualBox](https://www.virtualbox.org/) and [Vagrant](https://www.vagrantup.com/).
2. Clone this repository:
   ```bash
   git clone https://github.com/YOUR_USERNAME/three-tier-todo-app.git
   cd three-tier-todo-app
