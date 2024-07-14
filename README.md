### Branch naming
Requirement described in the file
```
.validate-branch-namerc.json
```
branch name auto validate on pre-push hook using
[validate-branch-name](https://www.npmjs.com/package/validate-branch-name
) package

### Commit convention
Each commit message must follow the [commit convention](https://www.conventionalcommits.org/)

Automatic message validation on commit-msg git hook.
All setting described in the file
```
commitlint.config.js
```

## Merge commit with semi-linear history

Use line git history. Read [documentation](https://docs.gitlab.com/ee/user/project/merge_requests/methods/#merge-commit-with-semi-linear-history)
