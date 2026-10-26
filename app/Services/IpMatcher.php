<?php

namespace App\Services;

class IpMatcher
{
    /**
     * Check if a client IP matches any of the registered IP expressions.
     */
    public static function matches(?string $clientIp, ?string $registeredIps): bool
    {
        if (empty($clientIp) || empty($registeredIps)) {
            return false;
        }

        $clientIp = trim($clientIp);

        // Normalize localhost IPv6 to IPv4 loopback
        if ($clientIp === '::1') {
            $clientNormalized = '127.0.0.1';
        } else {
            $clientNormalized = self::normalizeIp($clientIp);
        }

        // Split multiple IPs by comma, semicolon, space, or newline
        $ipList = preg_split('/[,;\s\r\n]+/', trim($registeredIps), -1, PREG_SPLIT_NO_EMPTY);

        foreach ($ipList as $registeredPattern) {
            $registeredPattern = trim($registeredPattern);
            if (empty($registeredPattern)) {
                continue;
            }

            // Normalize pattern if it's localhost or a standard IP
            if ($registeredPattern === 'localhost' || $registeredPattern === '::1') {
                $registeredPattern = '127.0.0.1';
            }

            // 1. Direct or Normalized Match (handles leading zeros like 192.168.88.09)
            $normalizedPattern = self::normalizeIp($registeredPattern);
            if ($clientNormalized === $normalizedPattern || $clientIp === $registeredPattern) {
                return true;
            }

            // 2. Wildcard Match (e.g., 192.168.88.*)
            if (str_contains($registeredPattern, '*')) {
                $patternRegex = '/^' . str_replace(['.', '*'], ['\.', '\d+'], $registeredPattern) . '$/';
                if (preg_match($patternRegex, $clientNormalized) || preg_match($patternRegex, $clientIp)) {
                    return true;
                }
            }

            // 3. CIDR Subnet Match (e.g., 192.168.88.0/24)
            if (str_contains($registeredPattern, '/')) {
                if (self::cidrMatch($clientNormalized, $registeredPattern)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Normalize an IP address by stripping leading zeros from IPv4 octets.
     * Example: "192.168.88.09" -> "192.168.88.9"
     */
    public static function normalizeIp(string $ip): string
    {
        $ip = trim($ip);

        // Check if standard IPv4 format
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $octets = explode('.', $ip);
            $normalized = array_map(fn ($octet) => (string) (int) $octet, $octets);

            return implode('.', $normalized);
        }

        // Regex for IPv4 with possible leading zeros
        if (preg_match('/^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/', $ip, $matches)) {
            $normalized = [
                (int) $matches[1],
                (int) $matches[2],
                (int) $matches[3],
                (int) $matches[4],
            ];

            return implode('.', $normalized);
        }

        return $ip;
    }

    /**
     * Check if an IPv4 address is within a CIDR range.
     */
    protected static function cidrMatch(string $ip, string $cidr): bool
    {
        [$subnet, $mask] = explode('/', $cidr, 2);

        $subnet = self::normalizeIp($subnet);
        $mask = (int) $mask;

        if ($mask < 0 || $mask > 32) {
            return false;
        }

        $ipLong = ip2long($ip);
        $subnetLong = ip2long($subnet);

        if ($ipLong === false || $subnetLong === false) {
            return false;
        }

        $maskLong = -1 << (32 - $mask);

        return ($ipLong & $maskLong) === ($subnetLong & $maskLong);
    }
}
