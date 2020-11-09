<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pph extends Model
{
    protected $table = 'pph';
    public $timestamps = false;
    protected $fillable = ['LIFNR','DOCNO','BUDAT','XBLNR','BKTXT','DMBTR','WRBTR','tgl_import'];
}
