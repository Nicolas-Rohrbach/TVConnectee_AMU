<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 26/04/2019
 * Time: 08:49
 */

abstract class ViewG{

    protected function displayInsertImportFile($name){
        echo'
             <form method="post" enctype="multipart/form-data">
				<input type="file" name="excel'.$name.'" class="btn btn-dark"/>
				<br/>
				<button type="submit" name="import'.$name.'" class="btn btn-primary" value="Importer">Importer le fichier</button>
			</form>
			<br/>';
    }

    protected function headerTab(){
        echo '
            <script src="/wp-content/plugins/TeleConnecteeAmu/views/js/addAllCheckBox.js"></script>
            <form method="post">
                <table class="table text-center"> 
                <thead>
                    <tr class="text-center">
                        <th scope="col">#</th>
                        <th scope="col"><input type="checkbox" onClick="toggle(this)" /></th>';
    }

    protected function endheaderTab(){
        echo'
                <th scope="col">Modifer</th>
                     </tr>
                </thead>
                <tbody>
        ';
    }

    /**
     * Build the header of a table
     * @param $tab
     */
    protected function startTab($tab){
        $this->headerTab();
        foreach ($tab as $value){
            echo'<th scope="col"> '.$value.'</th>';
        }
        $this->endheaderTab();
    }

    /**
     * Display the content of a row in a table
     * @param $row
     * @param $id
     * @param $tab
     */
    protected function displayAll($row, $id, $tab){
        echo '
        <tr>
          <th scope="row">'.$row.'</th>
          <td class="text-center"><input type="checkbox" name="checkboxstatus[]" value="'.$id.'"/></td>';
        if(isset($tab)){
            foreach ($tab as $value){
                echo '<td class="text-center">'.$value.'</td>';
            }
        }
    }

    /**
     * Close the table
     */
    public function endTab(){
        echo'
          </tbody>
        </table>
        <input type="submit" value="Supprimer" name="Delete"/>
        </form>';
    }

    /**
     * Refresh the page
     */
    public function refreshPage(){
        echo '<meta http-equiv="refresh" content="0">';
    }

    /**
     * Display a message
     */
    public function displayEmpty(){
        echo "<div> Il n'y rien ici, c'est triste :'( </div>";
    }

    public function displayAllTvStudent($id, $login, $year, $group, $halfgroup, $row){
        $tab = [$login, $year, $group, $halfgroup];
        $this->displayAll($row, $id, $tab);
        echo '<td class="text-center"> <a href="http://'.$_SERVER['HTTP_HOST'].'/gestion-des-utilisateurs/modification-utilisateur/'.$id.'" class="btn btn-primary btn-lg" name="modif" type="submit" value="Modifier">Modifier</a></td>
        </tr>';
    }
}