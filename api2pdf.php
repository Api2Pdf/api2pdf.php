<?php

define("API2PDF_BASE_ENDPOINT", 'https://v2018.api2pdf.com');
define("API2PDF_MERGE", API2PDF_BASE_ENDPOINT.'/merge');
define("API2PDF_WKHTMLTOPDF_HTML", API2PDF_BASE_ENDPOINT.'/wkhtmltopdf/html');
define("API2PDF_WKHTMLTOPDF_URL", API2PDF_BASE_ENDPOINT.'/wkhtmltopdf/url');
define("API2PDF_CHROME_HTML", API2PDF_BASE_ENDPOINT.'/chrome/html');
define("API2PDF_CHROME_URL", API2PDF_BASE_ENDPOINT.'/chrome/url');
define("API2PDF_LIBREOFFICE_CONVERT", API2PDF_BASE_ENDPOINT.'/libreoffice/convert');

class Api2PdfLibrary {
    var $apikey;
    function __construct($apikey) {
        $this->apikey = $apikey;    
    }
    public function headless_chrome_from_url($url, $inline = false, $filename = null, $options = null) {
        $payload = array("url"=>$url, "inlinePdf"=>$inline);
        if ($filename != null) {
            $payload["fileName"] = $filename;
        }
        if ($options != null) {
            $payload["options"] = $options;
        }
        return $this->_make_request(API2PDF_CHROME_URL, $payload);
    }
    public function headless_chrome_from_html($html, $inline = false, $filename = null, $options = null) {
        $payload = array("html"=>$html, "inlinePdf"=>$inline);
        if ($filename != null) {
            $payload["fileName"] = $filename;
        }
        if ($options != null) {
            $payload["options"] = $options;
        }
        return $this->_make_request(API2PDF_CHROME_HTML, $payload);
    }
    public function wkhtmltopdf_from_url($url, $inline = false, $filename = null, $options = null) {
        $payload = array("url"=>$url, "inlinePdf"=>$inline);
        if ($filename != null) {
            $payload["fileName"] = $filename;
        }
        if ($options != null) {
            $payload["options"] = $options;
        }
        return $this->_make_request(API2PDF_WKHTMLTOPDF_URL, $payload);
    }
    public function wkhtmltopdf_from_html($html, $inline = false, $filename = null, $options = null) {
        $payload = array("html"=>$html, "inlinePdf"=>$inline);
        if ($filename != null) {
            $payload["fileName"] = $filename;
        }
        if ($options != null) {
            $payload["options"] = $options;
        }
        return $this->_make_request(API2PDF_WKHTMLTOPDF_HTML, $payload);
    }
    public function merge($urls, $inline = false, $filename = null) {
        $payload = array("urls"=>$urls, "inlinePdf"=>$inline);
        if ($filename != null) {
            $payload["fileName"] = $filename;
        }
        return $this->_make_request(API2PDF_MERGE, $payload);
    }
    public function libreoffice_convert($url, $inline = false, $filename = null) {
        $payload = array("url"=>$url, "inlinePdf"=>$inline);
        if ($filename != null) {
            $payload["fileName"] = $filename;
        }
        return $this->_make_request(API2PDF_LIBREOFFICE_CONVERT, $payload);
    }

    private function _make_request($endpoint, $payload) {
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

        if($json_result === false) {
            throw new \Exception(curl_error($ch), 1);
        }
        $result = json_decode($json_result);
        return $result;
    }
}
