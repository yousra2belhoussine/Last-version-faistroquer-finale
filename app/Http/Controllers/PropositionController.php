<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Proposition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use App\Models\Feedback;

class PropositionController extends Controller
{
    use AuthorizesRequests;

    public function store(Request $request, Ad $ad)
    {
        try {
            // Vérifier que l'utilisateur ne fait pas de proposition sur sa propre annonce
            if ($ad->user_id === Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vous ne pouvez pas faire de proposition sur votre propre annonce'
                ], 422);
            }

            $validated = $request->validate([
                'offer' => 'required|string|max:255',
                'message' => 'nullable|string',
                'online_exchange' => 'boolean',
                'meeting_location' => 'required_if:online_exchange,false|nullable|string',
                'meeting_date' => 'required_if:online_exchange,false|nullable|date',
            ]);

            // Si l'échange en ligne est coché, définissez les champs meeting_location et meeting_date à null
            if ($request->boolean('online_exchange')) {
                $validated['meeting_location'] = null;
                $validated['meeting_date'] = null;
            }

            $proposition = new Proposition($validated);
            $proposition->ad_id = $ad->id;
            $proposition->user_id = Auth::id();
            $proposition->status = 'pending';
            $proposition->save();

            return response()->json([
                'success' => true,
                'message' => 'Votre proposition a été envoyée avec succès',
                'proposition' => $proposition
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la création de la proposition:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la création de la proposition'
            ], 500);
        }
    }

    public function accept(Proposition $proposition)
    {
        try {
            if (!$proposition->isPending()) {
                return back()->with('error', __('Cette proposition ne peut plus être acceptée.'));
            }

            $this->authorize('update', $proposition->ad);

            $proposition->update([
                'status' => 'accepted',
                'accepted_at' => now()
            ]);

            return redirect()->back()
                ->with('success', __('La proposition a été acceptée avec succès.'));
        } catch (\Exception $e) {
            \Log::error('Erreur lors de l\'acceptation de la proposition:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', __('Une erreur est survenue lors de l\'acceptation de la proposition.'));
        }
    }

    public function reject(Proposition $proposition)
    {
        try {
            if (!$proposition->isPending()) {
                return back()->with('error', __('Cette proposition ne peut plus être refusée.'));
            }

            $this->authorize('update', $proposition->ad);

            $proposition->update([
                'status' => 'rejected',
                'rejected_at' => now()
            ]);

            return redirect()->back()
                ->with('success', __('La proposition a été refusée.'));
        } catch (\Exception $e) {
            \Log::error('Erreur lors du refus de la proposition:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', __('Une erreur est survenue lors du refus de la proposition.'));
        }
    }

    public function complete(Request $request, Proposition $proposition)
    {
        // Vérifier que l'utilisateur est autorisé à marquer la proposition comme complétée
        if (!$proposition->isAccepted() || $proposition->isCompleted() || 
            (Auth::id() !== $proposition->user_id && Auth::id() !== $proposition->ad->user_id)) {
            return back()->with('error', __('Vous n\'êtes pas autorisé à effectuer cette action.'));
        }

        // Valider les données du feedback
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        // Créer le feedback
        $feedback = new Feedback([
            'user_id' => Auth::id(),
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        // Sauvegarder le feedback et marquer la proposition comme complétée
        DB::transaction(function () use ($proposition, $feedback) {
            $proposition->feedback()->save($feedback);
            $proposition->update(['status' => 'completed', 'completed_at' => now()]);
        });

        return redirect()->route('propositions.show', $proposition)
            ->with('success', __('La proposition a été marquée comme complétée et votre feedback a été enregistré.'));
    }

    public function cancel(Proposition $proposition)
    {
        if (Auth::id() !== $proposition->user_id && Auth::id() !== $proposition->ad->user_id) {
            abort(403);
        }

        if (!$proposition->isPending() && !$proposition->isAccepted()) {
            abort(403, __('This proposition cannot be cancelled.'));
        }

        $proposition->update(['status' => 'rejected']);

        return redirect()->back()
            ->with('success', __('Proposition cancelled successfully.'));
    }

    public function updateMeeting(Request $request, Proposition $proposition)
    {
        if (Auth::id() !== $proposition->user_id && Auth::id() !== $proposition->ad->user_id) {
            abort(403);
        }

        if (!$proposition->isAccepted()) {
            abort(403, __('Meeting details can only be updated for accepted propositions.'));
        }

        $validated = $request->validate([
            'meeting_location' => 'required|string',
            'meeting_date' => 'required|date|after:now',
        ]);

        $proposition->update($validated);

        return redirect()->back()
            ->with('success', __('Meeting details updated successfully.'));
    }

    public function index()
    {
        $propositions = Proposition::with(['ad', 'user'])
            ->where(function($query) {
                $query->where('user_id', Auth::id())
                    ->orWhereHas('ad', function($q) {
                        $q->where('user_id', Auth::id());
                    });
            })
            ->latest()
            ->paginate(10);

        return view('propositions.index', compact('propositions'));
    }

    public function show(Proposition $proposition)
    {
        if (Auth::id() !== $proposition->user_id && Auth::id() !== $proposition->ad->user_id) {
            abort(403);
        }

        $proposition->load(['ad', 'user', 'messages.user']);

        return view('propositions.show', compact('proposition'));
    }

    /**
     * Enregistre le feedback pour une proposition
     */
    public function feedback(Request $request, Proposition $proposition)
    {
        // Vérifier que l'utilisateur est autorisé à donner un feedback
        if (!$proposition->isCompleted() || Auth::id() !== $proposition->ad->user_id) {
            return back()->with('error', 'Vous n\'êtes pas autorisé à donner un feedback pour cette proposition.');
        }

        // Valider les données
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Créer le feedback
        $feedback = $proposition->feedback()->create([
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'user_id' => Auth::id(),
        ]);

        return back()->with('success', 'Votre feedback a été enregistré avec succès.');
    }
} 