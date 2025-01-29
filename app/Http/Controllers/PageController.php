<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Message;

class PageController extends Controller
{
    /**
     * Show the "How it works" page.
     */
    public function howItWorks()
    {
        return Inertia::render('Pages/HowItWorks', [
            'steps' => [
                [
                    'title' => 'Create an Account',
                    'description' => 'Sign up as a particular or professional user.',
                    'icon' => 'user-plus',
                ],
                [
                    'title' => 'Post Your Ad',
                    'description' => 'Share what you want to exchange.',
                    'icon' => 'ad',
                ],
                [
                    'title' => 'Receive Propositions',
                    'description' => 'Get exchange offers from other members.',
                    'icon' => 'handshake',
                ],
                [
                    'title' => 'Negotiate and Meet',
                    'description' => 'Discuss details and arrange a meeting.',
                    'icon' => 'comments',
                ],
                [
                    'title' => 'Complete the Exchange',
                    'description' => 'Make the exchange and rate your experience.',
                    'icon' => 'check-circle',
                ],
            ],
        ]);
    }

    /**
     * Show the help page.
     */
    public function help()
    {
        return Inertia::render('Pages/Help', [
            'faqs' => [
                [
                    'question' => 'How do I create an account?',
                    'answer' => 'Click on the "Sign Up" button and follow the registration process.',
                ],
                [
                    'question' => 'How do I post an ad?',
                    'answer' => 'After logging in, click on "Create Ad" and fill in the required information.',
                ],
                // Add more FAQs
            ],
            'contactInfo' => [
                'email' => 'support@faistroquer.fr',
                'phone' => '+33 1 23 45 67 89',
                'hours' => 'Monday to Friday, 9:00 - 18:00',
            ],
        ]);
    }

    /**
     * Show the contact page.
     */
    public function contact()
    {
        return Inertia::render('Pages/Contact');
    }

    /**
     * Handle contact form submission.
     */
    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Create contact message
        $message = Message::create([
            'sender_name' => $validated['name'],
            'sender_email' => $validated['email'],
            'subject' => $validated['subject'],
            'content' => $validated['message'],
            'type' => 'contact',
        ]);

        // Notify admins
        $admins = User::where('is_admin', true)->get();
        Notification::send($admins, new NewContactMessage($message));

        return back()->with('success', 'Your message has been sent successfully.');
    }

    /**
     * Show the privacy policy page.
     */
    public function privacy()
    {
        return Inertia::render('Pages/Privacy');
    }

    /**
     * Show the terms and conditions page.
     */
    public function terms()
    {
        return Inertia::render('Pages/Terms');
    }

    /**
     * Show the GDPR consent page.
     */
    public function gdpr()
    {
        return Inertia::render('Pages/Gdpr');
    }

    /**
     * Show the platform contract page.
     */
    public function contract()
    {
        return Inertia::render('Pages/Contract');
    }
} 