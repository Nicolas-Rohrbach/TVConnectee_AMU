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

    protected function displayHeaderTab(){
        echo '
            <script src="/wp-content/plugins/TeleConnecteeAmu/views/js/addAllCheckBox.js"></script>
            <form method="post">
                <table class="table text-center"> 
                <thead>
                    <tr class="text-center">
                        <th scope="col" width="5%" class="text-center">#</th>
                        <th scope="col" width="5%" class="text-center"><input type="checkbox" onClick="toggle(this)" /></th>';
    }

    /**
     * Build the header of a table
     * @param $tab
     */
    protected function displayStartTab($tab){
        $this->displayHeaderTab();
        foreach ($tab as $value){
            echo'<th scope="col" class="text-center"> '.$value.'</th>';
        }
        $this->displayEndheaderTab();
    }

    protected function displayEndheaderTab(){
        echo'
                <th scope="col" class="text-center">Modifer</th>
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
          <th scope="row" class="text-center">'.$row.'</th>
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
    public function displayEndTab(){
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
        echo "<div> Il n'y pas d'utilisateur de ce rôle inscrit!</div>";
    }

    public function displayUnregisteredCode($badCodes){
        echo'
        <h3> Ces codes ne sont pas encore enregistrés ! </h3>
        <table class="table text-center"> 
                <thead>
                    <tr class="text-center">
                        <th scope="col" width="33%" class="text-center">Année</th>
                        <th scope="col" width="33%" class="text-center">Groupe</th>
                        <th scope="col" width="33%" class="text-center">Demi-Groupe</th>
                        </tr>
                </thead>
                <tbody>';
        $sizeYear = sizeof($badCodes[0]);
        $sizeGroup = sizeof($badCodes[1]);
        $sizeHalfgroup = sizeof($badCodes[2]);
        $size = 0;
        if($sizeYear >= $sizeGroup && $sizeYear >= $sizeHalfgroup) $size = $sizeYear;
        if($sizeGroup >= $sizeYear && $sizeGroup >= $sizeHalfgroup) $size = $sizeGroup;
        if($sizeHalfgroup >= $sizeYear && $sizeHalfgroup >= $sizeGroup) $size = $sizeHalfgroup;
        for($i = 0; $i < $size; ++$i){
            echo '<tr>
                    <td class="text-center">';
            if($sizeYear > $i)
                echo $badCodes[0][$i];
            else
                echo ' ';
            echo '</td>
            <td class="text-center">';
            if($sizeGroup > $i)
                echo $badCodes[1][$i];
            else
                echo ' ';
            echo '</td>
            <td class="text-center">';
            if($sizeHalfgroup > $i)
                echo $badCodes[2][$i];
            else
                echo ' ';
            echo '</td>

                  </tr>';
        }
        echo '
                </tbody>
        </table>
        ';
    }
}