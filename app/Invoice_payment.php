<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Invoice_line;
use App\Budget_line;

class Invoice_payment extends Model
{
    use SoftDeletes;

    public function invoice_line()
    {
        return $this->belongsTo(Invoice_line::class, 'invoice_line_id');
    }
}
