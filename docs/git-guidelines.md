# Git Commit & Changelog Style Guide

This guide outlines how our development team should write Git commit messages and maintain the project changelog. Consistent practices improve collaboration, automate release processes, and keep our history readable.

---

## Git Commit Messages

We use the [Conventional Commits](https://www.conventionalcommits.org/en/v1.0.0/) specification for all commit messages. This ensures clarity, enables automation (e.g., changelog generation), and aligns with semantic versioning.

### Format

```
<type>(<scope>): <short summary>

<optional body with details, wrapped at 72 characters>

<optional footer with issue references or notes>
```

- ```<type>```: Category of the change (see list below).
- ```<scope>```: Specific part of the project affected (see list below).
- ```<short summary>```: Concise description (50 characters max), written in present tense (e.g., "Add" not "Added").
- ```<body>```: Additional context, reasoning, or details (optional).
- ```<footer>```: References to issues, breaking changes, etc. (optional).


### Rules
1. Use present tense: "Fix bug" not "Fixed bug".
2. Keep the summary under 50 characters for readability in logs.
3. Wrap body text at 72 characters for clean formatting.
4. Reference issue tracker IDs (e.g., ```#123```) in the footer when applicable.
5. Capitalize the first letter of the summary after the colon.


## Commit Types
The `<type>` indicates the nature of the change. Use one of the following:

| Type | Description | SemVer Impact |  
|------|-------------|---------------|
| `feat` | New feature or functionality | Minor |
| `fix` | Bug fix or correction | Patch |
| `docs` | Documentation updates (README, comments, etc.) | None |
| `style` | Code formatting (whitespace, semicolons, etc.) | None |
| `refactor` | Code restructuring (no feature/fix) | None |
| `test` | Adding or updating tests | None |
| `chore` | Maintenance tasks (deps, config, build tools) | None |
| `perf` | Performance improvements | Patch |
| `ci` | Changes to CI/CD pipelines | None |
| `build` | Build system or external dependency changes | None |
| `revert` | Revert a previous commit | None |
| `security` | Fixes for security vulnerabilities | Patch |
| `wip` | Work in progress (use sparingly, squash later) | None |


## Commit Scopes
The `<scope>` specifies the area of the project affected. Below is an exhaustive list tailored for web development (adjust based on your project):

| Scope | Description |
|-------|-------------|
| `api` | API endpoints or logic |
| `auth` | Authentication or authorization |
| `backend` | General backend changes |
| `build` | Build configuration (e.g., webpack, vite) |
| `ci` | Continuous integration setup |
| `components` | UI components (e.g., React, Vue) |
| `config` | Configuration files (env, settings) |
| `controller` | MVC controllers or similar |
| `css` | Stylesheets or CSS-related changes |
| `db` | Database schema or queries |
| `deps` | Dependency updates (e.g., npm, composer) |
| `docs` | Documentation files or inline comments |
| `frontend` | General frontend changes |
| `hooks` | Custom hooks (e.g., React hooks) |
| `i18n` | Internationalization or localization |
| `infra` | Infrastructure (servers, deployments) |
| `layout` | Page layouts or templates |
| `middleware` | Middleware logic (e.g., Express, Laravel) |
| `migration` | Database migrations |
| `model` | Data models or ORM entities |
| `pages` | Page-level changes (e.g., Next.js pages) |
| `perf` | Performance optimizations |
| `routes` | Routing configuration |
| `scripts` | Utility or build scripts |
| `security` | Security-related changes |
| `seo` | SEO improvements (meta tags, sitemaps) |
| `server` | Server-side logic or configuration |
| `ssg` | Static site generation |
| `ssr` | Server-side rendering |
| `styles` | Styling (global or component-specific) |
| `test` | Test files or suites |
| `ui` | User interface changes |
| `ux` | User experience improvements |
| `utils` | Utility functions or helpers |
| `view` | View templates (e.g., Blade, JSX) |

If a scope isn't listed, choose the most specific term that fits or omit it (e.g., ```feat: add initial project setup```).

---

## Examples

Here are sample commit messages for common scenarios:

1. Adding a Feature
```bash
feat(api): add user profile endpoint

Implement GET /api/user/{id} to fetch user details.
Add validation and error handling for invalid IDs.

Closes #45
```

2. Fixing a Bug
```bash
fix(frontend): resolve broken nav links

Update hrefs in Navbar component to match new routes.
Test navigation on mobile and desktop views.
```

3. Refactoring
```bash
refactor(model): simplify user data structure

Remove unused fields from User model and update queries.
Improve readability and reduce DB load.
```

4. Documentation
```bash
docs(readme): update installation instructions

Add steps for setting up environment variables and DB.
```

5. Dependency Update
```bash
chore(deps): upgrade laravel/framework to v10

Update composer.json and resolve breaking changes in auth.
```

6. Performance
```bash
perf(ssg): enable lazy loading for images

Add IntersectionObserver to defer off-screen image loads.
Reduces initial page load time by 20%.
```

7. Breaking Change
```bash
feat(api): redesign product API response format

Change response keys from snake_case to camelCase.
Update frontend to match new structure.

BREAKING CHANGE: Clients must update API parsing logic.
Closes #78
```


## Creating Message

Here’s how to create a Git commit message with a short summary, body, and footer (details) using the general Git command structure.

### General Git Command Structure
You can use git commit with the -m flag to specify the message. For multi-line messages (summary, body, and footer), you can either:

1. Use multiple -m flags (one per paragraph).
2. Open an editor by omitting -m or using -e.

#### Option 1: Using Multiple -m Flags

```bash
git commit -m "<type>(<scope>): <short summary>" -m "<body>" -m "<footer>"
```

- Each -m creates a new paragraph in the commit message.
- The first -m is the summary (50 characters max).
- Subsequent -m flags add the body and footer.

#### Option 2: Using the Editor

```bash
git commit
```

- This opens your default text editor (e.g., Vim, Nano, or VS Code if configured).
- Type the full message with summary, body, and footer, separated by blank lines.
- Save and exit the editor to commit.


### Examples

#### Example 1: Using Multiple -m Flags

```bash
git commit -m "feat(api): add user profile endpoint" -m "Implement GET /api/user/{id} to fetch user details. Add validation and error handling for invalid IDs." -m "Closes #45"
```

#### Resulting Commit Message:

```
feat(api): add user profile endpoint

Implement GET /api/user/{id} to fetch user details.
Add validation and error handling for invalid IDs.

Closes #45
```

#### Example 2: Using the Editor

Open editor:

```bash
git commit
```

In the editor, type:

```
feat(frontend): add dark mode toggle

Add CSS variables and toggle button for dark mode.
Tested on Chrome and Firefox for consistency.

Refs #72
```

Save and exit (e.g., ```:wq``` in Vim).

#### Resulting Commit Message:

```
feat(frontend): add dark mode toggle

Add CSS variables and toggle button for dark mode.
Tested on Chrome and Firefox for consistency.

Refs #72
```

### Tips

- **Staging First**: Always stage changes with git add . or git add <file> before committing.
- **Editor Config**: Set your preferred editor with git config --global core.editor "nano" (or code --wait for VS Code).
- **Line Wrapping**: Keep the body at 72 characters per line for readability (most editors show a guide).
- **Amend**: If you mess up, use git commit --amend to edit the last commit.



## Changelog Management

We maintain a CHANGELOG.md file in the project root to document significant changes for users and developers.

### Format

Follow the [Keep a Changelog](https://keepachangelog.com/en/1.0.0/) style:

```markdown
# Changelog
All notable changes to this project will be documented here.

## [Unreleased]
- <list changes here>

## [1.0.1] - 2025-03-30
### Added
- New user profile endpoint in API.
### Fixed
- Broken navigation links on mobile.

## [1.0.0] - 2025-03-25
### Added
- Initial project setup with auth and CRUD.
```


### Sections

- ```Added```: New features or enhancements.
- ```Changed```: Updates to existing functionality, including changes to existing features, dependencies, APIs, or behaviors.
- ```Deprecated```: Features marked for removal.
- ```Removed```: Deleted features or code.
- ```Fixed```: Bug fixes.
- ```Security```: Security patches.


### Workflow

1. During Development:
- Add changes to [Unreleased] manually or via commits.

2. On Release:
- Use standard-version to automate:
  - Parse commits.
  - Move [Unreleased] to a versioned section (e.g., [1.0.1]).
  - Update package.json version.
  - Create a Git tag.
- Command: npm run release.

3. Push:
- git push --follow-tags.

### Automation Setup

Install ```standard-version```:

```bash
npm install --save-dev standard-version
```

Add to ```package.json```:

```json
"scripts": {
  "release": "standard-version"
}
```
---

## Best Practices

- Be Specific: Include enough detail to understand the change without digging into code.
- Link Issues: Use Closes #123 or Refs #123 in the footer.
- Squash WIP Commits: Combine wip commits into meaningful ones before merging.
- Review: Ensure commits are clear during pull request reviews.
- Semantic Versioning: Use feat for minor bumps, fix for patches, and note breaking changes explicitly.

---

## Questions?

If unsure about a type, scope, or process, ask the team! Consistency is key.
