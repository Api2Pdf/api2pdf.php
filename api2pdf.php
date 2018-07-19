<?php
$API2PDF_BASE_ENDPOINT = 'https://v2018.api2pdf.com';
$API2PDF_MERGE = $API2PDF_BASE_ENDPOINT.'/merge';
$API2PDF_WKHTMLTOPDF_HTML = $API2PDF_BASE_ENDPOINT.'/wkhtmltopdf/html';
$API2PDF_WKHTMLTOPDF_URL = $API2PDF_BASE_ENDPOINT.'/wkhtmltopdf/url';
$API2PDF_CHROME_HTML = $API2PDF_BASE_ENDPOINT.'/chrome/html';
$API2PDF_CHROME_URL = $API2PDF_BASE_ENDPOINT.'/chrome/url';
$API2PDF_LIBREOFFICE_CONVERT = $API2PDF_BASE_ENDPOINT.'/libreoffice/convert';

class Api2Pdf {
    var $apikey;
    function __construct($apikey) {
        $this->apikey = $apikey;
    }

    public function headless_chrome_from_url($url, $inline = false, $filename = null, $options = null) {
        global $API2PDF_CHROME_URL;
        $payload = array("url"=>$url, "inlinePdf"=>$inline);
        if ($filename != null) {
            $payload["fileName"] = $filename;
        }

        if ($options != null) {
            $payload["options"] = $options;
        }

        return $this->_make_request($API2PDF_CHROME_URL, $payload);
    }

    public function headless_chrome_from_html($html, $inline = false, $filename = null, $options = null) {
        global $API2PDF_CHROME_HTML;
        $payload = array("html"=>$html, "inlinePdf"=>$inline);
        if ($filename != null) {
            $payload["fileName"] = $filename;
        }

        if ($options != null) {
            $payload["options"] = $options;
        }

        return $this->_make_request($API2PDF_CHROME_HTML, $payload);
    }

    public function wkhtmltopdf_from_url($url, $inline = false, $filename = null, $options = null) {
        global $API2PDF_WKHTMLTOPDF_URL;
        $payload = array("url"=>$url, "inlinePdf"=>$inline);
        if ($filename != null) {
            $payload["fileName"] = $filename;
        }

        if ($options != null) {
            $payload["options"] = $options;
        }

        return $this->_make_request($API2PDF_WKHTMLTOPDF_URL, $payload);
    }

    public function wkhtmltopdf_from_html($html, $inline = false, $filename = null, $options = null) {
        global $API2PDF_WKHTMLTOPDF_HTML;
        $payload = array("html"=>$html, "inlinePdf"=>$inline);
        if ($filename != null) {
            $payload["fileName"] = $filename;
        }

        if ($options != null) {
            $payload["options"] = $options;
        }

        return $this->_make_request($API2PDF_WKHTMLTOPDF_HTML, $payload);
    }

    public function merge($urls, $inline = false, $filename = null) {
        global $API2PDF_MERGE;
        $payload = array("urls"=>$urls, "inlinePdf"=>$inline);

        if ($filename != null) {
            $payload["fileName"] = $filename;
        }

        return $this->_make_request($API2PDF_MERGE, $payload);
    }

    public function libreoffice_convert($url, $inline = false, $filename = null) {
        global $API2PDF_LIBREOFFICE_CONVERT;
        $payload = array("url"=>$url, "inlinePdf"=>$inline);

        if ($filename != null) {
            $payload["fileName"] = $filename;
        }

        return $this->_make_request($API2PDF_LIBREOFFICE_CONVERT, $payload);
    }

    function _make_request($endpoint, $payload) {
        //Initiate cURL.
        $ch = curl_init($endpoint);

        //Encode the array into JSON.
        $jsonDataEncoded =  json_encode($payload);

        //Tell cURL that we want to send a POST request.
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //Attach our encoded JSON string to the POST fields.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

        //Set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: '.$this->apikey));

        //Execute the request
        $json_result = curl_exec($ch);
        $result = json_decode($json_result);
        return $result;
    }

}
?>
