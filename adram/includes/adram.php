<?php

if (!function_exists('adram_get_placement_cache_path')) {
    function adram_get_placement_cache_path() {
        return plugin_dir_path(__FILE__) . '../cache/placement-url';
    }
}

if (!function_exists('adram_update_cache')) {
    function adram_update_cache() {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://adram.media/api/2.1/raw/AdRam/GetPlacementURL?ID=" . get_option('adram-placement-id'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "postman-token: 1840cc60-07a8-dcd4-be3a-dd078884c61b"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            $placementScript = '';
        } else {
            $placementScript = $response;
        }
        file_put_contents(adram_get_placement_cache_path(), $placementScript);
    }
}

if (!function_exists('adram_is_placement_cache_valid')) {
    /**
     * @return bool
     */
    function adram_is_placement_cache_valid() {
        $placementCachePath = adram_get_placement_cache_path();
        return file_exists($placementCachePath)
            && (time() - filemtime($placementCachePath) < get_option('adram-placement-cache-lifetime'));
    }
}

if (!function_exists('adram_get_placement_url')) {
    function adram_get_placement_url() {
        if (!adram_is_placement_cache_valid()) {
            adram_update_cache();
        }

        return file_get_contents(adram_get_placement_cache_path());
    }
}
