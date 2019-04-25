<?php
/**
 * Created by PhpStorm.
 * User: s17018568
 * Date: 22/01/19
 * Time: 15:07
 */

abstract class ViewUser
{

    protected function displayInsertImportFile($name){
        echo'
             <form method="post" enctype="multipart/form-data">
				<input type="file" name="excel'.$name.'" class="btn btn-dark"/>
				<br/>
				<button type="submit" name="import'.$name.'" class="btn btn-primary" value="Importer">Importer le fichier</button>
			</form>
			<br/>';
    }

    public function endTab(){
        echo'
          </tbody>
        </table>
        </form>';
    }

    public function refreshPage(){
        echo '<meta http-equiv="refresh" content="0">';
    }

    protected function displayAll($row ,$firstname, $lastname, $code,  $code2, $code3, $hide){
        echo '
        <tr>
          <th scope="row">'.$row.'</th>
          <td class="text-center"> '.$firstname.'</td>';
            if(isset($lastname)) echo '<td class="text-center">'.$lastname.'</td>';
            if($code == 0) $code = 'X';
            if($code2 == 0) $code2 = 'X';
            if($code3 == 0) $code3 = 'X';
        echo '
            <td class="text-center">'.$code.'</td>';
            if(! ($hide)) {
                echo '
                <td class="text-center">'.$code2.'</td>
                <td class="text-center">'.$code3.'</td>';
            }
    }

//    public function displayButton() {
//        echo '
//          <td class="text-center"> <a href="http://'.$_SERVER['HTTP_HOST'].'/modifier-une-tv/'.$id.'" class="btn btn-primary btn-lg" name="modifyTv" type="submit" value="Modifier">Modifier</a></td>
//          <td class="text-center"> <button class="btn btn-danger btn-lg " name="deleteTv" type="submit" value="'.$id.'" >Supprimer</button></td>
//        </tr>
//            ';
//    }
}