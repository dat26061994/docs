<?php
function collection()
{
    $file1 = include 'doc-data.php';
    $arr = [];
    foreach ($file1 as $key => $value) {
        $collection = "";
        $title = $value['title'];
        $methods = isset($value["methods"]) ? $value["methods"] : [];
        $description = $value['description'];
        $attributes = $value['attributes'];
        $relationships = isset($value['relationships']) ? $value['relationships'] : [];
        if (count($methods) == 0 || in_array("collection",$methods)) {
        $collection = $collection."## List ".$title."\n";
        $collection = $collection."* Method name: `collection`\n";
        $collection = $collection."::: tip HTTP Request\n
#### GET `{{ baseUrl }}/{{ resourceType }}`\n
<strong>Query parameters</strong>\n
Query params | Type | Required | Description
-------------|------|----------|------------
";
    $txt_attr = '';
    foreach ($attributes as $key => $attr) {
        $txt_attr = $txt_attr.$key." | ".$attr["type"]." | false |".$attr["description"]."\n";
    }
    $collection = $collection.$txt_attr;
    $collection = $collection."Response is a [Document](/docs) of multiple [".$title."](".$title.".html)\n";
    if (isset($relationships) && count($relationships) > 0) {
        $collection = $collection.", also including all related [resource objects](/docs): ";
        $txt_rela = "";
        $txt_rela_arr = "";
        foreach ($relationships as $key => $rela) {
            $txt_rela = $txt_rela . "[".$key."](/docs/".ucfirst($key).".html), \n";
            $txt_rela_arr = $txt_rela_arr . ucfirst($key).", ";
        }
        $collection = $collection.$txt_rela;
    }
    $collection = $collection.'```json
// Status code: 200
{
"data": (array:'.$title.'),
"included": (array:('.$txt_rela_arr.'))
}
```
';
$collection = $collection." \n";
    $collection = $collection.":::\n\n";
    $arr[$title] = $collection;
    }
}
    return $arr;
}

function get()
{
    $file1 = include 'doc-data.php';
    $arr = [];
foreach ($file1 as $key => $value) {
    $collection = "";
    $title = $value['title'];
    $description = $value['description'];
    $attributes = $value['attributes'];
    $relationships = isset($value['relationships']) ? $value['relationships'] : [];
    $id = isset($value['id']) ? $value['id'] : [];
    $id_type = isset($id) ? $id["type"] : "";
    $id_des = isset($id["description"]) ? $id["description"] : $title." ID";
    $methods = isset($value["methods"]) ? $value["methods"] : [];
    if (count($methods) == 0 || in_array("get",$methods)) {
    $collection = $collection."# ".$title."\n";
    $collection = $collection."## Get a ".$title."\n";
    $collection = $collection."* Method name: `get`\n";
    $collection = $collection."You can get a single ".$title." by using {id}\n
::: tip HTTP Request\n
#### GET `{{ baseUrl }}/{{ resourceType }}/:id`\n
<strong>Path parameters</strong>\n
Parameter | Type | Required | Description
----------|------|----------|------------
id | ".$id_type." | true | ".$id_des."
:::\n\n";
    $collection = $collection."Response is a [Document](/docs) of a single [".$title."](models/".$title.".html)";
    if (isset($relationships) && count($relationships) > 0) {
        $collection = $collection.", also including all related [resource objects](/docs):";
        $txt_rela = "";
        $txt_rela_arr = "";
        foreach ($relationships as $key => $rela) {
            $txt_rela = $txt_rela . "[".$key."](/docs/".ucfirst($key).".html), \n";
            $txt_rela_arr = $txt_rela_arr . ucfirst($key).", ";
        }
        $collection = $collection.$txt_rela;
    }
    $collection = $collection."@include(model.md)\n\n";
    $arr[$title] = $collection;
}
}
    return $arr;
}

function create()
{
    $file1 = include 'doc-data.php';
    $arr = [];
    $baseUrl = "";
    foreach ($file1 as $key => $value) {
        $txt = "";
        $title = $value['title'];
        $description = $value['description'];
        $attributes = $value['attributes'];
        $relationships = isset($value['relationships']) ? $value['relationships'] : [];
        $methods = isset($value["methods"]) ? $value["methods"] : [];
        if (count($methods) == 0 || in_array("post",$methods)) {
        $txt = $txt."## Create new ".$title."\n";
        $txt = $txt."::: tip HTTP Request\n#### POST `{{ baseUrl }}/".$title."`\n";
        $txt = $txt."<strong>OAuth scopes:</strong>\nScope | Description\n------|------------\n";
        $txt = $txt."".$title.".post | Permission to create ".$title."\n<hr />\n\n";
        $txt = $txt."<strong>JSON Body:</strong> [Document](api-standard.html#document-objects) of a single [".$title."](models/".$title.".html)\n<hr />\n\n";
        $txt = $txt."<strong>".$title." attributes:</strong>\n";
        $txt = $txt."Attribute name | Type | Required | Description\n---------------|------|----------|------------\n";
        $txt_attr = '';
        foreach ($attributes as $key => $attr) {
            $txt_attr = $txt_attr.$key." | ".$attr["type"]." | false |".$attr["description"]."\n";
        }
        $txt = $txt.$txt_attr;
        $txt = $txt."\n\n<hr />\n\n";
        if (isset($relationships) && count($relationships) > 0) {
            $txt = $txt."<strong>".$title." relationships:</strong>\n";
            $txt = $txt."Relationship key | Value\n------------------|------------\n";
            $txt_rela = "";
            foreach ($relationships as $key => $rela) {
                $txt_rela = $txt_rela.$key." | A [relationship object](api-standard.html#relationship-objects) of [".ucfirst($key)."](models/".ucfirst($key).".html) resources for one-to-".$rela["relationship_type"]." relationship.\n";
            }
            $txt = $txt.$txt_rela;
        }
        $txt = $txt."\n\n:::\n\n<strong>Example request in Javascript using Axios:</strong>\n";
        $txt = $txt."```js\n// New ".$title." document\n";
        $txt = $txt."let productDocument = ";
        $document = array();
        $document["data"] = array();
        $document["data"]["id"] = "{".strtolower($title)."-id}";
        $document["data"]["type"] = $value["type"];
        $document["data"]["attributes"] = $attributes;
        $document["data"]["relationships"] = $relationships;
        $txt = $txt.formatArrayString($document);
        $txt = $txt." \n";
        $txt = $txt."// Send API request\n";
        $txt = $txt."axios.request({
    url: '".$baseUrl."/".$title."',
    method: 'post',
    headers: {
        'Content-Type': 'application/vnd.api+json',
        'OAuth-Token': '{OAuth-Token}',
        'Hiweb-Secret-Proof': '{Hiweb-Secret-Proof}'
    },
    data: ".strtolower($title)."Document
});\n````\n\n";
        $txt = $txt."Response is a [Document](api-standard.html#document-objects) of a single [".$title."](models/".$title.".html)\n";
        if (isset($relationships) && count($relationships) > 0) {
            $txt = $txt.", also including all related [resource objects](/docs):";
            $txt_rela = "";
            $txt_rela_arr = "";
            foreach ($relationships as $key => $rela) {
                $txt_rela = $txt_rela . "[".ucfirst($key)."](/docs/".ucfirst($key).".html), \n\n";
                $txt_rela_arr = $txt_rela_arr . ucfirst($key).", ";
            }
            $txt = $txt.$txt_rela;
        }
        $txt = $txt."```json\n// Status code: 201";
        $txt = $txt.'{
    "data": (object:'.$title.'),
    "included": (array:('.$txt_rela_arr.'))
}';
        $arr[$title] = $txt;
    }
}
    return $arr;
}

function update()
{
    $file1 = include 'doc-data.php';
    $arr = [];
    $baseUrl = "";
    foreach ($file1 as $key => $value) {
        $txt = "";
        $title = $value['title'];
        $description = $value['description'];
        $attributes = $value['attributes'];
        $id = $value["id"];
        $relationships = isset($value['relationships']) ? $value['relationships'] : [];
        $methods = isset($value["methods"]) ? $value["methods"] : [];
        if (count($methods) == 0 || in_array("path",$methods)) {
        $txt = $txt."\n\n```\n## Update a ".$title."\n\n ::: tip HTTP Request\n#### PATCH `".$baseUrl."".strtolower($title)."/{id}`\n\n<strong>OAuth scopes:</strong>\n";
        $txt = $txt."Scope | Description\n------|------------\n".strtolower($title).".patch | Permission to update ".strtolower($title)."\n\n";
        $txt = $txt."<hr />\n\n";
        $txt = $txt."<strong>Path parameters</strong>\n";
        $txt = $txt."Parameters | Type | Required | Description\n-----------|------|----------|------------\n{id} | ".$id["type"]." | true | ".$title." ID to edit\n\n";
        $txt = $txt."<hr />\n\n";
        $txt = $txt."<strong>JSON Body:</strong> [Document](api-standard.html#document-objects) of a single [".$title."](models/".$title.".html) (top level attribute `id` is required)\n<hr />\n\n";
        if (isset($attributes) && count($attributes) > 0) {
            $txt = $txt."<strong>".$title." attributes:</strong>\n";
            $txt = $txt."Attribute name | Type | Required | Description\n---------------|------|----------|------------\n";
            $txt_attr = "";
            foreach ($attributes as $key => $attr) {
                $txt_attr = $txt_attr.$key." | ".$attr["type"]." | false |".$attr["description"]."\n";
            }
            $txt = $txt.$txt_attr;
        }
        $txt = $txt."\n\n<hr />\n\n";
        if (isset($relationships) && count($relationships) > 0) {
            $txt = $txt."<strong>".$title." relationships:</strong>\n";
            $txt = $txt."Relationship name | Required | Value\n------------------|----------|------------\n";
            $txt_rela = "";
            foreach ($relationships as $key => $rela) {
                $txt_rela = $txt_rela.$key." | false | A [relationship object](api-standard.html#relationship-objects) of [".ucfirst($key)."](models/".ucfirst($key).".html) resources for one-to-".$rela["relationship_type"]." relationship.\n";
            }
            $txt = $txt.$txt_rela;
        }
        $txt = $txt."\n:::\n\n";
        $txt = $txt."<strong>Example request in Javascript using Axios:</strong>\n\n";
        $txt = $txt."```js\n";
        $txt = $txt."// Product document\n";
        $txt = $txt."let productDocument = ";
        $document = array();
        $document["data"] = array();
        $document["data"]["id"] = "{".strtolower($title)."-id}";
        $document["data"]["type"] = $value["type"];
        $document["data"]["attributes"] = $attributes;
        $document["data"]["relationships"] = $relationships;
        $txt = $txt.formatArrayString($document);
        $txt = $txt."\n\n// Send API request\n";
        $txt = $txt."axios.request({
    url: '".$baseUrl."/".$title."',
    method: 'post',
    headers: {
        'Content-Type': 'application/vnd.api+json',
        'OAuth-Token': '{OAuth-Token}',
        'Hiweb-Secret-Proof': '{Hiweb-Secret-Proof}'
    },
    data: ".strtolower($title)."Document
});\n````\n\n";
        $txt = $txt."Response is a [Document](api-standard.html#document-objects) of a single [Product](models/".$title.".html)\n";
        if (isset($relationships) && count($relationships) > 0) {
            $txt = $txt.", also including all related [resource objects](/docs):";
            $txt_rela2 = "";
            $txt_rela_arr = "";
            foreach ($relationships as $key => $rela) {
                $txt_rela2 = $txt_rela2 . "[".ucfirst($key)."](/docs/".ucfirst($key).".html), \n";
                $txt_rela_arr = $txt_rela_arr . ucfirst($key).", ";
            }
            $txt = $txt.$txt_rela2;
        }
        $txt = $txt."```json\n// Status code: 201";
        $txt = $txt.'{
    "data": (object:'.$title.'),
    "included": (array:('.$txt_rela_arr.'))
}';
        $arr[$title] = $txt;
    }
}
    return $arr;
}

function delete()
{
    $file1 = include 'doc-data.php';
    $arr = [];
    $baseUrl = "";
    foreach ($file1 as $key => $value) {
        $txt = "";
        $title = $value['title'];
        $description = $value['description'];
        $attributes = $value['attributes'];
        $id = $value["id"];
        $relationships = isset($value['relationships']) ? $value['relationships'] : [];
        $methods = isset($value["methods"]) ? $value["methods"] : [];
        if (count($methods) == 0 || in_array("delete",$methods)) {
        $txt = $txt."\n```\n\n## Delete a ".$value["type"]."\n";
        $txt = $txt."::: danger HTTP Request\n#### DELETE `https://api.hiweb.io/api/".strtolower($title)."/{id}`\n\n";
        $txt = $txt."<strong>OAuth scopes:</strong>\nScope | Description\n------|------------\n";
        $txt = $txt."".strtolower($title).".delete | Permission to delete ".strtolower($title)."\n\n<hr />\n\n";
        $txt = $txt."<strong>Path parameters</strong>\n";
        $txt = $txt."Parameter | Type | Required | Description\n----------|------|----------|------------\n";
        $txt = $txt."{id} | ".$id["type"]." | true | ".strtolower($title)." id\n:::\n\n";
        $txt = $txt."Example response\n\n";
        $txt = $txt.'```json
// Status code: 200
{
    "meta": {
        "status": "deleted"
    }
}';     $txt = $txt."\n```";
        $arr[$title] = $txt;
    }
}
    return $arr;
}

function model()
{
    $file1 = include 'doc-data.php';
    $arr = [];
    $baseUrl = "";
    foreach ($file1 as $key => $value) {
        $txt = "";
        $title = $value['title'];
        $description = $value['description'];
        $attributes = $value['attributes'];
        $id = $value["id"];
        $relationships = isset($value['relationships']) ? $value['relationships'] : [];
        $txt = $txt."---\ntitle: ".$title."\n---\n\n";
        $txt = $txt."# ".$title." model\n\n";
        $txt = $txt."```json\n";
        $model = array();
        $model['id'] = $id["type"];
        $model['type'] = $value["type"];
        $attr = array();
        if (isset($attributes) && count($attributes) > 0) {
            foreach ($attributes as $key => $attr2) {
                $attr[$key] = '('.$attr2["type"].')';
            }
            $model['attributes'] = $attr;
            $txt = $txt.json_encode($model,JSON_PRETTY_PRINT);
        }
        $txt = $txt."\n```";
        $arr[$title] = $txt;
    }
    return $arr;
}

function getListSideBar()
{
    $file1 = include 'doc-data.php';
    $arr = [];
    foreach ($file1 as $key => $value) {
        $title = $value['title'];
        array_push($arr,$title);
    }
    return $arr;
}

function formatArrayString($data)
{
    return json_encode($data,JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}

function writeFile()
{
    $data_collection = collection();
    $data_get = get();
    $data_create = create();
    $data_update = update();
    $data_delete = delete();
    foreach ($data_get as $key => $get) {
        $fileName = "docs/".$key.".md";
        $myfile = fopen($fileName, "w+") or die("Unable to create file!");
        fwrite($myfile, $get);
        fwrite($myfile,isset($data_collection[$key]) ? $data_collection[$key] : "");
        fwrite($myfile,isset($data_create[$key]) ? $data_create[$key] : "");
        fwrite($myfile,isset($data_update[$key]) ? $data_update[$key] : "");
        fwrite($myfile,isset($data_delete[$key]) ? $data_delete[$key] : "");
        fclose($myfile);
    }
}

function writeModelFile()
{
    $data_model = model();
    foreach ($data_model as $key => $value) {
        if (!file_exists('docs/models')) {
            mkdir('docs/models', 0777, true);
        }
        $fileName = "docs/models/".$key.".md";
        $myfile = fopen($fileName, "w+") or die("Unable to create file!");
        fwrite($myfile, $value);
        fclose($myfile);
    }
}

writeFile();
writeModelFile();
?>
