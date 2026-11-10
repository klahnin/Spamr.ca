<?php

namespace App\Http\Controllers;

use App\Services\CampaignDestinationPolicy;
use Illuminate\Http\Request;

class CampaignCoverageController extends Controller
{
    public function check(Request $request, CampaignDestinationPolicy $policy)
    {
        $validated = $request->validate([
            'countries' => ['required', 'string', 'max:800'],
        ]);

        $inputs = collect(preg_split('/[,;\n\r]+/', $validated['countries']))
            ->map(fn ($country) => trim($country))
            ->filter()
            ->unique(fn ($country) => $policy->normalise($country))
            ->take(20)
            ->values();

        if ($inputs->isEmpty()) {
            return response()->json(['message' => 'Enter at least one country name.'], 422);
        }

        $countryData = json_decode(file_get_contents(resource_path('views/partials/country.json')), true);
        $knownCountries = collect($countryData)->mapWithKeys(fn ($country) => [$policy->normalise($country['country']) => $country['country']]);
        $aliases = [
            'usa' => 'United States', 'united states of america' => 'United States', 'russian federation' => 'Russia',
            'peoples republic of china' => 'China', 'iran' => 'Iran - Islamic Republic of Persian Gulf',
            'islamic republic of iran' => 'Iran - Islamic Republic of Persian Gulf', 'north korea' => "Democratic People's Republic of Korea",
            'syria' => 'Syrian Arab Republic', 'burma' => 'Myanmar', 'libya' => 'Libyan Arab Jamahiriya',
        ];

        $results = $inputs->map(function ($input) use ($policy, $knownCountries, $aliases) {
            $normalised = $policy->normalise($input);
            $country = $aliases[$normalised] ?? $knownCountries->get($normalised);

            if (collect(['crimea', 'donetsk', 'luhansk'])->contains(fn ($region) => str_contains($normalised, $region))) {
                return ['input' => $input, 'country' => $input, 'status' => 'restricted', 'message' => 'Campaign delivery is unavailable for this restricted region.'];
            }

            if (!$country) {
                return ['input' => $input, 'country' => $input, 'status' => 'unknown', 'message' => 'We could not match this destination. Check the country name before creating a campaign.'];
            }

            if ($policy->isRestrictedDestination($country)) {
                return ['input' => $input, 'country' => $country, 'status' => 'restricted', 'message' => 'Campaign delivery is unavailable for this destination.'];
            }

            return ['input' => $input, 'country' => $country, 'status' => 'supported', 'message' => 'Campaign delivery is available for this destination.'];
        });

        return response()->json(['data' => ['results' => $results]]);
    }
}
