<?php
namespace application\models;
use system\Model;
use \PDO;

/**
 * Permet de mettre en place un système de commentaire (récupération et sauvegarde pour n'importe quel contenu)
 */
class Comment extends Model{

    private $options = array(
        'content_error' => "Vous n'avez pas mis de message.",
        'parent_error' => "Vous essayez de répondre à un commentaire qui n'existe pas."
    );
    public $errors = array();
    public $count  = 0;

    /**
     * Permet de récupérer les derniers commentaires d'un sujet
     * @param  string $ref
     * @param  integer $ref_id
     * @return array
     */
    public function findAll($ref, $ref_id) {
        $q = $this->pdo->prepare("
            SELECT *
            FROM comment
            WHERE ref_id = :ref_id
                AND ref = :ref
            ORDER BY created DESC");
        $q->execute(array('ref' => $ref, 'ref_id' => $ref_id));
        $comments = $q->fetchAll(PDO::FETCH_OBJ);
        $this->count = count($comments);

        // Filtrage des réponses
        $replies  = array();
        foreach($comments as $k => $comment){
            if ($comment->parent_id){
                $replies[$comment->parent_id][] = $comment;
                unset($comments[$k]);
            }
        }
        foreach($comments as $k => $comment){
            if (isset($replies[$comment->id_comment])) {
                $r = $replies[$comment->id_comment];
                usort($r, array($this,'sortReplies'));
                $comments[$k]->replies = $r;
            }else{
                $comments[$k]->replies = array();
            }
        }
        return $comments;
    }

    public function sortReplies($a, $b){
        $atime = strtotime($a->created);
        $btime = strtotime($b->created);
        return $btime > $atime ? -1 : 1;
    }

    /**
     * Permet de sauvegarder un commentaire
     * @param  string $ref
     * @param  integer $ref_id
     * @return boolean
     */
    public function save($ref, $ref_id, $username, $email) {
        $errors = array();
        if (empty($_POST['content'])) {
            $errors['content'] = $this->options['content_error'];
        }
        if (count($errors) > 0) {
            $this->errors = $errors;
            return false;
        }
        if (!empty($_POST['parent_id'])) {
            $q = $this->pdo->prepare("SELECT id_comment
                FROM comment
                WHERE ref = :ref AND ref_id = :ref_id AND id_comment = :id AND parent_id = 0");
            $q->execute(array(
                'ref' => $ref,
                'ref_id' => $ref_id,
                'id' => $_POST['parent_id']
            ));
            if($q->rowCount() <= 0){
                $this->errors['parent'] = $this->options['parent_error'];
                return false;
            }
        }
        $q = $this->pdo->prepare("INSERT INTO comment SET
            username = :username,
            email    = :email,
            content  = :content,
            ref_id   = :ref_id,
            ref      = :ref,
            created  = :created,
            parent_id= :parent_id");
        $data = array(
            'username' => $username,
            'email'    => $email,
            'content'  => $_POST['content'],
            'parent_id'=> $_POST['parent_id'],
            'ref_id'   => $ref_id,
            'ref'      => $ref,
            'created'  => date('Y-m-d H:i:s')
        );
        return $q->execute($data);
    }

}