#!/bin/bash
set -e

echo "🟡 Starting custom schema init..."

echo "🔁 Waiting for OpenLDAP to become ready..."
until ldapsearch -x -H ldap://localhost -b dc=example,dc=local > /dev/null 2>&1; do
  sleep 2
done

echo "📦 Applying custom schema..."
ldapadd -Y EXTERNAL -H ldapi:/// -f /container/bootstrap/01-custom-schema.ldif

echo "👤 Adding users..."
ldapadd -x -D "cn=admin,dc=example,dc=local" -w "${LDAP_ADMIN_PASSWORD}" -f /container/bootstrap/02-users.ldif

echo "✅ Init complete."
