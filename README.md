# CMPE-272 Enterprise Software Platforms Project

A containerized enterprise software platform for CMPE-272 coursework project, featuring Docker, PHP, MySQL, Nginx, and automated CI/CD deployment.

## Requirements

### Git

Version control system for cloning and managing the repository.

[Install Git](https://git-scm.com)

### Docker

Container runtime required to build and run application containers.

[Install Docker](https://www.docker.com)

### Docker Compose

Tool for defining and running multi-container Docker applications.

Check if Docker Compose is included with your Docker installation. If not, install it separately.

[Install Docker Compose](https://docs.docker.com/compose/)

## Quick Links

- [AGENTS.md](./AGENTS.md) - AI agent development guidelines
- [CONTRIBUTING.md](./CONTRIBUTING.md) - Codebase structure and development workflow
- [GIT_WORKFLOW.md](./GIT_WORKFLOW.md) - Git workflow and repository contribution process
- [DEBUG.md](./DEBUG.md) - Debugging and troubleshooting guide
- [SETUP.md](./SETUP.md) - Production environment setup

## Quick Start (Development)

### Clone the repository
```bash
git clone git@github.com:ianbunag/cmpe-272-enterprise-software-platforms-project.git
cd cmpe-272-enterprise-software-platforms-project
```

### Copy .env.example to .env and update values as needed
```bash
cp .env.example .env
```

### Start the development environment
```bash
docker compose up -d
```

### Install dependencies
```bash
docker compose exec php-fpm composer install
```

### Run database migrations
```bash
docker compose exec php-fpm vendor/bin/phinx migrate
```

### Access the application
Access the application at [http://localhost:8080](http://localhost:8080) (or the HTTP_PORT you configured in your .env file).
