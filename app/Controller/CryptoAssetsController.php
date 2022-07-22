<?php

namespace App\Controller;

use App\Models\CryptoAsset;
use App\View;

class CryptoAssetsController
{
    public function show(): View
    {
        $url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest';
        $parameters = [
            'start' => '1',
            'limit' => '10',
            'convert' => 'USD'
        ];

        $headers = [
            'Accepts: application/json',
            'X-CMC_PRO_API_KEY: cf190b86-e00e-4e6a-9d6f-6115228a1d46'
        ];
        $qs = http_build_query($parameters);
        $request = "$url?$qs";


        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $request,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => 1
        ]);

        $assets = json_decode(curl_exec($curl));

        curl_close($curl);

        $cryptoAssets = [];

        foreach ($assets->data as $asset)
        {
            $cryptoAssets[] = new CryptoAsset(
                $asset->name,
                $asset->symbol,
                $asset->quote->USD->price
            );
        }

        return new View('crypto-assets-index.html', ['assets' => $cryptoAssets]);
    }
}