<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Article;
use App\Mail\NewPostMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ArticleObserver
{
    /**
     * Handle the Article "created" event.
     */
    public function created(Article $article): void
    {
        $notLoginUsers = User::where("id", "!=", Auth::id())->limit(3)->get();
        foreach ($notLoginUsers as $notLoginUser) {
            $receiver = $notLoginUser->name;
            $receiverEmail = $notLoginUser->email;
            // dd($receiverEmail);

            Mail::to($receiverEmail)->later(now()->addMinutes(1), new NewPostMail($receiver, $article));
        }
    }

    /**
     * Handle the Article "updated" event.
     */
    public function updated(Article $article): void
    {
        //
    }

    /**
     * Handle the Article "deleted" event.
     */
    public function deleted(Article $article): void
    {
        //
    }

    /**
     * Handle the Article "restored" event.
     */
    public function restored(Article $article): void
    {
        //
    }

    /**
     * Handle the Article "force deleted" event.
     */
    public function forceDeleted(Article $article): void
    {
        //
    }
}
