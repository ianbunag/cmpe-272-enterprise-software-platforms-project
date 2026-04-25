# Setup Guide

*Estimated read time: 10 minutes*

This guide will walk you through setting up your hosting and web programming environment from scratch. Following these steps in order will result in a zero-cost, fully functional, publicly accessible application with automated CI/CD.

The application requires the following components:
- Google Cloud Platform (GCP) to host the application.
  - Other cloud providers can be used, but the instructions will differ.
- Cloudflare for DNS management, SSL, and CDN.
- GitHub to host the source code and run CI/CD automation.

## Phase 1: Infrastructure (Manual GCP Setup)

### 1. GCP VM Setup
- Create a new VM instance in Google Cloud Platform:
    - Machine type: `e2-micro` (1 vCPU, 1GB RAM)
    - Region: `us-west1`
    - Image: **Container-Optimized OS (COS)**

### 2. Static External IP
- Navigate to **VPC Network > IP addresses**.
- Locate the ephemeral external IP assigned to your VM.
- Click **Promote to static** to reserve it. Note this IP; it will be your `VM_HOST`.

### 3. Firewall Rules
- Go to **VPC Network > Firewall**.
  - Edit `default-allow-http`
  - Add/Set to a TCP port other than 80 (e.g., `8080`) to the allowed ports. Note this port; it will be your `HTTP_PORT`.
  - Click **Save**.
- Edit your VM instance.
    - Check **Allow HTTP traffic**.
    - This assigns the `http-server` network tag.

> Setting the HTTP port to something other than 80 allows sharing the server with another application.

### 4. GCP Budget Alert
- In the GCP Billing dashboard, create a budget alert for **$1.00** to monitor costs.

### 5. Cloudflare DNS & SSL
- In your Cloudflare dashboard, add an **A record** pointing your domain to the `VM_HOST` IP.
- Enable the Cloudflare proxy (orange cloud **ON**).
- Create a **Configuration Rule** to apply Flexible SSL only to this record:
    - Navigate to **Rules > Overview**.
    - Click **Create rule**.
    - **Rule name**: "Flexible SSL for yourdomain.com" (or your chosen name).
    - **If incoming requests match…**:
        - Select `Custom filter expression`
    - **When incoming requests match…**
        - Field: `Hostname`
        - Operator: `equals`
        - Value: `yourdomain.com`
    - **Then the settings are…**:
        - Search for **SSL** and set it to **Flexible**.
    - Click **Save**.
- Create an **Origin Rule** to forward requests to the correct port:
    - Click **Create rule**.
    - **Rule name**: "Custom port for yourdomain.com" (or your chosen name).
    - **If incoming requests match…**:
        - Select `Custom filter expression`
    - **When incoming requests match…**
        - Field: `Hostname`
        - Operator: `equals`
        - Value: `yourdomain.com`
    - **Then the settings are…**:
        - Search for **Destination Port** and set it to HTTP port from Phase 1, Step 3 (e.g., `8080`).
    - Click **Save**.

> Flexible SSL allows Cloudflare to handle SSL termination, while communicating with your origin server over HTTP. This is a common setup for applications that do not have their own SSL certificates.

---

## Phase 2: Server Configuration (One-Time Setup)

SSH into your VM via the GCP Console or your local terminal to prepare the environment.

> If you are using a local terminal, set up your personal SSH keys in the GCP Console under **Compute Engine > Metadata > SSH Keys**.

### 1. Create the App Directory and Docker Compose Wrapper
The application files reside in `/var/lib/app/cmpe-272-project`. Since COS may prevent binary execution on writable partitions, we use a wrapper script that runs Docker Compose inside a container.

```bash
sudo mkdir -p /var/lib/app/cmpe-272-project
sudo chown $USER:docker /var/lib/app/cmpe-272-project
sudo chmod 2775 /var/lib/app/cmpe-272-project

# Create the wrapper script
cat > /var/lib/app/cmpe-272-project/docker-compose << 'EOF'
#!/bin/bash
# Wrapper to run docker-compose in a container
# Inherits all shell environment variables and the .env file

# 1. Load the .env file if it exists
ENV_FILE="/var/lib/app/cmpe-272-project/.env"
ENV_OPTS=""
if [ -f "$ENV_FILE" ]; then
  ENV_OPTS="--env-file $ENV_FILE"
fi

# 2. Inherit all current shell variables
# This generates a list of -e VAR1 -e VAR2 for every variable in the shell
INHERIT_VARS=$(env | cut -d= -f1 | sed 's/^/-e /' | tr '\n' ' ')

docker run --rm \
  -v /var/run/docker.sock:/var/run/docker.sock \
  -v /var/lib/app/cmpe-272-project:/var/lib/app/cmpe-272-project \
  -v "$PWD":"$PWD" \
  -w "$PWD" \
  $ENV_OPTS \
  $INHERIT_VARS \
  docker/compose:alpine-1.29.2 "$@"
EOF

# Make it executable
chmod +x /var/lib/app/cmpe-272-project/docker-compose
```

### 2. Configure Deployment User
Ensure the user used for SSH deployment is in the `docker` group. Replace `VM_USERNAME` with your intended deployment username.
```bash
sudo usermod -aG docker VM_USERNAME
```
*IMPORTANT: You must restart your SSH session or log out/in for this to take effect.*

---

## Phase 3: CI/CD Integration (GitHub Setup)

### 1. Generate SSH Keys
On your local machine, generate a key pair for the GitHub Actions runner.
```bash
ssh-keygen -t ed25519 -f ./DEPLOY_KEY -C "VM_USERNAME"
```
1. **Public Key**: Add the content of `DEPLOY_KEY.pub` to **GCP Console > Compute Engine > Metadata > SSH Keys**.
2. **Private Key**: Copy the content of `DEPLOY_KEY` for the GitHub Secret below.

### 2. Add GitHub Secrets
In your repository, go to **Settings > Secrets and variables > Actions** and add:

| Secret | Value                                         |
|--------|-----------------------------------------------|
| `VM_HOST` | The Static IP from Phase 1, Step 2            |
| `VM_USERNAME` | The username from Phase 2, Step 2             |
| `SSH_PRIVATE_KEY` | The private key from Phase 3, Step 1          |
| `HTTP_PORT` | HTTP port from Phase 1, Step 3 (e.g., `8080`) |
| `DB_PORT` | Database port                                 |
| `DB_USER` | Database username                             |
| `DB_PASSWORD` | Database password                             |

---

## Phase 4: Maintenance and Updates

### Recreating the application

If a deployment fails, or you need to reset the application state, you can SSH into the VM and run the following commands to stop and remove all containers and volumes:

1. SSH into the VM.
2. Run `cd /var/lib/app/cmpe-272-project`
3. Run `bash ./docker-compose down -v`
4. Redeploy by pushing a new tag.

### Connecting to the database

Use a database client that supports SSH tunneling (e.g., DBeaver, PhpStorm) to connect to the database on the VM. Configure the SSH connection using `VM_HOST`, your personal username and the private key. Set the database host to `localhost` and the port to `DB_PORT`.