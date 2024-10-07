<?php

namespace App\Models;


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


     * @param  int $annee_id
     * @param  int $caisse_id
     * @param  int $utilisateur_id

     * @param  int $paiement_id

     * @param  int $type_Contact
     * @param  int $statut_Contact





     * @return  array
     */


    public static function getListe(
        $annee_id,
        $caisse_id = null,
        $utilisateur_id = null,

        $paiement_id = null,
        $type_Contact = null,

        $date1 = null,
        $date2 = null

    ) {

        $query =  Contact::where('Contacts.etat', '!=', TypeStatus::SUPPRIME)
            ->orderBy('Contacts.created_at', 'DESC')
            ->where('Contacts.annee_id', '=', $annee_id);

        if ($caisse_id != null) {

            $query->where('Contacts.caisse_id', '=', $caisse_id);
        }

        if ($utilisateur_id != null) {

            $query->where('Contacts.utilisateur_id', '=', $utilisateur_id);
        }



        if ($paiement_id != null) {

            $query->where('Contacts.paiement_id', '=', $paiement_id);
        }

        if ($type_Contact != null) {

            $query->where('Contacts.type_Contact', '=', $type_Contact);
        }


        if ($date1 != null && $date2 != null) {

            $query->whereBetween(DB::raw("DATE_FORMAT(Contacts.date_Contact, '%Y-%m-%d')"), [$date1, $date2]);
        }


        if ($date1 != null && $date2 == null) {

            $query->where(DB::raw("DATE_FORMAT(Contacts.date_Contact, '%Y-%m-%d')"), '=', $date1);
        }

        if ($date1 == null && $date2 != null) {

            $query->where(DB::raw("DATE_FORMAT(Contacts.date_Contact, '%Y-%m-%d')"), '=', $date2);
        }


        return     $query->get();
    }






    /**
     * Retourne le total  pour ...


     * @param  int $annee_id
     * @param  int $caisse_id
     * @param  int $utilisateur_id
     * @param  int $paiement_id
     * @param  int $type_Contact
     * @param  int $statut_Contact



     * @return  int $total
     */

    public static function getTotal(
        $annee_id,
        $caisse_id = null,
        $utilisateur_id = null,

        $paiement_id = null,
        $type_Contact = null,

        $date1 = null,
        $date2 = null

    ) {

        $query =    DB::table('Contacts')

            ->where('Contacts.etat', '!=', TypeStatus::SUPPRIME)
            ->where('Contacts.annee_id', '=', $annee_id)
            ;

        if ($caisse_id != null) {

            $query->where('Contacts.caisse_id', '=', $caisse_id);
        }

        if ($utilisateur_id != null) {

            $query->where('Contacts.utilisateur_id', '=', $utilisateur_id);
        }



        if ($paiement_id != null) {

            $query->where('Contacts.paiement_id', '=', $paiement_id);
        }

        if ($type_Contact != null) {

            $query->where('Contacts.type_Contact', '=', $type_Contact);
        }


        if ($date1 != null && $date2 != null) {

            $query->whereBetween(DB::raw("DATE_FORMAT(Contacts.date_Contact, '%Y-%m-%d')"), [$date1, $date2]);
        }


        if ($date1 != null && $date2 == null) {

            $query->where(DB::raw("DATE_FORMAT(Contacts.date_Contact, '%Y-%m-%d')"), '=', $date1);
        }

        if ($date1 == null && $date2 != null) {

            $query->where(DB::raw("DATE_FORMAT(Contacts.date_Contact, '%Y-%m-%d')"), '=', $date2);
        }




        $total = $query->count();

        if ($total) {

            return   $total;
        }

        return 0;
    }



    /**
     * Retourne le total  pour ...


     * @param  int $annee_id
     * @param  int $caisse_id
     * @param  int $utilisateur_id

     * @param  int $paiement_id

     * @param  int $type_Contact
     * @param  int $statut_Contact



     * @return  int $total
     */

    public static function getMontantTotal(
        $annee_id,
        $caisse_id = null,
        $utilisateur_id = null,

        $paiement_id = null,
        $type_Contact = null,

        $date1 = null,
        $date2 = null

    ) {

        $query =    DB::table('Contacts')

            ->where('Contacts.etat', '!=', TypeStatus::SUPPRIME)
            ->where('Contacts.annee_id', '=', $annee_id);

        if ($caisse_id != null) {

            $query->where('Contacts.caisse_id', '=', $caisse_id);
        }

        if ($utilisateur_id != null) {

            $query->where('Contacts.utilisateur_id', '=', $utilisateur_id);
        }



        if ($paiement_id != null) {

            $query->where('Contacts.paiement_id', '=', $paiement_id);
        }

        if ($type_Contact != null) {

            $query->where('Contacts.type_Contact', '=', $type_Contact);
        }


        if ($date1 != null && $date2 != null) {

            $query->whereBetween('Contacts.date_Contact', [$date1, $date2]);
        }


        if ($date1 != null && $date2 == null) {

            $query->where('Contacts.date_Contact', '=', $date1);
        }

        if ($date1 == null && $date2 != null) {

            $query->where('Contacts.date_Contact', '=', $date2);
        }





        $total = $query->SUM('Contacts.montant');

        if ($total) {

            return   $total;
        }

        return 0;
    }
}
