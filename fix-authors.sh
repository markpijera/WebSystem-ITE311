#!/bin/bash

git filter-branch --force --env-filter '
OLD_NAME1="Jedlang1502"
OLD_NAME2="ArnoldSupilanas"
CORRECT_NAME="markpijera"
CORRECT_EMAIL="jinwosung490@gmail.com"

if [ "$GIT_COMMITTER_NAME" = "$OLD_NAME1" ] || [ "$GIT_COMMITTER_NAME" = "$OLD_NAME2" ]
then
    export GIT_COMMITTER_NAME="$CORRECT_NAME"
    export GIT_COMMITTER_EMAIL="$CORRECT_EMAIL"
fi
if [ "$GIT_AUTHOR_NAME" = "$OLD_NAME1" ] || [ "$GIT_AUTHOR_NAME" = "$OLD_NAME2" ]
then
    export GIT_AUTHOR_NAME="$CORRECT_NAME"
    export GIT_AUTHOR_EMAIL="$CORRECT_EMAIL"
fi
' --tag-name-filter cat -- --branches --tags
