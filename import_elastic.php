<?php

include_once "inc/config.php";

$sql = "SELECT * FROM berita_baru";        // Change "berita_baru" into your own table name that want to be imported 
    foreach ($dbh->query($sql, PDO::FETCH_ASSOC) as $row) {
        $action = 'index';
        $meta   = array(
            '_index' => 'index_name',       // change with your designated Elasticsearch index name
            '_type'  => 'index_type',       // change with your proper index type
            '_id'    => $row["id"]          // this id is following the id fields from the database
        );
        $action_meta_data = array(
            $action => $meta
        );
    // $row["content"] = strip_tags($row["content"]);
        // Generate Source Data
        $optional_source = $row;

        // Convert to JSON
        $action_meta_data_json  = json_encode($action_meta_data);
        $optional_source_json   = json_encode($optional_source);
        // Newline to
        $docs .= $action_meta_data_json."\n".$optional_source_json."\n";
    }

$file = fopen("test.json","w");
if(fwrite($file,$docs))
{
    echo "successful to convert sql to test.json";
}
fclose($file);

// Use curl to send content using HTTP operation

$url = "http://localhost:9200/_bulk";
$ch=curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $docs);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER,
    array('Content-Type:application/json',
        'Content-Length: ' . strlen($docs))
);

$result = curl_exec($ch);
curl_close($ch);
