<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use App\Http\Requests\StoreSubscriberRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriptionConfirmation;
use App\Jobs\SendNewsletterJob;

class SubscriberController extends Controller
{
    /**
     * Store a newly created subscriber in storage.
     */
    public function subscribe(StoreSubscriberRequest $request)
    {
        // Check if request is AJAX
        if ($request->ajax()) {
            try {
                $subscriber = Subscriber::create([
                    'email' => $request->email,
                    'is_active' => true,
                    'is_verified' => true,
                    'verification_token' => md5($request->email . time()),
                ]);

                // Send confirmation email immediately (not queued)
                Mail::to($subscriber->email)->send(new SubscriptionConfirmation($subscriber));

                return response()->json([
                    'success' => true,
                    'message' => 'Thank you for subscribing! You will receive updates about new posts and videos.'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong. Please try again.'
                ], 500);
            }
        }

        // Non-AJAX fallback (for SEO/js disabled)
        $subscriber = Subscriber::create([
            'email' => $request->email,
            'is_active' => true,
            'is_verified' => true,
            'verification_token' => md5($request->email . time()),
        ]);

        // Send confirmation email immediately (not queued)
        Mail::to($subscriber->email)->send(new SubscriptionConfirmation($subscriber));

        return redirect()->back()->with('success', 'Thank you for subscribing! You will receive updates about new posts and videos.');
    }

    /**
     * Unsubscribe a subscriber.
     */
    public function unsubscribe($token)
    {
        $subscriber = Subscriber::where('verification_token', $token)->first();

        if (!$subscriber) {
            return redirect()->route('welcome')->with('error', 'Invalid unsubscribe link.');
        }

        $subscriber->update(['is_active' => false]);

        return redirect()->route('welcome')->with('success', 'You have been successfully unsubscribed.');
    }

    /**
     * Send newsletter to all active subscribers via queue job.
     */
    public function sendNewsletter($content, $type)
    {
        // Dispatch the job to the queue
        dispatch(new SendNewsletterJob($content, $type));
    }
}
