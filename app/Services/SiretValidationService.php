<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class SiretValidationService
{
    protected $baseUrl = 'https://api.insee.fr/entreprises/sirene/V3';
    protected $tokenUrl = 'https://api.insee.fr/token';

    /**
     * Valide un numéro SIRET
     *
     * @param string $siret
     * @return array
     */
    public function validateSiret(string $siret): array
    {
        try {
            // Vérifie d'abord la validité mathématique du SIRET
            if (!$this->isValidSiretFormat($siret)) {
                return [
                    'valid' => false,
                    'message' => 'Le numéro SIRET n\'est pas valide (format incorrect).',
                    'data' => null
                ];
            }

            // Récupère les informations de l'entreprise
            $response = $this->getCompanyInfo($siret);

            if (!$response['valid']) {
                return $response;
            }

            // Vérifie si l'établissement est toujours actif
            if ($response['data']['etablissement']['etatAdministratifEtablissement'] !== 'A') {
                return [
                    'valid' => false,
                    'message' => 'Cet établissement n\'est plus actif.',
                    'data' => $response['data']
                ];
            }

            return [
                'valid' => true,
                'message' => 'SIRET valide',
                'data' => $response['data']
            ];
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la validation du SIRET:', [
                'siret' => $siret,
                'error' => $e->getMessage()
            ]);

            return [
                'valid' => false,
                'message' => 'Une erreur est survenue lors de la validation du SIRET.',
                'data' => null
            ];
        }
    }

    /**
     * Vérifie la validité mathématique du SIRET
     *
     * @param string $siret
     * @return bool
     */
    protected function isValidSiretFormat(string $siret): bool
    {
        // Vérifie la longueur
        if (strlen($siret) !== 14) {
            return false;
        }

        // Vérifie que ce sont uniquement des chiffres
        if (!ctype_digit($siret)) {
            return false;
        }

        // Algorithme de Luhn
        $sum = 0;
        for ($i = 0; $i < 14; $i++) {
            $digit = intval($siret[$i]);
            if ($i % 2 === 0) {
                $digit *= 2;
                if ($digit > 9) {
                    $digit -= 9;
                }
            }
            $sum += $digit;
        }

        return ($sum % 10) === 0;
    }

    /**
     * Récupère les informations de l'entreprise via l'API INSEE
     *
     * @param string $siret
     * @return array
     */
    protected function getCompanyInfo(string $siret): array
    {
        try {
            $token = $this->getAccessToken();

            $response = Http::withToken($token)
                ->get("{$this->baseUrl}/siret/{$siret}");

            if ($response->successful()) {
                return [
                    'valid' => true,
                    'message' => 'Succès',
                    'data' => $response->json()
                ];
            }

            if ($response->status() === 404) {
                return [
                    'valid' => false,
                    'message' => 'Ce numéro SIRET n\'existe pas.',
                    'data' => null
                ];
            }

            return [
                'valid' => false,
                'message' => 'Impossible de vérifier ce numéro SIRET pour le moment.',
                'data' => null
            ];
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la requête à l\'API INSEE:', [
                'error' => $e->getMessage()
            ]);

            return [
                'valid' => false,
                'message' => 'Erreur lors de la vérification du SIRET.',
                'data' => null
            ];
        }
    }

    /**
     * Récupère un token d'accès pour l'API INSEE
     *
     * @return string
     * @throws \Exception
     */
    protected function getAccessToken(): string
    {
        // Vérifie si un token valide est en cache
        if (Cache::has('insee_token')) {
            return Cache::get('insee_token');
        }

        // Récupère les credentials depuis les variables d'environnement
        $consumerKey = config('services.insee.key');
        $consumerSecret = config('services.insee.secret');

        if (!$consumerKey || !$consumerSecret) {
            throw new \Exception('Les credentials de l\'API INSEE ne sont pas configurés.');
        }

        // Fait la requête pour obtenir un nouveau token
        $response = Http::withBasicAuth($consumerKey, $consumerSecret)
            ->asForm()
            ->post($this->tokenUrl, [
                'grant_type' => 'client_credentials'
            ]);

        if (!$response->successful()) {
            throw new \Exception('Impossible d\'obtenir un token d\'accès INSEE.');
        }

        $data = $response->json();
        $token = $data['access_token'];
        $expiresIn = $data['expires_in'];

        // Stocke le token en cache
        Cache::put('insee_token', $token, now()->addSeconds($expiresIn - 60));

        return $token;
    }
} 