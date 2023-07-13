<?php

namespace App\Models;

use App\Mail\NewPostMail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class Article extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ["title", "slug", "description", "excerpt", "thumbnail", "category_id", "user_id"];
    public function user()
    {
        // to retrieve user while articles are retrieving
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function visitors()
    {
        return $this->hasMany(Visitor::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    // protected static function booted(): void
    // {
    //     static::created(function (User $user) {
    //         $notLogiUusers = User::where("id", "!=", Auth::id())->limit(3)->get();
    //         foreach ($notLogiUusers as $notLogiUuser) {

    //             // logger('testing event');

    //             $receiver = $notLogiUuser->name;
    //             $receiverEmail = $notLogiUuser->email;
    //             dd($receiverEmail);

    //             Mail::to($receiverEmail)->send(new NewPostMail($receiver, $article));
    //         }
    //     });
    // }
}
