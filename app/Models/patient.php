<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class patient extends Model
{
    use HasFactory;

    public function medication()
    {
        return $this->hasMany(medication::class,'patient_id');
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function documents(){
        return $this->hasMany(Document::class);
    }
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======

    public function problems(){
        return $this->hasMany(Problem::class,'patient_id');
    }
>>>>>>> e38328c8e344df74e0aaed970b850148fd6f728b
>>>>>>> 1c7f9ed22f1a431c9cef97cd82022b8454954102
>>>>>>> 5f5cac5326938618709759d14757778d0bd916b2
}
