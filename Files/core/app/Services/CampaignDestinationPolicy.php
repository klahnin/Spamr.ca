<?php

namespace App\Services;

class CampaignDestinationPolicy
{
    public const RESTRICTED_COUNTRY_CODES = ['US', 'RU', 'CN', 'IL', 'BY', 'IR', 'KP', 'CU', 'SY', 'AF', 'MM', 'VE', 'YE', 'SD', 'SO', 'LY', 'HT'];

    public const RESTRICTED_COUNTRY_NAMES = [
        'United States', 'United States of America', 'USA', 'Russia', 'Russian Federation', 'China',
        "People's Republic of China", 'Israel', 'Belarus', 'Iran', 'Iran - Islamic Republic of Persian Gulf',
        'Islamic Republic of Iran', 'North Korea', "Democratic People's Republic of Korea", 'Cuba', 'Syria',
        'Syrian Arab Republic', 'Afghanistan', 'Myanmar', 'Burma', 'Venezuela', 'Yemen', 'Sudan', 'Somalia',
        'Libya', 'Libyan Arab Jamahiriya', 'Haiti', 'Crimea', 'Donetsk', 'Luhansk',
    ];

    private const RESTRICTED_UKRAINE_REGIONS = ['crimea', 'donetsk', 'luhansk'];

    public function isRestrictedDestination(?string $country, ?string $state = null): bool
    {
        $country = $this->normalise($country);
        $state = $this->normalise($state);
        $restrictedCountries = array_map(fn ($name) => $this->normalise($name), self::RESTRICTED_COUNTRY_NAMES);

        if (in_array($country, $restrictedCountries, true)) {
            return true;
        }

        return $country === 'ukraine'
            && collect(self::RESTRICTED_UKRAINE_REGIONS)->contains(fn ($region) => str_contains($state, $region));
    }

    public function normalise(?string $value): string
    {
        return trim((string) preg_replace('/[^a-z0-9]+/i', ' ', strtolower((string) $value)));
    }
}
