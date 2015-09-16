#!/usr/bin/env bash
app/console doctrine:database:drop --force
app/console doctrine:database:create
app/console doctrine:schema:update --force
app/console fos:user:create flo flo@flo.flo flo
app/console fos:user:promote flo ROLE_ADMIN
