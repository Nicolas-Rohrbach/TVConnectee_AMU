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

    public function endTab(){
        echo'
          </tbody>
        </table>
        </form>';
    }

    public function refreshPage(){
        echo '<meta http-equiv="refresh" content="0">';
    }

    protected function displayAll($row , $login, $code){
        echo '
        <tr>
          <th scope="row">'.$row.'</th>
          <td class="text-center"> '.$login.'</td>
          <td class="text-center">'.$code.'</td>';
    }
}