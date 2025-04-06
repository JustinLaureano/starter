#!/bin/bash
set -e

echo "⌛ Waiting for OpenLDAP to fully initialize..."
sleep 5

echo "🔧 Applying custom schema..."
ldapadd -Y EXTERNAL -H ldapi:/// -f /container/init/01-schema.ldif

echo "✅ Schema applied. Sleeping before user import..."
sleep 2

echo "👤 Adding users..."
ldapadd -x -D "cn=admin,dc=example,dc=local" -w $LDAP_ADMIN_PASSWORD -f /container/init/02-users.ldif

echo "🎉 Initialization complete."
