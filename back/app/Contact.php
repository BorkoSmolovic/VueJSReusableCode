<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\Cast\Object_;
use Illuminate\Support\Facades\Auth;

class Contact extends Model
{
    protected $fillable = ['contact', 'partner_id', 'isActive', 'contact_type_id', 'user_id'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $with = ['contact_type'];
    protected $casts = ["isActive" => "boolean", 'user_id' => 'integer', 'partner_id' => 'integer', 'contact_type_id' => 'integer'];

    public function contact_type(){
        return $this->belongsTo('App\ContactType');
    }


    public static function addContact($contact, $partnerId, $contactTypeId, $userId)
    {
        return Contact::create([
            'contact' => $contact,
            'partner_id' => $partnerId,
            'contact_type_id' => $contactTypeId,
            'isActive' => 1,
            'user_id' => $userId,
        ]);
    }

    public static function updateContact($contact, $partnerId, $contactTypeId, $contactId, $userId)
    {
        $contactObject = Contact::find($contactId);
        return $contactObject->update([
            'contact' => $contact,
            'partner_id' => $partnerId,
            'contact_type_id' => $contactTypeId,
            'user_id' => $userId,
        ]);
    }


}

