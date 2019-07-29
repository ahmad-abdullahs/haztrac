# Sidecar PR merging process

## Sidecar repository
  1. Merge a feature branch to master (eg. myFeatureBranch)
  2. Go to sidecar repository
  3. `git fetch upstream master; git checkout -b myMinifiedDirBranch upstream/master`
  4. `yarn`
  5. `gulp build` to create minified files or `./node_modules/gulp/bin/gulp.js build` if there is no gulp-cli in PATH
  6. Commit minified directory, create a new pull request and merge that pull request per rules set forth by a teamlead, take a note of commit hash [**\***](#notation1)

## Mango repository
  1. Go to Mango repository
  2. `git fetch upstream master`
  3. `git checkout -b myFeatureBranch upstream/master`
  4. `cd sidecar; git fetch upstream master; git checkout upstream/master`
  5. `git show HEAD`, ensure that commit hash you see is the same as the commit hash in step 4 of "Sidecar repository"
  6. `git commit sidecar -m 'Update pointer for myFeatureBranch'` [**\*\***](#notation2)
  7. `git push origin myFeatureBranch`
  8. Go to your repo to issue a pull request

## Notes
<a name="notation1"></a>\* The reason we commit minified directory separately is because myFeatureBranch might be one or more commits behind master. If we generated minified files before merging myFeatureBranch (without rebase), minified files would be missing features that have been merged and minified in those commits which myFeatureBranch is missing.

<a name="notation2"></a>\*\* There might be a situation where two or more of sidecar commits get squashed into one **after** developer issued a PR on Mango side updating sidecar pointer. In this situation, developer must go back and update Mango PR with new pointer, as squashed commits generated a new commit, which has a **new** hash.
