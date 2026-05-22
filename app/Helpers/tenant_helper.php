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
            return $tenant[$key] ?? null;
        }
        // Return as object so we can do tenant()->pkm_id or tenant()->pkm_nama
        return (object) $tenant;
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
