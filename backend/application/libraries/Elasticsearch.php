<?php
class Elasticsearch
{
        function __construct($server = 'http://bloomigo.in:9200')
        {
                $this->server = $server;
                $this->index = "searchmain";
                $this->type = 'my_index_type';

        }

        //This function returns the elasticsearch results
        function call($path, $http = array())
        {
                
                $content = @file_get_contents($this->server . '/' . $this->index . '/' . $path, NULL, stream_context_create(array('http' => $http)));
                if ($content === FALSE) return array(null, 0);
                else return array(json_decode($content), 1);
        }

        //curl -X PUT http://bloomigo.in:9200/{INDEX}/
        // This function is to create an index
        function create()
        {
                $this->call(NULL, array('method' => 'PUT', 'header' => "Content-Type: application/x-www-form-urlencoded\r\n"));
        }

        //curl -X GET http://bloomigo.in:9200/{INDEX}/_status
        function status()
        {
                return $this->call('_status');
        }

        //curl -X GET http://bloomigo.in:9200/{INDEX}/{TYPE}/_count -d {matchAll:{}}
        function count()
        {
                return $this->call($this->type . '/_count', array('method' => 'GET', 'content' => '{ matchAll:{} }'));
        }

        //curl -X PUT http://bloomigo.in:9200/{INDEX}/{TYPE}/_mapping -d ...
        function map($data)
        {
                return $this->call($this->type . '/_mapping', array('method' => 'PUT', 'content' => $data));
        }

        //curl -X PUT http://bloomigo.in:9200/{INDEX}/{TYPE}/{ID} -d ...
        function add($id, $data)
        {
                return $this->call($this->type . '/' . $id, array('method' => 'PUT', 'header' => "Content-Type: application/x-www-form-urlencoded\r\n", 'content' => $data));
        }

        //curl -X DELETE http://bloomigo.in:9200/{INDEX}/
        //Delete an indexed item by ID
        function delete($id)
        {
                return $this->call($this->type . '/' . $id, array('method' => 'DELETE'));
        }

        //curl -X GET http://bloomigo.in:9200/{INDEX}/{TYPE}/_search?q= ...
        function query($q)
        {
                $q = preg_replace('/(\+|\-|\&|\||\!|\(|\)|\{|\}|\[|\]|\^|\"|\~|\*|\?|\:|\\\\)/', ' ', $q);
                $q=trim($q);
                return $this->call($this->type . '/_search?' . http_build_query(array('q' => $q)));
        }

        function query_wresultSize($q, $size=999)
        {
                $q = preg_replace('/(\+|\-|\&|\||\!|\(|\)|\{|\}|\[|\]|\^|\"|\~|\*|\?|\:|\\\\)/', ' ', $q);
                $q=trim($q);
                return $this->call($this->type . '/_search?' . http_build_query(array('q' => $q, 'size' => $size)));
        }

        function query_all($q)
        {
                $q = preg_replace('/(\+|\-|\&|\||\!|\(|\)|\{|\}|\[|\]|\^|\"|\~|\*|\?|\:|\\\\)/', ' ', $q);
                $q=trim($q);
                return $this->call('_search?' . http_build_query(array('q' => $q)));
        }

        function query_all_wresultSize($q, $size=999)
        {
                $q = preg_replace('/(\+|\-|\&|\||\!|\(|\)|\{|\}|\[|\]|\^|\"|\~|\*|\?|\:|\\\\)/', ' ', $q);
                $q=trim($q);
                return $this->call('_search?' . http_build_query(array('q' => $q, 'size' => $size)));     
        }

        function query_highlight($q)
        {
                $q = preg_replace('/(\+|\-|\&|\||\!|\(|\)|\{|\}|\[|\]|\^|\"|\~|\*|\?|\:|\\\\)/', ' ', $q);
                $q=trim($q);
                return $this->call($this->type . '/_search?' . http_build_query(array('q' => $q)), array('header' => "Content-Type: application/x-www-form-urlencoded\r\n", 'content' => '{"highlight":{"fields":{"field_1":{"pre_tags" : ["<b style=\"background-color:#C8C8C8\">"], "post_tags" : ["</b>"]}, "field_2":{"pre_tags" : ["<b style=\"background-color:#C8C8C8\">"], "post_tags" : ["</b>"]}}}}'));
        }
}
?>
