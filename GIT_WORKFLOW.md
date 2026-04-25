# Git Workflow and Repository Contribution

*Estimated read time: 3 minutes*

## Overview

All contributions to the repository follow a standard branch-and-pull-request workflow. This ensures security validation before changes are merged to the main branch.

The review serves primarily for security validation - to ensure no secrets, API keys, credentials, or sensitive information were committed. Follow other suggestions at your discretion as a contributor.

## Workflow Steps

### 1. Create a Feature Branch

Create a new local branch for your work. Use a descriptive name that reflects the feature or fix.

```bash
git switch -c short-description-of-changes
```

### 2. Make Changes

Edit the necessary files in your local environment following the guidelines in [CONTRIBUTING.md](./CONTRIBUTING.md). Commit your changes with clear, descriptive commit messages.

```bash
git add .
git commit -m "Short description of changes"
```

### 3. Push to Repository

Push your branch to the remote repository.

```bash
git push origin short-description-of-changes
```

### 4. Create a Pull Request

Open a pull request against the main branch.

### 5. Request Review from Copilot

Request a review from GitHub Copilot on your pull request.

### 6. Merge the Pull Request

Once the PR is approved and all checks pass, merge the PR into the main branch. Delete the feature branch after merging.

```bash
git switch main
git pull origin main
git branch -d short-description-of-changes
```

## Production Deployment

### Create a Release with Semantic Versioning

Releases are created on GitHub using semantic versioning tags. This triggers automated deployment to production.

**Semantic Version Format**: `major.minor.patch`

- **Major** (e.g., `1.0.0`) - Breaking changes or significant feature releases
- **Minor** (e.g., `0.1.0`) - New features that are backward compatible
- **Patch** (e.g., `0.0.1`) - Bug fixes and small improvements

### Steps to Release

1. Ensure all changes are merged into the main branch and the repository is clean.
2. Go to GitHub repository → Releases → Draft a new release.
3. Click "Select tag" and create a new semantic version tag (e.g., `1.2.3`).
4. Target the main branch.
5. Fill in the release title with the version number (same as the tag, e.g., `1.2.3`).
6. Click "Generate release notes" to autopopulate the description based on merged PRs.
7. Click "Publish release".

The release triggers automated deployment to production. Monitor the deployment progress in GitHub Actions.
