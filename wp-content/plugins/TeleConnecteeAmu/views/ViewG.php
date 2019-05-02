<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 26/04/2019
 * Time: 08:49
 */

abstract class ViewG{

    public function _construct(){
        echo '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
              <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>';
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

    /**
     * Build the header of a table
     * @param $tab
     */
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

    public function displayError(){
        echo '<script src="/wp-content/plugins/TeleConnecteeAmu/views/js/displayError.js"></script>';
    }
}