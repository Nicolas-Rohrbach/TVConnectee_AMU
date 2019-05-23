<?php
/**
 * Created by PhpStorm.
 * User: Léa Arnaud
 * Date: 17/04/2019
 * Time: 11:34
 */


class BdInformation
{

    public function __construct(){
    }

    /**
     * Correspond a la base de donnée
     * @var
     */
    private static $db;

    /**
     * Ajoute la base de donnée avec Wordpress
     */
    private static function setDb(){
        global $wpdb;
        self::$db = new PDO('mysql:host='.$wpdb->dbhost.'; dbname='.$wpdb->dbname, $wpdb->dbuser, $wpdb->dbpassword);
        self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    } //setDb()

    /**
     * Renvoie la base de donnée
     * @return mixed
     */
    protected function getDb(){
        if (self:: $db == null)
            self::setDb();
        return self::$db;
    }//getDb()


    /**
     * Ajoute l'information dans la base de donnée avec la date du jour et l'utilisateur actuel.
     * Renvoie l'id du dernier objet venant d'être créer.
     * @param $title
     * @param $content
     * @param $endDate
     * @param $type
     * @return int
     */
    public function addInformationDB($title, $content, $endDate, $type){
        global $wpdb;
        $current_user = wp_get_current_user();

        if (isset($current_user)) {
            $user = $current_user->user_login;
        }
        $creationDate = date('Y-m-d');
        $null = null;

        $wpdb->query($wpdb->prepare("INSERT INTO informations (`ID_info`, `title`, `author`, `creation_date`, `end_date`, `content`, `type`) 
                                         VALUES (%d, %s, %s, %s, %s, %s, %s)",
                                        null, $title, $user, $creationDate, $endDate, $content, $type));
        return $wpdb->insert_id;

    } //addInformationDB()

    /**
     * Supprime l'information dans la base de donnée
     * @param $id
     */
    public function deleteInformationDB($id){
        global $wpdb;
        $wpdb->query(
            $wpdb->prepare(
                "DELETE FROM `informations` WHERE ID_info = %d",
                $id
            )
        );
    } //deleteInformationDB()

    /**
     * Renvoie la liste des onformations présentes dans la BD
     * @return array|null|object
     */
    public function getListInformation()
    {
        global $wpdb;
        $result = $wpdb->get_results("SELECT * FROM informations", ARRAY_A);
        return $result;
    } //getListInformation()

    /**
     * Renvoie la liste des informations crée par un utilisateur précis
     * @param $user
     * @return array|null|object
     */
    public function getListInformationByAuthor($user)
    {
        global $wpdb;
        $result = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM informations WHERE author = %s",
                $user
            ), ARRAY_A
        );
        return $result;
    } //getListInformationByAuthor()

    /**
     * Retourne une information avec un Id précis
     * @param $id
     * @return mixed
     */
    public function getInformationByID($id) {
     global $wpdb;
       $result = $wpdb->get_row('SELECT * FROM informations WHERE ID_info ="'.$id.'"',ARRAY_A );
       return $result;
    } //getInformationByID()

    /**
     * Modifie une information dans la base de donnée
     * @param $id
     * @param $title
     * @param $content
     * @param $endDate
     */
    public function modifyInformation($id, $title, $content, $endDate){
        $req = $this->getDb()->prepare('UPDATE informations SET title=:title, content=:content, end_date=:endDate
                                         WHERE ID_info=:id');
        $req->bindParam(':id',$id);
        $req->bindParam(':title',$title);
        $req->bindParam(':content',$content);
        $req->bindParam(':endDate',$endDate);

        $req->execute();

    } //modifyInformation()

}