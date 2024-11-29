<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Iodev\Whois\Factory;
use Illuminate\Support\Facades\Validator;

class WhoisController extends Controller
{
    public function query(Request $request)
    {
        // Validazione del dominio
        $validator = Validator::make($request->all(), [
            'domain' => ['required', 'string', 'regex:/^[a-z0-9-]+(\.[a-z]{2,})+$/i', 'ends_with:.com'],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid domain or not a .com domain'], 400);
        }

        $domain = $request->input('domain');
        try {
            // Interrogazione WHOIS
            $whois = Factory::get()->createWhois();
            $info = $whois->loadDomainInfo($domain);

            if (!$info) {
                return response()->json(['error' => 'WHOIS data not found'], 404);
            }

            return response()->json(['domain' => $domain, 'whois' => $info->toArray()], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }
}
