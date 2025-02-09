<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Category;
use App\Models\Region;
use App\Models\Department;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class AdController extends Controller
{
    public function index(Request $request)
    {
        $query = Ad::with(['user', 'category', 'images']);

        // Category filter
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        // Type filter
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Region filter
        if ($request->has('region')) {
            $query->where('region', $request->region);
        }

        // Department filter
        if ($request->has('department')) {
            $query->where('department', $request->department);
        }

        // Countdown filter
        if ($request->has('countdown')) {
            $query->whereNotNull('expires_at')
                  ->where('expires_at', '>', now())
                  ->orderBy('expires_at', 'asc');
        }

        // Online only filter
        if ($request->has('online_only')) {
            $query->where('online_only', true);
        }

        // Search filter
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Location search
        if ($request->has('location')) {
            $location = $request->location;
            $query->where(function($q) use ($location) {
                $q->where('location', 'like', "%{$location}%")
                  ->orWhere('region', 'like', "%{$location}%")
                  ->orWhere('department', 'like', "%{$location}%");
            });
        }

        $ads = $query->latest()->paginate(12);
        $categories = Category::all();
        $regions = Region::with('departments')->get();

        return view('ads.index', compact('ads', 'categories', 'regions'));
    }

    public function byCategory(Category $category)
    {
        $ads = $category->ads()
            ->where('status', 'active')
            ->with(['images', 'user'])
            ->latest()
            ->paginate(12);

        return view('ads.by-category', [
            'category' => $category,
            'ads' => $ads,
        ]);
    }

    public function byRegion(Request $request, $region)
    {
        $ads = Ad::with(['user', 'category'])
                ->where('status', 'active')
                ->where('region', $region);

        if ($request->has('department')) {
            $ads->where('department', $request->department);
        }

        $ads = $ads->latest()->paginate(12);
        $categories = Category::all();
        $regions = Region::with('departments')->get();
        $currentRegion = $region;

        return view('ads.index', compact('ads', 'categories', 'regions', 'currentRegion'));
    }

    /**
     * Display a listing of ads based on search criteria.
     */
    public function search(Request $request)
    {
        try {
            $validated = $request->validate([
                'q' => 'nullable|string|min:2|max:100',
                'category' => 'nullable|exists:categories,id',
                'type' => 'nullable|in:goods,services'
            ]);

            $query = Ad::query()
                ->with(['user', 'category', 'images'])
                ->where('status', 'active');

            // Recherche textuelle
            if (!empty($validated['q'])) {
                $searchTerm = $validated['q'];
                $query->where(function($q) use ($searchTerm) {
                    $q->where('title', 'like', "%{$searchTerm}%")
                      ->orWhere('description', 'like', "%{$searchTerm}%")
                      ->orWhereHas('category', function($q) use ($searchTerm) {
                          $q->where('name', 'like', "%{$searchTerm}%");
                      });
                });
            }

            // Filtre par catégorie
            if (!empty($validated['category'])) {
                $query->where('category_id', $validated['category']);
            }

            // Filtre par type
            if (!empty($validated['type'])) {
                $query->where('type', $validated['type']);
            }

            // Tri par date de création
            $query->latest();

            // Récupération des données pour les filtres
            $categories = Category::orderBy('name')->get();

            // Pagination avec conservation des paramètres de recherche
            $ads = $query->paginate(15)->withQueryString();

            return view('ads.index', [
                'ads' => $ads,
                'categories' => $categories,
                'searchQuery' => $validated['q'] ?? ''
            ]);

        } catch (\Exception $e) {
            \Log::error('Erreur lors de la recherche:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la recherche.');
        }
    }

    public function create()
    {
        $categories = Category::all();
        $regions = Region::all();
        return view('ads.create', compact('categories', 'regions'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // Validation minimale
            $validated = $request->validate([
                'title' => 'required',
                'description' => 'required',
                'price' => 'required',
                'category_id' => 'required',
                'type' => 'required',
                'department' => 'required',
                'city' => 'required',
                'postal_code' => 'required',
                'exchange_with' => 'required',
                'condition' => 'required',
                'region_id' => 'required',
                'expires_at' => 'nullable|date|after:now'  
            ]);

            // Préparation des données
            $adData = [
                'title' => $request->title,
                'description' => $request->description,
                'price' => $request->price,
                'category_id' => $request->category_id,
                'region_id' => $request->region_id,  
                'department' => $request->department,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'type' => $request->type,
                'exchange_with' => $request->exchange_with,
                'condition' => $request->condition,
                'user_id' => auth()->id(),
                'status' => 'pending',
                'is_online' => true,
                'online_exchange' => $request->has('online_exchange'),
                'expires_at' => $request->expires_at ? now()->addDays(30) : null
            ];

            // Pour le débogage, affichons les données avant l'insertion
            \Log::info('Données de l\'annonce avant création:', $adData);

            // Création de l'annonce
            $ad = Ad::create($adData);

            // Gestion des images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    if ($image->isValid()) {
                        try {
                            // Générer un nom unique pour l'image
                            $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
                            
                            // Stocker l'image dans le dossier public/storage/ads/{ad_id}
                            $path = $image->storeAs('ads/' . $ad->id, $fileName, 'public');
                            
                            // Log pour déboguer
                            \Log::info('Image upload:', [
                                'original_name' => $image->getClientOriginalName(),
                                'stored_path' => $path,
                                'full_url' => asset('storage/' . $path)
                            ]);
                            
                            // Créer l'entrée dans la base de données
                            $ad->images()->create([
                                'image_path' => $path
                            ]);
                        } catch (\Exception $e) {
                            \Log::error('Erreur lors du téléchargement de l\'image', [
                                'error' => $e->getMessage(),
                                'file' => $image->getClientOriginalName(),
                                'trace' => $e->getTraceAsString()
                            ]);
                        }
                    }
                }
            }

            DB::commit();

            return redirect()
                ->route('ads.show', $ad)
                ->with('success', 'Votre annonce a été créée avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Erreur lors de la création de l\'annonce', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()  
            ]);

            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la création de l\'annonce : ' . $e->getMessage());
        }
    }


    public function show(Ad $ad)
    {
        // Load the reviews relationship
        $ad->load(['reviews', 'images']);

        // Calculate the average rating
        $averageRating = $ad->reviews->avg('rating');
        $reviewsCount = $ad->reviews->count();

        $ad->load(['user', 'category', 'images']);
        return view('ads.show', compact('ad', 'averageRating', 'reviewsCount'));
    }


    public function edit(Ad $ad)
    {
        $this->authorize('update', $ad);
        
        return view('ads.edit', [
            'ad' => $ad,
            'categories' => Category::all(),
            'regions' => Region::all(),
        ]);
    }

    public function update(Request $request, Ad $ad)
    {
        $this->authorize('update', $ad);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'type' => 'required|in:goods,services',
            'condition' => 'required|in:new,like_new,good,fair',
            'region_id' => 'required|exists:regions,id',
            'department' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string',
            'exchange_with' => 'nullable|string',
            'online_exchange' => 'nullable|boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'expires_at' => 'nullable|date|after:now'
        ]);

        // Si expires_at est fourni, on le met à jour
        if ($request->has('expires_at')) {
            $validated['expires_at'] = now()->addDays(30);
        }

        $ad->update($validated);

        // Gérer les nouvelles images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image->isValid()) {
                    try {
                        // Générer un nom unique pour l'image
                        $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
                        
                        // Stocker l'image dans le dossier public/storage/ads/{ad_id}
                        $path = $image->storeAs('ads/' . $ad->id, $fileName, 'public');
                        
                        // Log pour déboguer
                        \Log::info('Image upload:', [
                            'original_name' => $image->getClientOriginalName(),
                            'stored_path' => $path,
                            'full_url' => asset('storage/' . $path)
                        ]);
                        
                        // Créer l'entrée dans la base de données
                        $ad->images()->create([
                            'image_path' => $path
                        ]);
                    } catch (\Exception $e) {
                        \Log::error('Erreur lors du téléchargement de l\'image', [
                            'error' => $e->getMessage(),
                            'file' => $image->getClientOriginalName(),
                            'trace' => $e->getTraceAsString()
                        ]);
                    }
                }
            }
        }

        // Supprimer les images sélectionnées
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = $ad->images()->find($imageId);
                if ($image) {
                    Storage::disk('public')->delete($image->image_path);
                    $image->delete();
                }
            }
        }

        return redirect()->route('ads.show', $ad)
            ->with('success', 'Annonce mise à jour avec succès.');
    }

    // public function update(Request $request, $id)
    // {
    //     $ad = Ad::findOrFail($id);

    //     // Validate the request
    //     $validated = $request->validate([
    //                 'title' => 'required|string|max:255',
    //                 'description' => 'required|string',
    //                 'category_id' => 'required|exists:categories,id',
    //                 'type' => 'required|in:good,service',
    //                 'condition' => 'required|in:new,like_new,good,fair',
    //                 'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //                 'region_id' => 'required|exists:regions,id',
    //                 'department' => 'required|string',
    //                 'city' => 'required|string',
    //                 'postal_code' => 'required|string',
    //                 'exchange_with' => 'nullable|string',
    //                 'online_exchange' => 'boolean',
    //     ]);
        
    //      // Log the request data
    //     Log::info('Updating ad', ['request' => $request->all()]);

    //     // Update the ad with the validated data
    //     $ad->update($validated);

    //     return redirect()->route('ads.show', $ad)
    //         ->with('success', 'Annonce mise à jour avec succès.');
    // }

    // public function destroy(Ad $ad)
    // {
    //     $this->authorize('delete', $ad);

    //     // Delete images
    //     foreach ($ad->images as $image) {
    //         Storage::disk('public')->delete($image->path);
    //     }

    //     $ad->delete();

    //     return redirect()->route('ads.index')
    //         ->with('success', 'Ad deleted successfully.');
    // }

    public function destroy($id)
    {
        $ad = Ad::findOrFail($id);

        // Assuming the file path is stored in a column named 'file_path'
        $filePath = $ad->file_path;

        if ($filePath) {
            Storage::delete($filePath);
        }

        $ad->delete();

        return redirect()->route('ads.index')->with('success', 'Annonce supprimée avec succès');
    }

    public function toggleStatus(Ad $ad)
    {
        $this->authorize('update', $ad);

        $ad->status = $ad->status === 'active' ? 'paused' : 'active';
        $ad->save();

        return back()->with('success', 'Ad status updated successfully.');
    }

    public function myAds()
    {
        $ads = Ad::where('user_id', Auth::id())
                 ->with(['category'])
                 ->latest()
                 ->paginate(12);

        return view('ads.my-ads', compact('ads'));
    }

    /**
     * Get departments for a specific region (AJAX request)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDepartments(Request $request)
    {
        $departments = Department::where('region_id', $request->region_id)
            ->get(['id', 'name']);

        return response()->json($departments);
    }

    public function suggestions(Request $request)
    {
        try {
            if (!$request->has('q') || strlen($request->q) < 2) {
                return response()->json([]);
            }

            $query = $request->get('q');
            
            $ads = Ad::where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%")
                  ->orWhereHas('category', function($q) use ($query) {
                      $q->where('name', 'like', "%{$query}%");
                  });
            })
            ->with('category')
            ->select('id', 'title', 'category_id')
            ->limit(5)
            ->get();

            $results = $ads->map(function($ad) {
                return [
                    'id' => $ad->id,
                    'title' => $ad->title,
                    'category' => $ad->category->name,
                    'url' => route('ads.show', $ad)
                ];
            });

            return response()->json($results);
        } catch (\Exception $e) {
            \Log::error('Error in suggestions:', ['error' => $e->getMessage()]);
            return response()->json([], 500);
        }
    }

    //Rating Update
    // public function rate(Request $request, Ad $ad){
    //     try {
    //         Log::info('Rate request received', [
    //             'ad_id' => $ad->id,
    //             'user_id' => auth()->id(),
    //             'rating' => $request->rating,
    //         ]);

    //         $request->validate([
    //             'rating' => 'required|integer|min:1|max:5',
    //         ]);

    //         $userId = auth()->id();

    //         // Check if user is authenticated
    //         if (!$userId) {
    //             return response()->json(['success' => false, 'error' => 'User not authenticated'], 401);
    //         }

    //         // Find or create a review
    //         $review = Review::firstOrNew([
    //             'reviewer_id' => $userId,
    //             'reviewed_id' => $ad->id,
    //         ]);

    //         $review->rating = $request->rating;
    //         $review->save();

    //         Log::info('Rating updated successfully', ['review_id' => $review->id]);

    //         return response()->json(['success' => true]);
    //     } catch (\Exception $e) {
    //         Log::error('Error updating rating', ['error' => $e->getMessage()]);
    //         return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
    //     }
    // }
    public function rate(Request $request, Ad $ad) {
        try {
            Log::info('Rate request received', [
                'ad_id' => $ad->id,
                'user_id' => auth()->id(),
                'rating' => $request->rating,
            ]);
    
            $request->validate([
                'rating' => 'required|integer|min:0|max:5', // Permettre 0 pour retirer le rating
            ]);
    
            $userId = auth()->id();
    
            // Check if user is authenticated
            if (!$userId) {
                return response()->json(['success' => false, 'error' => 'User not authenticated'], 401);
            }
    
            // Find or create a review
            $review = Review::firstOrNew([
                'reviewer_id' => $userId,
                'reviewed_id' => $ad->id,
            ]);
    
            // Si le rating est 0, supprimer la revue
            if ($request->rating === 0) {
                $review->delete();
                Log::info('Rating removed', ['review_id' => $review->id]);
            } else {
                $review->rating = $request->rating;
                $review->save();
                Log::info('Rating updated successfully', ['review_id' => $review->id]);
            }
    
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error updating rating', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    // Méthodes pour la création d'annonce en plusieurs étapes
    public function createStep1()
    {
        return view('ads.create.step1', [
            'categories' => Category::all()
        ]);
    }

    public function storeStep1(Request $request)
    {
        $validatedData = $request->validate([
            'type' => 'required|in:goods,services',
            'category_id' => 'required|exists:categories,id',
        ]);

        $request->session()->put('ad_data', $validatedData);
        return redirect()->route('ads.create.step2');
    }

    public function createStep2()
    {
        return view('ads.create.step2');
    }

    public function storeStep2(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|min:5|max:255',
            'description' => 'required|min:20',
            'exchange_with' => 'required|min:5',
        ]);

        // Log des données avant la fusion
        \Log::info('Step 2 - Current session data:', $request->session()->get('ad_data', []));
        \Log::info('Step 2 - New validated data:', $validatedData);

        // Fusionner avec les données existantes
        $sessionData = array_merge(
            $request->session()->get('ad_data', []),
            $validatedData
        );

        // Sauvegarder dans la session
        $request->session()->put('ad_data', $sessionData);

        // Log des données après la fusion
        \Log::info('Step 2 - Final session data:', $sessionData);

        return redirect()->route('ads.create.step3');
    }

    public function createStep3()
    {
        return view('ads.create.step3');
    }

    public function storeStep3(Request $request)
    {
        $validatedData = $request->validate([
            'price' => 'required|numeric|min:0',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('ads', 'public');
                $images[] = $path;
            }
            $validatedData['images'] = $images;
        }

        $request->session()->put('ad_data', array_merge(
            $request->session()->get('ad_data', []),
            $validatedData
        ));

        return redirect()->route('ads.create.step4');
    }

    public function createStep4()
    {
        return view('ads.create.step4', [
            'regions' => Region::all()
        ]);
    }

    public function storeStep4(Request $request)
    {
        $validatedData = $request->validate([
            'region_id' => 'required|exists:regions,id',
            'department' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:5',
        ]);

        // Récupérer toutes les données de la session
        $sessionData = $request->session()->get('ad_data', []);
        
        // Log pour déboguer
        \Log::info('Session data:', $sessionData);
        \Log::info('Validated data:', $validatedData);

        // Fusionner les données
        $adData = array_merge($sessionData, $validatedData);

        // Vérifier que les champs requis sont présents
        if (!isset($adData['title']) || !isset($adData['description']) || !isset($adData['type']) || !isset($adData['category_id'])) {
            return redirect()->route('ads.create.step1')
                ->with('error', 'Certaines informations sont manquantes. Veuillez recommencer le processus.');
        }

        // Log des données finales
        \Log::info('Final ad data:', $adData);

        try {
            // Créer l'annonce
            $ad = Auth::user()->ads()->create($adData);

            // Gérer les images si présentes
            if (isset($adData['images'])) {
                foreach ($adData['images'] as $image) {
                    $ad->images()->create(['image_path' => $image]);
                }
            }

            // Nettoyer la session
            $request->session()->forget('ad_data');

            return redirect()->route('ads.show', $ad)
                ->with('success', 'Votre annonce a été créée avec succès !');

        } catch (\Exception $e) {
            \Log::error('Error creating ad:', [
                'error' => $e->getMessage(),
                'data' => $adData
            ]);

            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de la création de l\'annonce. Veuillez réessayer.');
        }
    }
}