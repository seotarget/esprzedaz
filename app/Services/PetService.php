<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PetService
{
    private string $baseUrl = 'https://petstore.swagger.io/v2';

    /**
     * Pobierz wszystkie zwierzęta
     */
    public function getAllPets(): array
    {
        $response = Http::get("{$this->baseUrl}/pet/findByStatus", [
            'status' => 'available',
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Nie udało się pobrać zwierząt: '.$response->body());
    }

    /**
     * Pobierz zwierzę po ID
     */
    public function getPetById(int $id): array
    {
        $response = Http::get("{$this->baseUrl}/pet/{$id}");

        if ($response->successful()) {
            return $response->json();
        }

        if ($response->status() === 404) {
            throw new \Exception('Zwierzę nie zostało znalezione');
        }

        throw new \Exception('Nie udało się pobrać zwierzęcia: '.$response->body());
    }

    /**
     * Dodaj nowe zwierzę
     */
    public function createPet(array $petData): array
    {
        $response = Http::post("{$this->baseUrl}/pet", $petData);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Nie udało się dodać zwierzęcia: '.$response->body());
    }

    /**
     * Zaktualizuj zwierzę
     */
    public function updatePet(array $petData): array
    {
        $response = Http::put("{$this->baseUrl}/pet", $petData);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Nie udało się zaktualizować zwierzęcia: '.$response->body());
    }

    /**
     * Usuń zwierzę
     */
    public function deletePet(int $id): bool
    {
        $response = Http::delete("{$this->baseUrl}/pet/{$id}");

        if ($response->successful()) {
            return true;
        }

        if ($response->status() === 404) {
            throw new \Exception('Zwierzę nie zostało znalezione');
        }

        throw new \Exception('Nie udało się usunąć zwierzęcia: '.$response->body());
    }
}
