<?php

namespace App\Models;


use App\Models\Compte;
use App\Types\TypeStatus;
use App\Models\Utilisateur;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->etat = TypeStatus::ACTIF;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [


        'date_email',
        'email_destinataire',
        'objet_destinataire',
        'message',
        'espace_id',
        'compte_id',
        'annee_id',
        'inscription_id',
        'utilisateur_id',

        'etat',

    ];







    /**
     * Ajouter un Contact
     *

     * @param  date  $date_email
     * @param  string $email_destinataire

     * @param  string $objet_destinataire
     * @param  string $message
     * @param  int $espace_id
     * @param  int $compte_id
     * @param  int $annee_id
     * @param  int $inscription_id
     * @param  int $utilisateur_id



     * @return Contact
     */

    public static function addContact(
        $date_email,
        $email_destinataire,
        $objet_destinataire,

        $message,
        $espace_id,
        $compte_id,
        $annee_id,
        $inscription_id,
        $utilisateur_id


    ) {
         $contact = new Contact();


         $contact->date_email = $date_email;
         $contact->email_destinataire = $email_destinataire;
         $contact->objet_destinataire = $objet_destinataire;
         $contact->message = $message;

         $contact->espace_id = $espace_id;
         $contact->compte_id = $compte_id;
         $contact->annee_id = $annee_id;
         $contact->inscription_id = $inscription_id;
         $contact->utilisateur_id = $utilisateur_id;


         $contact->created_at = Carbon::now();

         $contact->save();

        return  $contact;
    }

    /**
     * Affichage d'une année scolaire
     * @param int $id
     * @return  Contact
     */

    public static function rechercheContactById($id)
    {

        return    $contact = Contact::findOrFail($id);
    }

    /**
     * Update d'une Contact scolaire

    * @param  date  $date_email
     * @param  string $email_destinataire

     * @param  string $objet_destinataire
     * @param  string $message
     * @param  int $espace_id
     * @param  int $compte_id
     * @param  int $annee_id
     * @param  int $inscription_id
     * @param  int $utilisateur_id



     * @param int $id
     * @return  Contact
     */

    public static function updateContact(
        $date_email,
        $email_destinataire,
        $objet_destinataire,

        $message,
        $espace_id,
        $compte_id,
        $annee_id,
        $inscription_id,
        $utilisateur_id,

        $id
    ) {


        return    $contact = Contact::findOrFail($id)->update([



            'date_email' => $date_email,
            'email_destinataire' => $email_destinataire,
            'objet_destinataire' => $objet_destinataire,
            'message' => $message,

            'espace_id' => $espace_id,
            'compte_id' => $compte_id,
            'annee_id' => $annee_id,
            'inscription_id' => $inscription_id,
            'utilisateur_id' => $utilisateur_id,

            'id' => $id,


        ]);
    }




    /**
     * Supprimer une Contact
     *
     * @param int $id
     * @return  boolean
     */

    public static function deleteContact($id)
    {

         $contact = Contact::findOrFail($id)->update([
            'etat' => TypeStatus::SUPPRIME

        ]);

        if ($contact) {
            return 1;
        }
        return 0;
    }


    /**
     * Obtenir un
     *
     */
    public function espace()
    {


        return $this->belongsTo(Espace::class, 'espace_id');
    }

    /**
     * Obtenir une utilisateur
     *
     */
    public function compte()
    {


        return $this->belongsTo(Compte::class, 'compte_id');
    }


    /**
     * Obtenir un paiement
     *
     */
    public function inscription()
    {


        return $this->belongsTo(Inscription::class, 'inscription_id');
    }



    /**
     * Obtenir une annee
     *
     */
    public function utilisateur()
    {


        return $this->belongsTo(Utilisateur::class, 'utilisateur_id');
    }








    /**
     * Retourne la liste des Contacts par ...


     * @param  int $espace_id
     * @param  int $compte_id
     * @param  int $annee_id

     * @param  int $inscription_id

     * @param  int $utilisateur_id


     * @return  array
     */


    public static function getListe(
        $espace_id = null,
        $compte_id = null,
        $annee_id = null,

        $inscription_id = null,
        $utilisateur_id = null,

        $date1 = null,
        $date2 = null

    ) {

        $query =  Contact::where('contacts.etat', '!=', TypeStatus::SUPPRIME)
            ->orderBy('contacts.created_at', 'DESC')
            ->where('contacts.annee_id', '=', $annee_id);

        if ($espace_id != null) {

            $query->where('contacts.espace_id', '=', $espace_id);
        }

        if ($compte_id != null) {

            $query->where('contacts.compte_id', '=', $compte_id);
        }



        if ($inscription_id != null) {

            $query->where('contacts.inscription_id', '=', $inscription_id);
        }

        if ($utilisateur_id != null) {

            $query->where('contacts.utilisateur_id', '=', $utilisateur_id);
        }


        if ($date1 != null && $date2 != null) {

            $query->whereBetween('contacts.date_email', [$date1, $date2]);
        }


        if ($date1 != null && $date2 == null) {

            $query->where('contacts.date_email', '=', $date1);
        }

        if ($date1 == null && $date2 != null) {

            $query->where('contacts.date_email', '=', $date2);
        }



        return     $query->get();
    }






    /**
     * Retourne le total  pour ...


     * @param  int $espace_id
     * @param  int $compte_id
     * @param  int $annee_id

     * @param  int $inscription_id

     * @param  int $utilisateur_id



     * @return  int $total
     */

    public static function getTotal(
        $espace_id = null,
        $compte_id = null,
        $annee_id = null,

        $inscription_id = null,
        $utilisateur_id = null,

        $date1 = null,
        $date2 = null

    ) {

        $query =    DB::table('Contacts')

            ->where('Contacts.etat', '!=', TypeStatus::SUPPRIME)
            ->where('Contacts.annee_id', '=', $annee_id)
            ;

            if ($espace_id != null) {

                $query->where('contacts.espace_id', '=', $espace_id);
            }

            if ($compte_id != null) {

                $query->where('contacts.compte_id', '=', $compte_id);
            }



            if ($inscription_id != null) {

                $query->where('contacts.inscription_id', '=', $inscription_id);
            }

            if ($utilisateur_id != null) {

                $query->where('contacts.utilisateur_id', '=', $utilisateur_id);
            }


            if ($date1 != null && $date2 != null) {

                $query->whereBetween('contacts.date_email', [$date1, $date2]);
            }


            if ($date1 != null && $date2 == null) {

                $query->where('contacts.date_email', '=', $date1);
            }

            if ($date1 == null && $date2 != null) {

                $query->where('contacts.date_email', '=', $date2);
            }


        $total = $query->count();

        if ($total) {

            return   $total;
        }

        return 0;
    }



}
