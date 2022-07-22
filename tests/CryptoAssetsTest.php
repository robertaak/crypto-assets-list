<?php

test('should display correct data', function () {
    $cryptoAssets = new App\Models\CryptoAsset(
        'DogeCoin',
        'DG',
        999.88
    );
    expect($cryptoAssets->getName())->toBe('DogeCoin');
    expect($cryptoAssets->getSymbol())->toBe('DG');
    expect($cryptoAssets->getPrice())->toBe(999.88);
});