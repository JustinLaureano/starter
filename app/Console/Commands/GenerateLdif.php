<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateLdif extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:ldif
                            {csv : The path to the CSV file}
                            {--output=docker/ldap/users.ldif : The output LDIF file path}
                            {--default-password=password123 : The default password for users}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate an LDIF file from a CSV file for OpenLDAP seeding';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Get command arguments and options
        $csvFile = $this->argument('csv');
        $ldifFile = $this->option('output');
        $baseDn = env('LDAP_BASE_DN', 'dc=example,dc=local');
        $ou = 'ou=users';
        $defaultPassword = $this->option('default-password');

        // Ensure the output directory exists
        $ldifDir = dirname($ldifFile);
        if (!is_dir($ldifDir)) {
            mkdir($ldifDir, 0777, true);
            $this->info("Created directory: $ldifDir");
        }

        // Open the LDIF file for writing
        $ldifHandle = fopen($ldifFile, 'w');
        if (!$ldifHandle) {
            $this->error("Could not open LDIF file '$ldifFile' for writing.");
            return 1;
        }

        // Write the Organizational Unit entry
        fwrite($ldifHandle, "# Organizational Unit for Users\n");
        fwrite($ldifHandle, "dn: $ou,$baseDn\n");
        fwrite($ldifHandle, "objectClass: organizationalUnit\n");
        fwrite($ldifHandle, "ou: users\n\n");

        // Open and read the CSV file
        if (!file_exists($csvFile) || !is_readable($csvFile)) {
            $this->error("CSV file '$csvFile' not found or not readable.");
            fclose($ldifHandle);
            return 1;
        }

        $csvHandle = fopen($csvFile, 'r');
        if (!$csvHandle) {
            $this->error("Could not open CSV file '$csvFile'.");
            fclose($ldifHandle);
            return 1;
        }

        // Get the header row
        $headers = fgetcsv($csvHandle);
        if (!$headers) {
            $this->error("CSV file is empty or malformed.");
            fclose($csvHandle);
            fclose($ldifHandle);
            return 1;
        }

        // Process each row
        $userCount = 0;
        while (($row = fgetcsv($csvHandle)) !== false) {
            // Map CSV row to associative array based on headers
            $user = array_combine($headers, $row);

            // Extract and sanitize fields
            $username = trim($user['username'] ?? '');
            $givenName = trim($user['givenname'] ?? '');
            $sn = trim($user['sn'] ?? '');
            $displayName = trim($user['displayname'] ?? '');
            $title = trim($user['title'] ?? '');
            $description = trim($user['description'] ?? '');
            $department = trim($user['department'] ?? '');
            $mail = trim($user['mail'] ?? '');

            // Skip if username is empty
            if (empty($username)) {
                $this->warn("Skipping row with empty username.");
                continue;
            }

            // Write user entry to LDIF
            fwrite($ldifHandle, "# User: $username\n");
            fwrite($ldifHandle, "dn: uid=$username,$ou,$baseDn\n");
            fwrite($ldifHandle, "objectClass: user\n");
            fwrite($ldifHandle, "uid: $username\n"); // Maps to samaccountname
            if (!empty($givenName)) fwrite($ldifHandle, "givenName: $givenName\n");
            if (!empty($sn)) fwrite($ldifHandle, "sn: $sn\n");
            if (!empty($displayName)) fwrite($ldifHandle, "displayName: $displayName\n");
            if (!empty($title)) fwrite($ldifHandle, "title: $title\n");
            if (!empty($description)) fwrite($ldifHandle, "description: $description\n");
            if (!empty($department)) fwrite($ldifHandle, "department: $department\n");
            if (!empty($mail)) fwrite($ldifHandle, "mail: $mail\n");
            fwrite($ldifHandle, "userPassword: $defaultPassword\n");
            fwrite($ldifHandle, "\n");

            $userCount++;
        }

        // Close file handles
        fclose($csvHandle);
        fclose($ldifHandle);

        $this->info("Generated '$ldifFile' with $userCount users.");
        return 0;
    }
}