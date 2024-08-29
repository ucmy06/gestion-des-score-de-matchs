<?php

namespace App\Mail;

use App\Models\Matches;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MatchDeletionRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $match;
    public $user;

    /**
     * Create a new message instance.
     *
     * @param Matches $match
     * @param User $user
     */
    public function __construct(Matches $match, User $user)
    {
        $this->match = $match;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Demande de suppression de match')
                    ->view('emails.match_deletion_request');
    }
}
