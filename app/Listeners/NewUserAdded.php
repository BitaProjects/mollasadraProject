<?php

namespace App\Listeners;

use App\Events\UserAdded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NewUserAdded
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    protected $name;
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserAdded  $event
     * @return void
     */
    public function handle(UserAdded $event)
    {
        $this->name = $event->name;

        echo "<br>New User with name: ".$this->name . "added to Database";

    }

}
