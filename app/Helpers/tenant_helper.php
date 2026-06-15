<?php

class TenantManager {
    public static $tenant = null;
}

if (!function_exists('tenant')) {
    /**
     * Get active tenant data.
     * 
     * @param string|null $key Specific key to fetch (e.g. 'pkm_id')
     * @return mixed Object containing all tenant data or specific value.
     */
    function tenant($key = null) {
        $tenant = \TenantManager::$tenant;
        if (!$tenant) {
            return null;
        }
        if ($key) {
            if (is_array($tenant)) {
                return $tenant[$key] ?? null;
            }
            return $tenant->$key ?? null;
        }
        return is_object($tenant) ? $tenant : (object) $tenant;
    }
}

if (!function_exists('set_tenant')) {
    /**
     * Set active tenant globally.
     */
    function set_tenant($tenantData) {
        \TenantManager::$tenant = $tenantData;
    }
}

if (!function_exists('tenant_url')) {
    /**
     * Generate URL for tenant (custom domain or slug based).
     */
    function tenant_url($path = '') {
        $tenant = tenant();
        if (!$tenant) {
            return base_url($path);
        }

        $path = ltrim($path, '/');

        // Jika ada domain kustom
        if (!empty($tenant->pkm_domain)) {
            $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https://' : 'http://';
            return $protocol . $tenant->pkm_domain . '/' . $path;
        }

        // Jika menggunakan domain utama (fallback ke slug)
        return base_url($tenant->pkm_slug . '/' . $path);
    }
}
