<?php

namespace App\Jobs;

use App\Models\Subscriber;
use App\Models\Post;
use App\Models\Video;
use App\Models\Gallery;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\NewPostNotification;
use App\Mail\NewVideoNotification;
use App\Mail\NewGalleryNotification;

class SendNewsletterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $content;
    protected $type;
    public $timeout = 300; // 5 minutes timeout
    public $tries = 3; // Retry 3 times if fails

    /**
     * Create a new job instance.
     */
    public function __construct($content, $type)
    {
        $this->content = $content;
        $this->type = $type;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $subscribers = Subscriber::where('is_active', true)->where('is_verified', true)->get();

        foreach ($subscribers as $subscriber) {
            try {
                if ($this->type === 'post') {
                    Mail::to($subscriber->email)->send(new NewPostNotification($this->content, $subscriber));
                } elseif ($this->type === 'video') {
                    Mail::to($subscriber->email)->send(new NewVideoNotification($this->content, $subscriber));
                } elseif ($this->type === 'gallery') {
                    Mail::to($subscriber->email)->send(new NewGalleryNotification($this->content, $subscriber));
                }
            } catch (\Exception $e) {
                // Continue with next subscriber even if one fails
                Log::error('Failed to send newsletter to ' . $subscriber->email . ': ' . $e->getMessage());
            }
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Newsletter job failed: ' . $exception->getMessage());
    }
}
