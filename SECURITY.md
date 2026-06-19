# Security Policy

## Supported Versions

Only the latest production release (tracked on the `master` branch) receives security fixes.
Older versions are not actively maintained.

| Branch    | Supported |
| --------- | --------- |
| `master`  | ✅        |
| `dev`     | ⚠️ development — may contain unreleased changes |
| all others | ❌       |

## Reporting a Vulnerability

**Please do not open a public GitHub issue for security vulnerabilities.**

Use [GitHub Private Vulnerability Reporting](https://github.com/Kadsuno/smash-up-randomizer/security/advisories/new)
to submit a report confidentially. This keeps the details private until a fix is available.

### What to include

- A clear description of the vulnerability and its potential impact
- Steps to reproduce (proof-of-concept, curl commands, screenshots, etc.)
- Affected component or file paths, if known
- Suggested fix or mitigation, if you have one

### Response timeline

| Milestone                        | Target     |
| -------------------------------- | ---------- |
| Acknowledgement of report        | 3 days     |
| Confirmed / triaged              | 7 days     |
| Fix released (if confirmed)      | 30 days    |
| Public disclosure (coordinated)  | After fix  |

We follow coordinated disclosure: once a fix is shipped, we will publish a security advisory crediting the reporter (unless you prefer to remain anonymous).

## Out of scope

The following are **not** considered vulnerabilities for this project:

- Issues requiring physical access to the server
- Self-XSS (user harming only themselves)
- Theoretical attacks with no practical exploit path
- Outdated browser or OS issues outside our control
- Spam or social engineering attacks

## Contact

All security reports go through **GitHub Private Vulnerability Reporting** (link above).
There is no separate security e-mail address.
