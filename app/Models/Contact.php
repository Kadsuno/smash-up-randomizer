<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;
use App\Mail\ContactConfirmationMail;

class Contact extends Model
{
    use HasFactory;

    public $fillable = ['name', 'email', 'phone', 'subject', 'message'];
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public static function boot() {
  
        parent::boot();
  
        static::created(function ($item) {
            $adminEmail = "info@smash-up-randomizer.com";
            Mail::to($adminEmail)->send(new ContactMail($item));

            Mail::to($item->email)->send(new ContactConfirmationMail($item));
        });
    }
}
