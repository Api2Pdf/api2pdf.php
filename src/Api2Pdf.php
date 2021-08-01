<?php

interface Api2PdfInterface
{
    public function chromeUrlToPdf($url, $inline = true, $filename = null, $options = null);
    public function chromeHtmlToPdf($html, $inline = true, $filename = null, $options = null);
    public function chromeUrlToImage($url, $inline = true, $filename = null, $options = null);
    public function chromeHtmlToImage($html, $inline = true, $filename = null, $options = null);
    public function wkUrlToPdf($url, $inline = true, $filename = null, $options = null, $enableToc = false);
    public function wkHtmlToPdf($html, $inline = true, $filename = null, $options = null, $enableToc = false);
    public function libreOfficeAnyToPdf($url, $inline = true, $filename = null);
    public function libreOfficeThumbnail($url, $inline = true, $filename = null);
    public function libreOfficePdfToHtml($url, $inline = true, $filename = null);
    public function libreOfficeHtmlToDocx($url, $inline = true, $filename = null);
    public function libreOfficeHtmlToXlsx($url, $inline = true, $filename = null);
    public function pdfsharpMerge($urls, $inline = true, $filename = null);
    public function pdfsharpAddBookmarks($url, $bookmarks, $inline = true, $filename = null);
    public function pdfsharpAddPassword($url, $userpassword, $ownerpassword = null, $inline = true, $filename = null);
    public function utilityDelete($responseId);
}

class Api2Pdf implements Api2PdfInterface
{
    /**
     * @var string|null
     */
    private $apiKey = null;

    /**
     * @var string|null
     */
    private $base_url = null;

    public function __construct($apiKey, $base_url = 'https://v2.api2pdf.com') {
        $this->apiKey = $apiKey;
        $this->base_url = $base_url;
    }

    /**
     * @param string $url
     * @throws Api2PdfException
     * @return Api2PdfResult
     */
    public function chromeUrlToPdf($url, $inline = true, $filename = null, $options = null) {
        $payload = array_merge(
            $this->buildPayloadBase($inline, $filename, $options),
            [
                'url' => $url,
            ]
        );
        return $this->makeRequest('/chrome/pdf/url', $payload);
    }

    /**
     * @param string $html
     *
     * @throws Api2PdfException
     * @return Api2PdfResult
     */
    public function chromeHtmlToPdf($html, $inline = true, $filename = null, $options = null) {
        $payload = array_merge(
            $this->buildPayloadBase($inline, $filename, $options),
            [
                'html' => $html,
            ]
        );

        return $this->makeRequest('/chrome/pdf/html', $payload);
    }

    /**
     * @param string $url
     * @throws Api2PdfException
     * @return Api2PdfResult
     */
    public function chromeUrlToImage($url, $inline = true, $filename = null, $options = null) {
        $payload = array_merge(
            $this->buildPayloadBase($inline, $filename, $options),
            [
                'url' => $url,
            ]
        );
        return $this->makeRequest('/chrome/image/url', $payload);
    }

    /**
     * @param string $html
     *
     * @throws Api2PdfException
     * @return Api2PdfResult
     */
    public function chromeHtmlToImage($html, $inline = true, $filename = null, $options = null) {
        $payload = array_merge(
            $this->buildPayloadBase($inline, $filename, $options),
            [
                'html' => $html,
            ]
        );

        return $this->makeRequest('/chrome/image/html', $payload);
    }

    /**
     * @param string $url
     *
     * @throws Api2PdfException
     * @return Api2PdfResult
     */
    public function wkUrlToPdf($url, $inline = true, $filename = null, $options = null, $enableToc = false) {
        $payload = array_merge(
            $this->buildPayloadBase($inline, $filename, $options),
            [
                'url' => $url,
                'enableToc' => $enableToc
            ]
        );

        return $this->makeRequest('/wkhtml/pdf/url', $payload);
    }

    /**
     * @param string $html
     *
     * @throws Api2PdfException
     * @return Api2PdfResult
     */
    public function wkHtmlToPdf($html, $inline = true, $filename = null, $options = null, $enableToc = false) {
        $payload = array_merge(
            $this->buildPayloadBase($inline, $filename, $options),
            [
                'html' => $html,
                'enableToc' => $enableToc
            ]
        );

        return $this->makeRequest('/wkhtml/pdf/html', $payload);
    }

    /**
     * @param string $url
     *
     * @throws Api2PdfException
     * @return Api2PdfResult
     */
    public function libreOfficeAnyToPdf($url, $inline = true, $filename = null) {
        $payload = array_merge(
            $this->buildPayloadBase($inline, $filename),
            [
                'url' => $url,
            ]
        );

        return $this->makeRequest('/libreoffice/any-to-pdf', $payload);
    }

    /**
     * @param string $url
     *
     * @throws Api2PdfException
     * @return Api2PdfResult
     */
    public function libreOfficeThumbnail($url, $inline = true, $filename = null) {
        $payload = array_merge(
            $this->buildPayloadBase($inline, $filename),
            [
                'url' => $url,
            ]
        );

        return $this->makeRequest('/libreoffice/thumbnail', $payload);
    }

    /**
     * @param string $url
     *
     * @throws Api2PdfException
     * @return Api2PdfResult
     */
    public function libreOfficePdfToHtml($url, $inline = true, $filename = null) {
        $payload = array_merge(
            $this->buildPayloadBase($inline, $filename),
            [
                'url' => $url,
            ]
        );

        return $this->makeRequest('/libreoffice/pdf-to-html', $payload);
    }

    /**
     * @param string $url
     *
     * @throws Api2PdfException
     * @return Api2PdfResult
     */
    public function libreOfficeHtmlToDocx($url, $inline = true, $filename = null) {
        $payload = array_merge(
            $this->buildPayloadBase($inline, $filename),
            [
                'url' => $url,
            ]
        );

        return $this->makeRequest('/libreoffice/html-to-docx', $payload);
    }

    /**
     * @param string $url
     *
     * @throws Api2PdfException
     * @return Api2PdfResult
     */
    public function libreOfficeHtmlToXlsx($url, $inline = true, $filename = null) {
        $payload = array_merge(
            $this->buildPayloadBase($inline, $filename),
            [
                'url' => $url,
            ]
        );

        return $this->makeRequest('/libreoffice/html-to-xlsx', $payload);
    }

    /**
     * @param array $urls
     *
     * @throws Api2PdfException
     * @return Api2PdfResult
     */
    public function pdfsharpMerge($urls, $inline = true, $filename = null) {
        $payload = array_merge(
            $this->buildPayloadBase($inline, $filename),
            [
                'urls' => $urls,
            ]
        );

        return $this->makeRequest('/pdfsharp/merge', $payload);
    }

    /**
     * @param $url
     * @param $bookmarks
     * @throws Api2PdfException
     * @return Api2PdfResult
     */
    public function pdfsharpAddBookmarks($url, $bookmarks, $inline = true, $filename = null) {
        $payload = array_merge(
            $this->buildPayloadBase($inline, $filename),
            [
                'url' => $url,
                'bookmarks' => $bookmarks
            ]
        );

        return $this->makeRequest('/pdfsharp/bookmarks', $payload);
    }

    /**
     * @param $url
     * @param $bookmarks
     * @throws Api2PdfException
     * @return Api2PdfResult
     */
    public function pdfsharpAddPassword($url, $userpassword, $ownerpassword = null, $inline = true, $filename = null) {
        $payload = array_merge(
            $this->buildPayloadBase($inline, $filename),
            [
                'url' => $url,
                'userpassword' => $userpassword
            ]
        );

        if (!is_null($ownerpassword))
            $payload['ownerpassword'] = $ownerpassword;

        return $this->makeRequest('/pdfsharp/password', $payload);
    }

    /**
     * @param string $responseId
     *
     * @return ApiResult
     * @throws ConversionException
     * @throws ProtocolException
     */
    public function utilityDelete($responseId) {
        $url = $this->base_url . '/file/'. $responseId;

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: '.$this->apiKey
            ]
        );

        $response = curl_exec($ch);

        if ($response === false) {
            throw new Api2PdfException(curl_error($ch) ?: 'API request failed');
        }

        return Api2PdfResult::createFromResponse($response);
    }

        /**
     * @param $endpoint
     * @param $payload
     * @throws Api2PdfException
     * @return Api2PdfResult
     */
    private function makeRequest($endpoint, $payload) {
        $url = $this->base_url . $endpoint;

        $ch = curl_init($url);

        $jsonDataEncoded =  json_encode($payload);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: '.$this->apiKey
            ]
        );

        $response = curl_exec($ch);

        if ($response === false) {
            throw new Api2PdfException(curl_error($ch) ?: 'API request failed');
        }

        return Api2PdfResult::createFromResponse($response);
    }

    /**
     * @return array
     */
    private function buildPayloadBase($inline, $filename, $options = null)
    {
        $payload = [
            'inline' => $inline,
        ];

        if (!is_null($filename)) {
            $payload["fileName"] = $filename;
        }

        if (!is_null($options) && !empty($options)) {
            $payload["options"] = $options;
        }

        return $payload;
    }
}

class Api2PdfResult
{
    /**
     * @var string|null
     */
    private $file = null;

    /**
     * @var float|null
     */
    private $seconds = null;

    /**
     * @var float|null
     */
    private $mbOut = null;

    /**
     * @var float|null
     */
    private $cost = null;

    /**
     * @var string|null
     */
    private $responseId = null;

    private $raw_json = null;

    public static function createFromResponse($response)
    {
        $data = json_decode($response, true);

        if ($data === false) {
            throw new ProtocolException('Error decoding API response');
        }

        if (!isset($data['Success']) || !$data['Success']) {
            if (isset($data['Error'])) {
                $errorMessage = $data['Error'];
            } else {
                $errorMessage = 'Error response received from API';
            }

            throw new Api2PdfException($errorMessage);
        }

        $apiResponse = new static();

        $apiResponse->file = isset($data['FileUrl'])?$data['FileUrl']: null;
        $apiResponse->seconds = $data['Seconds'];
        $apiResponse->mbOut = $data['MbOut'];
        $apiResponse->cost = $data['Cost'];
        $apiResponse->responseId = $data['ResponseId'];
        $apiResponse->raw_json = $response;

        return $apiResponse;
    }

    /**
     * @return string|null
     */
    public function getFile()
    {
        return $this->file;
    }

    public function getJson()
    {
        return $this->raw_json;
    }

    /**
     * @return float|null
     */
    public function getSeconds()
    {
        return $this->seconds;
    }

    /**
     * @return float|null
     */
    public function getMbOut()
    {
        return $this->mbOut;
    }

    /**
     * @return float|null
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @return string|null
     */
    public function getResponseId()
    {
        return $this->responseId;
    }
}

class Api2PdfException extends Exception { }
