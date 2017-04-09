<?php
/**
 * Shows a searcheable and sortable table with data CSV file
 * @author      Julian Bogdani <jbogdani@gmail.com>
 * @copyright    BraDypUS 2017
 * @license      ISC
 * @version      1.0
 * @since        2017/04/09
 * @see          https://github.com/jbogdani/bradycms-plugins
 */
class table extends plugins_ctrl
{
  /**
   * Returns data directory
   * @return [type] [description]
   */
  private function dir()
  {
    return SITE_DIR . 'modules/table/data';
  }


  /**
   * Main callable (from template or via ct) function. Sets modules queue with js and HTML data
   * @param  array  $data    array of data
   *                         content: name of CSV file to show
   *                         class: CSS class (or space separated classes) to apply to table element
   * @param  OutHtml $outHtml OutHtml object
   * @return text           Well formatted HTML
   */
  public function init($data, OutHtml $outHtml)
  {
    $file = $this->dir() . '/' . $data['content'] . '.csv';

    $uid = uniqid('id');

    if (!file_exists($file))
    {
      return false;
    }

    $d = [];
    $c =  [];
    $cnt = 0;

    $file = fopen($file, 'r');

    while (($line = fgetcsv($file)) !== FALSE)
    {
      if ($cnt === 0)
      {
        $c = $line;
      }
      else
      {
        array_push($d, $line);
      }
      $cnt++;
    }
    fclose($file);

    $jsondata = json_encode($d);

    $columns = '[{ title: "' . implode('"},{title:"', $c) . '"}]';


    $queue = <<<EOD
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script>
$('#{$uid}').DataTable({
  "language": {
      "lengthMenu": "Mostra _MENU_ elementi per pagina",
      "zeroRecords": "Non è stato trovato nessun risultato",
      "info": "Pagina _PAGE_ di _PAGES_",
      "infoEmpty": "Nessun record disponibile",
      "infoFiltered": "",
      "search": "Cerca: ",
      "paginate": {
        "first":      "Primo",
        "last":       "Ultimo",
        "next":       "Prossimo",
        "previous":   "Precedente"
    },
  },
  "data": {$jsondata},
  "columns": {$columns}
});
</script>
EOD;


    $outHtml->setQueue('modules', $queue, true);
    return '<div class="table-wrapper">'
      . '<table id="' . $uid . '" class="dt ' . $data['class'] . '"></table>'
      . '</div>';

  }

  /**
   * Main admin function:
   * - Shows list of available tables (CSV files)
   * - Delete functionality for sigle files
   * - Upload functionality for new files
   * @param  string|false $action Action to perform: delete | list (default)
   * @param  string|false $path   Path to file to delete
   */
  public function admin($action = false, $path = false)
  {
    if ($action === 'delete' && $more)
    {
      echo $this->deleteFile($this->dir() . '/' . $path);
      return;
    }

    $data = [
      'upload_dir' => $this->dir(),
      'files' => utils::dirContent($this->dir())

    ];
    $this->render('table', 'list', $data);
  }

  /**
   * Deletes file, if exists, and returns json structured response
   * @param  string $file full path to file to delete
   */
  private function deleteFile($file)
  {
    error_log($file);
    if (file_exists($file))
    {
      @unlink($file);
    }

    if(file_exists($file))
    {
      return $this->responseJson('error', tr::get('Error. Can not delete file ' . $file));
    }
    else
    {
      return $this->responseJson('success', tr::get('File deleted'));
    }
  }

}

?>
