<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 26/04/2019
 * Time: 08:49
 */

abstract class ViewG{

    public function startPage() {
        wp_head();
    }

    public function endPage() {
        wp_footer();
    }

    protected function displayInsertImportFile($name){
        echo'
             <form method="post" enctype="multipart/form-data">
				<input type="file" name="excel'.$name.'" class="btn btn-dark"/>
				<br/>
				<button type="submit" name="import'.$name.'" class="btn btn-primary" value="Importer">Importer le fichier</button>
			</form>
			<br/>';
    }
    public function startTab($tab){
        echo '
            <script src="/wp-content/plugins/TeleConnecteeAmu/views/js/addAllCheckBox.js"></script>
            <form method="post">
                <table class="table text-center"> 
                <thead>
                    <tr class="text-center">
                        <th scope="col">#</th>
                        <th scope="col"> Sélectionner <input type="checkbox" onClick="toggle(this)" /></th>';
        foreach ($tab as $value){
            echo'<th scope="col"> '.$value.'</th>';
        }
        echo'
                <th scope="col">Modifer</th>
                     </tr>
                </thead>
                <tbody>
        ';
    }

    public function endTab(){
        echo'
          </tbody>
        </table>
        <input type="submit" value="Delete" name="Delete"/>
        <a href="http://wptv"> Retour a la page d\'accueil</a>
        </form>';
    }

    protected function displayAll($row, $id, $tab){
        echo '
        <tr>
          <th scope="row">'.$row.'</th>
          <td class="text-center"> <input type="checkbox" name="checkboxstatus[]" value="'.$id.'"/></td>';
        foreach ($tab as $value){
            echo '<td class="text-center">'.$value.'</td>';
        }
    }

    public function refreshPage(){
        echo '<meta http-equiv="refresh" content="0">';
    }

}