<?php

namespace App\Http\Controllers;

use App\Services\PetService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class PetController extends Controller
{
    private PetService $petService;

    public function __construct(PetService $petService)
    {
        $this->petService = $petService;
    }

    /**
     * Wyświetl listę wszystkich zwierząt
     */
    public function index(): View
    {
        try {
            $pets = $this->petService->getAllPets();
            return view('pets.index', compact('pets'));
        } catch (\Exception $e) {
            return view('pets.index', ['pets' => [], 'error' => $e->getMessage()]);
        }
    }

    /**
     * Wyświetl formularz dodawania
     */
    public function create(): View
    {
        return view('pets.create');
    }

    /**
     * Zapisz nowe zwierzę
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:available,pending,sold',
        ]);

        try {
            $petData = [
                'name' => $request->name,
                'status' => $request->status,
                'category' => ['name' => $request->category ?? 'default'],
                'tags' => [['name' => $request->tags ?? 'default']],
                'photoUrls' => [$request->photo_url ?? '']
            ];

            $this->petService->createPet($petData);
            return redirect()->route('pets.index')->with('success', 'Zwierzę zostało dodane!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Wyświetl formularz edycji
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $pet = $this->petService->getPetById($id);
            return view('pets.edit', compact('pet'));
        } catch (\Exception $e) {
            return redirect()->route('pets.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Zaktualizuj zwierzę
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:available,pending,sold',
        ]);

        try {
            $petData = [
                'id' => $id,
                'name' => $request->name,
                'status' => $request->status,
                'category' => ['name' => $request->category ?? 'default'],
                'tags' => [['name' => $request->tags ?? 'default']],
                'photoUrls' => [$request->photo_url ?? '']
            ];

            $this->petService->updatePet($petData);
            return redirect()->route('pets.index')->with('success', 'Zwierzę zostało zaktualizowane!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Usuń zwierzę
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            $this->petService->deletePet($id);
            return redirect()->route('pets.index')->with('success', 'Zwierzę zostało usunięte!');
        } catch (\Exception $e) {
            return redirect()->route('pets.index')->with('error', $e->getMessage());
        }
    }
} 