<?php

namespace App\Mail;

use App\Models\Referral;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReferralLink extends Mailable
{
    use Queueable, SerializesModels;

    public $referrerName;
    public $link;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $referrerName, string $link)
    {
        $this->referrerName = $referrerName;
        $this->link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->referrerName . ' recommends ContactOut')
            ->markdown('emails.referrals.invitation');
    }
}
