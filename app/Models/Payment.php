<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*
    Status flow:
    1. în așteptare(pending) -- plata initiata dar nu e confirmata
    2. Confirmată(confirmed) -- plată confirmată
    3. Eșuată(failed) -- plata a fost refuzată de procesator
    4. Anulată(canceled) -- plata a fost anulată de client
*/

class Payment extends Model
{
    //
}
