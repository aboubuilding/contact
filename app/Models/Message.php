<?php

namespace App\Models;


use App\Models\Compte;
use App\Types\TypeStatus;
use App\Models\Utilisateur;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
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


        'date_message',
        'telephone_destinataire',
        'titre',
        'message',
        'espace_id',
        'compte_id',
        'annee_id',
        'inscription_id',
        'utilisateur_id',

        'etat',

    ];







    /**
     * Ajouter un Message
     *

     * @param  date  $date_message
     * @param  string $telephone_destinataire

     * @param  string $titre
     * @param  string $message
     * @param  int $espace_id
     * @param  int $compte_id
     * @param  int $annee_id
     * @param  int $inscription_id
     * @param  int $utilisateur_id




     * @return Message
     */

    public static function addMessage(
        $date_message,
        $telephone_destinataire,
        $titre,

        $message,
        $espace_id,
        $compte_id,
        $annee_id,
        $inscription_id,
        $utilisateur_id


    ) {
         $message = new Message();


         $message->date_message = $date_message;
         $message->telephone_destinataire = $telephone_destinataire;
         $message->titre = $titre;
         $message->message = $message;

         $message->espace_id = $espace_id;
         $message->compte_id = $compte_id;
         $message->annee_id = $annee_id;
         $message->inscription_id = $inscription_id;
         $message->utilisateur_id = $utilisateur_id;


         $message->created_at = Carbon::now();

         $message->save();

        return  $message;
    }

    /**
     * Affichage d'une année scolaire
     * @param int $id
     * @return  Message
     */

    public static function rechercheMessageById($id)
    {

        return    $message = Message::findOrFail($id);
    }

    /**
     * Update d'une Message scolaire

    * @param  date  $date_message
     * @param  string $telephone_destinataire

     * @param  string $titre
     * @param  string $message
     * @param  int $espace_id
     * @param  int $compte_id
     * @param  int $annee_id
     * @param  int $inscription_id
     * @param  int $utilisateur_id



     * @param int $id
     * @return  Message
     */

    public static function updateMessage(
        $date_message,
        $telephone_destinataire,
        $titre,

        $message,
        $espace_id,
        $compte_id,
        $annee_id,
        $inscription_id,
        $utilisateur_id,

        $id
    ) {


        return    $message = Message::findOrFail($id)->update([



            'date_message' => $date_message,
            'telephone_destinataire' => $telephone_destinataire,
            'titre' => $titre,
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
     * Supprimer une Message
     *
     * @param int $id
     * @return  boolean
     */

    public static function deleteMessage($id)
    {

         $message = Message::findOrFail($id)->update([
            'etat' => TypeStatus::SUPPRIME

        ]);

        if ($message) {
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
     * Retourne la liste des Messages par ...


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

        $query =  Message::where('messages.etat', '!=', TypeStatus::SUPPRIME)
            ->orderBy('messages.created_at', 'DESC')
            ->where('messages.annee_id', '=', $annee_id);

        if ($espace_id != null) {

            $query->where('messages.espace_id', '=', $espace_id);
        }

        if ($compte_id != null) {

            $query->where('messages.compte_id', '=', $compte_id);
        }




        if ($inscription_id != null) {

            $query->where('messages.inscription_id', '=', $inscription_id);
        }

        if ($utilisateur_id != null) {

            $query->where('messages.utilisateur_id', '=', $utilisateur_id);
        }


        if ($date1 != null && $date2 != null) {

            $query->whereBetween('messages.date_message', [$date1, $date2]);
        }


        if ($date1 != null && $date2 == null) {

            $query->where('messages.date_message', '=', $date1);
        }

        if ($date1 == null && $date2 != null) {

            $query->where('messages.date_message', '=', $date2);
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

        $query =    DB::table('messages')

            ->where('messages.etat', '!=', TypeStatus::SUPPRIME)
            ->where('messages.annee_id', '=', $annee_id)
            ;

            if ($espace_id != null) {

                $query->where('messages.espace_id', '=', $espace_id);
            }

            if ($compte_id != null) {

                $query->where('messages.compte_id', '=', $compte_id);
            }




            if ($inscription_id != null) {

                $query->where('messages.inscription_id', '=', $inscription_id);
            }

            if ($utilisateur_id != null) {

                $query->where('messages.utilisateur_id', '=', $utilisateur_id);
            }


            if ($date1 != null && $date2 != null) {

                $query->whereBetween('messages.date_message', [$date1, $date2]);
            }


            if ($date1 != null && $date2 == null) {

                $query->where('messages.date_message', '=', $date1);
            }

            if ($date1 == null && $date2 != null) {

                $query->where('messages.date_message', '=', $date2);
            }




        $total = $query->count();

        if ($total) {

            return   $total;
        }

        return 0;
    }



   
}
